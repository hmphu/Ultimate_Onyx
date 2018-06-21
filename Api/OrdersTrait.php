<?php

namespace Ultimate\Onyx\Api;

use GuzzleHttp\Client;
use Magento\Framework\App\ObjectManager;

/**
 * Onyx ERP orders management
 */
trait OrdersTrait
{
    /**
     * Get Magento store orders.
     *
     * @return \Magento\Sales\Model\Order $orders
     */
    public function getStoreOrders()
    {
        $orders = ObjectManager::getInstance()->get('Magento\Sales\Model\OrderFactory')
                                              ->create()
                                              ->getCollection()
                                              ->addFieldToSelect(['*']);

        // return $orders;
        return $orders->getFirstItem()->getShippingAddress()->getData();
    }

    /**
     * Create new Onyx ERP order.
     *
     * @param \Magento\Sales\Model\Order $order
     * @param \Ultimate\Onyx\Log\Logger $logger
     */
    public function createNewOrder($order, $logger)
    {
        $onyxClient = new Client(['base_uri' => getenv('API_URL')]);

        $address = $order->getShippingAddress()->getStreet()[0] . ', ' . $order->getShippingAddress()->getCity();

        $key = 'AIzaSyBwpWAYyjqMD3Ckhlp9i29CZJ9UK65_oPs';
        $coordinates = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=' . $key . '&address=' .
                        urlencode($address) . '&sensor=true');
        $coordinates = json_decode($coordinates, true);

        if ($coordinates['status'] == 'OK') {
            $latitude = $coordinates['results'][0]['geometry']['location']['lat'];
            $longitude = $coordinates['results'][0]['geometry']['location']['lng'];
        } else {
            $longitude = $latitude = '';
        }

        try {
            $response = $onyxClient->request(
                'POST',
                'SaveOrder',
                [
                    'json' => [
                        'type' => 'ORACLE',
                        'year' => getenv('ACCOUNTING_YEAR'),
                        'activityNumber' => getenv('ACTIVITY_NUMBER'),
                        'value' => [
                            'OrderNo'         => -1,
                            'OrderSer'        => -1,
                            'Code'            => '', // $order->getId() . '-' . $order->getCustomerId(),
                            'Name'            => $order->getCustomerName(),
                            'CustomerType'    => 4, // Credit payment
                            'FiscalYear'      => date('Y'),
                            'Activity'        => getenv('ACTIVITY_NUMBER'),
                            'BranchNumber'    => getenv('BRANCH_NUMBER'),
                            'WarehouseCode'   => getenv('WAREHOUSE_CODE'),
                            'TotalDemand'     => $order->getBaseGrandTotal(),
                            'TotalDiscount'   => $order->getDiscountAmount(),
                            'TotalTax'        => $order->getTaxAmount(),
                            'ChargeAmt'       => $order->getShippingAmount(),
                            'CustomerAddress' => $address,
                            'Mobile'          => $order->getBillingAddress()->getTelephone(),
                            'Latitude'        => $latitude,
                            'Longitude'       => $longitude,
                            'FileExtension'   => '',
                            'ImageValue'      => '',
                            'P_AD_TRMNL_NM'   => 0,
                            'OrderDetailsList' => $this->getOrderedItems($order->getItemsCollection())
                        ]
                    ]
                ]
            );

            $result = json_decode($response->getBody(), true);

            if ($result['_Result']['_ErrStatuse']) {
                $order->setData('onyx_order_no', $result['SingleObjectHeader']['OrderNo']);
                $order->setData('onyx_order_ser', $result['SingleObjectHeader']['OrderSer']);
                $order->save();

                $logger->info('Order with ID: ' . $order->getRealOrderId() . ' has been created.'
                            . ' Onyx OrderNo: ' . $result['SingleObjectHeader']['OrderNo'] .
                            ', ' . 'Onyx OrderSer: ' . $result['SingleObjectHeader']['OrderSer']);
            }
        } catch (\Exception $e) {
            $logger->error($e->getMessage());
        }
    }

    /**
     * Get Ordered items.
     *
     * @param array $items
     * @return array $orderdItems
     */
    public function getOrderedItems($items)
    {
        $orderdItems = [];

        foreach ($items as $item) {
            $code = explode('-', $item->getSku())[0];
            $unit = explode('-', $item->getSku())[1];

            $orderdItems [] = [
                'Code'               => $code,
                'Unit'               => $unit,
                'Quantity'           => $item->getQtyToShip(),
                'Price'              => $item->getPrice(),
                'DiscountPercentage' => $item->getDiscountPercent(),
                'DiscountValue'      => $item->getDiscountAmount(),
                'TaxRate'            => $item->getTaxPercent(),
                'TaxAmount'          => $item->getTaxAmount(),
                'ChargeAmt'          => 0
            ];
        }

        return $orderdItems;
    }
}

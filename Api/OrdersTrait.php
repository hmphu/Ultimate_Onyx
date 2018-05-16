<?php

namespace Ultimate\Onyx\Api;

use GuzzleHttp\Client;
use Magento\Framework\App\ObjectManager;

/**
 * Onyx ERP orders management
 */
trait OrdersTrait
{
    public function getStoreOrders()
    {
        $orders = ObjectManager::getInstance()->get('Magento\Sales\Model\OrderFactory')
                                              ->create()
                                              ->getCollection()
                                              ->addFieldToSelect(['*']); //->getData();

        // return $orders;
        return $orders->getFirstItem()->getShippingAddress()->getData();
    }

    public function sendOrder($order, $logger)
    {
        // set if customer exits
        $onyxClient = new Client([
            // 'base_uri' => 'http://196.218.192.248:2000/OnyxShopMarket/Service.svc/'
            'base_uri' => getenv('API_URL')
        ]);

        $address = $order->getShippingAddress()->getStreet()[0] . ', ' . $order->getShippingAddress()->getCity();

        $name = $order->getBillingAddress()->getFirstName() . ' ' . $order->getBillingAddress()->getLastName();

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
                            'Name'            => 'me',// $name,
                            'CustomerType'    => 4, // Credit payment
                            'FiscalYear'      => date('Y'), // date
                            'Activity'        => getenv('ACTIVITY_NUMBER'),
                            'BranchNumber'    => getenv('BRANCH_NUMBER'),
                            'WarehouseCode'   => getenv('WAREHOUSE_CODE'),
                            'TotalDemand'     => $order->getBaseGrandTotal(),
                            'TotalDiscount'   => $order->getDiscountAmount(),
                            'TotalTax'        => $order->getTaxAmount(),
                            'ChargeAmt'       => $order->getShippingAmount(),
                            'CustomerAddress' => 'adsasd',// $address,
                            'Mobile'          => $order->getBillingAddress()->getTelephone(),
                            'Latitude'        => '',
                            'Longitude'       => '',
                            'FileExtension'   => '',
                            'ImageValue'      => '',
                            'P_AD_TRMNL_NM'   => 0,
                            'OrderDetailsList' => $this->getOrderedItems($order->getItemsCollection())
                        ]
                    ]
                ]
            );
        } catch (\Exception $e) {
            $logger->error($e->getMessage());
        }

        $logger->info($response->getBody());
    }

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

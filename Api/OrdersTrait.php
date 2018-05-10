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
        $orders = ObjectManager::getInstance()
                                ->get('Magento\Sales\Model\OrderFactory')
                                ->create()
                                ->getCollection()
                                ->addFieldToSelect(['*']); //->getData();

        return $orders->getData();
    }

    public function postOrder() //($order)
    {
        $onyxClient = new Client([
            // 'base_uri' => 'http://196.218.192.248:2000/OnyxShopMarket/Service.svc/'
            'base_uri' => 'http://10.0.95.95/OnyxShopMarket/Service.svc/'
        ]);

        $response = $onyxClient->request(
            'POST',
            'SaveOrder',
            [
                'json' => [
                    'type' => 'ORACLE',
                    'year' => 2016,
                    'activityNumber' => 70,
                    'value' => [
                        'OrderNo'         => -1,
                        'OrderSer'        => -1,
                        'Code'            => '123-456',// $order->getId() . '-' . $order->getCustomerId(),
                        'Name'            => 'customer-123', // $order->getCustomerName(),
                        'CustomerType'    => 4, // Credit payment
                        'FiscalYear'      => data('Y'), // date
                        'Activity'        => 70,
                        'BranchNumber'    => 1,
                        'WarehouseCode'   => 101,
                        'TotalDemand'     => 100,
                        'TotalDiscount'   => 5,
                        'TotalTax'        => 5,
                        'ChargeAmt'       => 5,
                        'CustomerAddress' => 'customer-123-address',// $order->getShippingAddress(),
                        'Mobile'          => '0123456789',
                        'Latitude'        => '',
                        'Longitude'        => '',
                        'FileExtension'   => '',
                        'ImageValue'      => '',
                        'P_AD_TRMNL_NM'   => 0,
                        'OrderDetailsList' => $this->getOrderedItems()
                    ]
                ]
            ]
        );

        echo json_encode($response->getBody());
    }

    public function getOrderedItems()
    {
        return [
            [
                'Code'               => '451003',
                'Unit'               => 'كرتون',
                'Quantity'           => 1,
                'Price'              => 150,
                'DiscountPercentage' => 0,
                'DiscountValue'      => 0,
                'TaxRate'            => 0,
                'TaxAmount'          => 0,
                'ChargeAmt'          => 0
            ]
        ];
    }
}

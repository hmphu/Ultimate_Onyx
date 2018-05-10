<?php

namespace Ultimate\Onyx\Api;

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

    public function postOrder($order)
    {
        $onyxClient = new Client([
            // 'base_uri' => 'http://196.218.192.248:2000/OnyxShopMarket/Service.svc/'
            'base_uri' => 'http://10.0.95.95/OnyxShopMarket/Service.svc/'
        ]);

        $onyxClient->request(
            'POST',
            'SaveOrder',
            [
                'json' => [
                    'type' => 'ORACLE',
                    'year' => 2016,
                    'activityNumber' => 70,
                    'value' => [
                        'OrderNo' => -1,
                        'OrderSer' => -1,
                        'Code' => $order->getCustomerId(),
                        'Name' => $order->getCustomerName(),
                        'CustomerType' => 4, // Credit payment
                        'FiscalYear' => data('Y'), // date
                        'BranchNumber' => -1, // 1
                        'WarehouseCode' => -1, // 101
                        // 'TotalDemand' =>
                    ]
                ]
            ]

        );
    }
}

<?php

namespace Ultimate\Onyx\Observers;

use Ultimate\Onyx\Log\Logger;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\ObserverInterface;

class OrderStatusObserver implements ObserverInterface
{
    protected $connector;
    protected $logger;

    public function __construct(Logger $logger)
    {
        $objectManager = ObjectManager::getInstance();
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $customerId = $order->getCustomerId();

        $this->logger->info('Order status changed.');

        // if ($customerId)
            #do something with order an customer
    }
}

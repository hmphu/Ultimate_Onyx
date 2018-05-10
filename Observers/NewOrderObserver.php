<?php

namespace Ultimate\Onyx\Observers;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Ultimate\Onyx\Api\OrdersTrait;
use Ultimate\Onyx\Log\Logger;

class NewOrderObserver implements ObserverInterface
{
    use OrdersTrait;

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

        $this->postOrder($order);

        $this->logger->info('Order Found -> NewOrderObserver');
        // if ($customerId)
            #do something with order an customer
    }

    public function sendOrder()
    {
    }
}

<?php

namespace Ultimate\Onyx\Observers;

use Ultimate\Onyx\Log\Logger;
use Ultimate\Onyx\Api\OrdersTrait;
use Ultimate\Onyx\Api\SettingsTrait;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class NewOrderObserver implements ObserverInterface
{
    use SettingsTrait, OrdersTrait;

    protected $connector;
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
        $this->loadSettings();
    }

    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();

        $this->createNewOrder($order, $this->logger);
    }
}

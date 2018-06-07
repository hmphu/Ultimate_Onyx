<?php

namespace Ultimate\Onyx\Observers;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Ultimate\Onyx\Api\CustomersTrait;
use Ultimate\Onyx\Api\SettingsTrait;
use Ultimate\Onyx\Log\Logger;

class NewCustomerObserver implements ObserverInterface
{
    use SettingsTrait, CustomersTrait;

    protected $connector;
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
        $this->loadSettings();
    }

    public function execute(Observer $observer)
    {
        $this->createNewCustomer($observer->getEvent()->getCustomer(), $this->logger);
    }
}

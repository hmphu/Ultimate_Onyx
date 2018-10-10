<?php

namespace Ultimate\Onyx\Observers;

use Ultimate\Onyx\Log\Logger;
use Ultimate\Onyx\Api\SettingsTrait;
use Magento\Framework\Event\Observer;
use Ultimate\Onyx\Api\CustomersTrait;
use Magento\Framework\Event\ObserverInterface;

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
        // $this->createNewCustomer($observer->getEvent()->getCustomer(), $this->logger);
    }
}

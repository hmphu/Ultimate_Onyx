<?php

namespace Ultimate\Onyx\Cron;

use Ultimate\Onyx\Api\CategoriesTrait;
use Ultimate\Onyx\Api\OrdersTrait;
use Ultimate\Onyx\Api\ProductsTrait;
use Ultimate\Onyx\Api\SettingsTrait;
use Ultimate\Onyx\Log\Logger;

class Sync
{
    use SettingsTrait, CategoriesTrait, ProductsTrait, OrdersTrait;

    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function execute()
    {
        $this->loadSettings();

        $this->logger->info('Onyx ERP Synchronization started.');

        $this->syncCategories($this->logger);
        $this->syncProducts($this->logger);
        // sync orders

        $this->logger->info('Onyx ERP Synchronization ended.');
    }
}

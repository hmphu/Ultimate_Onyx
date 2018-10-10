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
        $this->loadSettings();
    }

    public function execute()
    {
        $this->logger->info('Onyx ERP Synchronization started.');

        // $this->syncCategories($this->logger);
        // $this->syncProducts($this->logger);

        $this->logger->info('Onyx ERP Synchronization ended.');
    }
}

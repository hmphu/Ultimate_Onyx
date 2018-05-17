<?php

namespace Ultimate\Onyx\Controller\Adminhtml\Api;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;
use Ultimate\Onyx\Api\CategoriesTrait;
use Ultimate\Onyx\Api\OrdersTrait;
use Ultimate\Onyx\Api\ProductsTrait;
use Ultimate\Onyx\Api\SettingsTrait;
use Ultimate\Onyx\Log\Logger;

class Settings extends Action
{
    use SettingsTrait, CategoriesTrait, ProductsTrait, OrdersTrait;

    protected $page;
    protected $storeManagerInterface;
    protected $logger;

    public function __construct(
        Context $context,
        PageFactory $page,
        StoreManagerInterface $storeManagerInterface,
        Logger $logger
        ) {
        parent::__construct($context);

        $this->page = $page;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->logger = $logger;
    }

    public function execute()
    {
        // echo json_encode();
        // exit;

        $this->loadSettings();

        if ($this->getRequest()->getParam('revert')) {
            return $this->revert();
        }

        if ($this->getRequest()->getParam('now')) {
            return $this->syncNow();
        }

        if ($this->getRequest()->getParam('api_url')) {
            $this->updateSettings($this->getRequest()->getParams());
            $this->messageManager->addSuccessMessage('Onyx ERP Settings are saved successfully!');

            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
                                       ->setUrl('/admin/onyx/api/settings');
        }

        return $this->page->create();
    }

    public function syncNow()
    {
        $this->logger->info('Onyx ERP Synchronization started.');
        $this->syncCategories($this->logger);
        $this->syncProducts($this->logger);
        // sync orders
        $this->logger->info('Onyx ERP Synchronization ended.');

        $this->messageManager->addSuccessMessage('Onyx ERP synchronization has finished successfully!');

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
                                   ->setUrl('/admin/onyx/api/settings');
    }

    public function revert()
    {
        $this->deleteStoreCategories($this->logger);
        $this->deleteStoreProducts($this->logger);

        $this->messageManager->addSuccessMessage('Products and categories are reverted successfully!');

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
                                   ->setUrl('/admin/onyx/api/settings');
    }
}

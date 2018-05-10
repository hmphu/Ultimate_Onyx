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
use Ultimate\Onyx\Log\Logger;

class Settings extends Action
{
    use CategoriesTrait, ProductsTrait, OrdersTrait;

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
        echo json_encode($this->getStoreOrders());
        exit;
        // return $this->getOnyxProducts();
        // echo json_encode($this->getStoreProducts()->getData());
        // return $this->getOnyxCategories();
        // return $this->getStoreCategories();
        // return $this->getStoreCategory(38);
        $revert = $this->getRequest()->getParam('revert');

        if ($revert) {
            return $this->revert();
        }

        $now = $this->getRequest()->getParam('now');

        if ($now) {
            return $this->syncNow();
        }

        $apiUrl = $this->getRequest()->getParam('api-url');

        if ($apiUrl) {

            // save settings
            $this->messageManager->addSuccessMessage('Settings are saved successfully!');

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

<?php

namespace Ultimate\Onyx\Controller\Adminhtml\Api;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Ultimate\Onyx\Log\Logger;

class Log extends Action
{
    protected $page;
    protected $store;
    protected $logger;

    public function __construct(Context $context, PageFactory $page, Logger $logger)
    {
        parent::__construct($context);

        $this->page = $page;
        $this->logger = $logger;
    }

    public function execute()
    {
        return $this->page->create();
    }
}

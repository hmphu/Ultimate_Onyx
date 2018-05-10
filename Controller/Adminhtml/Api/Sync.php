<?php

namespace Ultimate\Onyx\Controller\Adminhtml\Api;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Sync extends Action
{
    protected $page;

    public function __construct(Context $context, PageFactory $page)
    {
        parent::__construct($context);
        $this->page = $page;
    }

    public function execute()
    {
        return $this->page->create();
    }
}

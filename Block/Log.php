<?php

namespace Ultimate\Onyx\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Element\Template;

class Log extends Template
{
    protected $formKey;

    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
        $this->formKey = $context->getFormKey();
    }

    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    public function getLog()
    {
        $file = "var/log/onyx.log";
        return $file;
    }
}

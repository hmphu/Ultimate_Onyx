<?php

namespace Ultimate\Onyx\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Element\Template;

class Settings extends Template
{
    protected $formKey;

    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
        $this->formKey = $context->getFormKey();
    }

    public function getFormAction()
    {
        return 'onyx/api/settings';
    }

    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }
}

<?php

namespace Ultimate\Onyx\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Element\Template;
use Ultimate\Onyx\Api\SettingsTrait;

class Settings extends Template
{
    use SettingsTrait;

    protected $formKey;

    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
        $this->formKey = $context->getFormKey();
        $this->loadSettings();
    }

    public function getFormAction()
    {
        return '';
    }

    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }
}

<?php

namespace Ultimate\Onyx\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Magento\Framework\View\Element\Template;
use Ultimate\Onyx\Api\SettingsTrait;

class Settings extends Template
{
    use SettingsTrait;

    protected $formKey;
    protected $urlHelper;

    public function __construct(Context $context, array $data = [], Data $urlHelper)
    {
        parent::__construct($context, $data);

        $this->formKey = $context->getFormKey();
        $this->loadSettings();
        $this->urlHelper = $urlHelper;
    }

    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    public function getFormAction()
    {
        return $this->urlHelper->getAreaFrontName() . '/onyx/api/settings';
    }
}

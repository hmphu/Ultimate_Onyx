<?php

namespace Ultimate\Onyx\Model\Customer\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\Table;
use Ultimate\Onyx\Api\CustomersTrait;
use Ultimate\Onyx\Api\SettingsTrait;

class City extends Table
{
    use SettingsTrait, CustomersTrait;

    public function getAllOptions()
    {
        $this->loadSettings();
        $this->_options = $this->getOnyxCities();

        return $this->_options;
    }
}

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
        $onyxCities = $this->getOnyxCities();

        if ($onyxCities) {
            $this->_options = $onyxCities;

            return $this->_options;
        }
    }
}

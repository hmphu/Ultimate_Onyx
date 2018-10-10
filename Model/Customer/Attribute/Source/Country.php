<?php

namespace Ultimate\Onyx\Model\Customer\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\Table;
use Ultimate\Onyx\Api\CustomersTrait;
use Ultimate\Onyx\Api\SettingsTrait;

class Country extends Table
{
    use SettingsTrait, CustomersTrait;

    public function getAllOptions()
    {
        $this->loadSettings();

        $countries = [];
        $onyxCountries = $this->getOnyxCountries()['MultipleObjectHeader'];

        if ($onyxCountries) {
            foreach ($onyxCountries as $country) {
                $countries [] = [
                    'value' => $country['Code'],
                    'label' => $country['Name']
                ];
            }

            $this->_options = $countries;

            return $this->_options;
        }
    }
}

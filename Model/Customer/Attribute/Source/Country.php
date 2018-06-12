<?php

namespace Ultimate\Onyx\Model\Customer\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Country extends AbstractSource
{

    /**
     * getAllOptions
     *
     * @return array
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['value' => '1', 'label' => __('Saudi Arabia')],
                ['value' => '2', 'label' => __('Yemen')]
            ];
        }
        return $this->_options;
    }
}

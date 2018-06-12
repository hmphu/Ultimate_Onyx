<?php

namespace Ultimate\Onyx\Model\Customer\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class City extends AbstractSource
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
                ['value' => '1', 'label' => __('Jeddah')],
                ['value' => '2', 'label' => __('Cairo')]
            ];
        }
        return $this->_options;
    }
}

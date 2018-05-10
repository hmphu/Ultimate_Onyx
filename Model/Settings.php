<?php

namespace Ultimate\Onyx\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Settings extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'ultimate_onyx_settings';

    protected $_cacheTag = 'ultimate_onyx_settings';
    protected $_eventPrefix = 'ultimate_onyx_settings';

    public function _construct()
    {
        $this->_init('Ultimate\Onyx\Model\ResourceModel\Settings');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}

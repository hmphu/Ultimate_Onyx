<?php

namespace Ultimate\Onyx\Model\ResourceModel\Settings;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'ultimate_onyx_settings_collection';
    protected $_eventObject = 'settings_collection';

    public function _construct()
    {
        $this->_init('Ultimate\Onyx\Model\Settings', 'Ultimate\Onyx\Model\ResourceModel\Settings');
    }
}

<?php

namespace Ultimate\Onyx\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $quote = 'quote';

        $setup->getConnection()->addColumn(
            $setup->getTable($quote),
            'onyx_order_no',
            [
                'type'    => Table::TYPE_TEXT,
                'length'  => 255,
                'comment' => 'Onyx order number'
            ]
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('sales_order'),
            'onyx_order_no',
            [
                'type'     => Table::TYPE_TEXT,
                'length'   => 255,
                'comment'  => 'Onyx order number',
                'nullable' => true
            ]
        );

        $setup->getConnection()->addColumn(
            $setup->getTable($quote),
            'onyx_order_ser',
            [
                'type'    => Table::TYPE_TEXT,
                'length'  => 255,
                'comment' => 'Onyx order serial'
            ]
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('sales_order'),
            'onyx_order_ser',
            [
                'type'     => Table::TYPE_TEXT,
                'length'   => 255,
                'comment'  => 'Onyx order serial',
                'nullable' => true
            ]
        );

        $setup->endSetup();
    }
}

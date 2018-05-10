<?php

namespace Ultimate\Onyx\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (!$setup->tableExists('ultimate_onyx_settings')) {
            $table = $setup->getConnection()
                           ->newTable($setup->getTable('ultimate_onyx_settings'))
                           ->addColumn(
                                'id',
                                Table::TYPE_INTEGER,
                                null,
                                [
                                    'identity' => true,
                                    'nullable' => false,
                                    'primary' => true,
                                    'unsigned' => true
                                ]
                           )
                           ->addColumn(
                                'api_url',
                                Table::TYPE_TEXT,
                                255,
                                ['nullable' => false]
                           )
                           ->addColumn(
                               'api_key',
                               Table::TYPE_TEXT,
                               255,
                               ['nullable' => false]
                           )
                           ->addColumn(
                               'api_token',
                               Table::TYPE_TEXT,
                               255,
                               ['nullable' => false]
                           )
                           ->addColumn(
                               'accounting_year',
                               Table::TYPE_INTEGER,
                               null,
                               ['nullable' => false]
                           )
                           ->addColumn(
                               'accounting_unit',
                               Table::TYPE_INTEGER,
                               null,
                               ['nullable' => false]
                           )
                           ->addColumn(
                                'branch',
                                Table::TYPE_INTEGER,
                                null,
                               ['nullable' => false]
                           )
                           ->addColumn(
                               'warehouse',
                               Table::TYPE_INTEGER,
                               null,
                               ['nullable' => false]
                           )->addColumn(
                               'language',
                               Table::TYPE_INTEGER,
                               null,
                               ['nullable' => false]
                           )
                           ->addColumn(
                               'shipping_method',
                               Table::TYPE_INTEGER,
                               null,
                               ['nullable' => false]
                           )
                           ->addColumn(
                               'sms_url',
                               Table::TYPE_TEXT,
                               255,
                               ['nullable' => false]
                           )
                           ->addColumn(
                               'images_base_url',
                               Table::TYPE_TEXT,
                               255,
                               ['nullable' => false]
                           )
                           ->addColumn(
                               'product_qty',
                               Table::TYPE_INTEGER,
                               null,
                               ['nullable' => false]
                           );
            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}

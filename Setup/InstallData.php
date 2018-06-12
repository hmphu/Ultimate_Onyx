<?php

namespace Ultimate\Onyx\Setup;

use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $customerSetupFactory;

    /**
     * Constructor
     *
     * @param \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(CustomerSetupFactory $customerSetupFactory)
    {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    /**
     * Install data
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'onyx_address', [
            'type'     => 'varchar',
            'label'    => 'onyx_address',
            'input'    => 'text',
            'source'   => '',
            'required' => true,
            'visible'  => true,
            'position' => 333,
            'system'   => false,
            'backend'  => ''
        ]);

        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'onyx_address')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'onyx_phone', [
            'type'     => 'varchar',
            'label'    => 'onyx_phone',
            'input'    => 'text',
            'source'   => '',
            'required' => true,
            'visible'  => true,
            'position' => 333,
            'system'   => false,
            'backend'  => ''
        ]);

        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'onyx_phone')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'onyx_city', [
            'type'     => 'int',
            'label'    => 'onyx_city',
            'input'    => 'select',
            'source'   => 'Ultimate\Onyx\Model\Customer\Attribute\Source\City',
            'required' => true,
            'visible'  => true,
            'position' => 333,
            'system'   => false,
            'backend'  => ''
        ]);

        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'onyx_city')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'onyx_country', [
            'type'     => 'int',
            'label'    => 'onyx_country',
            'input'    => 'select',
            'source'   => 'Ultimate\Onyx\Model\Customer\Attribute\Source\Country',
            'required' => true,
            'visible'  => true,
            'position' => 333,
            'system'   => false,
            'backend'  => ''
        ]);

        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'onyx_country')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'adminhtml_checkout',
                'customer_account_create',
                'customer_account_edit'
            ]]);
        $attribute->save();
    }
}

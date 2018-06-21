<?php

namespace Ultimate\Onyx\Setup;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    protected $customerSetupFactory;

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

        $customerSetup->addAttribute(Customer::ENTITY, 'onyx_address', [
            'type'             => 'varchar',
            'label'            => 'Address',
            'input'            => 'text',
            'required'         => true,
            'visible'          => true,
            'visible_on_front' => true,
            'system'           => false,
            'global'           => ScopedAttributeInterface::SCOPE_GLOBAL,
            'position'         => 999
        ]);

        $customerSetup->getEavConfig()
                      ->getAttribute('customer', 'onyx_address')
                      ->addData(['used_in_forms' => [
                          'adminhtml_customer',
                          'adminhtml_checkout',
                          'customer_account_create',
                          'customer_account_edit'
                      ]])->save();

        $customerSetup->addAttribute(Customer::ENTITY, 'onyx_phone', [
            'type'             => 'varchar',
            'label'            => 'Phone',
            'input'            => 'text',
            'required'         => true,
            'visible'          => true,
            'visible_on_front' => true,
            'system'           => false,
            'global'           => ScopedAttributeInterface::SCOPE_GLOBAL,
            'position'         => 999
        ]);

        $customerSetup->getEavConfig()
                      ->getAttribute('customer', 'onyx_phone')
                      ->addData(['used_in_forms' => [
                          'adminhtml_customer',
                          'adminhtml_checkout',
                          'customer_account_create',
                          'customer_account_edit'
                      ]])->save();

        $customerSetup->addAttribute(Customer::ENTITY, 'onyx_city', [
            'type'             => 'int',
            'label'            => 'City',
            'input'            => 'select',
            'source'           => 'Ultimate\Onyx\Model\Customer\Attribute\Source\City',
            'required'         => true,
            'visible'          => true,
            'visible_on_front' => true,
            'system'           => false,
            'global'           => ScopedAttributeInterface::SCOPE_GLOBAL,
            'position'         => 999
        ]);

        $customerSetup->getEavConfig()
                      ->getAttribute('customer', 'onyx_city')
                      ->addData(['used_in_forms' => [
                          'adminhtml_customer',
                          'adminhtml_checkout',
                          'customer_account_create',
                          'customer_account_edit'
                      ]])->save();

        $customerSetup->addAttribute(Customer::ENTITY, 'onyx_country', [
            'type'             => 'int',
            'label'            => 'Country',
            'input'            => 'select',
            'source'           => 'Ultimate\Onyx\Model\Customer\Attribute\Source\Country',
            'required'         => true,
            'visible'          => true,
            'visible_on_front' => true,
            'system'           => false,
            'global'           => ScopedAttributeInterface::SCOPE_GLOBAL,
            'position'         => 999
        ]);

        $customerSetup->getEavConfig()
                      ->getAttribute('customer', 'onyx_country')
                      ->addData(['used_in_forms' => [
                          'adminhtml_customer',
                          'adminhtml_checkout',
                          'customer_account_create',
                          'customer_account_edit'
                      ]])->save();
    }
}

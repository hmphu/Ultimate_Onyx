<?php

namespace Ultimate\Onyx\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Element\Template;
use Ultimate\Onyx\Api\CustomersTrait;
use Ultimate\Onyx\Api\SettingsTrait;

class Register extends Template
{
    use SettingsTrait, CustomersTrait;

    protected $client;

    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
        $this->loadSettings();
    }

    // public function getCities()
    // {
    //     $cities = $this->getOnyxCities();
    //     $citiesSelect = $this->getLayout()->createBlock('Magento\Framework\View\Element\Html\Select');

    //     $citiesSelect->setOptions($cities)
    //                 ->setName('onyx_city')
    //                 ->setClass('cities-select')
    //                 ->setId('cities-select');

    //     return $citiesSelect->getHtml();
    // }

    // public function getCountries()
    // {
    //     $countries = [];

    //     foreach ($this->getOnyxCountries()['MultipleObjectHeader'] as $country) {
    //         $countries [] = [
    //             'value' => $country['Code'],
    //             'label' => $country['Name']
    //         ];
    //     }

    //     $countriesSelect = $this->getLayout()->createBlock('Magento\Framework\View\Element\Html\Select');

    //     $countriesSelect->setOptions($countries)
    //                     ->setName('onyx_country')
    //                     ->setClass('countries-select')
    //                     ->setId('countries-select');

    //     return $countriesSelect->getHtml();
    // }
}

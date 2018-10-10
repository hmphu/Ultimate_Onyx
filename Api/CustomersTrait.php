<?php

namespace Ultimate\Onyx\Api;

use GuzzleHttp\Client;
use Magento\Framework\App\ObjectManager;

/**
 * Customers ERP management.
 */
trait CustomersTrait
{
    /**
     * Create Onyx ERP customer.
     *
     * @param \Magento\Customer\Model\Customer $customer
     * @param \Ultimate\Onyx\Log\Logger $logger
     */
    public function createNewCustomer($customer, $logger)
    {
        $onyxClient = new Client(['base_uri' => getenv('API_URL')]);

        try {
            $response = $onyxClient->request(
                'POST',
                'RegistrCashCustomer',
                [
                    'json' => [
                        'type' => 'ORACLE',
                        'year' => getenv('ACCOUNTING_YEAR'),
                        'activityNumber' => getenv('ACTIVITY_NUMBER'),
                        'value' => [
                            'ActivityType' => getenv('ACTIVITY_NUMBER'),
                            'CompanyName'  => $customer->getName(),
                            'Email'        => $customer->getEmail(),
                            'Mobile'       => $customer->getData('onyx_phone'),
                            'Name'         => $customer->getName(),
                            'Password'     => $customer->getName(),
                            'CountryCode'  => $customer->getData('onyx_country'),
                            'CityCode'     => $customer->getData('onyx_city'),
                            'Address'      => $customer->getData('onyx_address')
                        ]
                    ]
                ]
            );

            $result = json_decode($response->getBody(), true);

            if ($result['_Result']['_ErrStatuse']) {
                $logger->info('Customer with name: ' . $customer->getName() . ' has been created.');
            }
        } catch (\Exception $e) {
            $logger->error($e->getMessage());
        }
    }

    /**
     * Get Onyx ERP countries list
     *
     * @return array $countries
     */
    public function getOnyxCountries()
    {
        $onyxClient = new Client(['base_uri' => getenv('API_URL')]);

        try {
            $response = $onyxClient->request(
                'GET',
                'GetCountriesList',
                [
                    'query' => [
                        'type'               => 'ORACLE',
                        'year'               => getenv('ACCOUNTING_YEAR'),
                        'activityNumber'     => getenv('ACTIVITY_NUMBER'),
                        'languageID'         => getenv('LANGUAGE_ID'),
                        'searchValue'        => -1,
                        'pageNumber'         => -1,
                        'rowsCount'          => -1,
                        'orderBy'            => -1,
                        'sortDirection'      => -1
                    ]
                ]
            );

            $countries = json_decode($response->getBody(), true);

            return $countries;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get Onyx ERP cities list
     *
     * @return array $cities
     */
    public function getOnyxCities()
    {
        $cities = [];
        $countries = $this->getOnyxCountries()['MultipleObjectHeader'];

        $onyxClient = new Client(['base_uri' => getenv('API_URL')]);

        if ($countries) {
            foreach ($countries as $country) {
                try {
                    $response = $onyxClient->request(
                        'GET',
                        'GetCitiesList',
                        [
                            'query' => [
                                'type'           => 'ORACLE',
                                'year'           => getenv('ACCOUNTING_YEAR'),
                                'activityNumber' => getenv('ACTIVITY_NUMBER'),
                                'languageID'     => getenv('LANGUAGE_ID'),
                                'searchValue'    => -1,
                                'pageNumber'     => -1,
                                'rowsCount'      => -1,
                                'orderBy'        => -1,
                                'sortDirection'  => -1,
                                'countryID'      => $country['Code']
                            ]
                        ]
                    );

                    $onyxCities = json_decode($response->getBody(), true);

                    foreach ($onyxCities['MultipleObjectHeader'] as $city) {
                        $cities [] = [
                            'value' => $city['Code'],
                            'label' => $city['Name']
                        ];
                    }
                } catch (\Exception $e) {
                    return false;
                }
            }
            return $cities;
        }
    }

    /**
     * Get Store customer by id
     *
     * @param integer $id
     * @return Customer $customer
     */
    public function getStoreCustomer($id)
    {
        $customer = ObjectManager::getInstance()->get('Magento\Customer\Model\Customer')
                                               ->load($id);

        if ($customer->getId()) {
            return $customer;
        }

        return null;
    }
}

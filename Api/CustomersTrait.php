<?php

namespace Ultimate\Onyx\Api;

use GuzzleHttp\Client;

/**
 * Customers ERP management.
 */
trait CustomersTrait
{
    public function createNewCustomer($customer, $logger)
    {
        $onyxClient = new Client([
            'base_uri' => getenv('API_URL')
        ]);

        // $address = $customer->getShippingAddress()->getStreet()[0] . ', ' . $customer->getShippingAddress()->getCity();

        $name = $customer->getFirstName() . ' ' . $customer->getLastName();

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
                            'CompanyName'  => $name,
                            'Email'        => $customer->getEmail(),
                            'Mobile'       => random_int(1111111111, 9999999999), // $customer->getBillingAddress()->getTelephone(),
                            'Name'         => $name,
                            'Password'     => $name,
                            'CountryCode'  => 1,
                            'CityCode'     => 1,
                            'Address'      => 'address' // $address
                        ]
                    ]
                ]
            );

            $result = json_decode($response->getBody(), true);

            if ($result['_Result']['_ErrStatuse']) {
                $logger->info('Customer: ' . $name . ' has been created.');
            }
        } catch (\Exception $e) {
            $logger->error($e->getMessage());
        }
    }
}

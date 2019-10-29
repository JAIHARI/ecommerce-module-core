<?php

namespace Mundipagg\Core\Test\Payment\Factories;

use Mundipagg\Core\Payment\Aggregates\Customer;
use Mundipagg\Core\Payment\Factories\CustomerFactory;
use PHPUnit\Framework\TestCase;

class CustomerFactoryTests extends TestCase
{
    /**
     * @var CustomerFactory
     */
    private $customerFactory;

    public function setUp()
    {
        $this->customerFactory = new CustomerFactory();
    }

    public function testCustomerFactoryCreateFromPostData()
    {
        $postCustomer = [
            'id' => 'cus_K7dJ521DKLLZnjM4',
            'code' => 213
        ];

        $customer = $this->customerFactory->createFromPostData($postCustomer);

        $this->assertInternalType('object', $customer);
        $this->assertInstanceOf(Customer::class, $customer);
    }

    public function testCustomerFactoryCreateFromJson()
    {
        $postCustomer = '{
                          "name":"Fulano", 
                          "email":"fulano@test.com", 
                          "document": "05746761700", "homePhone": "2134519090", 
                          "mobilePhone": "21992196969","street": "Rua 1",
                          "number": "120", "neighborhood": "La Paz", 
                          "complement": "Fundos", "city": "Rio de Janeiro", 
                          "state": "Rio de JK", "zipCode": "21241300"
                         }';

        $customer = $this->customerFactory->createFromJson($postCustomer);

        $this->assertInternalType('object', $customer);
        $this->assertInstanceOf(Customer::class, $customer);
    }

    public function testCustomerFactoryCreateFromDbData()
    {
        $dbData = [
            'mundipagg_id' => 'cus_K7dJ521DKLLZnjM4',
            'code' => 213
        ];

        $customer = $this->customerFactory->createFromDbData($dbData);

        $this->assertInternalType('object', $customer);
        $this->assertInstanceOf(Customer::class, $customer);
    }
}

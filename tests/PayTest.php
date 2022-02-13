<?php

namespace WdevRs\PhpEsir\Tests;

use PHPUnit\Framework\TestCase;
use WdevRs\PhpEsir\Request\InvoicePay;


class PayTest extends TestCase{

    public function testEmptyPay(){

        $pay = new InvoicePay(null);
        $this->assertFalse($pay->isValid());
    }

    /**
     * @dataProvider providePayData
     */
    public function testsetUnitPrice($payment, $expectedResult)
    {
        $pay = new InvoicePay($payment);
        $this->assertEquals($expectedResult, $pay->isValid());
    }

    public function providePayData(){
        return [
            'Valid payTypeint' => [
                'payment' =>[
                'amount' =>  10.5,
                'paymentType' =>  0
                ],
                'expectedResult' => true
                
            ],
            'Valid payTypestring' => [
                'payment' =>[
                'amount' =>  100,
                'paymentType' =>  'Cash'
                ],
                'expectedResult' => true
                
            ],
            'Missing amount' => [
                'payment' =>[
                'amount' =>  null,
                'paymentType' => 2
                ],
                'expectedResult' => false

            ],
            'Type outOfRangeInt' => [
                'payment' =>[
                'amount' =>  10,
                'paymentType' => 7
                ],
                'expectedResult' => false

            ],
            'Type stringUnknown' => [
                'payment' =>[
                'amount' =>  10,
                'paymentType' => 'Valami'
                ],
                'expectedResult' => false

            ],
            'Amount nulla' => [
                'payment' =>[
                'amount' =>  0,
                'paymentType' => 4
                ],
                'expectedResult' => true

            ],
            'Amount negative' => [
                'payment' =>[
                'amount' =>  -10,
                'paymentType' => 'Card'
                ],
                'expectedResult' => false

               ]
            ];
    }

}
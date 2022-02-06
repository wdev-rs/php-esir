<?php

namespace WdevRs\PhpEsir\Tests;

use PHPUnit\Framework\TestCase;
use WdevRs\PhpEsir\Request\Pay;


class PayTest extends TestCase{

    public function testEmptyPay(){

        $pay = new Pay(null,null);
        $this->assertFalse($pay->isValid());
    }

    /**
     * @dataProvider providePayData
     */
    public function testsetUnitPrice($payAmount,$payType, $expectedResult)
    {
        $pay = new Pay($payAmount,$payType);
        $this->assertEquals($expectedResult, $pay->isValid());
    }

    public function providePayData(){
        return [
            'Valid payTypeint' => [
                'payAmount' =>  10.5,
                'payType' =>  0,
                'expectedResult' => true

            ],
            'Valid payTypestring' => [
                'payAmount' =>  100,
                'payType' =>  'Cash',
                'expectedResult' => true

            ],
            'Missing amount' => [
                'payAmount' =>  null,
                'payType' => 2,
                'expectedResult' => false

            ],
            'Type outOfRangeInt' => [
                'payAmount' =>  10,
                'payType' => 7,
                'expectedResult' => false

            ],
            'Type stringUnknown' => [
                'payAmount' =>  10,
                'payType' => 'Valami',
                'expectedResult' => false

            ],
            'Amount nulla' => [
                'payAmount' =>  0,
                'payType' => 4,
                'expectedResult' => true

            ],
            'Amount negative' => [
                'payAmount' =>  -10,
                'payType' => 'Card',
                'expectedResult' => false

               ]
            ];
    }

}
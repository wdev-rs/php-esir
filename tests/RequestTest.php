<?php

namespace WdevRs\PhpEsir\Tests;

use PHPUnit\Framework\TestCase;
use WdevRs\PhpEsir\Request\Item;
use WdevRs\PhpEsir\Request\Pay;
use WdevRs\PhpEsir\Request\Request;


class RequestTest extends TestCase{

    /**
     * @dataProvider provideReqData
     */
    public function testRequestIsValid($invType,$transType, $regNum,$cashier,$buyerId, $buyerCostId,$refNum, $refDT,$payAmount, $payType,$item, $expectedResult)
    {
        $pay = new Pay($payAmount,$payType);
        $itm = new Item($item);
        $req = new Request($invType, $transType, $regNum);
        $req->cashier = $cashier;
        $req->referentDocumentNumber = $refNum;
        $req->referentDocumentDT = $refDT;
        $req->buyerId = $buyerId;
        $req->buyerCostCenterId = $buyerCostId;
        $req->setDateAndTimeOfIssue();
        $req->addItem($itm);
        $req->addPaymant($pay);
        $this->assertEquals($expectedResult, $req->isValid());
    }

    public function provideReqData(){
        return [
            'Valid request' => [
                'invType' =>  0,
                'transType' =>  0,
                'regNum' => '123/1.0.0',
                'cashier' => 'Radnik',
                'buyerId' => null,
                'buyerCostId' => null,
                'refNum' => null,
                'refDT' => null,
                'payAmount' => 10,
                'payType' => 1,
                'item' => [
                    'gtin' => '12345678',
                    'name' => 'Test item/kg',
                    'quantity' => 1,
                    'unitPrice' => 10,
                    'labels' => ['A']
                ],
                'expectedResult' => true
            ],
            'Valid requestInvType string' => [
                'invType' =>  'Normal',
                'transType' =>  0,
                'regNum' => '123/1.0.0',
                'cashier' => 'Radnik',
                'buyerId' => null,
                'buyerCostId' => null,
                'refNum' => null,
                'refDT' => null,
                'payAmount' => 10,
                'payType' => 1,
                'item' => [
                    'gtin' => '12345678',
                    'name' => 'Test item/kg',
                    'quantity' => 1,
                    'unitPrice' => 10,
                    'labels' => ['A']
                ],
                'expectedResult' => true
            ],
            'Valid requestTransType string' => [
                'invType' =>  'Normal',
                'transType' =>  'Sale',
                'regNum' => '123/1.0.0',
                'cashier' => 'Radnik',
                'buyerId' => null,
                'buyerCostId' => null,
                'refNum' => null,
                'refDT' => null,
                'payAmount' => 10,
                'payType' => 1,
                'item' => [
                    'gtin' => '12345678',
                    'name' => 'Test item/kg',
                    'quantity' => 1,
                    'unitPrice' => 10,
                    'labels' => ['A']
                ],
                'expectedResult' => true
            ],
            'Valid requestbuyerId' => [
                'invType' =>  'Normal',
                'transType' =>  0,
                'regNum' => '123/1.0.0',
                'cashier' => 'Radnik',
                'buyerId' => '10:123456',
                'buyerCostId' => null,
                'refNum' => null,
                'refDT' => null,
                'payAmount' => 10,
                'payType' => 1,
                'item' => [
                    'gtin' => '12345678',
                    'name' => 'Test item/kg',
                    'quantity' => 1,
                    'unitPrice' => 10,
                    'labels' => ['A']
                ],
                'expectedResult' => true
            ],
            'Valid requestbuyerCostId' => [
                'invType' =>  'Normal',
                'transType' =>  0,
                'regNum' => '123/1.0.0',
                'cashier' => 'Radnik',
                'buyerId' => '10:123456',
                'buyerCostId' => '20:25-5',
                'refNum' => null,
                'refDT' => null,
                'payAmount' => 10,
                'payType' => 1,
                'item' => [
                    'gtin' => '12345678',
                    'name' => 'Test item/kg',
                    'quantity' => 1,
                    'unitPrice' => 10,
                    'labels' => ['A']
                ],
                'expectedResult' => true
            ],
            'Valid requestRefDoc' => [
                'invType' =>  'Normal',
                'transType' =>  0,
                'regNum' => '123/1.0.0',
                'cashier' => 'Radnik',
                'buyerId' => '10:123456',
                'buyerCostId' => '20:25-56',
                'refNum' => 'XXXXXXXX-XXXXXXXX-52',
                'refDT' => '2022/02/07 12:34:35.12',
                'payAmount' => 10,
                'payType' => 1,
                'item' => [
                    'gtin' => '12345678',
                    'name' => 'Test item/kg',
                    'quantity' => 1,
                    'unitPrice' => 10,
                    'labels' => ['A']
                ],
                'expectedResult' => true
            ],
            'Invalid requestInvType string' => [
                'invType' =>  'Valami',
                'transType' =>  0,
                'regNum' => '123/1.0.0',
                'cashier' => 'Radnik',
                'buyerId' => null,
                'buyerCostId' => null,
                'refNum' => null,
                'refDT' => null,
                'payAmount' => 10,
                'payType' => 1,
                'item' => [
                    'gtin' => '12345678',
                    'name' => 'Test item/kg',
                    'quantity' => 1,
                    'unitPrice' => 10,
                    'labels' => ['A']
                ],
                'expectedResult' => false
            ],
            'Invalid transTypeInt' => [
                'invType' =>  'Normal',
                'transType' =>  3,
                'regNum' => '123/1.0.0',
                'cashier' => 'Radnik',
                'buyerId' => null,
                'buyerCostId' => null,
                'refNum' => null,
                'refDT' => null,
                'payAmount' => 10,
                'payType' => 1,
                'item' => [
                    'gtin' => '12345678',
                    'name' => 'Test item/kg',
                    'quantity' => 1,
                    'unitPrice' => 10,
                    'labels' => ['A']
                ],
                'expectedResult' => false
            ],
            'Missing refDt have refDoc' => [
                'invType' =>  'Normal',
                'transType' =>  0,
                'regNum' => '123/1.0.0',
                'cashier' => 'Radnik',
                'buyerId' => null,
                'buyerCostId' => null,
                'refNum' => 'XXXXXXXX-XXXXXXXX-256',
                'refDT' => null,
                'payAmount' => 10,
                'payType' => 1,
                'item' => [
                    'gtin' => '12345678',
                    'name' => 'Test item/kg',
                    'quantity' => 1,
                    'unitPrice' => 10,
                    'labels' => ['A']
                ],
                'expectedResult' => false
            ],
            'Missing buyerId havebuyercost' => [
                'invType' =>  'Normal',
                'transType' =>  0,
                'regNum' => '123/1.0.0',
                'cashier' => 'Radnik',
                'buyerId' => null,
                'buyerCostId' => '20:55',
                'refNum' => null,
                'refDT' => null,
                'payAmount' => 10,
                'payType' => 1,
                'item' => [
                    'gtin' => '12345678',
                    'name' => 'Test item/kg',
                    'quantity' => 1,
                    'unitPrice' => 10,
                    'labels' => ['A']
                ],
                'expectedResult' => false
            ],
            'RefDoc wrongformat' => [
                'invType' =>  'Normal',
                'transType' =>  0,
                'regNum' => '123/1.0.0',
                'cashier' => 'Radnik',
                'buyerId' => '10:123456',
                'buyerCostId' => '20:25-56',
                'refNum' => 'XXXXXXX-XXXXXXXX-52',
                'refDT' => '2022/02/07 12:34:35.12',
                'payAmount' => 10,
                'payType' => 1,
                'item' => [
                    'gtin' => '12345678',
                    'name' => 'Test item/kg',
                    'quantity' => 1,
                    'unitPrice' => 10,
                    'labels' => ['A']
                ],
                'expectedResult' => false
            ],
            'buyerId wrong format' => [
                'invType' =>  'Normal',
                'transType' =>  0,
                'regNum' => '123/1.0.0',
                'cashier' => 'Radnik',
                'buyerId' => '12345',
                'buyerCostId' => '20:55',
                'refNum' => null,
                'refDT' => null,
                'payAmount' => 10,
                'payType' => 1,
                'item' => [
                    'gtin' => '12345678',
                    'name' => 'Test item/kg',
                    'quantity' => 1,
                    'unitPrice' => 10,
                    'labels' => ['A']
                ],
                'expectedResult' => false
            ],
            'buyerCostId wrong format' => [
                'invType' =>  'Normal',
                'transType' =>  0,
                'regNum' => '123/1.0.0',
                'cashier' => 'Radnik',
                'buyerId' => '10:12345',
                'buyerCostId' => '55',
                'refNum' => null,
                'refDT' => null,
                'payAmount' => 10,
                'payType' => 1,
                'item' => [
                    'gtin' => '12345678',
                    'name' => 'Test item/kg',
                    'quantity' => 1,
                    'unitPrice' => 10,
                    'labels' => ['A']
                ],
                'expectedResult' => false
            ],
            'missing item' => [
                'invType' =>  'Normal',
                'transType' =>  0,
                'regNum' => '123/1.0.0',
                'cashier' => 'Radnik',
                'buyerId' => '10:12345',
                'buyerCostId' => '20:55',
                'refNum' => null,
                'refDT' => null,
                'payAmount' => 10,
                'payType' => 1,
                'item' => [
                    'gtin' => '12345678',
                    'name' => null,
                    'quantity' => 1,
                    'unitPrice' => 10,
                    'labels' => ['A']
                ],
                'expectedResult' => false
            ],
            'missing pay' => [
                'invType' =>  'Normal',
                'transType' =>  0,
                'regNum' => '123/1.0.0',
                'cashier' => 'Radnik',
                'buyerId' => '10:12345',
                'buyerCostId' => '20:55',
                'refNum' => null,
                'refDT' => null,
                'payAmount' => -10,
                'payType' => 1,
                'item' => [
                    'gtin' => '12345678',
                    'name' => 'Test item/kg',
                    'quantity' => 1,
                    'unitPrice' => 10,
                    'labels' => ['A']
                ],
                'expectedResult' => false
            ],
            'Valid missingCashier' => [
                'invType' =>  0,
                'transType' =>  0,
                'regNum' => '123/1.0.0',
                'cashier' => null,
                'buyerId' => null,
                'buyerCostId' => null,
                'refNum' => null,
                'refDT' => null,
                'payAmount' => 10,
                'payType' => 1,
                'item' => [
                    'gtin' => '12345678',
                    'name' => 'Test item/kg',
                    'quantity' => 1,
                    'unitPrice' => 10,
                    'labels' => ['A']
                ],
                'expectedResult' => true
            ],
            ];
        }

}

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
            'Valid payTypeint' => [
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
                ]
                'expectedResult' => true
            ]
        ]

}

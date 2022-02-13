<?php

namespace WdevRs\PhpEsir\Tests;

use PHPUnit\Framework\TestCase;
use WdevRs\PhpEsir\Request\InvoiceItem;
use WdevRs\PhpEsir\Request\InvoicePay;
use WdevRs\PhpEsir\Request\InvoiceRequest;


class RequestTest extends TestCase{

    /**
     * @dataProvider provideReqData
     */
    public function testRequestIsValid($requestData, $expectedResult)
    {
       
        $req = new InvoiceRequest($requestData);
        
        $this->assertEquals($expectedResult, $req->isValid());
    }

    public function provideReqData(){
        return [
            'Valid request' => [
                'requestData' =>[
                   'invoiceType' =>  0,
                   'transactionType' =>  0,
                   'invoiceNumber' => '123/1.0.0',
                   'cashier' => 'Radnik',
                   'buyerId' => null,
                   'buyerCostCenterId' => null,
                   'referentDocumentNumber' => null,
                   'referentDocumentDT' => null,
                   'payment' => [
                       [
                       'amount' => 10,
                       'paymentType' => 1
                       ]
                   ],     
                   'items' => [
                       [
                      'gtin' => '12345678',
                      'name' => 'Test item/kg',
                      'quantity' => 1,
                      'unitPrice' => 10,
                      'labels' => ['A']
                       ]
                    ],
                ],
                'expectedResult' => true
            ],
            'Valid requestWord' => [
                'requestData' =>[
                   'invoiceType' =>  'Normal',
                   'transactionType' =>  'Sale',
                   'invoiceNumber' => '123/1.0.0',
                   'cashier' => 'Radnik',
                   'buyerId' => null,
                   'buyerCostCenterId' => null,
                   'referentDocumentNumber' => null,
                   'referentDocumentDT' => null,
                   'payment' => [
                       [
                       'amount' => 10,
                       'paymentType' => 1
                       ],
                       [
                        'amount' => 10,
                        'paymentType' => 'Cash'
                        ]
                   ],     
                   'items' => [
                       [
                      'gtin' => '12345678',
                      'name' => 'Test item/kg',
                      'quantity' => 1,
                      'unitPrice' => 10,
                      'labels' => ['A']
                       ]
                    ],
                ],
                'expectedResult' => true
                ]
            ];
        }

}

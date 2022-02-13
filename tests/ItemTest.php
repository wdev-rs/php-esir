<?php

namespace WdevRs\PhpEsir\Tests;

use PHPUnit\Framework\TestCase;
use WdevRs\PhpEsir\InvoiceRequest\InvoiceItem;


class ItemTest extends TestCase
{

    public function testEmptyItem()
    {
        $item = new InvoiceItem();
        $this->assertFalse($item->isValid());
    }

    /**
     * @dataProvider provideItemData
     */
    public function testItem($itemData, $expectedResult)
    {
        $item = new InvoiceItem($itemData);
        $this->assertEquals($expectedResult, $item->isValid());
    }

    public function provideItemData()
    {
        return [
            'Valid item data' => [
                'itemData' => [
                'gtin' => null,
                'name' => 'Test name/kom',
                'quantity' => 1,
                'unitPrice' => 10,
                'labels' => ['A']
                ],
                'expectedResult' => true
            ],
            'Missing name' => [
                'itemData' => [
                'gtin' => null,
                'name' => null,
                'quantity' => 1,
                'unitPrice' => 10,
                'labels' => ['A']
                ],
                'expectedResult' => false
            ],
            'Name whitout unit' => [
                'itemData' => [
                'gtin' => null,
                'name' => 'Test item',
                'quantity' => 1,
                'unitPrice' => 10,
                'labels' => ['A']
                ],
                'expectedResult' => false
            ],
            'Valid gtin' => [
                'itemData' => [
                'gtin' => '12345678',
                'name' => 'Test item/kg',
                'quantity' => 1,
                'unitPrice' => 10,
                'labels' => ['A']
                ],
                'expectedResult' => true
            ],
            'Invalid gtin' => [
                'itemData' => [
                'gtin' => '1234567',
                'name' => 'Test item/kg',
                'quantity' => 1,
                'unitPrice' => 10,
                'labels' => ['A']
                ],
                'expectedResult' => false
            ],
            'Invalid unitPrice' => [
                'itemData' => [
                'gtin' => '12345678',
                'name' => 'Test item/kg',
                'quantity' => 1,
                'unitPrice' => 0,
                'labels' => ['A']
                ],
                'expectedResult' => false
            ],
            'No labels' => [
                'itemData' => [
                'gtin' => '12345678',
                'name' => 'Test item/kg',
                'quantity' => 1,
                'unitPrice' => 10,
                'labels' => []
                ],
                'expectedResult' => false
            ],
            'Invalid quantity' => [
                'itemData' => [
                'gtin' => '12345678',
                'name' => 'Test item/kg',
                'quantity' => -1,
                'unitPrice' => 10,
                'labels' => ['A']
                ],
                'expectedResult' => false
            ]
        ];
    }

    /**
     * @dataProvider providePriceData
     */
    public function testsetUnitPrice($priceData, $expectedResult)
    {
        $item = new InvoiceItem();
        $this->assertEquals($expectedResult, $item->setUnitPrice($priceData));
    }

    public function providePriceData(){
        return [
            'Valid unitPrice' => [
                'priceData' =>  10.5,
                'expectedResult' => true

            ],
            'Null unitPrice' => [
                'priceData' =>  null,
                'expectedResult' => false

            ],
            'Negative unitPrice' => [
                'priceData' =>  -10.5,
                'expectedResult' => false

               ]
            ];
    }

     /**
     * @dataProvider provideQuantData
     */
    public function testaddNewQuantity($quantData, $expectedResult)
    {
        $item = new InvoiceItem();
        $item -> setUnitPrice(10);
        $this->assertEquals($expectedResult, $item->addQuantity($quantData));
    }

     /**
     * @dataProvider provideAddQuantData
     */
    public function testaddMoreQuantity($quantData, $expectedResult)
    {
        $item = new InvoiceItem();
        $item -> setUnitPrice(10);
        $item->addQuantity(1);
        $this->assertEquals($expectedResult, $item->addQuantity($quantData));
    }

    public function provideQuantData(){
        return [
            'Valid quant' => [
                'quantData' =>  2,
                'expectedResult' => true

            ],
            'Null quant' => [
                'quantData' =>  null,
                'expectedResult' => false

            ],
            'Negative quant' => [
                'quantData' =>  -2,
                'expectedResult' => false

               ]
            ];
    }

    public function provideAddQuantData(){
        return [
            'Valid quant' => [
                'quantData' =>  2,
                'expectedResult' => true

            ],
            'Null quant' => [
                'quantData' =>  null,
                'expectedResult' => false

            ],
            'Negative quant' => [
                'quantData' =>  -2,
                'expectedResult' => true

               ]
            ];
    }

    /**
     * @dataProvider provideLabelData
     */
    public function testaddLabel($labelData, $expectedResult)
    {
        $item = new InvoiceItem();
        
        $this->assertEquals($expectedResult, $item->addOneLabel($labelData));
    }

    public function provideLabelData(){
        return [
            'Valid label' => [
                'labelData' =>  'A',
                'expectedResult' => true

            ],
            'Null label' => [
                'labelData' =>  null,
                'expectedResult' => false

            ],
            'Nonstring label' => [
                'labelData' =>  2,
                'expectedResult' => false

            ],
            'Long label' => [
                'labelData' =>  'Huhu',
                'expectedResult' => false

               ]
            ];
    }

}
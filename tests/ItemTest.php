<?php

namespace WdevRs\PhpEsir\Tests;

use PHPUnit\Framework\TestCase;
use WdevRs\PhpEsir\Request\Item;


class ItemTest extends TestCase
{

    public function testEmptyItem()
    {
        $item = new Item();
        $this->assertFalse($item->isValid());
    }

    /**
     * @dataProvider provideItemData
     */
    public function testItem($itemData, $expectedResult)
    {
        $item = new Item($itemData);
        $this->assertEquals($expectedResult, $item->isValid());
    }

    public function provideItemData()
    {
        return [
            'Valid item data' => [
                'itemData' => [
                'gtin' => null,
                'name' => 'Test name',
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
            ]
        ];
    }

}
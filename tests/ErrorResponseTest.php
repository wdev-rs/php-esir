<?php

namespace WdevRs\PhpEsir\Tests;

use PHPUnit\Framework\TestCase;
use WdevRs\PhpEsir\Invoice\ErrorResponse;
use WdevRs\PhpEsir\Invoice\ModelError;


class ErrorResponseTest extends TestCase{

    /**
     * @dataProvider provideErrorData
     */
    public function testErrorResponseMessage($errorString, $expectedResult)
    {
        $err = new ErrorResponse($errorString);
        $this->assertEquals($expectedResult, $err->getMessage());
    }

     /**
     * @dataProvider provideModelErrorData
     */
    public function testModelErrorProperty($errorString, $expectedResult)
    {
        $err = new ErrorResponse($errorString);
        $modelErr = $err->getModelState;
        $modelErr = $modelErr[0];
        $this->assertEquals($expectedResult, $modelErr->getProperty());
    }


    public function provideErrorData(){
        return [
            'Valid Error Message' => [
                'errorString' => [
                    [
                    'message' => 'Bad request',
                    'modelState' => [
                        
                            'property' => 'referentDocumentDT',
                            'errors' => ['2100','1500']
                        
                    ]
                 ] ],
                'expactedResult' => 'Bad request'
            ]
        ];

    }

    public function provideModelErrorData(){
        return [
            'Valid Error Message' => [
                'errorString' => [
                    'message' => 'Bad request',
                    'modelState' => [
                        
                            'property' => 'referentDocumentDT',
                            'errors' => ['2100','1500']
                        
                    ]
                ],
                'expactedResult' => 'referentDocumentDT'
            ]
        ];

    }


}
<?php

namespace WdevRs\PhpEsir\Tests;

use PHPUnit\Framework\TestCase;
use WdevRs\PhpEsir\Invoice\ErrorResponse;
use WdevRs\PhpEsir\Invoice\ModelError;


class ErrorResponseTest extends TestCase{

    
    public function testErrorResponseMessage()
    {
        $errorJsonString = '{"message":"Bad Request","modelState":[{"property":"referentDocumentNumber","errors":["2806"]}]}';
        $errorArray = json_decode($errorJsonString, true);
        $err = new ErrorResponse($errorArray);
        $this->assertEquals("Bad Request", $err->getMessage());
    }

    
    public function testModelErrorProperty()
    {
        $errorJsonString = '{"message":"Bad Request","modelState":[{"property":"referentDocumentNumber","errors":["2806"]}]}';
        $errorArray = json_decode($errorJsonString, true);
        $err = new ErrorResponse($errorArray);
        $modelErr = $err->getModelState();
        $modelErr = $modelErr[0];
        $this->assertEquals("referentDocumentNumber", $modelErr->getProperty());
    }

    public function testModelErrorCodes()
    {
        $errorJsonString = '{"message":"Bad Request","modelState":[{"property":"referentDocumentNumber","errors":["2806"]}]}';
        $errorArray = json_decode($errorJsonString, true);
        $err = new ErrorResponse($errorArray);
        $modelErr = $err->getModelState();
        $modelErr = $modelErr[0];
        $this->assertEquals(["2806"], $modelErr->getErrors());
    }
   
    public function testModelErrorProperty2()
    {
        $errorJsonString = '{"message":"Bad Request","modelState":[{"property":"referentDocumentNumber","errors":["2800"]},{"property":"referentDocumentDT","errors":["2800"]}]}';
        $errorArray = json_decode($errorJsonString, true);
        $err = new ErrorResponse($errorArray);
        $modelErr = $err->getModelState();
        $modelErr = $modelErr[1];
        $this->assertEquals("referentDocumentDT", $modelErr->getProperty());
    }
}
<?php
namespace WdevRs\PhpEsir\Invoice;

class ModelError {

    protected $property;
    protected $errors;

    public function __construct($prop, $err){
        $this->property = $prop ?? null;
        if (is_array($err)){
            foreach ($err as $errorCode){
                $errors[] = $errorCode;
            }
        }else{
            $errors[] = $err ?? null;
        }

    }

    public function getProperty(){
        return $this->property;
    }

    public function getErrors(){
        return $this->errors;
    }
}
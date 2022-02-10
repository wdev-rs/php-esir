<?php
namespace WdevRs\PhpEsir\Invoice;

class ModelError {

    protected $property;
    protected $errors;

    public function __construct($prop){
        foreach ($prop as $err => $value)
        if (is_array($value)){
        
              $this->errors = $value;
        
        }else{
            $this->property = $value;
        }

    }

    public function getProperty(){
        return $this->property;
    }

    public function getErrors(){
        return $this->errors;
    }
}
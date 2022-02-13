<?php
namespace WdevRs\PhpEsir\VirtualInvoiceProcesorStatus;

//az egy tax rate meghatarozasa label - rate
class TaxRate {

    //Az adokulcs szazalekos erteke
    protected $rate;

    //Az alkalmazott label
    protected $label;

    public function __construct($rate){
        foreach ($rate as $key => $value){
            $this->$key = $value;
        }

    }

    public function getRate(){
        return $this->rate;
    }

    public function getLabel(){
        return $this->label;
    }

}
<?php
namespace WdevRs\PhpEsir\InvoiceResponse;

//A szamla responzaban lesz egy lista, az adoelszeamolasrol a lista elemei a class adatait tartalmazzak
class TaxItem {

    //Az ado tipusa taxOnTotal, taxOnNetto vagy taxPerQuantity
    protected $categoryType;   
    
    //Az alkalmazott label
    protected $label;   
    
    //A befizetendo ado osszege erre a labelre
    protected $amount;   
    
    //Az ado szazalekos kulcsa
    protected $rate;     
    
    //Az adokategoria neve pl VAT
    protected $categoryName;
    
    //Egy array jon a konstructorba amine key ei megegyeznek a class valtozoival
    public function __construct($tax){
        foreach ($tax as $key => $value){
            $this->$key = $value;
        }
    }

    public function getCategoryType(){
        return $this->categoryType;
    }

    public function getLabel(){
        return $this->label;
    }

    public function getAmount(){
        return $this->amount;
    }

    public function getRate(){
        return $this->rate;
    }

    public function getCategoryName(){
        return $this->categoryName;
    }

}
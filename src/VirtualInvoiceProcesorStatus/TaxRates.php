<?php
namespace WdevRs\PhpEsir\VirtualInvoiceProcesorStatus;


class TaxRates {

    //A datum amitol az adocsoport ervenyben van
    protected $validFrom; 

    //A csoport azonosito szama
    protected $groupId; 

    //Egy array a az ado kategoriakrol amik az adot csoportba tartoznak
    protected $taxCategories;

    public function __construct($taxes){
        if (is_array($taxes)){
            foreach ($taxes as $key => $value){
                if (is_array($value)){
                    foreach ( $value as $taxCategory){
                       $tax = new TaxCategory($taxCategories);
                       $this->taxCategories[] = $tax;
                    }
                }else{
                    $this->$key = $value;
                }
            }
        }
    }

    public function getValidFrom(){
        return $this->validFrom;
    }

    public function getGroupId(){
        return $this->groupId;
    }

    public function getTaxCategories(){
        return $this->taxCategories;
    }


}
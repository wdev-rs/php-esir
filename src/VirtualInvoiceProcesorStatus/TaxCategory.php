<?php
namespace WdevRs\PhpEsir\VirtualInvoiceProcesorStatus;

//Meghataroz egy tax kategoriat, ami all tobb taxratesbol ami all tax rate bol :)
class TaxCategory {

    //A kategoria neve
    protected $name; 

    //A kategoria tipusa pl tax on total, tax on netto, tax on quantity
    protected $categoryType; 

    //Array tax rate bol, ami tartalmazza a rate es label fieldet
    protected $taxRates; 

    //A kategoria sorszama
    protected $orderId;

    public function __construct($category){
        if (is_array($category)){
            foreach ( $category as $key => $value){
                if (is_array($value)){
                    foreach ($value as $rate){
                        $taxRate = new TaxRate($rate);
                        $this->taxRates[] = $taxRate;
                    }
                }else {
                    $this->$key = $value;
                }
            }
        }
    }

    public function getName(){
        return $this->name;
    }

    public function getCategoryType(){
        return $this->categoryType;
    }

    public function getTaxRates(){
        return $this->taxRates;
    }

    public function getOrderId(){
        return $this->orderId;
    }

}
<?php
namespace WdevRs\PhpEsir\VirtualInvoiceProcesorStatus;


class TaxRates {

    //A datum amitol az adocsoport ervenyben van
    protected $validFrom; 

    //A csoport azonosito szama
    protected $groupId; 

    //Egy array az ado kategoriakrol amik az adot csoportba tartoznak
    protected $taxCategories;

    public function __construct($taxes){
        if (is_array($taxes)){
            foreach ($taxes as $key => $value){
                if (is_array($value)){
                    foreach ( $value as $taxCategory){
                       $tax = new TaxCategory($taxCategory);
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

    public function getLabels(){
        $labels = [];
        foreach ($this->taxCategories as $taxCategory) {
            foreach ($taxCategory->getTaxRates() as $taxRate){
                $newLabel = [
                    'order_id'      => $taxCategory->getOrderId(),
                    'name'          => $taxCategory->getName(),
                    'category_type' => $taxCategory->getCategoryType(),
                    'label'         => $taxRate->getLabel(),
                    'rate'          => $taxRate->getRate(),
                ];
                $labels[] = $newLabel;
            }
        }
        return $labels;
    }

}
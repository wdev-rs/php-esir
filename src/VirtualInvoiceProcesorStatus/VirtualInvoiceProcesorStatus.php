<?php
namespace WdevRs\PhpEsir\VirtualInvoiceProcesorStatus;

//A webshop termekeinek megfelelo ado labelhez valo beallitashoz lehet egy jelentest lekerni
//Amely tartalmazza az aktualis adokulcsokat, a regebbi adokulcsokat es a kovetkezo tervezett adokulcsokat
//Valamint meg sok mas haszontalan infot 
class VirtualInvoiceProcesorStatus {

    //Az ido amikor a status el lett kuldve
    protected $sdcDateTime; 

    //A virtualis procesor azonositoja
    protected $uid; 

    //A tax core api alapcime
    protected $taxCoreApi; 

    //a jelenleg ervenyben levo tax rates
    protected $currentTaxRates; 

    //Egy array az osszes tax rates rol
    protected $allTaxRates; 

    //Egy string array a tamogatot nyelvekrol
    protected $supportedLanguages; 

    //Ezt meg tesztelni kell!!!!!!
    public function __construct($status){
        $this->sdcDateTime = $status['sdcDateTime'] ?? null;
        $this->uid = $status['uid'] ?? null;
        $this->taxCoreApi = $status['taxCoreApi'] ?? null;
        $this->supportedLanguages = $status['supportedLanguages'] ?? [];
        $this->currentTaxRates = new TaxRates($status['currentTaxRates']);
        foreach ($status['allTaxRates'] as $allTax){
            $oneTax = new TaxRates($allTax);
            $this->allTaxRates[] = $oneTax;
        }

    }

    public function getSdcDateTime(){
        return $this->sdcDateTime;

    }

    public function getUid(){
        return $this->uid;
    }

    public function getTaxCoreApi(){
        return $this->taxCoreApi;
    }

    public function getCurrentTaxRates(){
        return $this->currentTaxRates;
    }

    public function getAllTaxRates(){
        return $this->allTaxRates;
    }

    public function getSupportedLanguages(){
        return $this->supportedLanguages;
    }

    public function getCurrentLabels(){
        return $this->currentTaxRates->getLabels();
    }

}
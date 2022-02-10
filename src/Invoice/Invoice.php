<?php
namespace WdevRs\PhpEsir\Invoice;

//sikeres fiszkalizacio utan a valasz ez a model adatait fogja tartalmazni
class Invoice {

    protected $requestedBy; 
    protected $sdcDateTime; 
    protected $invoiceCounter; 
    protected $invoiceCounterExtension; 
    protected $invoiceNumber; 
    protected $taxItems; 
    protected $verificationUrl; 
    protected $verificationQRCode; 
    protected $journal; 
    protected $messages; 
    protected $signedBy; 
    protected $encryptedInternalData; 
    protected $signature; 
    protected $totalCounter; 
    protected $transactionTypeCounter; 
    protected $totalAmount; 
    protected $taxGroupRevision; 
    protected $businessName; 
    protected $tin; 
    protected $locationName; 
    protected $address; 
    protected $district; 
    protected $mrc;  
    
    public function __construct($invoice){
        foreach ($invoice as $key => $value){
            if (is_array($value)){
                foreach($value as $tax){
                    $taxModel = new TaxItem($tax);
                    $this->taxItems[] = $taxModel;
                }

            }else {
                $this->$key = $value;
            }
            
        }
    }

}
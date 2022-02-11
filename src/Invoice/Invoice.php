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

    public function getRequestedBy(){
        return $this->requestedBy;
    }

    public function getSdcDateTime(){
        return $this->sdcDateTime;
    }

    public function getInvoiceCounter(){
        return $this->invoiceCounter;
    }

    public function getInvoiceCounterExtension(){
        return $this->invoiceCounterExtension;
    }

    public function getInvoiceNumber(){
        return $this->invoiceNumber;
    }

    //Egy array a Tax Itemekbol
    public function getTaxItems(){
        return $this->taxItems;
    }

    //Ezt kell mindenfelekeppen a szamlahoz csatolni!!!!
    public function getVerificationUrl(){
        return $this->verificationUrl;
    }

    //Ugyis null
    public function getVerificationQRCode(){
        return $this->verificationQRCode;
    }

    //A fiszkalis resz a szamlanak
    public function getJournal(){
        return $this->journal;
    }

    //Ertelmetlen, mindeg success, ha nem ugyis error response volt
    public function getMessages(){
        return $this->messages;
    }

    public function getSignedBy(){
        return $this->signedBy;
    }

    //Ugyis olvashatatlan, de ha valaki akar oszeviszasagot nezni
    public function getEncryptedInternalData(){
        return $this->encryptedInternalData;
    }

    //Mint a fentebbi
    public function getSignature(){
        return $this->signature;
    }

    //Osszesen hany szamla lett kiadva
    public function getTotalCounter(){
        return $this->totalCounter;
    }

    //Az adott szamlatipusbol, amihez ez a szamla tartozik, hany szamla lett edig kiadva
    public function getTransactionTypeCounter(){
        return $this->transactionTypeCounter;
    }

    public function getTotalAmount(){
        return $this->totalAmount;
    }

    //Az adocsoport kodja, ami alapjan let az ado szamolva a szamlan
    public function getTaxGroupRevision(){
        return $this->taxGroupRevision;
    }


    //Ha elfelejtenenk a cegunk nevet itt leelenorizhetjuk
    public function getBusinessName(){
        return $this->businessName;
    }

    //Valojaba a ceg PIB je
    public function getTin(){
        return $this->tin;
    }

    public function getLocationName(){
        return $this->locationName;
    }

    public function getAddress(){
        return $this->address;
    }

    //A varos neve
    public function getDistrict(){
        return $this->district;
    }

    //A regisztracios kodja a programnak amelyik alairta a szamlat
    public function getMrc(){
        return $this->mrc;
    }

}
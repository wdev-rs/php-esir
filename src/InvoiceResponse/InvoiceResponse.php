<?php
namespace WdevRs\PhpEsir\InvoiceResponse;

//sikeres fiszkalizacio utan a valasz ez a model adatait fogja tartalmazni
class InvoiceResponse {

    protected $requestedBy; 
    protected $sdcDateTime; 
    protected $invoiceCounter; 
    protected $invoiceCounterExtension; 
    protected $invoiceNumber; 
    protected $taxItems; 
    protected $verificationUrl; 
    protected $verificationQRCode; 
    protected $journal; 
    protected $messages = null; 
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

    public function toArray()
    {
        $data = [];
        if ( $this->requestedBy !== null) {
            $data['requestedBy'] = $this->requestedBy;
        }
        if ($this->sdcDateTime !== null) {
            $data['sdcDateTime'] = $this->sdcDateTime;
        }
        if ($this->invoiceCounter !== null) {
            $data['invoiceCounter'] = $this->invoiceCounter;
        }
        if ($this->invoiceCounterExtension !== null) {
            $data['invoiceCounterExtension'] = $this->invoiceCounterExtension;
        }
        if ($this->verificationUrl !== null) {
            $data['verificationUrl'] = $this->verificationUrl;
        }
        if ($this->verificationQRCode !== null) {
            $data['verificationQRCode'] = $this->verificationQRCode;
        }
        if ($this->invoiceNumber !== null) {
            $data['invoiceNumber'] = $this->invoiceNumber;
        }
        if ($this->journal !== null) {
            $data['journal'] = $this->journal;
        }
        if ($this->messages !== null) {
            $data['messages'] = $this->messages;
        }
        if ($this->signedBy !== null) {
            $data['signedBy'] = $this->signedBy;
        }
        if ($this->encryptedInternalData !== null) {
            $data['encryptedInternalData'] = $this->encryptedInternalData;
        }
        if ($this->signature !== null) {
            $data['signature'] = $this->signature;
        }
        if ($this->totalCounter !== null) {
            $data['totalCounter'] = $this->totalCounter;
        }
        if ($this->transactionTypeCounter !== null) {
            $data['transactionTypeCounter'] = $this->transactionTypeCounter;
        }
        if ($this->totalAmount !== null) {
            $data['totalAmount'] = $this->totalAmount;
        }
        if ($this->taxGroupRevision !== null) {
            $data['taxGroupRevision'] = $this->taxGroupRevision;
        }
        if ($this->businessName !== null) {
            $data['businessName'] = $this->businessName;
        }
        if ($this->tin !== null) {
            $data['tin'] = $this->tin;
        }
        if ($this->locationName !== null) {
            $data['locationName'] = $this->locationName;
        }
        if ($this->address !== null) {
            $data['address'] = $this->address;
        }
        if ($this->district !== null) {
            $data['district'] = $this->district;
        }
        if ($this->mrc !== null) {
            $data['mrc'] = $this->mrc;
        }
       
        $taxItems = [];
        if (count($this->taxItems) > 0) {
            foreach ($this->taxItems as $taxItem) {
                $newTaxItem = [
                    'categoryType' => $taxItem->getCategoryType(),
                    'label' => $taxItem->getLabel(),
                    'amount' => $taxItem->getAmount(),
                    'rate' => $taxItem->getRate(),
                    'categoryName' => $taxItem->getCategoryName(),
                ];
                $taxItems[] = $newTaxItem;
            }
        }
        $data['taxItems'] = $taxItems;
        

        return $data;
    }

}
<?php
namespace WdevRs\PhpEsir\InvoiceRequest;

//Az egy fizetesfajta meghatarozasara es a fizetes osszege
class InvoicePay {

    //az amountnak 0 vagy nagyobbnak kell lenie
    protected $amount;

    /*a payment type lehet integer vagy string mindkettot elfogadja a proceszor
    paymentType ertekei lehetnek a kovetkezok int - string formaban
    0 - Other
    1 - Cash
    2 - Card
    3 - Check
    4 - WireTransfer
    5 - Voucher
    6 - MobileMoney */   
    protected $paymentType;

    public function __construct($payment){
        $this->amount = $payment['amount'] ?? null;
        $this->paymentType = $payment['paymentType'] ?? null;
    }

    public function isValid(){

        //az osszegnek szamnak kell lenie, ha nem az bisztos nem jo
        if (is_numeric($this->amount)){

            //Nem lehet kevesebb mint nulla, megha refund akkor is pozitivba kell megadni
            if ($this->amount < 0){
                return false;
            }

            //Ez a maximum osszeg amit meg lehet adni
            if ($this->amount > 999999999999.99){
                return false;
            }
        }else{

            //Nem szam volt az amount
            return false;
        }

        //A paytype lehet szam vagy string itt megnezuk szam e
        if (is_numeric($this->paymentType)){

            //Ha szam 0 es 6 kozott kell lenie
            if ($this->paymentType < 0 || $this->paymentType > 6){
                return false;
            }

            //Nem szam volt, tehat osszehasonlitsuk a stringekkel, a kis es nagy beture vigyazni kell, mert erzekeny ra a proceszor
        }elseif ($this->paymentType !== 'Other' && $this->paymentType !== 'Cash' && $this->paymentType !== 'Card' && $this->paymentType !== 'Check' && $this->paymentType !== 'WireTransfer' && $this->paymentType !== 'Voucher' && $this->paymentType !== 'MobilMoney'){
            return false;
        }

        //Ha egyik ellenorzes sem kuldott vissza false ot talan minden jo
        return true;
    }
    //amount
    public function getAmount()
    {
        return $this->amount;
    }
    //paymentType
    public function getPaymentType()
    {
        return $this->paymentType;
    }
}
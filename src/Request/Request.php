<?php
namespace WdevRs\PhpEsir\Request;

//A vegleges szamlakerelmi modell amit kell majd elkuldeni
class Request {
    //A dateAndTimeOfIssue -t csak is es kizarolag AVANS PRODAJA esetebe kell megadni, minden mas esetbe null kell, hogy legyen
    protected $dateAndTimeOfIssue;

    //lenyegtelen adat lehet null vagy valakinek a neve aki elmeletileg a kaszan dolgozik alltalaba null
    public $cashier = null;

    //lehet megadni, de a formatuma macerans meghatarozott kodszamok vannak a kulonbozo azonositashoz, nemely szamlan viszont kotelezo :(
    public $buyerId = null;

    //egyaltalan nem kotelezo, de ha meg van adva kotelezo, hogy legyen buyerId is megadva ugyszinten kodszamokkal megy
    public $buyerCostCenterId = null;

    //FONTOS lehet szam vagy string kovetkezok lehetnek int - string formaban:
        //0 - Normal  
        //1 - ProForma   
        //2 - Copy       
       // 3 - Training   
       // 4 - Advance
    
    protected $invoiceType;

    //FONTOS lehet szam vagy string kovetkezok lehetnek int - string formaban
    //0 - Sale
    //1 - Refund
    protected $transactionType;

    //Array a Pay classokbol, akkor is array kell, hogy legyen, ha csak egy eleme van
    protected $payment;

    //Ez nem az aminek gondolja az ember, ez a PROGRAM regisztracios kodja, ugyhogy hardcodolva lesz a vegen :)
    protected $invoiceNumber;

    //Ha egy szamlat egy masik szamlara hivatkozva adnak ki a kovetkezo ket mezo kotelezo
    //Copy es refundnal mindenfelekeppen, vagy normal, ami tartalmaz Avans fizetest, vagy eloszamlara hivatkozik
    //A referentDocumentNumber a szamla szama, ami a responsba visszajott
    //A DT pedig az ideje, vigyazni kell a datum formatumara, stringbe kell keldeni yyyy/MM/DD hh:mm:ss.ms formatumban
    public $referentDocumentNumber;
    public $referentDocumentDT;

    //Ez hogy kersz e vissza QR kodott, meg journalt ezzel a bealitassal journal jon QR kod nem
    public $options = array("omitQRCodeGen" => '1', "omitTextualRepresentation" => '0');

    //array az Item class bol akkor is array, ha csak egy item van
    protected $items;

    //Az invoice tipusat es transakcio tipusat keszitesnel logikus megadni, igy pl keszitsz egy Normal Sale szamla alapjat
    public function __construct($invType, $transType, $programRegNum){
        $this->invoiceType = $invType;
        $this->transactionType = $transType;
        $this->invoiceNumber = $programRegNum;
    }

    //Ha kell dateandtime a szamlara, a szamlakeszitesi idejet meg adni ezzel a functioval
    public function setDateAndTimeOfIssue(){

        //Ha a szamla nem Advance nem szabad megadni a datumjat
        if ($this->invoiceType === 4 || $this->invoiceType == 'Advance'){
             //esetleg idozonat meghatarozni elotte
             $this->dateAndTimeOfIssue =date("Y/m/d H:i:s");
        }    
    }

    //Egy itemet add a szamlahoz, ha tobb van tobszor kell hivni ugyanezt a functiot
    public function addItem(Item $Itm){

        //leellenorizi magat az item, hogy meg e van minden erteke, ha nincs nem adja hozza(a return ertekkel lehet leellenorizni, hogy hozza lett e adva a szamlahoz)
        if ($Itm -> isValid()){
            $this->items[] = $Itm;
            return true;
        }else{
            return false;
        }
    }

    //Egy paymantet add a szamlahoz, ha tobb van tobbszor kell hivni ugyanazt a functiont
    public function addPaymant(Pay $payment){
        if ($payment -> isValid()){
            $this->payment[] = $payment;
            return true;
        }else{
            return false;
        }
    }

    //leelenorizni, hogy a szamla minden lenyeges resze meg e van
    public function isValid(){

        //Ha Advance szamla kell, hogy legyen datum
        if ($this->invoiceType === 4 || $this->invoiceType == 'Advance'){
            if ($this->dateAndTimeOfIssue === null){
                return false;
            }
        }

        //Ha van megadva cashier az azonosito nem lehet 20 characternel hosszabb
        if ($this->cashier !== null){
            if (strlen($this->cashier) > 20){
                return false;
            }
        }

        //Leellenorizni van e buyerid
        if ($this->buyerId !== null){

            //A buyerId nem lehet tobb mint 50 character
            if (strlen($this->buyerId) > 50){
                return false;
            }

            //A bayerId-nek meghatarozott formatuma van code:documentum number, a : - nal szetvalasztjuk, hogy ellenorizuk a forma jo e 
            $sec = explode(':', $this->buyerId);
            if (count($sec) !== 2){
                return false;
            }
        }
        // Leellenorizni van e buyerCostCenterId
        if ($this->buyerCostCenterId !== null){

            //Ha van kitoltve buyerCostCenterId muszaj, hogy legyen kitoltve buyerId is
            if ($this->buyerId === null){
                return false;
            }

            //Nem lehet hoszabb 50 karakternel
            if (strlen($this->buyerCostCenterId) > 50){
                return false;
            }

            //Megprobaljuk szetvalasztani a : nal, hogy ellenorizuk a formatum jo e
            $secC = explode(':', $this->buyerCostCenterId);
            if (count($secC) !== 2){
                return false;
            }
        }

        //Ellenorizni az invoiceTypot
        //Ha null, bisztos nem jo
        if ($this->invoiceType === null){
            return false;
        }

        //Szam erteke 0-4 kozott lehet, ha kisebb 0 vagy nagyobb 4 out of range
        if (is_numeric($this->invoiceType)){
            if ($this->invoiceType !== 0 && $this->invoiceType !== 1 && $this->invoiceType !== 2 && $this->invoiceType !== 3 && $this->invoiceType !== 4){
                return false;
            }
        }else{

            //Ha stringertek a felsorolt ertekek lehetnek nagybetukre vigyazni
            if ($this->invoiceType != 'Normal' && $this->invoiceType != 'ProForma' && $this->invoiceType != 'Copy' && $this->invoiceType != 'Training' && $this->invoiceType != 'Advance'){
                return false;
            }
        }

        //Leellenorizni a transactionType-ot
        //Nem lehet null
        if ($this->transactionType === null){
            return false;
        }

        //Ha szam van megadva vagy 0 vagy 1 lehet
        if (is_numeric($this->transactionType)){
            if ($this->transactionType !== 0 && $this->transactionType !== 1){
                return false;
            }
        }else{

            //Ha string akkor Sale vagy Refund lehet, vigyazni a nagy betukkel
            if ($this->transactionType != 'Sale' && $this->transactionType != 'Refund'){
                return false;
            }
        }

        //Ellenorizni a paymenteket
        if ($this->payment === null){
            return false;
        }

        //Megha egy eleme is van, muszaj, hogy array legyen
        if (!is_array($this->payment)){
            return false;
        }

        //Nem lehet ures array
        if(count($this->payment) < 1){
            return false;
        }

        //Ellenorizni, hogy van e refdocnum
        if ($this->referentDocumentNumber !== null){

            //Ha van refdocnum kell, hogy legyen DT is
            if ($this->referentDocumentDT === null){
                return false;
            }
            $refSec = explode('-', $this->referentDocumentNumber);
            if ($refSec !== 3){
                return false;
            }

        }
          
    }

}
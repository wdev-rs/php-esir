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
    
    public $invoiceType;

    //FONTOS lehet szam vagy string kovetkezok lehetnek int - string formaban
    //0 - Sale
    //1 - Refund
    public $transactionType;

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

}
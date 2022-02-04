<?php
namespace WdevRs\PhpEsir\Request;

//Egy item adatai amit a szamlan meg kell adni
//A szamlara items[] megy, megha csak egy item van is benne
class Item {

    //barcodja az itemnek 8-14 character, mindeg string
    //Ha nincs gtin null ertek kell
   public $gtin = null;

   //A neve kovetve/unit pl kabat/kom
   public $name;

   //Hany darab
   public $quantity;

   //Egy darab mennyibe kerul
   public $unitPrice;

   //Mindeg egy array, megha csak egy label van pl ['A']
   public $labels;

   //quantity*unit price 
   public $totalAmount;

   //ha lekuljek az item adatait(vagy reszadatait) az obj keszitesenel
   public function __construct(  $itemData = null) {
       
       $this->gtin = $itemData['gtin'] ?? null;
       $this->name =  $itemData['name'] ?? null;
       $this->quantity = $itemData['quantity'] ?? null;
       $this->unitPrice = $itemData['unitPrice'] ?? null;
       $this->labels = $itemData['labels'] ?? [];
       if ($this->quantity !== null && $this->unitPrice !== null){
           $this->totalAmount = $this->quantity * $this->unitPrice;
       }else{
           $this->totalAmount = null;
       }
   }


   //Ha utolag adjak meg a quantityt es a unitpricet ezzel be lehet allitani a totalAmpuntot
   public function countTotal(){
    if ($this->quantity !== null && $this->unitPrice !== null){
        $this->totalAmount = $this->unitPrice * $this->quantity;
        return true;
    }else{
        return false;
    }      
   }

   //Ezzel lehet mertekegyseget a nevhez hozzaadni, ha nem adtuk alapbol oda
   public function addUnitToItemname($unit){
       $this->name .= '/'. $unit;
   }


   //Leelenorzi, hogy az item tartalmaz minden szukseges adatot
   public function isValid(){
    //gtin nem kotelezo, de nem lehet ures string sem, ha nincs null - nak kell lennie
    if ($this->gtin !== null){
        if (strlen($this->gtin) < 8 || strlen($this->gtin) > 14){
            return false;
        }
    }

    //A name kotelezo
    if ($this->name === null){
        return false;
    }else{
        //A max limit amilyen hosszu lehet a name
        if (strlen($this->name) > 2048){
            return false;
        }
    }

    //quantity kotelezo min 0.001 max 9999999999.999 lehet
    if ($this->quantity == null){
        return false;
    }

    //unitprice kotelezo
    if ($this->unitPrice == null){
        return false;
    }

    //labels egy array, megha csak egy eleme van is
    if ($this->labels == null){
        return false;
    }else{
        if (!is_array($this->labels)){
            return false;
        }
    }

    //A total amount kotelezo, bar ha idaig eljutott a check akar itt is lehetne szamolni ha meg nincs
    //De feltetelezem mar ki van szamolva ha nincs hiba
    if ($this->totalAmount == null){
        return false;
    }

    //Ha egyik check sem kuldot vissza falsot akkor talan jo az item, mehet a szamlara :)
    return true;
   }
}
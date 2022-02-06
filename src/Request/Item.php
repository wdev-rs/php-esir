<?php
namespace WdevRs\PhpEsir\Request;

/**
 * Define one item in Invoice.
 * 
 * Can define an item more than one way, the easiest way throu its constructor send all data as associative array
 * That way the class will be done and ready to use right after its creation
 * The ather way, to send its constructor just its name (and optionally gtin), and the rest set throu functions later
 * Before use the item, the class have isValid function to check all data in item have and valid.
 * 
 * @var string|null $gtin  The barcode of item must be 8-14 character or null.
 * @var string $name The name of the item, after the name must hav /unit (there is a fuction to add that later).
 * @var float|double|int $quantity The quantity of item.
 * @var float|double $unitPrice The price for one unit.
 * @var array $labels Tax category labels for item.
 * @var float|double $totalPrice The total price of item (quantity * unitPrice).
 */
class Item {

    //barcodja az itemnek 8-14 character, mindeg string
    //Ha nincs gtin null ertek kell
   protected $gtin = null;

   //A neve kovetve/unit pl kabat/kom
   protected $name;

   //Hany darab
   protected $quantity;

   //Egy darab mennyibe kerul
   protected $unitPrice;

   //Mindeg egy array, megha csak egy label van pl ['A']
   protected $labels;

   //quantity*unit price 
   protected $totalAmount;

   //ha lekuljek az item adatait(vagy reszadatait) az obj keszitesenel
   public function __construct(  $itemData = null) {
       
       $this->gtin = $itemData['gtin'] ?? null;
       $this->name =  $itemData['name'] ?? null;
       $this->quantity = $itemData['quantity'] ?? null;
       $this->unitPrice = $itemData['unitPrice'] ?? null;
       $this->labels = $itemData['labels'] ?? [];
       if ($this->quantity !== null && $this->unitPrice !== null){
           if (is_numeric($this->quantity) && is_numeric($this->unitPrice)){

           //Ha a quantity es unit price szam akkor szorozuk ossze a total amountot
             $this->totalAmount = $this->quantity * $this->unitPrice;
             $this->totalAmount = round($this->totalAmount, 2, PHP_ROUND_HALF_UP);
           }else{
            $this->totalAmount = null;
           }
       }else{
           $this->totalAmount = null;
       }
   }

   //Utolag is lehessen beallitani az egyseg arat
   public function setUnitPrice($price){

       //Ha nem szamot kuldott, nem foglalkozunk vele
       if (is_numeric($price)){

           //Az ar nem lehet negativ vagy nulla
           if ($price > 0){
            $this->unitPrice = $price;
            return true;
           }else{
               return false;
           }
       }else{
           return false;
       }
   }

    //Ha utolag adjak meg a quantityt es a unitpricet ezzel be lehet allitani a totalAmpuntot
    public function countTotal(){
        if ($this->quantity !== null && $this->unitPrice !== null){
            if (is_numeric($this->quantity) && is_numeric($this->unitPrice)){
              $this->totalAmount = $this->unitPrice * $this->quantity;
              $this->totalAmount = round($this->totalAmount, 2, PHP_ROUND_HALF_UP);
            return true;
            }else{
                return false;
            }
        }else{
            return false;
        }      
    }

   //Ezzel lehet megadni, vagy a megadott quantityhez hozzaadni quantity t
   public function addQuantity($quant){

       //Ha meg nem volt megadva quantity
       if ( $this->quantity === null){

           //A lekuldott quantity szam e
           if (is_numeric($quant)){

               //Mivel elso quantity, tehat meg nem volt hozzaadva nagyobbnak kell, hogy legyen nullanal
               if ($quant > 0){
                  $this->quantity = $quant;

                  //Miutan kaptunk quantityt kiszamoljuk a totalt, ha a funkcio false ot kuld vissza, nincs unit price megadva
                  if ($this->countTotal()){
                    return true;
                  }else{
                    return false;
                  }
               }else{
                   //A megadott quant nulla, vagy negativ, nem lehet az elso quant nulla vagy negativ
                   return false;
               }
           }else{
               //Nem szamot kuldott quantnak, a felhasznalo valamit eltolt 
               return false;
           }

        //Mar volt quantunk megadva, az uj quantot hozzaadjuk a regihez es ujraszamoljuk a totalt
       }else{
           if (is_numeric($quant)){

              //Hozzaadjuk a kapott quantot a regi quanthoz(kivonjuk, ha negativ a szam)
               $this->quantity += $quant;

               //Leellenorizuk, hogy a quant nagyobb e nullanal
               if ($this->quantity > 0){

                   //Ujraszamoljuk a totalt, ha nem sikerul nincs unit price megadva
                   if ($this->countTotal()){
                       return true;
                   }else{
                       return false;
                   }
               }else{
                   
                //A quantity nulla vagy negativ volt, igy null erteket adunk a quantitynek meg a totalnak, mintha meg sem lett volna adva
                $this->quantity = null;
                $this->totalAmount = null;

                //Attol fuggetlenul, hogy lenullaztuk az erteket a muvelet sikeres volt (Ha az volt a cel hogy toroljuk a quantot es totalt)
                return true;
               }
           }else{
               //Nem szamot kuldott quantnak
               return false;
           }

       }
   }


  

   //Ezzel lehet mertekegyseget a nevhez hozzaadni, ha nem adtuk alapbol oda
   public function addUnitToItemname($unit){
       if ($this->name !== null){
        $this->name .= '/'. $unit;
        return true;
       }else{
           return false;
       }
       
   }

   //A labels array hoz lehet egyesivel adni labeleket
   public function addOneLabel($label){

       //A label egy character, de string formaban, ha hosszabb, vagy nem string nem adjuk az arrayhoz
       if (is_string($label)){
           if (strlen($label) === 1){
            $this->labels[] = $label;
            return true;
           }else{
               return false;
           }
       }else{
           return false;
       }
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
        //Van e mertekegyseg csatolva a nevhez
        $sec = explode('/', $this->name);
        if (count($sec) < 2){
            return false;
        }
    }

    //quantity kotelezo min 0.001 max 9999999999.999 lehet
    if ($this->quantity == null){
        return false;
    }
    if (is_numeric($this->quantity) !== true){
        return false;
    }
    if ($this->quantity < 0.001 || $this->quantity > 9999999999.999){
        return false;
    }

    //unitprice kotelezo
    if ($this->unitPrice == null){
        return false;
    }
    //Szamnak kell, hogy legyen
    if (is_numeric($this->unitPrice) !== true){
        return false;
    }
    //Nem lehet nulla, vagy nagyobb 999999999999.99
    if ($this->unitPrice <= 0 || $this->unitPrice > 999999999999.99){
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
<?php
namespace WdevRs\PhpEsir;

//ebbe a class -ban majd a komunikacios funkciok lesznek, legalabbis egyenlore ugy gondolom
class Kom {

    //A certifikatban megadott allap Uri a virtualis fiszkalis proceszorhoz
    protected $BaseUri;

    //A certificate neve, vagy utvonal(attol fugg milyen modszerrel lesz majd a requesthez csatolva)
    protected $Certificate;

    //A pac egy kod amit a certificate melle kapunk, minden request headerjebe be kell irni PAK:Kapott pak 
    protected $Pak;

    //Nem kotelezo, csak ha akarunk lehetoseget az utolso szamla ujranyomtatasara
    protected $UnicId;

    //A http object, valoszinu ebbol a classbol fog extendelni, az invoice, a status, es az enviroment class a kulonbozo komunikaciokra
    //vagy a class fo tartalmazni public funciokat a kulonbozo endpoitokhoz
    protected $HttpClient;

    //Az object keszitesenel bealitja az ertekeket
    public function __construct(string $Vsdc_Uri, string $Cert, string $Pak, string $UniqId = '') {
        $this->BaseUri = $Vsdc_Uri;
        $this->Certificate = $Cert;
        $this->Pak = $Pak;
        $this->UnicId = $UnicId;
        $this->HttpClient = SetClient();

    }

    //Elkeszit egy http komunikaciora alkalmas objectet
    protected function SetClient(){
        //Felkesziteni valamilyen http komunikaciot a kesobbi hasznalatra

        //return valamilyen http komunikacios objectet
    }
}
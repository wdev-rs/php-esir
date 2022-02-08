<?php
namespace WdevRs\PhpEsir\Response;

//ebbe a class -ban majd a komunikacios funkciok lesznek, legalabbis egyenlore ugy gondolom
class Kom {

    //A certifikatban megadott allap Uri a virtualis fiszkalis proceszorhoz
    protected $baseUri;

    //A certificate neve, vagy utvonal(attol fugg milyen modszerrel lesz majd a requesthez csatolva)
    protected $certificate;

    //A pac egy kod amit a certificate melle kapunk, minden request headerjebe be kell irni PAK:Kapott pak 
    protected $pak;

    //Nem kotelezo, csak ha akarunk lehetoseget az utolso szamla ujranyomtatasara
    protected $unicId;

    //A http object, valoszinu ebbol a classbol fog extendelni, az invoice, a status, es az enviroment class a kulonbozo komunikaciokra
    //vagy a class fo tartalmazni public funciokat a kulonbozo endpoitokhoz
    protected $httpClient;

    //Az object keszitesenel bealitja az ertekeket
    public function __construct(string $Vsdc_Uri, string $Cert, string $Pak, string $UniqId = '') {
        $this->baseUri = $Vsdc_Uri;
        $this->certificate = $Cert;
        $this->pak = $Pak;
        $this->unicId = $UnicId;
        $this->httpClient = SetClient();

    }

    //Elkeszit egy http komunikaciora alkalmas objectet
    protected function setClient(){
        //Felkesziteni valamilyen http komunikaciot a kesobbi hasznalatra

        //return valamilyen http komunikacios objectet
    }
}
<?php
namespace WdevRs\PhpEsir\InvoiceRequestSender;

use WdevRs\PhpEsir\InvoiceResponse\InvoiceResponse;
use WdevRs\PhpEsir\InvoiceRequest\InvoiceRequest;
use WdevRs\PhpEsir\InvoiceResponse\ErrorResponse;
use WdevRs\PhpEsir\VirtualInvoiceProcesorStatus\VirtualInvoiceProcesorStatus;

//ebbe a class -ban majd a komunikacios funkciok lesznek, legalabbis egyenlore ugy gondolom
class InvoiceRequestSender {

    //A certifikatban megadott allap Uri a virtualis fiszkalis proceszorhoz
    protected $baseUri;

    //A http object, valoszinu ebbol a classbol fog extendelni, az invoice, a status, es az enviroment class a kulonbozo komunikaciokra
    //vagy a class fo tartalmazni public funciokat a kulonbozo endpoitokhoz
    protected $options;

    protected $client;

    //Az object keszitesenel bealitja az ertekeket
    public function __construct( string $vsdc_Uri, string $cert, string $pak, $client = null ) {

        if ( $client === null){
            $client = new GuzzleHttp\Client();       
        }else{
            $this->client = $client;
        }
        $this->baseUri = $vsdc_Uri;     
        $this->options = $this->setOptions( $cert, $pak );

    }

    //Elkeszit egy http komunikaciora alkalmas object opcioit
    protected function setOptions($cert, $pak){

        return [
            'headers' => [
                'Content-type' => 'application/json; charset=UTF-8',
                'pac' => $pak
            ],
            'cert' => $cert
            
        ];
    }

    //Attention endpoint
    public function atention(){

        $response = $this->client->get($this->baseUri . '/api/v3/attention', $this->options );
        
        if ($response->getStatusCode() === 200){

            return true;

        }else{

            return false;

        }
        
    }

    //get status report
    public function getStatus(){
       
        $response = $this->client->get($this->baseUri . '/api/v3/status', $this->options );    

        if ($response->getStatusCode() === 200){

            $responseString = ( string )$response->getBody();
            return new VirtualInvoiceProcesorStatus(json_decode($responseString, true));

        }else{

            return false;
        }
        
    }

    //invoice request 
    public function sendInvoice($invoice){

        
        $this->options['json'] = $invoice;
        
        try{
            
            $response = $this->client->post($this->baseUri . '/api/v3/invoices', $this->options ); 
        }catch(\Exception $ex)
        {

            return $ex->getMessage();
        }
        

        if ($response->getStatusCode() === 200){

            $responseString = ( string )$response->getBody();
            $responseArray = json_decode($responseString, true);
            return $this->checkResponse($responseArray);
        
        }else{

            return false;
        }
        
    }

    //Szetvalasztani a responset
    private function checkResponse($response){
        //Le kell ellenorizni hogy invoicet vagy error modelt kaptunk visza es viszakuldeni a megfelelo modelt

        if (isset($response['verificationUrl'])){

            return new InvoiceResponse($response);
        }else{
            return new ErrorResponse($response);
        }
    }
}
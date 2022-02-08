<?php
namespace WdevRs\PhpEsir\Invoice;

use WdevRs\PhpEsir\Invoice\ModelError;

//Ha sikertelen a szamlakerelem a valasz ilyen errorresponse formatumba jon vissza
class ErrorResponse {

    //Az uzenet a proceszortol altalaban BadRequest
    protected $message;

    //Egy array a modelErrorokrol ami megmondja hol mi volt a hiba
    protected $modelState;

    //Ha a konstractorba lekuldjuk a responsot mint assocArrayt, ha nem error volt nult kuld visza
    public function __construct($response){
        $this->message = $response['message'] ?? null;
        if (isset($response['modelState'])){
            if (is_array($response['modelState'])){
                foreach ($response['modelState'] as $state){
                    $modelErr = new ModelError($state['property'], $state['errors']);
                    $this->modelState[] = $modelErr;
                }
            }
        }else{
            $this->modelState = null;
        }
        if ($this->message === null || $this->modelState === null){
            return null;
        }

    }

    //Valamilyen formaban visszakuldi az adatokat
    public function returnErrors(){

    }

}
<?php
namespace WdevRs\PhpEsir\InvoiceResponse;

use WdevRs\PhpEsir\InvoiceResponse\ModelError;

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
                foreach ($response['modelState'] as $states){
                    
                        $modelErr = new ModelError($states);
                        $this->modelState[] = $modelErr;
                    
                    
                }
            }
        }else{
            $this->modelState = null;
        }

    }

    //viszakuldi a messaget
    public function getMessage(){
        return $this->message;

    }

    //viszakuldi a modelState et ami egy array a modelErrorokbol, utana rajtuk is lehet viszakuldeni az ertekeiket
    public function getModelState(){
        return $this->modelState;
    }

}
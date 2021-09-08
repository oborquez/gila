<?php
include_once('vehicle.class.php');
class Moto extends Vehicle{
    
    private $motoType; // chopper, sport, scooter

    public function __construct($color,$wheels_number,$horsepower,$registration,$model,$motoType){
        parent::__construct($color,$wheels_number,$horsepower,$registration,$model);
        $this->motoType = $motoType;

    }

    public function getAll(){
        
        include_once('classes/dataHandler.class.php');
        $dh = new DataHandler;
        $data =  json_decode($dh->read());
        $motoData = array();
        foreach($data as $k=>$item)
            if($item->wheels_number < 3 && $item->horsepower <300)
                $motoData[$k] = $item;    
        return $motoData;

    }

    public function validate(){

        $status = true;
        $aError = array();
        $parentValidate = parent::validate();
        if(empty($this->motoType) || trim($this->motoType)==''){ $status = false; $aError['motoType'] = "motoType can't be empty";}        

        if(!$parentValidate['status']){
            $aError += $parentValidate['aError'];
            return array( 'status' => 'error', 'aError' => $aError );
        }else{
            return array('status'=>$status,'aError'=>$aError);

        }
    }

    public function create(){
        include_once( 'dataHandler.class.php' );
        $dataHandler = new DataHandler;
        $dataHandler->insert( [
            "color" => $this->color,
            "wheels_number" => $this->wheels_number,
            "horsepower" => $this->horsepower,
            "registration" => $this->registration,
            "model" => $this->model,
            'motoType' => $this->motoType,
        ] );
    }

    public function motoTypes(){

        $motoTypes[1] = "Chooper";
        $motoTypes[2] = "Sport";
        $motoTypes[3] = "Scooter";

        return $motoTypes;
    }   

    public function getMotoTypeText(){
        $motoTypes = self::motoTypes();
        return $motoTypes[$this->motoType];
    }

}
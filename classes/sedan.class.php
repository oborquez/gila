<?php
include_once('vehicle.class.php');
class Sedan extends Vehicle{
    
    private $doors_number;
    private $sunroof;

    public function __construct($color,$wheels_number,$horsepower,$registration,$model,$doors_number,$sunroof){
        parent::__construct($color,$wheels_number,$horsepower,$registration,$model);
        $this->doors_number = $doors_number;
        $this->sunroof =$sunroof;
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
            'doors_number' => $this->doors_number,
            'sunroof' => $this->sunroof
        ] );
    }

    public function validate(){

        $status = true;
        $aError = array();
        $parentValidate = parent::validate();
        if(empty($this->doors_number) || trim($this->doors_number)==''){ $status = false; $aError['doors_number'] = "doors_number can't be empty";}
        if(empty($this->sunroof) || trim($this->sunroof)==''){ $status = false; $aError['sunroof'] = "sunroof can't be empty";}

        

        if(!$parentValidate['status']){
            $aError += $parentValidate['aError'];
            return array( 'status' => 'error', 'aError' => $aError );
        }else{
            return array('status'=>$status,'aError'=>$aError);

        }

    }

    public function getAll(){
        
        include_once('classes/dataHandler.class.php');
        $dh = new DataHandler;
        $data =  json_decode($dh->read());
        $sedanData = array();
        foreach($data as $k=>$item)
            if($item->wheels_number >= 3 && $item->horsepower >=300)
                $sedanData[$k] = $item;    
        return $sedanData;

    }
}
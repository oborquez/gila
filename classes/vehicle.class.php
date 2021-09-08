<?php 

include_once('classes/dataHandler.class.php');

class Vehicle{

    protected $color;
    protected $wheels_number;
    protected $horsepower;
    protected $registration;
    protected $model;

    public function __construct($color,$wheels_number,$horsepower,$registration,$model){
        $this->color = $color;
        $this->wheels_number = $wheels_number;
        $this->horsepower = $horsepower;
        $this->registration = $registration;
        $this->model = $model;
    }

    public function validate() {
        
        $status = true;
        $aError = array();

        if(empty($this->color) || trim($this->color)=='') { $status = false; $aError['color']="color can't be empty";};
        if(empty($this->wheels_number) || trim($this->wheels_number)=='') { $status = false; $aError['wheels_number']="wheels_number can't be empty";};
        if(empty($this->horsepower) || trim($this->horsepower)=='') { $status = false; $aError['horsepower']="horsepower can't be empty";};
        if(empty($this->registration) || trim($this->registration)=='') { $status = false; $aError['registration']="registration can't be empty";};
        if(empty($this->model) || trim($this->model)=='') { $status = false; $aError['model']="model can't be empty";};

        return array('status'=>$status,'aError'=>$aError);
        
    }

    public function create(){
        
        
        $dataHandler = new DataHandler;
        $dataHandler->insert( [
            "color" => $this->color,
            "wheels_number" => $this->wheels_number,
            "horsepower" => $this->horsepower,
            "registration" => $this->registration,
            "model" => $this->model
        ] );

    }

    public function delete( $key ){
        $dh = new DataHandler;
        return $dh->delete($key);
    }

    public function getAll(){
        
        $dh = new DataHandler;
        return json_decode($dh->read());
        
    }

    
    
}
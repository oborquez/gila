<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: *");

    $isLocal = false;

    $method = $_SERVER['REQUEST_METHOD'];
    $path = $isLocal ? $_SERVER['PATH_INFO'] : $_SERVER['REQUEST_URI'];

    $path = str_replace('/gila','',$path);
    $expPath = explode('/',$path);
    
    // inlcudes
    include_once('classes/sedan.class.php');
    include_once('classes/moto.class.php');
    include_once('classes/vehicle.class.php');
    include_once('classes/login.class.php');
    
    $headers = getallheaders();
    if(!isset($headers['token'])){
        $isLoged = false;
    }else{  
        $login = new Login('','',$headers['token']);
        $isLoged = $login->isLoged();
    }    

    $action = $expPath[2] ?? '';

    if($expPath[1]=='isLoged'){
        $response = $isLoged? array('status'=>'ok') : array('status'=>'noLoged');
    }

    if($isLoged && $expPath[1]!='isLoged'){ // loged routes

        switch($expPath[1]) {
            case 'moto':
                
                switch($action){
                    case "create": 
                        $moto = new Moto($_POST['color'],$_POST['wheels_number'],$_POST['horsepower'],$_POST['registration'],$_POST['model'], $_POST['motoType'] );
                        $validate = $moto->validate();
    
                        if($validate['status']===true){
                            $moto->create();
                            $response = array('status' => 'ok');
                        }else{
                            $response = array('status'=>'error','errorData'=>$validate['aError']);
                        }
    
                    break;
                    default: 
                        $response = array('status'=>'ok','data'=>Moto::getAll());
                    break;
                }
    
            break;
            
            case 'sedan':
    
                switch($action){
                    case "create": 
                        $sunroof = isset($_POST['sunroof'])? 'y' : 'n' ; 
                        $sedan = new Sedan( $_POST['color'],$_POST['wheels_number'],$_POST['horsepower'],$_POST['registration'],$_POST['model'], $_POST['doors_number'],$sunroof);
                        $validate  = $sedan->validate();
                        
                        if($validate['status']===true){
                            $sedan->create();
                            $response = array('status' => 'ok');
                        }else{
                            $response = array('status'=>'error','errorData'=>$validate['aError']);
                        }
                    break;
                    default: 
                     $response = array('status'=>'ok','data'=>Sedan::getAll());
                    break;
                }
    
            break;
            
            case 'vehicle':
    
                
                switch($action){
                    
                    case "create": 
    
                        $vehicle = new Vehicle( $_POST['color'],$_POST['wheels_number'],$_POST['horsepower'],$_POST['registration'],$_POST['model'] );    
                        $validate = $vehicle->validate();
    
                        if($validate['status']===true){
                            $vehicle->create();
                            $response = array('status' => 'ok');
                        }else{
                            $response = array('status'=>'error','errorData'=>$validate['aError']);
                        }
                        
                    break;
                    case "delete": 
                        
                        $delete = Vehicle::delete($_POST['key']);
                        $delete ?  $response = array('status' => 'ok') :  $response = array('status'=>'error','errorMessage'=>'Failed trying to delete item');
    
                    break;
                    
                    default: 
                        $response = array('status'=>'ok','data'=>Vehicle::getAll());
                    break;
                }
    
            break;    
    
        }

    }else{ // no loged routes

        switch($expPath[1]) {
            case 'login':
                $login = new Login( $_POST['username'], $_POST['password'], '' );
                $try = $login->tryToLog();
                if($try){
                    $response = array('status'=>'ok', 'userData' => $try);
                }
            break;

            case 'isLoged':  break;
            
            default :
             $response = array('status'=>'notLoged','errorMessage'=>'This endpoint needs to be loged','post_data'=> $_POST);
            break;
        }

    }


    
    
    header('Content-Type: application/json; charset=utf-8');
    //$response['post'] = $_POST ?? 'no post data';
    echo json_encode($response);


?>
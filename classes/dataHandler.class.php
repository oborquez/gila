<?php
class DataHandler {
    
    private $filePath = "data/vehicle";
    
    public function read() {
        $data = file_get_contents($this->filePath, true);
        return $data;
    }

    public function insert( $item ){
        $data = $this->read();
        $decodeData = json_decode($data, true);
        $decodeData[] = $item;
        return file_put_contents($this->filePath, json_encode($decodeData));
    }

    public function delete( $key ){
        $data = $this->read();
        $decodeData = json_decode($data, true);
        if(isset($decodeData[$key])) unset($decodeData[$key]);
        return file_put_contents($this->filePath, json_encode($decodeData));        
    }
}
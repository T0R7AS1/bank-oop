<?php

require_once('./Operations.php');
class JsonConfig{

    private $connect;

    public function connect(){
        return $this->connect = json_decode(file_get_contents(__DIR__. '/saskaitos.json'), true);
    }
    
}

?>
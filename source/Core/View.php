<?php

namespace Source\Core;

class View{


    public function __construct(){
    }

    public static function jsonRender(array $data): string{

        return json_encode($data);

    }


}

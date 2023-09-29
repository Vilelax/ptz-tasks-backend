<?php

namespace Source\Core;

class Controller{

    protected array $data;

    protected bool $feedback;

    public function __construct(){

        $this->data = [];

        $this->feedback = false;

    }

}



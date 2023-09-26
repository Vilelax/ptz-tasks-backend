<?php

function setAccessControlHeaders(){
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: 'X-Requested-With,content-type'");
    header("Access-Control-Allow-Methods: 'GET, POST, OPTIONS, PUT, PATCH, DELETE'");
}

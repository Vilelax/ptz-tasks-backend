<?php

function setAccessControlHeaders(): void{
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: 'X-Requested-With,content-type'");
    header("Access-Control-Allow-Methods: 'GET, POST, OPTIONS, PUT, PATCH, DELETE'");
}

function getHttpError(int $code): string{

    switch($code){

        case HTTP_CODE_BAD_REQUEST:

        case HTTP_CODE_METHOD_NOT_ALLOWED:
            return "Sorry, there is a problem with your request, try something different!";
            break;

        case HTTP_CODE_UNAUTHORIZED:
            return "Sorry, you need to login before continue!";
            break;

        case HTTP_CODE_FORBIDDEN:
            return "Sorry, you don't have permission to access this content!";
            break;

        case HTTP_CODE_NOT_FOUND:
            return "Sorry, the requested content doesn't exists";
            break;

        default:
            return "Unknown error";

    }
}


function redirect(string $path = ""): void{

    $url = URL_BASE_FRONTEND;

    if ($path){
        $url .= "/".$path;
        return;
    }

    header("Location: ".$url);
}


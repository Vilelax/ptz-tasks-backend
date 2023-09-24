<?php

namespace Source\Core;

class HttpError{

    private string $message;

    private int $code;

    public function __construct(int $code){

        $this->code = $code;

        $this->message = "";

    }

    public function setMessage(): void{

        switch($this->getCode()){

            case HTTP_CODE_BAD_REQUEST:

            case HTTP_CODE_METHOD_NOT_ALLOWED:
                $this->message = "Sorry, there is a problem with your request, try something different!";
                break;
            
            case HTTP_CODE_UNAUTHORIZED:
                $this->message = "Sorry, you need to login before continue!";
                break;

            case HTTP_CODE_FORBIDDEN:
                $this->message = "Sorry, you don't have permission to access this content!";
                break;

            case HTTP_CODE_NOT_FOUND:
                $this->message = "Sorry, the requested content doesn't exists";
                break;

            default:
                $this->message = "Unknown error";

        }
    }

    public function getMessage(): string{

        if(!$this->message){

            $this->setMessage();

        }

        return $this->message;
    }

    public function getCode(): int{

        return $this->code;
        
    }

}


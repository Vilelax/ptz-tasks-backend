<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Core\View;

class FrontController extends Controller
{

    public function __construct(){
        parent::__construct();
    }

    public function index(array $data): void{

        echo (new View())->render("home",["title" => "Home"]);

    }

    public function about(array $data): void{
        $file = file_exists(__DIR__."/../../frontend/about.php") ? file_get_contents(
            __DIR__ . "/../../frontend/index.php"
        ) : null;

        if($file){
            echo $file;
            return;
        }

        echo "Error";
        return;
    }

}
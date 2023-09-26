<?php

namespace Source\App;

use \Source\Core\Controller;
use \Source\Core\HttpError;
use \Source\Core\View;
use \Source\Models\Task;
use \Exception;

class TaskController extends Controller{

    public function __construct(){

        parent::__construct();

    }

    /**
     * @return void
     */
    public function index(): void{

        $data = [];

        $feedback = false;

        try{


            $tasks = (new Task())->all();

            if($tasks){

                foreach ($tasks as $task){
                    $data[$task->id]['title'] = $task->title;
                    $data[$task->id]['description'] = $task->description;
                }

                $feedback = true;
            }

        }catch(Exception $exception){

        }

        echo View::jsonRender([
            "data" => $data,
            "success" => $feedback
        ]);

    }

    public function task(array $data): void{

        $taskId = strip_tags($data['id']);

        $feedback = false;

        $result = [];

        try{
            $task = (new Task())->find($taskId);

            if($task){
                $feedback = true;
                $result['title'] = $task->title;
                $result['description'] = $task->description;
            }

        }catch(Exception $exception){

        }

        echo View::jsonRender([
            "data" => $result ?? null,
            "success" => $feedback
        ]);

    }

    /**
     * @throws Exception
     */
    public function create(?array $data): void{

        $feedback = false;

        try{

            $task = new Task();

            $task->title = isset($_POST['title']) ? strip_tags($_POST['title']) : "";
            $task->description = isset($_POST['description']) ? strip_tags($_POST['description']) : "";

            if($task->save()){
                $feedback= true;
            }

        }catch(Exception $exception){
        }

        echo View::jsonRender([
            "success" => $feedback
        ]);

        header('Location: http://localhost:3000/');

    }

    public function update(array $data): void{

        $feedback = false;

        try{
            $task = new Task();
            $task->id = isset($_POST['id']) ? strip_tags($_POST['id']) : "";
            $task->title = isset($_POST['title']) ? strip_tags($_POST['title']) : "";
            $task->description = isset($_POST['description']) ? strip_tags($_POST['description']) : "";

            if($task->save()){
                $feedback = true;
            }

        }catch(Exception $exception){

        }

        echo View::jsonRender([
            "success" => $feedback
        ]);

        header('Location: http://localhost:3000');

    }

    public function complete(array $data):void {

        $feedback = false;

        $taskId = strip_tags($data['id']);

        try{
            $task = new Task();

            if($task->find($taskId)->delete()){
                $feedback = true;
            }

        }catch(Exception $exception){

        }

        echo View::jsonRender([
            "success" => $feedback
        ]);

        header('Location: http://localhost:3000');
    }

    /**
     * @param array $data
     * @return void
     */
    public function httpError(array $data): void{

        try{

            $errorCode = (int) strip_tags($data['code']);

        }catch(Exception $exception){

            $errorCode = 0;

        }

        $this->data['message'] = (new HttpError($errorCode))->getMessage();

        $this->data['code'] = $errorCode;

        echo View::jsonRender([
            "message" => $this->data['message'],
            "code" => $this->data['code']
        ]);

    }

    public function test(?array $data): void{



    }

}


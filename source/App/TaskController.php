<?php

namespace Source\App;

use \Source\Core\Controller;
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

        try{

            $tasks = (new Task())->all();

            if($tasks){

                foreach ($tasks as $task){
                    $this->data[$task->id]['title'] = $task->title;
                    $this->data[$task->id]['description'] = $task->description;
                }

                $this->feedback = true;
            }

        }catch(Exception $exception){

        }

        echo View::jsonRender([
            "data" => $this->data,
            "success" => $this->feedback
        ]);

    }

    public function task(array $data): void{

        $taskId = strip_tags($data['id']);

        try{
            $task = (new Task())->find($taskId);

            if($task){
                $this->feedback = true;
                $this->data['title'] = $task->title;
                $this->data['description'] = $task->description;
            }

        }catch(Exception $exception){

        }

        echo View::jsonRender([
            "data" => $this->data ?? null,
            "success" => $this->feedback
        ]);

    }

    /**
     * @throws Exception
     */
    public function create(): void{

        try{

            $task = new Task();

            $task->title = isset($_POST['title']) ? strip_tags($_POST['title']) : "";
            $task->description = isset($_POST['description']) ? strip_tags($_POST['description']) : "";

            if($task->save()){
                $this->feedback= true;
            }

        }catch(Exception $exception){
        }

        echo View::jsonRender([
            "success" => $this->feedback
        ]);

        redirect();

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

        redirect();
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

        redirect();
    }

    /**
     * @param array $data
     * @return void
     */
    public function Error(array $data): void{

        try{

            $errorCode = (int) strip_tags($data['code']);

        }catch(Exception $exception){

            $errorCode = 0;

        }

        $this->data['message'] = getHttpError($errorCode);

        $this->data['code'] = $errorCode;

        echo View::jsonRender([
            "message" => $this->data['message'],
            "code" => $this->data['code']
        ]);

    }

}


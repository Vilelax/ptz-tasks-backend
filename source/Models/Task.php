<?php

namespace Source\Models;

use \Source\Core\Model;

class Task extends Model{
    
    protected string $table = "tasks";
    protected string $idField = "id";
    protected bool $logTimestamp = TRUE;



}

<?php

namespace Source\Models;

use \Source\Core\ActiveRecord;

class Task extends ActiveRecord{
    
    protected string $table = "tasks";
    protected string $idField = "id";
    protected bool $logTimestamp = TRUE;

}

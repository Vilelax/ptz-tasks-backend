<?php

namespace Source\Core;

class View{

    public static function render(array $data): string{

        return json_encode($data);

    }


}

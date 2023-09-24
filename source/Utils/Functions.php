<?php

function format($value)
{
    if (is_string($value) && !empty($value)) {
        return "'" . addslashes($value) . "'";
    } else if (is_bool($value)) {
        return $value ? 'TRUE' : 'FALSE';
    } else if ($value !== '') {
        return $value;
    } else {
        return "NULL";
    }
}

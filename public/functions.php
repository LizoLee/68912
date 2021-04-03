<?php
function str_filter($str)
{
    if (is_array($str)) {
        foreach ($str as $value) $value = str_filter($value);
        return $str;
    }
    return htmlspecialchars(stripslashes(trim($str)));
}


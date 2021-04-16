<?php

if (!isset($index)) {
    header("Location: /");
    die();
}

function str_filter($str)
{
    if (is_array($str)) {
        foreach ($str as &$value) {
            $value = str_filter($value);
        }
        return $str;
    }
    return htmlspecialchars(stripslashes(trim($str)));
}

function include_header(array $params, string $header = "header.php")
{
    global $index, $user;
    require_once $header;
}

function include_footer(string $footer = "footer.php")
{
    global $index, $user;
    require_once $footer;
}

<?php
function str_filter($str)
{
    if (is_array($str)) {
        foreach ($str as $value) $value = str_filter($value);
        return $str;
    }
    return htmlspecialchars(stripslashes(trim($str)));
}

function include_header(string $title, string $header = "header.php")
{
    require_once $header;
}

function include_footer(string $footer = "footer.php")
{
    require_once $footer;
}
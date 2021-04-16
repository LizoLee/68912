<?php

if (!isset($index)) {
    header("Location: /");
    die();
}
session_start();
require_once "functions.php";
require_once "../lib/DataBase.php";

$user = ["authorized" => false];
if (!isset($_COOKIE["PHPSESSID"]) || session_id() != filter_input(INPUT_COOKIE, "PHPSESSID")) {
    setcookie("PHPSESSID", session_id(), time() + 60 * 60 * 24);
} elseif (!empty($_SESSION["authorized_user"]["id"])) {
    $user["authorized"] = true;
    $user["id"] = $_SESSION["authorized_user"]["id"];
    $user["email"] = $_SESSION["authorized_user"]["email"];
    $user["name"] = $_SESSION["authorized_user"]["name"];
}

if (filter_input(INPUT_SERVER, "REQUEST_METHOD") == "POST" && !empty(filter_input(INPUT_POST, "form"))) {
    if (filter_input(INPUT_POST, "form") == "review") {
        require "reviews.php";
        die();
    } elseif (filter_input(INPUT_POST, "form") == "log_in" || filter_input(INPUT_POST, "form") == "register") {
        require "authenticate.php";
        die();
    }
}

if (isset($_GET["log_out"])) {
    session_destroy();
    header("Location: /");
    die();
} elseif (isset($_GET["log_in"]) || isset($_GET["register"])) {
    require "authenticate.php";
    die();
}

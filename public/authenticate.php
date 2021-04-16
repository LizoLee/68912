<?php

if (!isset($index)) {
    header("Location: /");
    die();
}

if (filter_input(INPUT_SERVER, "REQUEST_METHOD") != "POST" || empty(filter_input_array(INPUT_POST))) {
    require "authenticate_form.php";
    die();
}

$auth_form = str_filter(filter_input_array(INPUT_POST));
$db_obj = new DataBase();
if (filter_input(INPUT_POST, "form") == "log_in") {
    $db_user = $db_obj->select_from_table(
            "users",
            ["id", "name", "email", "password"],
            ["email" => $auth_form["email"]]
    );
    if (is_string($db_user)) {
        $response = "Возникла неполадка. Пожалуйста, попробуйте позже";
        require "authenticate_form.php";
        die();
    } elseif (empty($db_user)) {
        $response = "Пользователь с таким email не найден";
        require "authenticate_form.php";
        die();
    } elseif ($db_user[0]["password"] != base64_encode($auth_form["password"])) {
        $response = "Неправильный пароль";
        require "authenticate_form.php";
        die();
    } else {
        $_SESSION["authorized_user"]["id"] = $db_user[0]["id"];
        $_SESSION["authorized_user"]["email"] = $db_user[0]["email"];
        $_SESSION["authorized_user"]["name"] = $db_user[0]["name"];
        header("Location: /");
        die();
    }
    require "authenticate_form.php";
    die();
} elseif (filter_input(INPUT_POST, "form") == "register") {
    $db_user = $db_obj->select_from_table(
            "users",
            ["id"],
            ["email" => $auth_form["email"]]
    );
    $password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)"
            . "(?=.*[\$-_\.\+\!\*\'\(\)\,\{\}\|\\\^\~\[\]\`\<\>\#\%\"\;\/\?\:\@\&\=])"
            . "[a-zA-Z\d\$-_\.\+\!\*\'\(\)\,\{\}\|\\\^\~\[\]\`\<\>\#\%\"\;\/\?\:\@\&\=]{8,100}/";

    if (is_string($db_user)) {
        $response = "Возникла неполадка. Пожалуйста, попробуйте позже";
        require "authenticate_form.php";
        die();
    } elseif (!empty($db_user)) {
        $response = "Пользователь с таким email уже зарегистрирован";
        require "authenticate_form.php";
        die();
    } else {
        if (!$auth_form["name"]) {
            $response = "Введите имя";
            require "authenticate_form.php";
            die();
        } elseif (!preg_match("/\A(([а-яёa-z]')?[а-яёa-z-]+\h*)+\z/iu", $auth_form["name"])) {
            $response = "Имя может содержать русские и латинские буквы";
            require "authenticate_form.php";
            die();
        } elseif (!filter_var($auth_form["email"], FILTER_VALIDATE_EMAIL)) {
            $response = "Неправильный формат email";
            require ("authenticate_form.php");
            die();
        } elseif (!preg_match($password_pattern, $auth_form["password"])) {
            $response = "Пароль должен состоять из букв латинского алфавита, цифр, знаков препинания и спецсимволов,<br>"
                    . "должен быть не короче 8 символов и содержать хотя бы одну строчную букву,<br>"
                    . "одну прописную букву, одну цифру и один знак препинания или спецсимвол";
            require "authenticate_form.php";
            die();
        } elseif ($auth_form["password"] != $auth_form["password_confirm"]) {
            $response = "Пароль и подтверждение пароля не совпадают";
            require "authenticate_form.php";
            die();
        }
        unset($auth_form["form"], $auth_form["password_confirm"]);
        $auth_form["password"] = base64_encode($auth_form["password"]);
        $err = $db_obj->insert_to_users($auth_form);
        if (isset($err)) {
            $response = "Возникла неполадка. Пожалуйста, попробуйте позже3";
            require "authenticate_form.php";
            die();
        } else {
            $db_user = $db_obj->select_from_table(
                    "users",
                    ["id", "name", "email"],
                    ["email" => $auth_form["email"]]
            );
            if (is_string($db_user) || empty($db_user)) {
                $response = "Возникла неполадка. Пожалуйста, попробуйте позже4";
                require "authenticate_form.php";
                die();
            } else {
                $_SESSION["authorized_user"]["id"] = $db_user[0]["id"];
                $_SESSION["authorized_user"]["email"] = $db_user[0]["email"];
                $_SESSION["authorized_user"]["name"] = $db_user[0]["name"];
                header("Location: /");
                die();
            }
        }
    }
    require "authenticate_form.php";
    die();
}

require "authenticate_form.php";

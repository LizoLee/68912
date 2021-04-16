<?php
if (!isset($index)) {
    header("Location: /");
    die();
}
?><!DOCTYPE html>
<html lang="ru">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title><?php echo $params["title"] ?></title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <header class="page-header">
            <div class="container">
                <div class="row first">
                    <div class="col-lg-3 col-sm-12 col-10">
                        <div class="logo">
                            <a href="/">
                                <img src="logo.png" alt="#68912">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12"></div>
                    <div class="col-lg-3 col-sm-12">
                        <?php if ($user["authorized"]) { ?>
                            <div class="authentication">
                                <span><?php echo $user["email"] ?></span>&#8195;
                                <a href="/?log_out">Выход</a>
                            </div>
                        <?php } else { ?>
                            <div class="authentication">
                                <a href="/?log_in">Вход</a>&#8195;
                                <a href="/?register">Регистрация</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </header>
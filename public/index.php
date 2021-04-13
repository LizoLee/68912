<?php

$index = 1;
require_once 'functions.php';
require_once '../lib/DataBase.php';

$db_obj = new DataBase();
$db_reviews = $db_obj->select_all_from_table("reviews", "date_insert");
if (is_string($db_reviews)) {
    unset($db_reviews);
} else {
    foreach ($db_reviews as $key => $db_review) {
        if ($db_review["image_path"]) {
            $db_reviews[$key]["image_path"] = explode(", ", $db_review["image_path"]);
        }
    }
}

if (filter_input(INPUT_SERVER, "REQUEST_METHOD") != "POST") {
    require ("form.php");
    die();
} elseif (empty(filter_input_array(INPUT_POST))) {
    require ("form.php");
    die();
}

$form = str_filter(filter_input_array(INPUT_POST));
$form["picture"] = !empty($_FILES["picture"]["name"][0]) ? $_FILES["picture"] : 0;

$form_review = array();
$form_review["name"] = str_replace("'", "''", $form["name"]);
$form_review["email"] = $form["email"];
$form_review["rate"] = $form["rate"];
if ($form["comment"]) {
    $form_review["text"] = str_replace("'", "''", $form["comment"]);
}

if (!$form["name"]) {
    $response = "Введите имя";
    require ("form.php");
    die();
} elseif (!$form["rate"]) {
    $response = "Поставьте оценку";
    require ("form.php");
    die();
} elseif (!preg_match("/\A(([а-яёa-z]')?[а-яёa-z-]+\h*)+\z/iu", $form["name"])) {
    $response = "Имя может содержать русские и латинские буквы";
    require ("form.php");
    die();
} elseif ($form["email"] && !filter_var($form["email"], FILTER_VALIDATE_EMAIL)) {
    $response = "Неправильный формат email";
    require ("form.php");
    die();
} else {
    if ($form["picture"]) {
        if (count($form["picture"]["name"]) > 5) {
            $response = "Нельзя прикрепить к отзыву больше пяти фотографий";
            require ("form.php");
            die();
        } else {
            $phpFileUploadErrors = array(
                0 => "Файл успешно загружен",
                1 => "Превышен максимальный размер файла (" . ini_get("upload_max_filesize") . "МБ)",
                2 => "Превышен максимальный размер файла (" . $form["MAX_FILE_SIZE"] / 1024 . "МБ)",
                3 => "Файл загружен частично",
                4 => "Файл не был загружен",
                6 => "Отсутствует временная папка",
                7 => "Не удалось записать файл на диск",
                8 => "PHP-расширение остановило загрузку файла.",
            );
            foreach ($form["picture"]["error"] as $key => $err) {
                if ($err) {
                    $response = "Не удалось загрузить файл: " . $phpFileUploadErrors[$err];
                    require ("form.php");
                    die();
                } elseif (
                        !in_array(exif_imagetype(
                                        $form["picture"]["tmp_name"][$key]),
                                [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP]
                        ) && !preg_match("/(.gif|.jpg|.jpeg|.png|.bmp)$/ui", $_FILES['picture']['name'][$key])
                ) {
                    $response = "Не удалось загрузить файл: разрешено загружать картинки gif, jpeg, png и bmp";
                    require ("form.php");
                    die();
                }
            }
        }
        $uploaddir = "uploads/68912/";
        $form_review["image_path"] = "";
        foreach ($form["picture"]["name"] as $key => $name) {
            $uploadfile[$key] = $uploaddir . time() . $key . "_" . basename($name);
            $form_review["image_path"] .= $uploadfile[$key] . ", ";
        }
        $form_review["image_path"] = trim($form_review["image_path"], ", ");
        foreach ($form["picture"]["tmp_name"] as $key => $tmp_name) {
            if (!move_uploaded_file($tmp_name, $uploadfile[$key])) {
                $response = "Не удалось загрузить файл";
                require ("form.php");
                die();
            }
        }
    }

    $err = $db_obj->insert_to_reviews($form_review);
    if (isset($err)) {
        $response = "Возникла неполадка. Пожалуйста, попробуйте позже";
        require ("form.php");
        die();
    } else {
        $response = "Отзыв отправлен";
        require ("form.php");
    }
}
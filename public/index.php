<?php

$index = 1;
include_once ("functions.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    include ("form.php");
    die();
}

$form = str_filter($_POST);
$form["picture"] = !empty($_FILES["picture"]["name"][0]) ? $_FILES["picture"] : 0;

$reviews_filename = "../68912_reviews.txt";
$review = time() . "\n" . "Имя : " . $form["name"] . "\n"
        . "Email : " . $form["email"] . "\n" . "Оценка : " . $form["mark"] . "\n";
if ($form["comment"])
    $review .= "Отзыв : " . $form["comment"] . "\n";

if (!$form["name"]) {
    $response = "Введите имя";
    include ("form.php");
    die();
} elseif (!$form["mark"]) {
    $response = "Поставьте оценку";
    include ("form.php");
    die();
} elseif (!preg_match("/\A(([а-яёa-z]')?[а-яёa-z-]+\h*)+\z/iu", $form["name"])) {
    $response = "Имя может содержать русские и латинские буквы";
    include ("form.php");
    die();
} elseif ($form["email"] && !filter_var($form["email"], FILTER_VALIDATE_EMAIL)) {
    $response = "Неправильный email";
    include ("form.php");
    die();
} else {
    if ($form["picture"]) {
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
                include ("form.php");
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
        $uploaddir = "uploads/68912/";
        foreach ($form["picture"]["name"] as $key => $name) {
            $uploadfile[$key] = $uploaddir . time() . $key . "_" . basename($name);
            $review .= "Фото : " . $uploadfile[$key] . "\n";
        }
        foreach ($form["picture"]["tmp_name"] as $key => $tmp_name) {
            if (!move_uploaded_file($tmp_name, $uploadfile[$key])) {
                $response = "Не удалось загрузить файл";
                include ("form.php");
                die();
            }
        }
    }

    if (is_writable($reviews_filename)) {
        if (($handle = fopen($reviews_filename, "a")) !== FALSE) {
            fwrite($handle, $review . "\n");
            fclose($handle);
            $response = "Отзыв отправлен";
        }
    }
}

include ("form.php");


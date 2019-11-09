<?php
$link = mysqli_connect("127.0.0.1", "root", "", "task_beejee");

if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL.";
    exit;
}


?>
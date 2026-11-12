<?php
// Лабораторная работа №5. Подключение к MySQL.
// Настройки ниже подходят для стандартного локального XAMPP.
// Для хостинга укажите данные базы из панели управления хостинга.
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASSWORD = '';
const DB_NAME = 'lab5_data';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $mysql = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $mysql->set_charset('utf8mb4');
} catch (mysqli_sql_exception $exception) {
    http_response_code(503);
    exit('Не удалось подключиться к базе данных. Проверьте настройки в db.php и импорт lab5_data.sql.');
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

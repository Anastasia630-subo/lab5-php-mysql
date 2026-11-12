-- Лабораторная работа №5 — Биябева Анастасия Алексеевна, 251-361
-- Импортируйте файл через phpMyAdmin: http://localhost:8080/phpmyadmin/
CREATE DATABASE IF NOT EXISTS lab5_data CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lab5_data;

CREATE TABLE IF NOT EXISTS terms (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    definition TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO terms (name, definition, image) VALUES
('HTML', 'Язык разметки, который определяет структуру веб-страницы.', 'assets/img/html.svg'),
('CSS', 'Язык стилей для оформления и расположения элементов страницы.', 'assets/img/css.svg'),
('PHP', 'Серверный язык программирования для создания динамических веб-страниц.', 'assets/img/php.svg'),
('MySQL', 'Система управления реляционными базами данных.', 'assets/img/mysql.svg'),
('SQL', 'Язык запросов для работы с данными в реляционных базах.', 'assets/img/sql.svg'),
('HTTP', 'Протокол обмена запросами и ответами между клиентом и сервером.', 'assets/img/http.svg'),
('GET', 'HTTP-метод получения ресурса; параметры запроса могут передаваться в URL.', 'assets/img/get.svg'),
('POST', 'HTTP-метод передачи данных в теле запроса для обработки на сервере.', 'assets/img/post.svg'),
('Массив', 'Структура данных, которая хранит несколько значений под одним именем.', 'assets/img/array.svg'),
('Форма', 'HTML-элемент для ввода и отправки пользовательских данных.', 'assets/img/form.svg');

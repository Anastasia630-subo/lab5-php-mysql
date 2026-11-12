<?php
// Обработка формы: третья PHP-страница лабораторной.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php', true, 303);
    exit;
}
require 'db.php';

$name = trim((string) ($_POST['name'] ?? ''));
$definition = trim((string) ($_POST['definition'] ?? ''));
$errors = [];

if ($name === '' || mb_strlen($name) > 100) {
    $errors[] = 'Укажите термин длиной от 1 до 100 символов.';
}
if ($definition === '' || mb_strlen($definition) > 1500) {
    $errors[] = 'Укажите определение длиной от 1 до 1500 символов.';
}

if (!isset($_FILES['image']) || !is_array($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    $errors[] = 'Необходимо прикрепить изображение.';
}

$fileInfo = null;
$extension = '';
if (!$errors) {
    $upload = $_FILES['image'];
    if ($upload['size'] > 2 * 1024 * 1024 || $upload['size'] <= 0) {
        $errors[] = 'Размер изображения должен быть не больше 2 МБ.';
    } else {
        $fileInfo = @getimagesize($upload['tmp_name']);
        $types = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'];
        if (!$fileInfo || !isset($types[$fileInfo[2]])) {
            $errors[] = 'Допустимы только настоящие изображения JPG, PNG или WEBP.';
        } else {
            $extension = $types[$fileInfo[2]];
        }
    }
}

if (!$errors) {
    $uploadDirectory = __DIR__ . '/uploads';
    if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true)) {
        $errors[] = 'Не удалось создать папку uploads.';
    } else {
        $filename = bin2hex(random_bytes(16)) . '.' . $extension;
        $relativePath = 'uploads/' . $filename;
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadDirectory . '/' . $filename)) {
            $errors[] = 'Не удалось сохранить изображение.';
        } else {
            try {
                // Подготовленный запрос защищает INSERT от SQL-инъекций.
                $statement = $mysql->prepare('INSERT INTO terms (name, definition, image) VALUES (?, ?, ?)');
                $statement->bind_param('sss', $name, $definition, $relativePath);
                $statement->execute();
                $statement->close();
                header('Location: index.php?status=added#terms', true, 303);
                exit;
            } catch (mysqli_sql_exception $exception) {
                @unlink($uploadDirectory . '/' . $filename);
                $errors[] = 'Не удалось добавить запись в базу данных.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результат добавления — Лабораторная №5</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="site-header"><div class="container header-inner"><div><div class="brand">БИЯБЕВА АНАСТАСИЯ АЛЕКСЕЕВНА</div><div class="meta">Группа 251-361 · Лабораторная работа №5</div></div><nav><a href="index.php">На главную</a></nav></div></header>
<main class="container result-page">
    <section class="card">
        <div class="eyebrow">РЕЗУЛЬТАТ ДОБАВЛЕНИЯ</div>
        <h1>Не удалось добавить запись</h1>
        <?php foreach ($errors as $error): ?><p class="error-text"><?= e($error) ?></p><?php endforeach; ?>
        <a class="button-link" href="index.php#new">Вернуться к форме</a>
    </section>
</main>
<footer class="site-footer"><div class="container footer-inner"><span>© 2026 Биябева Анастасия Алексеевна · 251-361</span></div></footer>
</body>
</html>

<?php
$pageTitle = 'Термины веб-разработки';
require 'db.php';

$result = $mysql->query('SELECT id, name, definition, image FROM terms ORDER BY id ASC');
$terms = $result->fetch_all(MYSQLI_ASSOC);
$status = (string) ($_GET['status'] ?? '');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> — Лабораторная №5 — Биябева Анастасия</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <div>
            <div class="brand">БИЯБЕВА АНАСТАСИЯ АЛЕКСЕЕВНА</div>
            <div class="meta">Группа 251-361 · Лабораторная работа №5</div>
        </div>
        <nav><a href="#terms">Термины</a><a href="#gallery">Изображения</a><a href="#new">Добавить</a></nav>
    </div>
</header>
<main class="container">
    <section class="hero">
        <div class="eyebrow">PHP + MYSQL · ЛАБОРАТОРНАЯ РАБОТА №5</div>
        <h1>Термины веб-разработки</h1>
        <p class="lead">Определения и изображения загружаются из базы данных MySQL при каждом открытии страницы. Новые записи можно добавлять через форму ниже.</p>
        <div class="counter">Записей в базе: <strong><?= count($terms) ?></strong></div>
    </section>

    <?php if ($status === 'added'): ?>
        <div class="notice" role="status">Новая запись успешно добавлена в базу данных.</div>
    <?php endif; ?>

    <section id="terms" class="card">
        <div class="section-heading"><div><div class="eyebrow">СПРАВОЧНИК</div><h2>Термины и определения</h2></div><span class="pill"><?= count($terms) ?> терминов</span></div>
        <div class="table-scroll">
            <table>
                <thead><tr><th>№</th><th>Термин</th><th>Определение</th></tr></thead>
                <tbody>
                <?php foreach ($terms as $i => $term): ?>
                    <tr><td class="number"><?= $i + 1 ?></td><td class="term-name"><?= e($term['name']) ?></td><td><?= e($term['definition']) ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if (!$terms): ?><p>Пока нет записей. Добавьте первый термин через форму.</p><?php endif; ?>
    </section>

    <section id="gallery" class="card">
        <div class="section-heading"><div><div class="eyebrow">ГАЛЕРЕЯ</div><h2>Изображения терминов</h2></div></div>
        <p class="section-description">Наведите курсор на изображение, чтобы увидеть его название.</p>
        <div class="gallery">
            <?php foreach ($terms as $term): ?>
                <figure class="image-tile">
                    <img src="<?= e($term['image']) ?>" title="<?= e($term['name']) ?>" alt="Иллюстрация термина <?= e($term['name']) ?>" loading="lazy">
                    <figcaption><?= e($term['name']) ?></figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="new" class="card">
        <div class="section-heading"><div><div class="eyebrow">НОВАЯ ЗАПИСЬ</div><h2>Добавить термин в базу</h2></div></div>
        <p class="section-description">Введите термин, определение и выберите изображение PNG, JPG или WEBP размером до 2 МБ.</p>
        <form action="add.php" method="post" enctype="multipart/form-data" class="term-form">
            <div class="form-row"><label for="name">Термин</label><input id="name" name="name" type="text" maxlength="100" required placeholder="Например, API"></div>
            <div class="form-row"><label for="definition">Определение</label><textarea id="definition" name="definition" rows="5" maxlength="1500" required placeholder="Введите определение термина"></textarea></div>
            <div class="form-row"><label for="image">Изображение</label><input id="image" name="image" type="file" accept=".png,.jpg,.jpeg,.webp,image/png,image/jpeg,image/webp" required></div>
            <div class="actions"><button type="submit">Добавить запись</button></div>
        </form>
    </section>
</main>
<footer class="site-footer"><div class="container footer-inner"><span>© 2026 Биябева Анастасия Алексеевна · 251-361</span><span>Данные из MySQL · PHP</span></div></footer>
</body>
</html>

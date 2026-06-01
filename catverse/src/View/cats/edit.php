<h2>Редактировать кота</h2>

<form method="post" enctype="multipart/form-data">
    <label>Имя:</label><br>
    <input type="text" name="name" value="<?= $cat->name ?>" required><br><br>

    <label>Возраст:</label><br>
    <input type="number" name="age" value="<?= $cat->age ?>" required><br><br>

    <label>Цвет:</label><br>
    <input type="text" name="color" value="<?= $cat->color ?>" required><br><br>

    <label>Новое фото (необязательно):</label><br>
    <input type="file" name="photo"><br><br>

    <?php if ($cat->photo): ?>
        <img src="/uploads/cats/<?= $cat->photo ?>" width="150">
    <?php endif; ?>

    <button type="submit">Сохранить</button>
</form>


<a href="/cat/<?= $cat->id ?>">Назад</a>

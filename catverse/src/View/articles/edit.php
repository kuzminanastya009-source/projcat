<h2>Редактировать статью</h2>
<form method="POST">
    <input type="text" name="title" value="<?= htmlspecialchars($article->title) ?>" required>
    <textarea name="text" rows="10" required><?= htmlspecialchars($article->text) ?></textarea>
    <button type="submit" class="btn btn-primary">Сохранить</button>
    <a href="/article/<?= $article->id ?>" class="btn">Отмена</a>
</form>
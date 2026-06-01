<?php
use Src\Models\Comment;
?>

<h2><?= $cat->name ?></h2>

<p><strong>Возраст:</strong> <?= $cat->age ?></p>
<p><strong>Цвет:</strong> <?= $cat->color ?></p>

<a href="/cats">Назад к списку</a>
<a href="/cat/<?= $cat->id ?>/edit">Редактировать</a>
<a href="/cat/<?= $cat->id ?>/delete" onclick="return confirm('Удалить кота?')">Удалить</a>
<a href="/cat/<?= $cat->id ?>/age">Рассчитать возраст в человеческих годах</a><br>
<?php if ($cat->photo): ?>
   <img src="http://catverse.loc/uploads/cats/<?= htmlspecialchars($cat->photo) ?>" ...>
<?php endif; ?>
<a class="btn" href="/cat/<?= $cat->id ?>/favorite">
    <?= $cat->favorite ? 'Убрать из избранного' : 'В избранное' ?>
</a>
<a class="btn" href="/cat/<?= $cat->id ?>/like"> Лайк (<?= $cat->likes ?>)</a>
<h3>Комментарии</h3>

<?php foreach (Comment::getByCat($cat->id) as $comment): ?>
    <div class="cat-card">
        <strong><?= htmlspecialchars($comment->author) ?></strong><br>
        <?= nl2br(htmlspecialchars($comment->text)) ?><br>
        <small><?= $comment->created_at ?></small>
    </div>
<?php endforeach; ?>
<form method="post" action="/cat/<?= $cat->id ?>/comment">
    <input type="text" name="author" placeholder="Ваше имя">
    <textarea name="text" placeholder="Комментарий..." required></textarea>
    <button class="btn">Отправить</button>
</form>
<?php
// Проверяем, лайкнул ли текущий пользователь
$userLiked = false;
if (!empty($_SESSION['user'])) {
    $db = \Src\Services\Db::getConnection();
    $stmt = $db->prepare("SELECT id FROM cat_likes WHERE user_id = ? AND cat_id = ?");
    $stmt->execute([$_SESSION['user']['id'], $cat->id]);
    $userLiked = $stmt->fetch(\PDO::FETCH_OBJ) !== false;
}

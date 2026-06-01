<h2>Личный кабинет</h2>

<div class="cabinet-info">
    <h3>Информация о пользователе</h3>
    <p><strong>Имя:</strong> <?= htmlspecialchars($user['nickname']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Роль:</strong> <?= htmlspecialchars($user['role']) ?></p>
</div>

<div class="cabinet-menu">
    <h3>Действия</h3>
    <a href="/cats/create" class="cabinet-link">➕ Добавить кота</a>
    <a href="/favorites" class="cabinet-link"> Избранные коты</a>
    <a href="/articles/create" class="cabinet-link"> Создать статью</a>
</div>

<!-- Мои коты -->
<div class="cabinet-section">
    <h3>Мои коты (<?= count($cats) ?>)</h3>
    <?php if (empty($cats)): ?>
        <p>У вас пока нет добавленных котов. <a href="/cats/create">Добавить первого кота</a></p>
    <?php else: ?>
        <div class="cats-grid">
            <?php foreach ($cats as $cat): ?>
                <div class="cabinet-card">
                    <?php if (!empty($cat->photo)): ?>
                        <img src="/uploads/cats/<?= htmlspecialchars($cat->photo) ?>" 
                             alt="<?= htmlspecialchars($cat->name) ?>">
                    <?php endif; ?>
                    <h4><?= htmlspecialchars($cat->name) ?></h4>
                    <p>Возраст: <?= $cat->age ?> г.</p>
                    <p>Цвет: <?= htmlspecialchars($cat->color) ?></p>
                    <div class="card-actions">
                        <a href="/cat/<?= $cat->id ?>" class="btn-sm">Просмотр</a>
                        <a href="/cat/<?= $cat->id ?>/edit" class="btn-sm btn-edit">Редактировать</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Мои статьи -->
<div class="cabinet-section">
    <h3>Мои статьи (<?= count($articles) ?>)</h3>
    <?php if (empty($articles)): ?>
        <p>У вас пока нет статей. <a href="/articles/create">Создать первую статью</a></p>
    <?php else: ?>
        <div class="articles-list">
            <?php foreach ($articles as $article): ?>
                <div class="cabinet-card article-card">
                    <h4><?= htmlspecialchars($article->title) ?></h4>
                    <p class="article-excerpt">
                        <?= htmlspecialchars(mb_substr($article->text, 0, 150)) ?>...
                    </p>
                    <p class="article-meta">
                         <?= date('d.m.Y', strtotime($article->created_at)) ?>
                    </p>
                    <div class="card-actions">
                        <a href="/article/<?= $article->id ?>" class="btn-sm">Просмотр</a>
                        <a href="/article/<?= $article->id ?>/edit" class="btn-sm btn-edit">Редактировать</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.cabinet-info, .cabinet-menu, .cabinet-section {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 25px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.08);
}

.cabinet-info h3, .cabinet-menu h3, .cabinet-section h3 {
    margin-top: 0;
    border-bottom: 2px solid #ffd1dc;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.cabinet-menu {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.cabinet-link {
    display: block;
    padding: 12px 18px;
    background: #f9f9f9;
    border: 2px solid #1a1a1a;
    border-radius: 8px;
    color: #1a1a1a;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s;
}

.cabinet-link:hover {
    background: #ffd1dc;
    border-color: #ffd1dc;
    transform: translateX(5px);
}

.cats-grid, .articles-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.cabinet-card {
    background: #fff;
    border: 2px solid #eee;
    border-radius: 10px;
    padding: 15px;
    transition: all 0.3s;
}

.cabinet-card:hover {
    border-color: #ffd1dc;
    box-shadow: 0 4px 12px rgba(255, 209, 220, 0.3);
}

.cabinet-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 12px;
}

.cabinet-card h4 {
    margin: 0 0 10px;
    color: #1a1a1a;
}

.article-excerpt {
    color: #666;
    font-size: 14px;
    line-height: 1.5;
    margin: 10px 0;
}

.article-meta {
    color: #999;
    font-size: 13px;
    margin: 10px 0;
}

.card-actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.btn-sm {
    display: inline-block;
    padding: 8px 15px;
    background: #1a1a1a;
    color: #fff !important;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-sm:hover {
    background: #ffd1dc;
    color: #1a1a1a !important;
}

.btn-edit {
    background: #ffd1dc;
    color: #1a1a1a !important;
}

.btn-edit:hover {
    background: #ff9eb5;
}
</style>
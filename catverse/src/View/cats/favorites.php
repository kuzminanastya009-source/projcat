<h2> Мои избранные коты</h2>

<?php if (empty($cats)): ?>
    <p>У вас пока нет избранных котов. <a href="/cats">Посмотреть каталог</a></p>
<?php else: ?>
    <div class="cats-list">
        <?php foreach ($cats as $cat): ?>
            <div class="cat-card">
                <?php if (!empty($cat->photo)): ?>
                    <img src="/uploads/cats/<?= htmlspecialchars($cat->photo) ?>" 
                         alt="<?= htmlspecialchars($cat->name) ?>">
                <?php endif; ?>
                
                <h3><a href="/cat/<?= $cat->id ?>"><?= htmlspecialchars($cat->name) ?></a></h3>
                <p>Возраст: <?= $cat->age ?> г.</p>
                <p>Цвет: <?= htmlspecialchars($cat->color) ?></p>
                <p> Лайков: <?= $cat->likes ?></p>
                
                <div class="cat-actions">
                    <a href="/cat/<?= $cat->id ?>" class="btn">Подробнее</a>
                    <a href="/cat/<?= $cat->id ?>/favorite" class="btn btn-danger">
                        Убрать из избранного
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
.cats-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.cat-card {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.08);
    border: 2px solid #ffd1dc;
    transition: transform 0.2s;
}

.cat-card:hover {
    transform: translateY(-5px);
}

.cat-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 15px;
}

.cat-card h3 {
    margin: 0 0 10px;
    font-size: 20px;
}

.cat-card h3 a {
    color: #1a1a1a;
}

.cat-card h3 a:hover {
    color: #ff69b4;
}

.cat-actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.btn-danger {
    background: #ff6b6b;
    color: #fff !important;
}

.btn-danger:hover {
    background: #ff5252;
}
</style>
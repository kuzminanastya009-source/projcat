<div class="cats-page-wrapper">
    <!-- Левая колонка - список котов -->
    <div class="cats-main-content">
        <h2>Все коты</h2>

        <form method="get" action="/cats" style="margin-bottom:20px;">
            <input type="text" name="q" placeholder="Поиск..." 
                   value="<?= htmlspecialchars($params['q']) ?>" 
                   style="padding:8px; width:200px;">

            <select name="color" style="padding:8px;">
                <option value="">Все цвета</option>
                <?php foreach ($colors as $c): ?>
                    <option value="<?= $c ?>" <?= $params['color']==$c?'selected':'' ?>>
                        <?= ucfirst($c) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="number" name="age_min" placeholder="Возраст от" 
                   value="<?= htmlspecialchars($params['age_min'] ?? '') ?>" 
                   style="padding:8px; width:100px;">

            <input type="number" name="age_max" placeholder="до" 
                   value="<?= htmlspecialchars($params['age_max'] ?? '') ?>" 
                   style="padding:8px; width:100px;">

            <button class="btn">Применить</button>
        </form>

        <!-- 🔽 ВЫВОД КОТОВ -->
        <?php if (empty($cats)): ?>
            <p>Котов пока нет.</p>
        <?php else: ?>
            <?php foreach ($cats as $cat): ?>
                <div class="cat-card" style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                    
                    <?php if (!empty($cat->photo)): ?>
                        <img src="/uploads/cats/<?= htmlspecialchars($cat->photo) ?>" 
                             style="width:150px; height:auto;">
                    <?php endif; ?>

                    <h3><a href="/cat/<?= $cat->id ?>"><?= htmlspecialchars($cat->name) ?></a></h3>
                    <p>Возраст: <?= $cat->age ?></p>
                    <p>Цвет: <?= htmlspecialchars($cat->color) ?></p>

                    <?php if (!empty($_SESSION['user'])): ?>
                        <p>Лайков: <?= $cat->likes ?></p>
                        <a class="btn" href="/cat/<?= $cat->id ?>/like">Лайк</a>
                        <a class="btn" href="/cat/<?= $cat->id ?>/favorite">
                            <?= $cat->favorite ? 'Убрать из избранного' : 'В избранное' ?>
                        </a>
                    <?php else: ?>
                        <p>👍 Лайков: <?= $cat->likes ?></p>
                        <p style="color: #999; font-size: 14px;">
                            <em>Войдите, чтобы добавлять в избранное</em>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- 🔽 ПАГИНАЦИЯ -->
        <div style="margin-top:20px;">
            <?php if ($page > 1): ?>
                <a class="btn" href="/cats?page=<?= $page-1 ?>">Назад</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <a class="btn" href="/cats?page=<?= $i ?>"
                   style="<?= $i==$page?'background:#333; color:#fff;':'' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $pages): ?>
                <a class="btn" href="/cats?page=<?= $page+1 ?>">Вперёд</a>
            <?php endif; ?>
        </div>
    </div> <!-- ✅ ЗАКРЫВАЕМ ОСНОВНОЙ КОНТЕНТ ЗДЕСЬ -->

    <!-- Правая колонка - статистика -->
    <div class="cats-sidebar">
        <?php if (!empty($popularNames) || !empty($popularBreeds)): ?>
            <?php include __DIR__ . '/statistics.php'; ?>
        <?php endif; ?>
    </div>
</div>
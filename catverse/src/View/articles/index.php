<h2>Все статьи</h2>

<?php if (empty($articles)): ?>
    <p>Статей пока нет. 
    <?php if (!empty($currentUser)): ?>
        <a href="/articles/create">Создать первую?</a>
    <?php endif; ?>
    </p>
<?php else: ?>
    <div class="articles-list">
        <?php foreach ($articles as $article): ?>
            <div class="article-card">
                <h3>
                    <a href="/article/<?= $article->id ?>">
                        <?= htmlspecialchars($article->title) ?>
                    </a>
                </h3>
                <p class="article-excerpt">
                    <?= htmlspecialchars(mb_substr($article->text, 0, 150)) ?>...
                </p>
                <a href="/article/<?= $article->id ?>" class="btn btn-primary">Читать</a>
                
                <!-- Показываем кнопку редактирования только автору -->
                <?php if (!empty($currentUser) && $currentUser['id'] == $article->author_id): ?>
                    <a href="/article/<?= $article->id ?>/edit" class="btn">Редактировать</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!empty($currentUser)): ?>
    <div style="margin-top: 30px;">
        <a href="/articles/create" class="btn btn-primary">+ Создать статью</a>
    </div>
<?php endif; ?>
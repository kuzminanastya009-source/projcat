<article class="article-full">
    <h2><?= htmlspecialchars($article->title) ?></h2>
    
    <div class="article-meta">
    <?php if ($author): ?>
        <span><?= htmlspecialchars($author->nickname) ?></span>
    <?php endif; ?>
    <span> | <?= date('d.m.Y', strtotime($article->created_at)) ?></span>
</div>
    
    <div class="article-content">
        <?= nl2br(htmlspecialchars($article->text)) ?>
    </div>
    
    <div class="mt-30">
        <a href="/articles" class="btn">← Назад к списку</a>
        
        <!-- Кнопка редактирования только для автора -->
        <?php if (!empty($currentUser) && $currentUser['id'] == $article->author_id): ?>
            <a href="/article/<?= $article->id ?>/edit" class="btn btn-primary">Редактировать</a>
        <?php endif; ?>
    </div>
</article>
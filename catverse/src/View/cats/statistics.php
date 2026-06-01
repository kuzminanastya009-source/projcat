<div class="statistics-sidebar">
    <!-- Популярные клички -->
    <div class="stat-block">
        <h3> САМЫЕ ПОПУЛЯРНЫЕ КЛИЧКИ</h3>
        
        <div class="names-columns">
            <div class="names-column">
                <h4> КОШКИ</h4>
                <?php 
                $femaleNames = array_filter($popularNames ?? [], function($name) {
                    // Простая проверка на "женские" имена
                    $femaleEndings = ['а', 'я', 'ка'];
                    $lastChar = mb_substr($name->name, -1);
                    return in_array($lastChar, $femaleEndings);
                });
                
                foreach (array_slice($femaleNames, 0, 10) as $name): ?>
                    <div class="name-item">
                        <span class="name-text"><?= htmlspecialchars($name->name) ?></span>
                        <span class="name-count"><?= $name->count ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="names-column">
                <h4> КОТЫ</h4>
                <?php 
                $maleNames = array_filter($popularNames ?? [], function($name) {
                    $lastChar = mb_substr($name->name, -1);
                    return $lastChar !== 'а' && $lastChar !== 'я';
                });
                
                foreach (array_slice($maleNames, 0, 10) as $name): ?>
                    <div class="name-item">
                        <span class="name-text"><?= htmlspecialchars($name->name) ?></span>
                        <span class="name-count"><?= $name->count ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- Популярные породы -->
    <div class="stat-block">
        <h3> ПОПУЛЯРНЫЕ ПОРОДЫ КОШЕК</h3>
        
        <div class="breeds-list">
            <?php foreach ($popularBreeds ?? [] as $breed): ?>
                <div class="breed-item">
                    <div class="breed-icon"></div>
                    <div class="breed-info">
                        <span class="breed-name"><?= htmlspecialchars($breed->breed) ?></span>
                    </div>
                    <div class="breed-count"><?= $breed->count ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
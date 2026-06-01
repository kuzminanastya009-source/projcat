<h2>Личный кабинет</h2>

<div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <h3>Информация о пользователе</h3>
    <p><strong>Имя:</strong> <?= htmlspecialchars($user['nickname']) ?></p>
    <p><strong>Роль:</strong> <?= htmlspecialchars($user['role'] ?? 'Пользователь') ?></p>
    
    <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
    
    <h4>Действия:</h4>
    <ul style="list-style: none; padding: 0;">
        <li><a href="/cats/create" style="color: #4CAF50; font-weight: bold;">+ Добавить кота</a></li>
    </ul>
</div>
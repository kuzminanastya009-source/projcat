<h2>Вход</h2>

<?php if (!empty($error)): ?>
    <p style="color: #d9534f; background: #ffe6e6; padding: 10px; border-radius: 6px;">
        <?= htmlspecialchars($error) ?>
    </p>
<?php endif; ?>

<!-- ✅ action="/login" и name="email" -->
<form method="POST" action="/login">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit" class="btn btn-primary">Войти</button>
</form>

<p style="margin-top: 15px; font-size: 14px;">
    Нет аккаунта? <a href="/register">Зарегистрироваться</a>
</p>
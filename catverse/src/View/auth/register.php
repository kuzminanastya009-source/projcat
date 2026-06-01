<h2>Регистрация</h2>

<!-- ✅ action="/register" -->
<form method="POST" action="/register">
    <input type="text" name="nickname" placeholder="Имя пользователя" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
</form>

<p style="margin-top: 15px; font-size: 14px;">
    Уже есть аккаунт? <a href="/login">Войти</a>
</p>
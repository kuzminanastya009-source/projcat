<h1>Пока, <?= htmlspecialchars($name) ?>!</h1>
<p>До встречи в CatVerse! 🐱</p>
<a href="/" class="btn">Вернуться на главную</a>

<style>
h1 {
    color: #1a1a1a;
    text-align: center;
    margin-top: 100px;
}
p {
    text-align: center;
    font-size: 18px;
    color: #666;
}
.btn {
    display: inline-block;
    padding: 12px 24px;
    background: #1a1a1a;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    margin-top: 20px;
    transition: background 0.3s;
}
.btn:hover {
    background: #ffd1dc;
    color: #1a1a1a;
}
</style>
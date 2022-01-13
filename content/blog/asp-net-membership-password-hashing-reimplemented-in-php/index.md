---
title: "ASP.NET membership password hashing reimplemented in PHP"
date: "2018-08-02T18:49:42.000Z"
description: "Будни разработчика Сейчас у меня стадия активной переработки проекта анонимного поиска работы — GeekJob.ru [https://geekjob.ru] "
---

<h4>Будни разработчика</h4>
<p>Сейчас у меня стадия активной переработки проекта анонимного поиска работы — <a href="https://geekjob.ru" target="_blank" rel="noopener noreferrer">GeekJob.ru</a></p>
<p>Этот проект написан на ASP.NET еще в далеком 2012 году, крутится на Windows Server, хранит данные в MS SQL. И сейчас стоит задача его кардинально переработать и сделать супер модным молодежным. Чтобы все было пушка, изи катка и вот это вот все…</p>
<p>Я ничего не имею против C# и .NET, но я лично привык делать веб сервисы на скриптовых языках. Я считаю что соотношение скорости разработки, производительности и затрат ресурсов с применением PHP и/или Python самое оптимальное, особенно если у тебя очень мало человеческих ресурсов.</p>
<p>Я фанат SOA и использую разные инструменты для решения задач. Где-то я использую PHP, так как он лучше подходит для задачи. Где-то Python. Где-то Node.js, а где-то можно и Go, если прям по другому никак. Сейчас это монолит. Постепенно части сервиса выносятся и переписываются в виде отдельных сервисов и микросервисов.</p>
<p>Одной из проблем оказалась авторизация. В ASP .NET используется какой-то стандартный модуль Membership (я не .NET разработчик, так что могу путаться в терминах и названиях, поправляйте меня смело).</p>
<p>Честно искал ответ на стековерфлоу, но так и не нашел (либо я не так искал). Пришлось вспомнить юность и пореверсинжинирить (хоспади какое слово).</p>
<p>В базе есть таблица</p>
<pre>[dbo].[aspnet_Membership]</pre>
<p>В этой таблице есть 2 поля</p>
<pre>[Password], [PasswordSalt]</pre>
<p>Собственно в поле Password лежит base64 хеш пароля. В поле salt, понятное дело, лежит соль для этого пароля.</p>
<p>Вопрос — как повторить авторизацию на PHP?</p>
<p>Я нашел следующий код генерации пароля из ASP .NET</p>
<pre><code><strong>public</strong> <strong>string</strong> EncodePassword(<strong>string</strong> password, <strong>string</strong> salt)<br>{<br><strong>byte</strong>[] bytes = Encoding.Unicode.GetBytes(password);<br><strong>byte</strong>[] src = Encoding.Unicode.GetBytes(salt);<br><strong>byte</strong>[] dst = <strong>new</strong> byte[src.Length + bytes.Length];<br><br>    Buffer.BlockCopy(src, 0, dst, 0, src.Length);<br>    Buffer.BlockCopy(bytes, 0, dst, src.Length, bytes.Length);<br><br>    HashAlgorithm algorithm = HashAlgorithm.Create("SHA1");<br><br><strong>byte</strong>[] inArray = algorithm.ComputeHash(dst);<br><br><strong>return</strong> Convert.ToBase64String(inArray);<br>}</code></pre>
<p>Что видим:</p>
<ul>
<li>Соль примешивается перед паролем</li>
<li>Соль и пароли обрабатываются в виде байтовых массивов</li>
<li>Результат возвращается в виде base64</li>
<li>Используется криптоалгоритм SHA1</li>
</ul>
<p>Что у нас есть — пароль и соль и они уже лежать в базе в base64. Значит нам надо разкодировать соль, склеить с паролем и закриптовать через SHA1.</p>
<h3>PHP аналог генерации хеша для паролей как в ASP.NET membership модуле</h3>
<p>И так, нам нужно плаинтекст пароль представить в виде набора байт, сцепить с солью и вычислить SHA1. Как оказалось это довольно просто в итоге:</p>
<pre><strong>function</strong> get_hash4pass(<strong>string</strong> $password, <strong>string</strong> $salt) :<strong>string<br></strong>{<br><strong>return</strong> base64_encode(sha1(<br>          base64_decode($salt)<br>             . pack('v*', ...unpack('C*', $password))<br>         , <strong>true<br></strong>));<br>}</pre>
<p>Ну и когда у вас есть хеш из базы и хеш из данной функции, вы просто сравниваете их:</p>
<pre><strong>function</strong> valid_password(<strong>string</strong> $password, <strong>string</strong> $hashed_password, <strong>string</strong> $salt) :<strong>bool<br></strong>{<br>   $hash = get_hash4pass($password, $salt);<br>   return <strong>hash_equals</strong>($hash, $hashed_password);<br>}</pre>
<p>В итоге не пришлось ломать текущую авторизацию в коде на ASP .NET и появилась возможность писать сервисы на PHP, которые могут авторизовать пользователя используя текущий алгоритм.</p>
<p>Возможно кому-то это пригодится.</p>



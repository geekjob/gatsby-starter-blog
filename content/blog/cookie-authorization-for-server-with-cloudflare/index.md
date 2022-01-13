---
title: "Cookie авторизация"
date: "2019-05-09T02:19:39.00Z"
description: "Закрываем dev версию сайта от посторонних глаз В прошлой статье я рассказывал как сделать простую авторизацию по кукисам для тог"
---

<!--kg-card-begin: html--><h4>Закрываем dev версию сайта от посторонних глаз</h4>
<p>В прошлой статье я рассказывал как сделать простую авторизацию по кукисам для того, чтобы закрыть хост от посторонних глаз.</p>
<h4>UPD #1</h4>
<p>Я исправил уже, но сначала я указывал код редиректа 301. Нужно отдавать 302. Если ваш клиент/заказчик/etc хотя бы раз зайдет без авторизации, то браузер может очень жестко закешировать ответ и потом его сбросить будет не легко (особенно на чужом компьютере, к которому нет доступа). Например Safari у нашего продакта так сильно закешировал ответ, что мне стоило прям усилий заставить его снова видеть сайт, даже когда я отключил авторизацию.</p>
<h4>UPD #2</h4>
<p>Если вы пользуетесь сервисом Cloudflare то, как вариант, можно сделать авторизацию по такому же типу, но через воркеры.</p>
<figure>
<p><img data-width="2080" data-height="892" src="https://cdn-images-1.medium.com/max/800/1*9HS2P48AoPMbfgcwDphr0w.jpeg"><br />
</figure>
<p>Воркеры — это аналог лямбд. Эдакий серверлесс подход. Вы можете обрабатывать входящий и исходящие запросы и модифицировать их по своему усмотрению. Воркеры пишутся на новомодном JS (ES6+, async/await и прочие плюхи).</p>
<p>Код Cloudflare Worker’а для авторизации по кукисам:</p>
<pre><strong>addEventListener</strong>('fetch', event <strong>=&gt; {</strong><br>  event.respondWith(handleRequest(event.request))<br><strong>})</strong><br><br><strong>async</strong> <strong>function</strong> handleRequest(request) {<br><strong>const</strong> url = <strong>new</strong> URL(request.url);<br><strong>const</strong> query = <strong>new</strong> URLSearchParams(url.search);<br><br><strong>if</strong> ('<em>secretkey</em>' == query.get('<em>access</em>')) {<br><strong>return</strong> <strong>new</strong> Response(`<em>&lt;meta refresh="3;/"&gt;&lt;p&gt;Loading, please wait...&lt;/p&gt;&lt;script&gt;document.cookie='access=secretKey; path=/; domain=.someserver.com; expires='+(new Date(new Date().getTime()+6e5)).toUTCString();location='/'&lt;/script&gt;</em>`,<br>        {<br>          status: 200,<br>          statusText: 'Ok',<br>          headers: [<br>            ["content-type", "text/html;charset=UTF-8"],<br>          ]<br>        }<br>      )<br>    ;<br>  }<br><br><strong>const</strong> cookies = request.headers.get('Cookie')||'';<br>  if (!cookies.includes('<em>access</em>=<em>secretkey</em>')) {<br><strong>return</strong> <strong>new</strong> Response(<br>        `&lt;h1&gt;403 Forbidden&lt;/h1&gt;`,<br>        {<br>          status: 403,<br>          statusText: 'Forbidden',<br>          headers: [<br>            ["Content-Type", "text/html;charset=UTF-8"],<br>          ]<br>        }<br>      )<br>    ;<br>  }<br><br><br><strong>const</strong> response = <strong>await</strong> fetch(request)<br><strong>return</strong> response<br>}</pre>
<p>Суть проста и похожа: если нет нужной куки, просто говорим что доступа нет. Чтобы открыть сайт, формируем URL вида:</p>
<pre>https://some.com?access=secretKey</pre>
<p>Воркер проверяет этот запрос и в ответ выдает HTML страницу, в которой через JS выставляем куку в браузер. После чего снова редиректим на главную, но так как у нас уже открыт доступ к сайту (есть нужная кука), то воркер просто перенаправляет запрос к серверу без модификаций.</p>
<p>Воркер можно включить на все поддомены используя маски:</p>
<figure>
<p><img data-width="1056" data-height="880" src="https://cdn-images-1.medium.com/max/800/1*mraME8hK80DpMbNAGgox9g.jpeg"><br />
</figure>
<p>Ну вот и все. Удобно, просто, быстро.</p>
<p>Так как это реверс прокси с возможностью писать полноценные обработчики, то можно сделать сложную авторизацию, авторизацию по базе пользователей и так далее. Вы, почти что, не ограничены в реализации и можете навернуть любую логику. Конечно с приходом ngScript в Nginx можно такое же повторить и в Nginx, но тут, считайте, полноценный “Node.js” аналог. Вы можете ходить по рестапи за данными, можете логировать проходящие запросы, отдавать несуществующие страницы, сгенерированные специально для конкретного запроса (например чтобы подтвердить права на сайт через файл, при этом не залезая на сам сервер). Очень мощный инструмент.</p>
<!--kg-card-end: html-->


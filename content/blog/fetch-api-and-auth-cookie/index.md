---
title: "Fetch API и Auth Cookie"
date: "2016-11-29T18:10:07.00Z"
description: "Передаем на сервер Если нужно сделать запрос с передачей авторизационных cookie с текущей страницы, то нужно добавить следующие "
---

<!--kg-card-begin: html--><h4>Передаем на сервер</h4>
<p>Если нужно сделать запрос с передачей авторизационных cookie с текущей страницы, то нужно добавить следующие настройки при запросе:</p>
<pre><code><strong>fetch</strong>('/some/uri/', {<br><strong>credentials</strong>: <em>'same-origin'</em><br>})</code></pre>
<!--kg-card-end: html-->


---
title: "Юзкейсы деструктуризации"
date: "2016-11-14T13:50:08.000Z"
description: "Трюки с ES2015



С приходом нового синтаксического сахара в ES.Next в руках фронтендеров
появились новые мощные инструменты для"
---

<h4>Трюки с ES2015</h4>

<p>С приходом нового синтаксического сахара в ES.Next в руках фронтендеров появились новые мощные инструменты для сокращения кода. Код можно делать более читаемым (но при этом более непонятным для тех, кто не знает новый стандарт).</p>
<h4>Переименование</h4>
<p>Рассмотрим первый пример с деструктуризацией — переименование.</p>
<p>Допустим у вас есть функция такого вида:</p>
<pre><strong>function</strong> getUser(<em>user</em>){<br><strong>let</strong> <em>id</em> = <em>user</em>.userId;<br><strong>return</strong> getUserById(<em>id</em>);<br>}</pre>
<pre>getUser({ <em>userId</em>: 123 })</pre>
<p>Как видите, чтобы удобнее было работать с id , а не писать длинное имя, мы получили идентификатор пользователя и сохранили в перменной id. Это утрированный пример, в реальной практике все может быть сложнее.</p>
<p>Этот же пример на 1 строчку кода меньше может выглядеть так:</p>
<pre><strong>function</strong> getUser({ <em>userId</em>: id }){<br><strong>return</strong> getUserById(<em>id</em>);<br>}</pre>
<h4>Поменять местами значения</h4>
<p>Это решение классической задачи на собеседованиях — как поменять местами значения двух переменных без создания третьей. Покажу как это сделать при помощи деструктуризации:</p>
<pre><strong>var</strong> a = 1;<br><strong>var</strong> b = 2;</pre>
<pre>console.log(<em>a</em>, <em>b</em>); <em>// 1 2</em></pre>
<pre><strong>var</strong> { <em>a</em>: b, <em>b</em>: a } = { <em>a</em>,<em> b</em> }</pre>
<pre>console.log(<em>a</em>, <em>b</em>); <em>// 2 1</em></pre>
<p>Важно помнить что этот вариант показан ради фана и возможностей, но ни в коем случае не является рекомендацией к применению в продакшене.</p>
<h4>Параметрами по умолчанию</h4>
<p>Если вы собирались деструктуризовать параметры, но вам так же надо задать дефолтные значения на случай, если они не пришли, вы можете сделать следующее:</p>
<pre><strong>function</strong> foo({ a, b } = { a: 1, b: 2 }) {<br>  console.log(a, b);<br>}</pre>
<pre>foo(); // 1 2<br>foo({ a: 4, b: 8, c: 48 }); // 4 8<br>foo({ a: 4 }); // 4 undefined</pre>
<p>Но у такого способа есть один минус. Если вы передадите объект с отсутствующими полями, то они станут undefined, как в третьем вызове функции foo.</p>
<p>На самом деле у деструктуризации есть свои собственные параметры по умолчанию. Так что наш пример лучше переписать так:</p>
<pre><strong>function</strong> foo({ a = 1, b = 2 } = {}) {<br>  console.log(a, b);<br>}</pre>
<pre>foo(); // 1 2<br>foo({ a: 4, b: 8, c: 48 }); // 4 8<br>foo({ a: 4 }); // 4 2</pre>
<p>Вот теперь все работает четко.</p>
<h4>Shift аргументов</h4>
<p>Если у вас есть функция с неограниченным количеством аргументов, то при работе есть несколько вариантов получения нужных. Вы можете обращаться к конкретному аргументу по его индексу в объекте аргументов, либо присвоить все аргументы в переменные, например так:</p>
<pre><strong>function</strong> foo(...args) {<br><strong>let</strong> a = args.shift(),<br><em>      b = args.shift(),</em><br>      c = args.shift();</pre>
<pre>  console.log(<strong>a</strong>, <strong>c</strong>); // 1 3<br>}</pre>
<pre>foo(1, 2, 3);</pre>
<p>Вы можете присвоить значение по индексам:</p>
<pre><strong>function</strong> foo(...args) {<br><strong>let</strong> a = args[0],<br><em>      b = args[1],</em><br>      c = args[2];<br><br>  console.log(<strong>a</strong>, <strong>c</strong>);<br>}</pre>
<p>А можете сделать проще:</p>
<pre><strong>function</strong> foo(...args) {<br><strong>let</strong> [<strong>a,,c</strong>] = args;<br>  console.log(<strong>a</strong>, <strong>c</strong>);<br>}</pre>
<p>В данном примере мы воспользовались пропуском при деструктуризации массива. Это особенно удобно при работе с аргументами в Nodejs скриптах:</p>
<pre><em>#!/usr/bin/env node</em></pre>
<pre><strong>const</strong> [,,filePath] = process.argv;</pre>
<pre>console.log(filepath);</pre>
<hr>
<p>Лайк, хлопок, шер. Слушайте меня в <a href="https://itunes.apple.com/ru/podcast/pro-web-it/id1366662242?mt=2" target="_blank" rel="noopener noreferrer">iTunes</a>, подписывайтесь на <a href="https://t.me/prowebit" target="_blank" rel="noopener noreferrer">Телеграм</a> канал или <a href="https://vk.com/mayorovprowebit" target="_blank" rel="noopener noreferrer">Вконтакте</a>.</p>



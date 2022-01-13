---
title: "JS Зарисокви на тему URL"
date: "2019-03-31T02:32:41.00Z"
description: "А вы знали что… Не зная таких вещей, можно наломать дров  Наверняка вы знаете что, чтобы получить имя домена нужно обратиться к "
---

<h4>А вы знали что…</h4>

<p>Наверняка вы знаете что, чтобы получить имя домена нужно обратиться к <code>window.location</code>:</p>
<pre>window.location.href</pre>
<p>При этом не раз слышал на собеседовании что чтобы получить имя домена, надо парсить это свойство. Я думаю что многие знают, что чтобы получить части URL нужно обратиться к соответствующим полям (их там на все части URL):</p>
<pre>window.location.host     // medium.com<br>window.location.hostname // medium.com</pre>
<p>Но не все знают, что можно не писать window, так как location будет найден по цепочке, так что это можно писать в любом месте, внутри любой функции как:</p>
<pre><strong>const</strong> getHostName = () =&gt; location.hostname ;</pre>
<p><strong>А вы знали, что чтобы получить имя домена в JS можно обратиться так же к </strong><code>document.domain</code><strong> ?</strong></p>
<pre><strong>const</strong> getHostName = () =&gt; <code>document</code>.domain ;</pre>
<blockquote><p>Свойство <code>domain</code> у <code>Document</code> интерфейса получает/устанавливает доменную часть источника происхождения (origin) текущего документа и используется в политике ограничения домена (same origin policy).</p></blockquote>
<p>Чтобы сделать редирект на другую страницу всегда и везде писали и пишем такой код:</p>
<pre>window.location.href = '<a href="https://geekjob.ru" target="_blank" rel="noopener noreferrer">https://geekjob.ru</a>'</pre>
<p><strong>А вы знали, что можно просто присвоить значение в location и это будет равносильно </strong><code>window.location.href</code><strong>?</strong></p>
<pre>location = '<a href="https://geekjob.ru" target="_blank" rel="noopener noreferrer">https://geekjob.ru</a>'</pre>
<p>Дело в том, что location это не просто глобальное свойство &#8212; это setter/getter объект (ну там немного сложнее, но для простоты так). Когда вы присваиваете значение в location, вызывается метод:</p>
<pre><code>location.assign(</code>'<a href="https://geekjob.ru" target="_blank" rel="noopener noreferrer">https://geekjob.ru</a>'<code>)</code></pre>
<p>Отсюда могут родиться <strong>хитрые вопросы для собеседования</strong>: что делает следующий код?</p>
<pre><strong>function</strong> getLocation() {<br>   location = '<a href="https://vacancy.new.hr" target="_blank" rel="noopener noreferrer">vacancy.new.hr</a>';<br><strong>return</strong> location<br>}</pre>
<pre>console.log( getLocation() ) // ???</pre>
<p>Скорее всего будет ответ что есть локальная переменная, которая протекает в глобальную область. На самом деле будет редирект страницы, да. Вот такие вот дела.</p>
<p>Конечно для Node.js это все не актуально. Но для браузеров еще как. Отсюда вывод: настраивайте линтеры так, чтобы не пропускать инициализации, используйте <code>use strict</code> и вот это все.</p>
<p><strong>А знаете ли вы, что чтобы получить текущий URL в виде строки, то не обязательно писать</strong> <code>window.location.href</code> <strong>?</strong></p>
<p>Вы можете использовать метод toString():</p>
<pre><strong>location</strong>.toString()<br>// или<br><strong>location</strong>+''</pre>
<p><strong>А знаете ли вы, что можно так же отправить запрос с параметрами используя</strong> <code>location.search</code> ?</p>
<pre>location.search = 'a=1&amp;b=2'</pre>
<p>И тут точно такой же механизм, страница перезагрузится на текущем URL + добавятся параметры. Удобно, когда нужно отправить на текущий URI данные.</p>
<p><strong>А вы знаете, что</strong> все тоже самое можно проделать и с путями?</p>
<pre>location.pathname = '/foo/bar'</pre>
<pre>// вместо<br>window.location.href = '/foo/bar'</pre>
<p>если вам нужно сделать внутренний редирект? <strong>Таким образом можно защищаться от разного рода XSS</strong>, если у вас пользовательский ввод, так как нельзя просунуть ничего кроме пути:</p>
<pre>location.pathname = 'https://google.com'</pre>
<p>отредиректит на текущий URL + pathname:</p>
<pre>https://medium.com/https://google.com</pre>
<p>Такие вот дела.</p>
<p>Ну и в тему, еще вопрос с собеседования, который можно было встретить раньше (может быть где-то и сейчас, почему бы и нет): как распарсить URL ?</p>
<p>Ответы можно дать разные, от регулярок до более чего-то сложного. Но если вы работаете в контексте браузера, то самый простой способ (<em>был</em>) это:</p>
<pre><strong>function</strong> urlParse(url) {<br><strong>var</strong> location = document.createElement('a');<br>  location.href = url;<br><strong>return</strong> location<br>}</pre>
<pre>console.dir( urlParse('<a href="https://geekjob.ru" target="_blank" rel="noopener noreferrer">https://geekjob.ru</a>').hostname )</pre>
<p>Этот ответ был актуальным до тех пор, пока в браузерах не появилось API:</p>
<pre><strong>const</strong> location = <strong>new</strong> URL('https://vacancy.new.hr')</pre>
<p>Все современные браузеры поддерживают этот класс и он есть даже в Node.js в глобальной области.</p>
<h4>Распарсить query params</h4>
<p>В location есть такое поле (мы говорили выше) — search. Оно содержит параметры запроса. Как его распарсить? Раньше приходилось решать эту задачку, а сегодня для этих целей есть API: <code>URLSearchParams</code> :</p>
<pre><code><strong>const</strong> query = <strong>new</strong> URLSearchParams( </code>location.search )</pre>
<p><a href="https://developer.mozilla.org/ru/docs/Web/API/URLSearchParams" target="_blank" rel="noopener noreferrer">Подробности на MDN</a>.</p>
<p>Такая вот интересная годнота. Вроде многое знакомо и пользуемся чуть ли не каждый день, но всегда есть нюансы, на которые можем просто не обращать внимание.</p>



---
title: "Релиз TypeScript 2.1"
date: "2016-12-08T13:37:39.00Z"
description: "Выкидываем Babel До текущего релиза TypeScript, который совершился 7 декабря 2016 года, некоторые пользовались двойной компиляци"
---

<!--kg-card-begin: html--><h4>Выкидываем Babel</h4>
<p>До текущего релиза TypeScript, который совершился 7 декабря 2016 года, некоторые пользовались двойной компиляцией при работе с TypeScript:</p>
<p><iframe title="Battle Programmer Shirase - Double Compile (In English)" width="580" height="435" src="https://www.youtube.com/embed/6WxJECOFg8w?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>
<p>Код на TS/TSX транспилировался с таргетом ESNEXT и далее уже полученный код отдавался на транспилирование в Babeljs:</p>
<pre>source.ts <strong>→</strong> tsc --target ESNEXT <strong>→</strong> babeljs <strong>→</strong> out.js</pre>
<p>Тут есть лишнее звено в виде Babel, который не нужен, так как TypeScript умеет отлично транспилировать код в ES3/ES5. И вот настал тот день, когда бабель можно исключить из этой пищевой цепочки совсем и оставить всего лишь одну компиляцию (прощай боевой программист Ширасу).</p>
<h3>Async/Await Functions</h3>
<p>Свершилось, теперь есть транспиляция асинковэйтов в ES3/ES5. Это одна из долгожданных фич. Пример таких функций:</p>
<pre><strong>const</strong> getDataFromServer <em>:Promise</em> = () <em>:Promise</em> =&gt;<br> fetch('<a href="https://jsonplaceholder.typicode.com/comments?postId=1%27%29.then%28f=" target="_blank" rel="noopener noreferrer">https://jsonplaceholder.typicode.com/comments?postId=1').then(f=</a>&gt;f.json());</pre>
<pre><strong>async</strong> function showData() {<br>    return <strong>await</strong> getDataFromServer()<br>}</pre>
<pre>console.table(showData(), ['id','email']);</pre>
<h3>Object Rest &amp; Spread</h3>
<p>О да, все уже вовсю используют эту фичу и гоняют свой код в Babel, но фича это, на минуточку, из стандарта ES2017. Но теперь и в TS есть возможность использовать этот механизм и компилировать код в ES5.</p>
<pre><strong>let</strong> copy = { ...original };</pre>
<pre><strong>let</strong> merged = { ...foo, ...bar, ...baz };</pre>
<pre><strong>let</strong> { a, b, c, ...defghijklmnopqrstuvwxyz } = alphabet;</pre>
<h4>И много чего еще интересного</h4>
<p>А вообще много чего еще интересного добавлено в этом релизе. Просто банально нет времени переводить все. Так что советую пройтись по ссылкам и самим все увидеть</p>
<p><a href="https://blogs.msdn.microsoft.com/typescript/2016/12/07/announcing-typescript-2-1/">https://blogs.msdn.microsoft.com/typescript/2016/12/07/announcing-typescript-2-1/</a><br />
<a href="https://blogs.msdn.microsoft.com/typescript/2016/12/07/announcing-typescript-2-1/">https://blogs.msdn.microsoft.com/typescript/2016/12/07/announcing-typescript-2-1/</a></p>
<!--kg-card-end: html-->


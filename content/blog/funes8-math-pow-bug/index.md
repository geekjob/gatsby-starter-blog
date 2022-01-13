---
title: "FunES#8: Math.pow не равно**"
date: "2019-02-22T00:51:47.00Z"
description: "JavaScript зарисовки в стиле WTF Browsers    В JS есть оператор возведения в степень. Появился он в JavaScript относительно неда"
---

<!--kg-card-begin: html--><h4>JavaScript зарисовки в стиле WTF</h4>
<h3>Browsers</h3>
<figure>
<p><img data-width="948" data-height="422" src="https://cdn-images-1.medium.com/max/800/1*cVuY5m8OlUlN6SbOarVfPw.jpeg"><br />
</figure>
<p>В JS есть оператор возведения в степень. Появился он в JavaScript относительно недавно (хотя с учетом скорости развития JS можно сказать что и давно). Пример использования:</p>
<pre>Math.pow(2,2) === 2**2</pre>
<p>Но, эти операторы не совсем эквивалентны. И вот вам пример:</p>
<pre>Math.pow(99,99); // -&gt; 3.69729637649726<strong>3e</strong>+197<br>99 ** 99; // -&gt; 3.69729637649726<strong>8e</strong>+197</pre>
<pre>// следовательно<br>Math.pow(99,99) === 99**99 // false</pre>
<p>Что за фигня? Опять этот ЖабаСкрипт косячит? Разные значения!</p>
<p>Но вдруг вы встречаете такой код:</p>
<pre><strong>const</strong> pow = num <strong>=&gt;</strong> num <strong>**</strong> num<br><strong>const</strong> num = 99<br>num ** num - pow(99) === 0 // true</pre>
<p>И тут вы говорите: чоооо? В смысле? Ээээ… Перепроверяете:</p>
<pre><strong>void</strong> <strong>function</strong> (num = 99) {<br>  console.log((num ** 99) === Math.pow(99,99)) // true<br>}()</pre>
<p>Да что такое?</p>
<p>Короче, через какое-то время вы дойдете до того, что есть 2 вида выполнения кода: runtime и compiletime.</p>
<p>Это ошибка в V8 и проявляется она в браузере Chrome и Opera (это кстати тема к вопросу про монополизм и единый движок :)).</p>
<p>Оператор “**” вычисляется во время компиляции, что дает другой результат, чем результат во время выполнения. В Firefox и Safari ошибки нет.</p>
<h3>Node.js и Deno</h3>
<blockquote><p>Deno — это экспериментальный молодой проект, альтернатива Node.js со встроенным TypeScript рантаймом.</p></blockquote>
<p>И тут меня ждал сюрприз. В ноде есть ошибка, в то время как в Deno ее нет! Но у меня ест предположение: так как в Deno используется TS, то код оборачивается в некий рантайм, который как раз и компилируется. Поэтому то, что кажется выполняется в рантайме, на самом деле выполняется в компайле.</p>
<figure>
<p><img data-width="1266" data-height="552" src="https://cdn-images-1.medium.com/max/800/1*Mt3FGXXhQiL1BxJsKCvcow.jpeg"><br />
</figure>
<h4>Детали бага “Math.pow and ** not equal”</h4>
<p>Можно узнать по ссылке <a href="https://bugs.chromium.org/p/v8/issues/detail?id=5848" target="_blank" rel="noopener noreferrer">https://bugs.chromium.org/p/v8/issues/detail?id=5848</a></p>
<blockquote><p>Информация актуальна на 22.02.2019+-. Это должны пофиксить. Как баг пофиксят, статья аннигилируется</p></blockquote>

<!--kg-card-end: html-->


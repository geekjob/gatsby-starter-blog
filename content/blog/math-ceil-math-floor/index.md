---
title: "Math.ceil & Math.floor"
date: "2018-02-07T14:58:50.00Z"
description: "Tips & Tricks in JS    Сегодня не про задачки, а про трюки в JS. Пример, как можно сократить запись Math.ceil и Math.floor. Не т"
---

<!--kg-card-begin: html--><h4>Tips &amp; Tricks in JS</h4>
<figure>
<p><img data-width="800" data-height="306" src="https://cdn-images-1.medium.com/max/800/1*vJUGHsAC1lYcXqB11RgtdA.jpeg"><br />
</figure>
<p>Сегодня не про задачки, а про трюки в JS. Пример, как можно сократить запись Math.ceil и Math.floor. Не то, чтобы это круто, но в чужом коде, особенно в NPM пакетах такое может встречаться. Чтобы это не вызывало вопросов и не было ощущения что тут какая-то магия(а тут нет никакой магии, просто нужно знать как работают операторы). Где-то такой код генерится “машиной”, всякими обфускаторами и минификаторами. А где-то люди сами пишут такой код.</p>
<h3>Math.ceil</h3>
<blockquote><p>Метод <code><strong>Math.ceil()</strong></code> возвращает наименьшее целое число, большее, либо равное указанному числу.</p></blockquote>
<h4>Побитовое НЕ (NOT)</h4>
<p>Оператор “<strong>~” </strong>— заменяет каждый бит операнда на противоположный. Используем совместно с мнусом, так как NOT инвертирует знак числа.</p>
<pre>-~number === Math.ceil(number)</pre>
<pre>// Примеры:<br>Math.ceil(8.1) === -~8.1 // 9<br>Math.ceil(4.9) === -~4.9 // 5</pre>
<h3>Math.floor</h3>
<blockquote><p>Метод <code><strong>Math.floor()</strong></code> возвращает наибольшее целое число, которое меньше или равно данному числу.</p></blockquote>
<h4>Побитовое ~</h4>
<p>Используем двойное преобразование.</p>
<pre>~~number === Math.floor(number)</pre>
<pre>// Примеры:<br>Math.floor(8.1) === ~~8.1 // 8<br>Math.floor(4.9) === ~~4.9 // 4</pre>
<h4>Побитовое ИЛИ (OR)</h4>
<p>Ставит 1 на бит результата, для которого хотя бы один из соответствующих битов операндов равен 1.</p>
<pre>0|number === Math.floor(number)<br>number|0 === Math.floor(number)</pre>
<pre>// Примеры:<br>0|8.1 === Math.floor(8.1)<br>4.9|0 === Math.floor(4.9)</pre>
<!--kg-card-end: html-->


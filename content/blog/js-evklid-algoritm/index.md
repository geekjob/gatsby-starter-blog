---
title: "Алгоритм Евклида"
date: "2016-12-24T16:40:32.00Z"
description: "Задачки с собеседований по JS Очередная задачка с собеседований. На этот раз написать функцию, реализующую алгоритм Евклида.  Ал"
---

<!--kg-card-begin: html--><h4>Задачки с собеседований по JS</h4>
<p>Очередная задачка с собеседований. На этот раз написать функцию, реализующую алгоритм Евклида.</p>
<p><strong>Алгоритм Евклида</strong> — это алгоритм нахождения наибольшего общего делителя (НОД) пары целых чисел.</p>
<p><strong>Наибольший общий делитель (НОД)</strong> — это число, которое делит без остатка два числа и делится само без остатка на любой другой делитель данных двух чисел. Проще говоря, это самое большое число, на которое можно без остатка разделить два числа, для которых ищется НОД.</p>
<h4>Варианты решений нахождения НОД</h4>
<p>Вариант без рекурсии</p>
<pre><strong>function </strong>nod(x, y) {<br><strong>while </strong>(y !== 0) y = x % (x = y);<br><strong>return </strong>x;<br>}</pre>
<pre>console.log( nod(21, 14) ); <em>// = 7</em></pre>
<p>Рекурсивный алгоритм на ES6</p>
<pre><strong>const </strong>nod = (x, y) =&gt; x !== 0 ? nod(y%x, x) : y;</pre>
<pre>console.log( nod(10, 5) ); <em>// = 5</em></pre>
<!--kg-card-end: html-->


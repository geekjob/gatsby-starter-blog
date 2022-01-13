---
title: "Замена for и let"
date: "2017-07-30T22:17:38.000Z"
description: "В arrow functions
Покажу на примере 1й функции, как заменить цикл for () и инициализацию
переменных в стрелочных функциях:

Прим"
---

<h4>В arrow functions</h4>
<p>Покажу на примере 1й функции, как заменить цикл for () и инициализацию переменных в стрелочных функциях:</p>
<p>Пример функции вычисления n-го числа Фибоначи с применением деструкторизации:</p>
<pre><strong>function</strong> fib(n){<br><strong>let</strong>[ x, y ] = [ 0, 1 ];<br><strong>for</strong> (<strong>let</strong> i=0; i&lt;n; i++) { [ x, y ] = [ y, x+y ] };<br><strong>return</strong> x<br>}</pre>
<p>Превращаем этот алгоритм в стрелочную функцию. Цикл можно заменить следующим образом:</p>
<pre><strong>for</strong> (<strong>let</strong> i=0; i&lt;n; i++) { ...code... }<br>// на<br>[...<strong>Array</strong>(n)].<strong>forEach</strong>(i=&gt; ...code...)</pre>
<p>Локальные переменные объявляем в виде аргументов с дефолтными значениями. В итоге получаем функцию:</p>
<pre><strong>const</strong> fib = (n, x=0, y=1) =&gt; (<br>  [...<strong>Array</strong>(n)].<strong>forEach</strong>(i <strong>=&gt; </strong>[ x, y ] = [ y, x+y ]), x<br>)</pre>



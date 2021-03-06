---
title: "Array range в ES2016+"
date: "2016-12-30T15:50:09.00Z"
description: "Старая задача на новый лад Задача: инициализировать массив и заполнить значениями. Раньше задача решалась строкой:  var a = Arra"
---

<!--kg-card-begin: html--><h4>Старая задача на новый лад</h4>
<p>Задача: инициализировать массив и заполнить значениями. Раньше задача решалась строкой:</p>
<pre><strong>var</strong> a = <strong>Array</strong>.apply(<strong>null</strong>, {length: 8}).map(<strong>Number</strong>.call, <strong>Number</strong>);</pre>
<p>Но сейчас же уже конец 2016 года (считай что уже 2017). И пишем мы давно не на ES5, а на ES2016+…</p>
<h4>Array.fill</h4>
<p>Есть такой метод: Array.fill — заполняет все элементы массива от начального до конечного индексов одним значением. Но его минус в том, что он умеет заполнять значением, но не диапазоном.</p>
<h4>Метод map</h4>
<p>Используя метод map мы могли бы заполнить массив значениями. Попробуем:</p>
<pre><strong>&gt; new</strong> Array(8).map((n,i) =&gt; i)<br>&gt; []</pre>
<p>Но тут есть проблема. Массив будет содержать 8 элементов undefined, поэтому метод map не сработает. Вот здесь мы могли бы использовать комбинацию методов fill() и map():</p>
<pre><strong>&gt; new</strong> <strong>Array</strong>(8).fill(null).map((n,i) =&gt; i)<br>&gt; [0,1,2,3,4,5,6,7]</pre>
<p>Работает, да. Но как-то слишком длинно, не правда ли? Можно короче? Да, используя спред оператор.</p>
<h4>Spread operator</h4>
<pre><strong>const</strong> a = [ ...<strong>Array</strong>(8).keys() ];</pre>
<p>Вуаля! Если вдруг, по каким-то причинам нет возможности использовать этот оператор, можно заменить его на метод Array.from()</p>
<pre><strong>const</strong> a = <strong>Array</strong>.from(<strong>Array</strong>(8).keys());</pre>
<!--kg-card-end: html-->


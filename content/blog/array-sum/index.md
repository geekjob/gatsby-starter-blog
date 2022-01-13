---
title: "Array sum"
date: "2016-12-28T19:11:36.00Z"
description: "Сложить и посчитать В очередной раз решаем простые задачки с собеседований (ну и из жизни). Надо получить сумму всех чисел в мас"
---

<h4>Сложить и посчитать</h4>
<p>В очередной раз решаем простые задачки с собеседований (ну и из жизни). Надо получить сумму всех чисел в массиве. Вроде бы напрашивается некоторая готовая функция Array.sum. К примеру в PHP есть такая функция <a href="http://php.net/manual/ru/function.array-sum.php" target="_blank" rel="noopener noreferrer">array_sum</a>. Но вот в JS такой функции нет. Ну и задача вроде бы простая.</p>
<p>Дано:</p>
<pre><strong>const</strong> ar = [2,4,8];</pre>
<p>Алгоритм с ходу:</p>
<pre><strong>for</strong> (<strong>var</strong> sum=0,i=0; i&lt;ar.length; i++) sum += ar[i];</pre>
<pre>// или</pre>
<pre><strong>var</strong> sum = 0; <strong>for</strong> (i <strong>of</strong> ar) sum += i;</pre>
<p>Когда-то, давным давно (лет 8 назад), такую задачу я решал через eval и считал это ниипически крутым финтом:</p>
<pre><strong>var</strong> sum = <strong>eval</strong>([2,4,8].join(‘+’));</pre>
<p>Сейчас такой код я бы лично охаял и осудил.</p>
<h4>Функциональный подход</h4>
<p>В функциональном стиле все можно решить через редьюсер:</p>
<pre><strong>const</strong> sum = [2,4,8].<strong>reduce</strong>((a,b)=&gt;a+b, 0);</pre>
<p>На сегодня я считаю данный вариант наиболее предпочтительным.</p>



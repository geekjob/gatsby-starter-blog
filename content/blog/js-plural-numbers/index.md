---
title: "Склоняем числительные"
date: "2017-06-27T18:04:56.00Z"
description: "1 дня, 2 лет, 5 день Склонять числительные нужно периодически в работе. Цены, возраст, количество товара и так далее… Предлагаю "
---

<!--kg-card-begin: html--><h4>1 дня, 2 лет, 5 день</h4>
<p>Склонять числительные нужно периодически в работе. Цены, возраст, количество товара и так далее… Предлагаю простую функциональную реализацию в 1 строчку:</p>
<pre><strong>const</strong> numfix <strong>=</strong> (n, t) <strong>=&gt;</strong> t<strong>[</strong><br>       (n <strong>%=</strong> 100, 20 <strong>&gt;</strong> n &amp;&amp; n <strong>&gt;</strong> 4) <strong>?</strong> 2<br><strong>:[</strong>2,0,1,1,1,2<strong>][</strong> <strong>(</strong>n <strong>%=</strong> 10, n &lt; 5<strong>)</strong> <strong>?</strong> n : 5<strong>]</strong><br><strong>]</strong><br>;</pre>
<h3>Применение</h3>
<pre><strong>const</strong> a = ['день','дня','дней'];<br>numfix(1, a) // день<br>numfix(2, a) // дня<br>numfix(5, a) // дней</pre>
<!--kg-card-end: html-->


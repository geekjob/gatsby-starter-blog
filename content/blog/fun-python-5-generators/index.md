---
title: "FunPython #5: Функция-генератор"
date: "2020-01-24T13:09:12.000Z"
description: "Lazy function Функция в Python не может быть одновременно генератором и обычной функцией. Если указано слово yield, то функция с"
---

<h4>Lazy function</h4>
<p>Функция в Python не может быть одновременно генератором и обычной функцией. Если указано слово yield, то функция становится генератором:</p>
<pre><strong>def</strong> foo(count=0, lazy=<strong>True</strong>):<br><strong>if</strong> lazy:<br><strong>for</strong> i <strong>in</strong> range(count):<br><strong>yield</strong> i<br><strong>else</strong>:<br><strong>return</strong> <strong>list</strong>(range(count))<br><br><br><strong>print</strong>(foo(10, <strong>False</strong>))<br>&lt;generator object foo at 0x108d9e3c0&gt;</pre>
<p>Решить эту проблем можно, если вынести генератор в отдельную функцию:</p>
<pre><strong>def</strong> _foo_generator(count=0):<br><strong>for</strong> i <strong>in</strong> range(count):<br><strong>yield</strong> i<br><br><br><strong>def</strong> foo(count=0, lazy=<strong>True</strong>):<br><strong>if</strong> lazy:<br><strong>return</strong> _foo_generator(count)<br><strong>else</strong>:<br><strong>return</strong> <strong>list</strong>(range(count))<br><br><br><strong>print</strong>(foo(10))<br>&lt;generator object _foo_generator at 0x10113f430&gt;</pre>
<pre><strong>print</strong>(foo(10, <strong>False</strong>))<br>[0, 1, 2, 3, 4, 5, 6, 7, 8, 9]</pre>
<p>Если генератор простой, то можно использовать генераторные выражения:</p>
<pre><strong>def</strong> foo(count=0, lazy=<strong>True</strong>):<br><strong>if</strong> lazy:<br><strong>return</strong> (i <strong>for</strong> i <strong>in</strong> range(count))<br><strong>return</strong> <strong>list</strong>(range(count))</pre>

<p>Собственно вот что сегодня я узнал…</p>




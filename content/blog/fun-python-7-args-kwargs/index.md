---
title: "Fun Python #7: про args и kwargs"
date: "2020-04-05T15:32:30.00Z"
description: "Вот что я узнал… Функции только с именованными аргументами kwargs Если нужно сделать функцию, которая поддерживает только именов"
---

<!--kg-card-begin: html--><h4>Вот что я узнал…</h4>
<h3>Функции только с именованными аргументами kwargs</h3>
<p>Если нужно сделать функцию, которая поддерживает только именованные аргументы и запретить позиционные, мы можем писать так:</p>
<pre><strong>def</strong> foo(*, a, b, c):<br><strong>return</strong> a + b + c</pre>
<p>Вызываем с позиционными аргументами:</p>
<pre>foo(1, 2, 3)<em><br>TypeError: foo() takes 0 positional arguments but 3 were given</em></pre>
<p>Получаем ошибку. Но зато:</p>
<pre>foo(c=1, a=2, b=3)<br>6</pre>
<h3>Функции только с позиционными аргументами args</h3>
<p>До недавнего времени я думал, что если хочется сделать наоборот, то тут уже придется написать свою логику. Но сприходом Python 3.8 появился встроенный механизм и теперь если хочется указать функцию только с позиционными аргументами, нам достаочно написать так:</p>
<pre><strong>def</strong> foo(a, b, c, <strong>/</strong>):<br><strong>return</strong> a + b + c</pre>
<pre>foo(1,2,3) # Ok</pre>
<pre>foo(a=1, b=2, c=3)<br>TypeError: foo() got some positional-only arguments passed as keyword arguments: 'a, b, c'</pre>
<p>Добавляя <strong>/</strong> , вы указываете, что аргументы является позиционными. Вы также можете комбинировать обычные аргументы с позиционными только, поместив обычные аргументы после косой черты:</p>
<pre><strong>def</strong> foo(a, b, c, <strong>/</strong>, foo):<br><strong>return</strong> a + b + c + foo<br><br>foo(1, 2, 3, foo=456)</pre>
<p>Ну и на финалочку, если вы скомбинируете /и * , то ошибки не будет, но смысла в этом так же не будет:</p>
<pre><strong>def</strong> foo(a, b, c, <strong>/, *</strong>, foo):<br><strong>return</strong> a + b + c + foo<br><br>foo(1, 2, 3, foo=456)</pre>
<p>Вот как-то так. Возможно это может быть полезно.</p>
<figure>
<p><img data-width="74" data-height="90" src="https://cdn-images-1.medium.com/max/600/1*jaqHGQeOhOdDX_lJAH4ntg.jpeg"><br />
</figure>
<p>Собственно вот что сегодня я узнал…</p><!--kg-card-end: html-->


---
title: "Object.assign для Array"
date: "2016-11-14T16:54:11.000Z"
description: "Ломаем Javascript Я уже писал статьи про слияние массивов. Показывал много разных способов*. Но один способ показать забыл. Он н"
---

<h4>Ломаем Javascript</h4>
<p>Я уже писал статьи про слияние массивов. Показывал много разных способов*. Но один способ показать забыл. Он не столько важен, сколько просто забавен.</p>
<p>Массив — это объект, у которого в качестве ключей — числовые индексы. Поэтому мы в праве написать так:</p>
<pre><strong>const</strong> a = [ 1, 2 ];<br><strong>const</strong> b = [ 3, 4, 5, 6 ];<br><strong>const</strong> c = <strong>Object</strong>.assign([], a, b);</pre>
<p>Что-то не так. На выходе имеем вывод массива b. Дело в том, что мы перетерли значения массива ‘a’, так как в данном случае идет работа с массивом как с объектом у которого есть пары ключ — значение. Если мы хотим добавить элементы, нам надо будет указывать индексы перезаписываемых элементов:</p>
<pre><strong>const</strong> a = [ 0, 1, 2 ];<br><strong>const</strong> c = <strong>Object</strong>.assign([], a, { 3:3, 4:4, 5:5, 6:6 });</pre>
<p>Это вообще неудобно. Но зачем может понадобиться нам Object.assign? Не смог пока придумать вменяемого юзкейса. Преимуществ это никаких не дает. Скорее это just for fun =)</p>
<p>Например, можно создать array-like объект:</p>
<pre><strong>const</strong> c = <strong>Object</strong>.assign([], { a:'foo', b:'bar' });</pre>
<pre><strong>console</strong>.log( <strong>Array</strong>.isArray(c) ); // true</pre>
<pre>c.<strong>map</strong>((a,b,c) =&gt; { // not call<br><strong>console</strong>.log(a,b,c);<br>});</pre>
<p>Таким образом мы получили “сломанный” массив. У нас проходит объект проверку isArray и даже есть метод map, но вот этот самый map не вызывается , потому что length = 0. Но даже если и задать длину:</p>
<pre><strong>const</strong> c = <strong>Object</strong>.assign([], { a:'foo', b:'bar', length: 2 });</pre>
<pre><strong>console</strong>.log( c.length ); // 2</pre>
<p>Всеравно не получится пройтись по элементам, так как невозможен перебор вида:</p>
<pre>for(let i=0;i&lt;a.length;i++) a[i];</pre>
<hr>



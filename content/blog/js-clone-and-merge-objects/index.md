---
title: "Клонирование и слияние объектов"
date: "2016-10-26T23:22:00.00Z"
description: "В ES2015+ Если вы давно работаете с JS, то знаете, что объекты передаются по ссылке. При этом частенько в работе есть необходимо"
---

<!--kg-card-begin: html--><h4>В ES2015+</h4>
<p>Если вы давно работаете с JS, то знаете, что объекты передаются по ссылке. При этом частенько в работе есть необходимость в расширении, клонировании и слиянии объектов. Порой ради таких задач в проект тянут библиотеки jQuery, Underscore/Lo-dash и им подобные.</p>
<p>Раньше для клонирования только полей использовалась техника сериализации-десереализации через JSON. Выглядело это так:</p>
<pre><strong>var</strong> src = { a: 1, b: 2, f: function(){}, c: [1,2,3], o: {x:1,y:2} }<br><strong>var</strong> dest = <strong>JSON</strong>.parse( <strong>JSON</strong>.stringify(src) );</pre>
<pre><strong>console</strong>.log(dest);</pre>
<p>Не очень эффективно, не копирует методы, но для полей вполне рабочий вариант.</p>
<p>Но у нас на дворе 2016 год подходит к концу, в 2016 году такие задачи решаются на ES2015+ не так уж и сложно.</p>
<h4>Object.assign</h4>
<p>Если вам нужно расширить объект, то вы смело можете использовать Object.assign для этих целей:</p>
<pre><strong>class</strong> Point {<br><strong>constructor</strong>(x, y) {<br><strong>Object</strong>.assign(this, { x, y });<br>  }<br>}</pre>
<pre><strong>let</strong> o = <strong>new</strong> Point(1,1);<br><strong>console</strong>.log(o);</pre>
<p>Еще один пример копирования:</p>
<pre><strong>let</strong> src1 = { a: 'a', b: 'b', c: 'c'}<br><strong>let</strong> src2 = { a: 1, foo: { x: 1, y: 2, src1, f:f=&gt;f } };<br><strong>let</strong> src3 = { b: 2, bar: { s: 'abc', src1 } };</pre>
<pre><strong>let</strong> dest = <strong>Object</strong>.assign({}, src2, src3);</pre>
<pre><strong>console</strong>.dir(dest);</pre>
<p>Если вам нужно склонировать объект, так же для этих целей используется Object.assign:</p>
<pre><strong>let</strong> dest = <strong>Object</strong>.assign({ <strong>__proto__</strong>: source.<strong>__proto__</strong> }, source);</pre>
<h4>Spread оператор</h4>
<p>Если вы используете Babel или TypeScript, вы можете слить объекты через оператор расширения:</p>
<pre><strong>let</strong> src1 = { a: 'a', b: 'b', c: 'c'}<br><strong>let</strong> src2 = { a: 1, foo: { x: 1, y: 2, src1, f:f=&gt;f } };<br><strong>let</strong> src3 = { b: 2, bar: { s: 'abc', src1 } };</pre>
<pre><strong>let</strong> dest = { ...src2, ...src3 };</pre>
<pre><strong>console</strong>.dir(dest);</pre>
<p>Кстати, просто клонировать объект так же можно через spread:</p>
<pre><strong>let </strong>obj = { foo: 123, bar: 'abc'}<br><strong>let </strong>copy = { ...obj }</pre>
<p>В обозримом будущем это можно будет провернуть прямо в браузере без транспайлеров.</p>
<p>И вам не нужно ставить специальных библиотек дополнительно.</p>
<!--kg-card-end: html-->


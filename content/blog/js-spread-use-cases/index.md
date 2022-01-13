---
title: "Юзкейсы …spread оператора"
date: "2016-12-24T12:59:15.000Z"
description: "Трюки с ES2016
Расширение объекта
const config = { ...defaults, ...userSettings }

Клонирование объекта
const clone = { ...sourc"
---

<h4>Трюки с ES2016</h4>
<h4>Расширение объекта</h4>
<pre><strong>const </strong>config = { ...defaults, ...userSettings }</pre>
<h4>Клонирование объекта</h4>
<pre><strong>const </strong>clone = { ...sourceObject  }</pre>
<h4>Слияние объектов</h4>
<pre><strong>const </strong>merged = { ...obj1, ...obj2 }</pre>
<h4>Иммутабельное обновление свойств</h4>
<pre><strong>const </strong>obj1 = { foo: 123, bar: 'abc' }<br><strong>const </strong>obj2 = { ...obj1, foo: 456 } <em>// { foo: 456, bar: 'abc' }</em></pre>
<h3>Вызов метода map() из строки</h3>
<pre><strong>[...123456..toString()]</strong>.map(s =&gt; s.someDo()).map(parseFloat)</pre>
<p>Если применить спред оператор к итерируемому объекту (а строка — это Array-like object), то можно быстро разбить строку без использования split()</p>




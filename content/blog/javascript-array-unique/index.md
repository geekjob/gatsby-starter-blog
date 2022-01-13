---
title: "Выбрать уникальные значения из массива"
date: "2016-02-09T15:45:54.000Z"
description: "Увлекательные задачки по Javascript Дано  Массив чисел, произвольной длинны. Числа могут повторяться сколь угодно раз. Массив не"
---

<h4>Увлекательные задачки по Javascript</h4>
<p><strong>Дано</strong></p>
<p>Массив чисел, произвольной длинны. Числа могут повторяться сколь угодно раз. Массив не отсортирован.</p>
<pre>var data = [1,1,1,2,3,4,5,6,5,4,3,5,7,8,9,0,....];</pre>
<p><strong>Задача</strong></p>
<p>Выбрать все уникальные значения.</p>
<hr>
<h4>Варианты решений</h4>
<p>Используя Lo-dash/Underscore</p>
<pre>var result = _.uniq(data)</pre>
<p>ES5</p>
<pre>var result = Object.keys(data.reduce((res,x,idx)=&gt;res[x]=1&amp;&amp;res,{})).map(x=&gt;Number(x))</pre>
<p>ES5/ES6 — означает, что изменив синтаксис, но сохранив логику, можно использовать в ES5.</p>
<p>ES5/ES6 #1</p>
<pre>var result = (a=&gt;a.sort().filter((v,i)=&gt;i===0||a[i]!==a[--i]))(data);</pre>
<p>ES5/ES6 #2</p>
<pre>var result = data.filter((x,i)=&gt;i===data.lastIndexOf(x));</pre>
<p>ES6 #1</p>
<pre>let result = new Set(data)</pre>



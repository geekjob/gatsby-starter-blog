---
title: "Fun ES #3. Найти пересечение в массивах"
date: "2018-01-24T22:52:53.000Z"
description: "Задачки с собеседований и не только



Дан список пользователей. У каждого есть массив скилов. Нужно отфильтровать
людей имеющих"
---

<h4>Задачки с собеседований и не только</h4>

<p>Дан список пользователей. У каждого есть массив скилов. Нужно отфильтровать людей имеющих только определенные скилы:</p>
<pre><strong>let</strong> users = [<br>  {name: 'Alex', experience: ['React', 'Babel']},<br>  {name: 'Boba', experience: ['Ember', 'jQuery']},<br>  {name: 'Lola', experience: ['Angular', 'TS']},<br>];</pre>
<pre><em>// Нужны только люди с такими скилами</em><br><strong>let</strong> skills = ['Angular', 'React'];</pre>
<h4>Решение</h4>
<p>Нам нужно найти пересечение в 2х массивах. Можем пройтись по списку кандидатов и у каждого кандидата поискать вхождение каждого слова из списка skills. В общем решение предвещает кучу циклов в циклах. Кто-то предложит подключить Lodash и заюзать оттуда функцию intersection. Но все решается проще на чистом ES6+:</p>
<pre><strong>let</strong> filtered = users.<strong>filter</strong>(x =&gt;<br>  x.experience.<strong>some</strong>(i =&gt; skills.<strong>includes</strong>(i))<br>);</pre>
<pre><strong>console</strong>.log(filtered);</pre>
<p>Внутри функции filter мы реализовываем нахождение пересечений 2х массивов через функцию some.</p>
<blockquote><p>Метод <code><strong>some()</strong></code> проверяет, удовлетворяет ли хоть какой-нибудь элемент массива условию, заданному в передаваемой функции.</p></blockquote>
<p><a href="https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/some">https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/some</a></p>
<p>Т.е. выражение</p>
<pre>x.experience.<strong>some</strong>(i =&gt; skills.<strong>includes</strong>(i))</pre>
<p>и есть функци intersection из Underscore</p>
<pre><code><strong>const</strong> _ = <strong>require</strong>('underscore');<br><br></code><strong>let</strong> filtered = users.<strong>filter</strong>(x =&gt;<br><strong>_</strong>.intersection(skills, x.experience)<br>);</pre>
<pre><strong>console</strong>.log(filtered);</pre>
<p><em>Дисклеймер: яимею в виду что она решает ту же задачу, я не утверждаю что внутри она реализована точно так же.</em></p>



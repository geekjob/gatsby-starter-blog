---
title: "Notes. Зарисовки будней #1001"
date: "2019-06-08T19:55:15.00Z"
description: "JS, Node.js, Bash Bash: посчитать количество уникальных расширений из поддиректорий  Если вдруг есть такая задачка, то она так ж"
---

<h4>JS, Node.js, Bash</h4>
<h3>Bash:</h3>
<p><strong>посчитать количество уникальных расширений из поддиректорий</strong></p>
<p>Если вдруг есть такая задачка, то она так же как и в JS решается 100500 способами, но я для себя выбрал один, который использую:</p>
<pre>$&gt; <strong>ls -1 storage/**/*.* | cut -d"." -f2- | sort | uniq -c</strong><br> 2065 doc<br> 2305 docx<br>10030 pdf<br>  740 rtf<br>  108 txt</pre>
<p>Вот как-то так…</p>
<h3>Array.flat polyfill</h3>
<p>С недавних пор в JS есть метод flat. Может быть очень полезен, например, при рекурсивных/вложенных обработках. Например нужно прочитать файлы из поддиректорий директорий, отсеить по условиям и вернуть 1 плоский массив полных путей. Но, если вы используете LTS версию Node.js то этого метода там еще нет. И тут по сути решение задачи, которое так же можно встретить на собеседованиях:</p>
<p>Заполифилить метод flat для массива.</p>
<p><strong>Решение (</strong>без особых объяснений):</p>
<pre><strong>if</strong> (!<strong><em>Array</em></strong>.prototype.flat) <strong><em>Array</em></strong>.prototype.flat = <strong>function</strong> () {<br><strong>return</strong> (<strong>function</strong> <em>f</em>(arr) {<br><strong>return</strong> arr.reduce(<br>         (a, v) <strong>=&gt;</strong><br><strong><em>Array</em></strong>.isArray(v)<br>               ? a.concat(<em>f</em>(v))<br>               : a.concat(  v )<br>         , []<br>      )<br>   })(<strong>this</strong>)<br>};</pre>
<pre><code>// Usage<br>[1,2,3,[1,2,3,4, [2,3,4]]].flat()</code></pre>
<pre><code>// [1, 2, 3, 1, 2, 3, 4, 2, 3, 4]</code></pre>




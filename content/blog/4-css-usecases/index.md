---
title: "4 CSS фишки"
date: "2019-01-03T23:33:29.00Z"
description: "На каждый день Скрыть все пустые строки в таблице Для этого не нужно использовать JS и писать функции модификации DOM. Все можно"
---

<h4>На каждый день</h4>
<h4>Скрыть все пустые строки в таблице</h4>
<p>Для этого не нужно использовать JS и писать функции модификации DOM. Все можно сделать на уровне CSS:</p>
<pre><strong>table</strong> {<br><strong>empty-cells</strong>: hide;<br>}</pre>
<p>Отличная поддержка в браузерах начиная с IE8+.</p>
<h4>UPD</h4>
<p>В комментариях <a href="https://medium.com/u/5a0b4df41f22" target="_blank" rel="noopener noreferrer">4rontender (Rinat Valiullov)</a> добавил:</p>
<blockquote><p>работает оно при условии, что свойству <code>border-collapse</code> выставлено значение <code>separate</code>
</p></blockquote>
<h4>Идентификатор currentColor</h4>
<p>Если нужно задать цвет через переменную в CSS, то не спешите использовать пользовательские свойства. Есть такой встроенный идентификатор как currentColor, который хранит значение цвета элемента.</p>
<pre>&lt;style&gt;<br>.<strong>text</strong> {<br> color: red;<br>}</pre>
<pre>.<strong>border</strong> {<br><strong>background</strong>: <em>currentColor</em>;<br><strong>height</strong>: 1px;<br>}<br>&lt;/style&gt;</pre>
<pre>&lt;div class=”text”&gt;<br> The color of this text is the same as the one of the line:<br> &lt;div class=”border”&gt;&lt;/div&gt; <strong>⇐ RED BORDER</strong><br> Some more text.<br>&lt;/div&gt;</pre>
<p>Работает, начиная с IE8+.</p>
<h4>Псевдоэлементы для первых</h4>
<p>Если нужно задать стиль для первого символа или первой строки, то пользуйтесь псевдоэлементами с префиксом <em>first</em>:</p>
<pre><strong>p</strong>::<strong>first-letter</strong> {<br><strong>font-size</strong>: 2rem;<br>}</pre>
<pre><strong>p</strong>::<strong>first-line</strong> {<br><strong>font-weight</strong>: 600;<br>}</pre>
<h4>Ассиметричный border-radius</h4>
<p>Свойство <em>border-radius</em> может быть ассиметричным. Это позволяет создавать объекты нестандартной формы. Например:</p>
<pre>.<strong>non-symmetric-round</strong> {<br><strong>border-radius</strong>: 15px 15px 15px 10px / 5px 5px 20px 5px;<br>}</pre>




---
title: "Защита Email от Spamer’ов на CSS"
date: "2019-09-26T14:53:15.00Z"
description: "Nojs, only CSS! Да да, No JS Сейчас поведаю про интересный способ защиты имейлов от спамеров используя только CSS.  И так, снача"
---

<h2 id="nojs-only-css-">Nojs, only CSS!</h2><!--kg-card-begin: html--><h4>Да да, No JS</h4>
<p>Сейчас поведаю про интересный способ защиты имейлов от спамеров используя только CSS.</p>
<p>И так, сначала ревертим наш имейл, можем это сделать на JS:</p>
<pre>'major@geekjob.ru'.<strong>split</strong>('').<strong>reverse</strong>().<strong>join</strong>('')<br>// ur.bojkeeg@rojam</pre>
<p>Далее этот имейл вставляем в HTML:</p>
<pre><strong>&lt;span</strong> class="antibot"&gt;ur.bojkeeg@rojam<strong>&lt;/span&gt;</strong></pre>
<p>Далее пишем такой CSS:</p>
<pre>&lt;style&gt;<br><strong>.antibot {</strong><br>    unicode-bidi: bidi-override;<br>    direction: rtl;<br><strong>}</strong><br>&lt;/style&gt;</pre>
<p>Результат: люди видят нормальный перевернутый перевернутого имейл.</p>
<figure class="wp-caption">
<p><img data-width="1786" data-height="790" src="https://cdn-images-1.medium.com/max/800/1*D4T6gKuKAUbVYSy7GPhH0Q.jpeg"><figcaption class="wp-caption-text">Antibot protection on pure CSS</figcaption></figure>
<h4>Как это работает</h4>
<blockquote><p>В европейских языках чтение текста происходит слева направо, в то время как есть языки, где текст читается справа налево. При смешении в одном документе разных по написанию символов (русского с ивритом, к примеру) в системе юникод, их направление определяется браузером из характеристик и содержимого текста. Свойства unicode-bidi и direction задают, как должен располагаться текст используемого языка.</p></blockquote>
<p>Собственно вот и все. Правда такой механизм неудобен для людей, так как скопировать такой адрес не получается нормально ?</p>
<!--kg-card-end: html-->


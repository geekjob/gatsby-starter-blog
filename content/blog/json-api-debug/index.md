---
title: "Дебажим JSON API"
date: "2016-11-10T11:57:05.00Z"
description: "Быстрый дамп в DevTools Это пост из серии лайфхаков. Не знал, но вспомнил. Если вам нужно посмотреть вывод данных, отдаваемых ка"
---

<!--kg-card-begin: html--><h4>Быстрый дамп в DevTools</h4>
<p>Это пост из серии лайфхаков. Не знал, но вспомнил. Если вам нужно посмотреть вывод данных, отдаваемых каким-то JSON API сервисом, то используя fetch и console.table это делается так просто и быстро, как два байта переслать.</p>
<p>В качестве сервера данных для примера будем использовать специальный сервис, который генерит JSON ответ:</p>
<pre><strong>const</strong> jsonApiUri = "<a href="http://www.filltext.com/?rows=32&amp;id=%7Bnumber%7C1000%7D&amp;firstName=%7BfirstName%7D&amp;lastName=%7BlastName%7D&amp;email=%7Bemail%7D&amp;phone=%7Bphone%7C%28xxx%29xxx-xx-xx%7D&amp;description=%7Blorem%7C16%7D" target="_blank" rel="noopener noreferrer"><em>http://www.filltext.com/?rows=32&amp;id={number|1000}&amp;firstName={firstName}&amp;lastName={lastName}&amp;email={email}&amp;phone={phone|(xxx)xxx-xx-xx}&amp;description={lorem|16}</em></a>"</pre>
<p>И всего одной строчкой кода мы можем вывести все эти данные в табличном виде:</p>
<pre><strong>fetch</strong>(jsonApiUri<a href="http://www.filltext.com/?rows=32&amp;id=%7Bnumber%7C1000%7D&amp;firstName=%7BfirstName%7D&amp;lastName=%7BlastName%7D&amp;email=%7Bemail%7D&amp;phone=%7Bphone%7C%28xxx%29xxx-xx-xx%7D&amp;description=%7Blorem%7C16%7D%27%29.then%28r=" target="_blank" rel="noopener noreferrer">).<strong>then</strong>(r=</a>&gt;r.<strong>json</strong>()).<strong>then</strong>(<strong>console</strong>.<strong>table</strong>)</pre>
<p>На выходе получим такую вот красивую таблицу:</p>
<figure class="wp-caption">
<p><img data-width="1772" data-height="1030" src="https://cdn-images-1.medium.com/max/800/1*Q6exfHZ57eUYyvYCStcYOw.png"><figcaption class="wp-caption-text">Вывод данных через console.table</figcaption></figure>
<p>Вы можете определять какие столбцы (поля) объекта вы хотите увидеть. Например, вывод всех ссылок на странице:</p>
<pre>console.<strong>table</strong>(document.<strong>querySelectorAll</strong>('a'), [<em>'href'</em>,<em>'text'</em>])</pre>
<figure class="wp-caption">
<p><img data-width="1776" data-height="1094" src="https://cdn-images-1.medium.com/max/800/1*OXO8s0K6guGm0BswqLwKEQ.png"><figcaption class="wp-caption-text">Настраиваемые поля в console.table</figcaption></figure>
<!--kg-card-end: html-->


---
title: "Массив уникальных значений"
date: "2016-11-09T17:43:54.00Z"
description: "На Javascript Если у вас в работе такого никогда не требовалось, то на собеседовании это точно могут спросить. И так, в прошлый "
---

<!--kg-card-begin: html--><h4>На Javascript</h4>
<p>Если у вас в работе такого никогда не требовалось, то на собеседовании это точно могут спросить. И так, в прошлый раз мы уже обсуждали дедупликацию массивов при слиянии.</p>

<p>Мы использовали следующие способы:</p>
<pre><strong>let</strong> uniqa1 = Array.of(...<strong>new</strong> Set(someArray));<br><strong>let </strong>uniqa2 = Array.from(<strong>new</strong> Set(someArray));<br><strong>let </strong>uniqa3 = [ ...<strong>new</strong> Set(someArray)];</pre>
<p>Но Set не самый быстрый способ. А если вас поставят перед условием — у вас нет никакого готового объекта Set. Ваши действия?</p>
<h4>Ограничения развивают</h4>
<p>Ок, давайте решать. Самый простой способ это пройтись циклом по массиву и выписать все значения в новый. При каждом добавлении проверять на существование такого значения. Очень медленный и очень некрасивый вариант. А что же делать?</p>
<p><strong>Перебор и копирование с проверкой</strong></p>
<pre><strong>function</strong> uniq(a) {<br><strong>for</strong>(<strong>var</strong> c=0,r=[]; c&lt;a.length; c++) <br><strong>if</strong> (r.indexOf(a[c]) &lt; 0) r.push(a[c]);<br><strong>return</strong> r;<br>}</pre>
<p>Это вариация на тему перебора. Не самая лучшая и вовсе не быстрая. Примерно так и работает Set, но не буду утверждать (внутри не копался).</p>
<p>Этот же вариант, но короче:</p>
<pre><strong>function</strong> uniq(a) {<br>   return a.filter((i,p) =&gt; a.indexOf(i) == p)<br>}</pre>
<p>И содержит потенциальные ошибки доступа по ссылке через замыкание. Нам следует использовать 3й аргумент:</p>
<pre><strong>function</strong> uniq(a) {<br>   return a.filter((i,p,<strong>o</strong>) =&gt; <strong>o</strong>.indexOf(i) == p)<br>}</pre>
<h4>Используем хеш таблицу</h4>
<p>Идея проста и наиболее верная (по крайней мере в мире JS). Мы копируем каждое значение в качестве ключа объекта. Перед копированием делаем проверку на его наличие в этом самом объекте.</p>
<pre><strong>function</strong> uniq(a) {<br><strong>let</strong> r = {};<br><strong>return</strong> a.filter(i<strong>=&gt;</strong>i <strong>in</strong> r?!1:r[i]=!0)<br>}</pre>
<p>Эта же запись, но короче:</p>
<pre><strong>function</strong> uniq(a) {<br><strong>let</strong> r = {};<br><strong>return</strong> a.filter(i<strong>=&gt;</strong>r[i]?!1:r[i]=!0)<br>}</pre>
<p>Но безопаснее будет следующий вариант:</p>
<pre><strong>function</strong> uniq(a) {<br><strong>let</strong> r = {};<br><strong>return</strong> a.filter(i=&gt;r.<strong>hasOwnProperty</strong>(i)?!1:r[i]=!0)<br>}</pre>
<h4>Кто быстрее?</h4>
<p>Из всех перечисленных вариантов самый быстрый — вариант с хеш-таблицей. Тесты предлагаю провести вам. В комментариях приветствуются дополнения, поправки, конструктивная критика.</p>
<!--kg-card-end: html-->


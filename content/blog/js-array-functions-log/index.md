---
title: "Логируем в стрелках"
date: "2018-07-10T11:54:31.00Z"
description: "Как вызвать console.log в arrow functions Когда увлекаешься ФП стилем и стрелочными функциями, наступает момент, когда код обилу"
---

<!--kg-card-begin: html--><h4>Как вызвать console.log в arrow functions</h4>
<p>Когда увлекаешься ФП стилем и стрелочными функциями, наступает момент, когда код обилует функциями вида</p>
<pre><strong>const</strong> y = x =&gt; f(x);</pre>
<p>Если вдруг вам надо отдебажить код и залогировать такую функцию, то часто это делается так:</p>
<pre>const y = x =&gt; {<br>   console.log(x)<br>   return f(x)<br>}</pre>
<p>Мастера ES напишут этот код так:</p>
<pre><strong>const</strong> y = x =&gt; (console.log(x), f(x));</pre>
<p>Но недавно мне подсказал более клевое решение мой товарищ и коллега:</p>
<pre><strong>const</strong> y = x <strong>=&gt;</strong> console.log(x) <strong>||</strong> f(x);</pre>
<p>Всегда будет выполнена левая часть, при этом console.log возвращает undefined, что приводит к выполнению правой части и возврату значения из правой части.</p>
<h3>Логируем map</h3>
<p>Если же вам нужно залогировать обраотку цепочки map-reduce последовательности, то для этого можно использовать следующие варианты:</p>
<pre>a.map(x =&gt; f(x))<br> .map(console.log) // далее undefined<strong><br></strong> .map(...)<br> .reduce(...)<br>;</pre>
<p>Минусы такого подхода — это то, что у нас дальше логирования результата не будет. Но таким подходом можно делать быстрый просмотр промежуточных результатов. Затем комментируем логирование и смотрим работу всей цепочки.</p>
<pre>a.map(x =&gt; f(x))<br><em> //.map(console.log)</em><strong><br></strong> .map(...)<br><em>//.map(console.log)</em><br> .reduce(...)<br>;</pre>
<p>Не так удобно. Поэтому применяем уже описанный выше лайфхак:</p>
<pre>a.<strong>map(x =&gt; console.log(x = f(x)) ||  x)</strong><br> .map(...)<br> .filter(...)<br> .reduce(...)<br>;</pre>
<p><strong>UPD</strong></p>
<p><a href="https://medium.com/u/c9260b1d8d0d" target="_blank" rel="noopener noreferrer">Grigorii Horos</a> в комментариях показал еще одно интересное решение:</p>
<pre>a.filter(x =&gt; !console.log(x))<br> .map(...)</pre>
<p>filter всегда возвращает boolean значение. Если True — элемент остается. Так как console.log() всегда возвращает `void 0` , то используя это, мы можем через инверсию всегда возвращать True. При этом мы дампим поток map-reduce логики. Удобно.</p>

<!--kg-card-end: html-->


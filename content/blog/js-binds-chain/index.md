---
title: "Цепочка bind’ов в JS"
date: "2016-08-18T13:03:44.000Z"
description: "Добавляет аргументы, но делает 1 привязку к контексту Если взывать последовательно цепочку bind’ов, то переданные аргументы пере"
---

<h4>Добавляет аргументы, но делает 1 привязку к контексту</h4>
<p>Если взывать последовательно цепочку bind’ов, то переданные аргументы передадутся в вызов привязываемой функции, но сам контекст будет передан всего 1 раз, из первого вызова bind(). Если говорить кодом, то:</p>
<pre>function <strong>f</strong> (<em>…args</em>) {<br>   console.log(<em>args</em>);<br>   console.log(<em>this.x</em>);<br>};<br><br>var <strong>a</strong> = {x: 1},<br><strong>b</strong> = {x: 2},<br><strong>c</strong> = {x: 3};<br><br><em>f</em>.bind(<em>a</em>, ‘a’).bind(<em>b</em>, ‘b’).bind(<em>c</em>, ‘c’)();</pre>
<p>Выдаст</p>
<pre>['a', 'b', 'c']<br>1</pre>
<p>Т.е. это равносильно, по логике работы</p>
<pre><em>f</em>.bind(<em>a</em>, ‘a’, ‘b’, ‘c’)();</pre>
<p>А почему так — предлагаю вам ответить ?</p>
<h3>UPD</h3>
<p>Метод bind фиксирует контекст в момент вызова через замыкание. Поэтому он фиксируется жетско и его нельзя перебиндить. Примерно как может выглядеть функция бинда:</p>
<pre><strong>Function</strong>.prototype.<strong>bond</strong> = function(ctx) {<br>    var fn = <strong>this</strong>;<br><strong>return</strong> () =&gt; fn.<strong>apply</strong>(ctx, arguments);<br>}</pre>



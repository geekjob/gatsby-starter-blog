---
title: "Управляем console.log"
date: "2016-12-19T14:03:13.000Z"
description: "Метод { inspect } в Nodejs Допустим есть такой объект (в нашем случае функция) и мы хотим вывести console.log результата:  const"
---

<h4>Метод { <strong>inspect } </strong>в Nodejs</h4>
<p>Допустим есть такой объект (в нашем случае функция) и мы хотим вывести console.log результата:</p>
<pre><strong>const</strong> <em>Right </em>= x =&gt; ({<br>   map: f =&gt; <em>Right</em>(f(x)),<br>   fold: (f, g) =&gt; g ? g(x) : f(x),<br>   flatMap: f =&gt; f(x),<em><br></em>});</pre>
<pre><strong><em>console</em></strong>.log(<em>Right</em>(1));</pre>
<pre>&gt; node code.js<br>{ map: [Function: map],<br>  fold: [Function: fold],<br>  flatMap: [Function: flatMap] }</pre>
<p>Возможно ли как-то управлять этим выводом? Ответ — да!</p>
<p>В Nodejs есть возможность добавить метод <strong>inspect</strong> к объекту. Тогда в console.log будет выводится то, что указано именно в этом методе:</p>
<pre><strong>const</strong> <em>Right </em>= x =&gt; ({<br>   map: f =&gt; <em>Right</em>(f(x)),<br>   fold: (f, g) =&gt; g ? g(x) : f(x),<br>   flatMap: f =&gt; f(x),<br><strong>inspect</strong>: <em>() =&gt; `Call: Right(${x} :${typeof x})`</em><br>});<br><br><strong><em>console</em></strong>.log(<em>Right</em>(1));</pre>
<pre>&gt; node code.js<br>Call: Right(1 :number)</pre>
<p>В браузере Chrome такой возможности не нашел. Возможно вы знаете еще какие-то методы для отладки, позволяющие управлять выводом?</p>



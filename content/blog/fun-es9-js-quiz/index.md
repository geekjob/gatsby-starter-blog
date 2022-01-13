---
title: "FunES#9: загадка"
date: "2019-02-28T23:53:44.00Z"
description: "Фокусы с JavaScript    Ответ будет объяснятся сразу после вопроса, так что если хотите сами подумать, не листайте. Мой ответ баз"
---

<!--kg-card-begin: html--><h4>Фокусы с JavaScript</h4>
<figure>
<p><img data-width="764" data-height="322" src="https://cdn-images-1.medium.com/max/800/1*ZwJ71TabMHhKTN_ke9uvCA.jpeg"><br />
</figure>
<p>Ответ будет объяснятся сразу после вопроса, так что если хотите сами подумать, не листайте. Мой ответ базируется на моем опыте и моем понимании как работает JS. Если я ошибся — поправьте, пожалуйста.</p>
<p>Недавно меня попросили помочь объяснить как отработает такой код. Будет ли ошибка или нет? Если ошибка, то какая ошибка и почему? А если не ошибка, то как отработает и почему?</p>
<pre><strong>class</strong> Foo <strong>extends</strong> <strong>null</strong> {}<br><strong>const</strong> foo = <strong>new</strong> Foo;</pre>
<p>Что получим? Как отработает? Что из себя представляет класс Foo и экземпляр класса — объект foo?</p>
<hr>
<h4>Объяснение</h4>
<p>Во 1х будет ошибка, но не синтаксическая, а TypeError:</p>
<pre><em>TypeError: Super constructor null of Foo is not a constructor</em></pre>
<p>В данном классе нет конструктора. Поэтому конструктор будет искаться в родителе. Родитель у нас кто?</p>
<pre>console.dir( <strong>Object</strong>.getPrototypeOf(Foo.<strong>prototype</strong>) ); // null</pre>
<p>Ну надо же, родитель у класса null. А у null нет конструктора и он не может быть вызван. Но тогда другой вопрос: <strong>а почему мы можем вообще наследоваться от null ?</strong></p>
<p>А потому, что:</p>
<pre><strong>typeof</strong> <strong>null</strong> === 'object'</pre>
<p>Да да, в JS null это объект. А следовательно к нему применимы некоторые операции как и к Object (но не все!). Возможно это баг, но выглядит как фича. Если вы модифицируете код, добавив конструктор:</p>
<pre><strong>class</strong> Foo <strong>extends</strong> <strong>null</strong> {<br><strong>constructor</strong>() {<br>        console.log('call Foo.constructor')<br>    }<br>}</pre>
<p>то получите следующий результат:</p>
<pre>0 |<br>1 | call Foo.constructor<br>2 |<br>3 | ReferenceError: Must call super constructor in derived class<br>  | before accessing 'this' or returning from derived constructor<br>4 |</pre>
<p>Как видим, конструктор получилось вызвать, но требуется вызов родительского. Добавляем super:</p>
<pre><strong>class</strong> Foo <strong>extends</strong> <strong>null</strong> {<br><strong>constructor</strong>() {<br>        console.log('call Foo.constructor')<br><strong>super</strong>()<br>    }<br>}</pre>
<p>И получаем такой вот результат:</p>
<pre>0 |<br>1 | call Foo.constructor<br>2 |<br>3 | TypeError: Super constructor null of Foo is not a constructor<br>4 |</pre>
<p>Ну что и требовалось доказать. Такая вот небольшая вэтээфка джээска.</p>
<h3>UPD</h3>
<p>В принципе, если вернуть из конструктора объект, то:</p>
<pre><strong>class</strong> Foo <strong>extends</strong> <strong>null</strong> {<br><strong>constructor</strong>() {<br><strong>return</strong> <strong>Object</strong>.create(<strong>null</strong>);<br> }<br>}</pre>
<p>то это будет даже работать и не будет ошибок. Семантичность? Ну не знаю…</p>
<h4>Для чего знать и где применять?</h4>
<p>Ну чисто меряться друг с другом, делать сложные quiz’ы (например такие как <a href="https://alf.nu/ReturnTrue" target="_blank" rel="noopener noreferrer">ReturnTrue</a>). Возможно у вас появятся идеи как и зачем это использовать ?</p>
<figure class="wp-caption">
<p><img data-width="640" data-height="640" src="https://cdn-images-1.medium.com/max/800/1*qU5AuxRJ8mKowL9gKx_IMA.jpeg"><figcaption class="wp-caption-text">Грязные фишки JS применяются для писькомерства</figcaption></figure>

<!--kg-card-end: html-->


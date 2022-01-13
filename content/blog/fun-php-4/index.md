---
title: "Fun PHP #4"
date: "2018-04-10T22:03:53.00Z"
description: "Задачка с собеседования    В каждом языке есть свои примечательные особенности. Некоторые из них могут подпортить жизнь при отла"
---

<h4>Задачка с собеседования</h4>

<p>В каждом языке есть свои примечательные особенности. Некоторые из них могут подпортить жизнь при отладке, другие могут позволить делать невозможное возможным. В PHP есть так же свои особенности и часто про эти особенности любят спрашивать на собеседованиях. Одна из таких задачек:</p>
<pre>&lt;?php</pre>
<pre><strong>class</strong> Foo<br>{<br><strong>private</strong> $prop = 'Hello!';<br><br><strong>public</strong> <strong>function</strong> show($obj)<br>    {<br><strong>echo</strong> $obj-&gt;prop;<br>    }<br>}</pre>
<pre>$obj = <strong>new</strong> Foo();<br>$obj-&gt;show( <strong>new</strong> Foo() );</pre>
<p>Как выполнится этот код?</p>
<p>Размышляем&#8230; Мы пытаемся вызвать приватное свойство у объекта. По логике должна быть ошибка. Чтобы это было проще для понимания, сделаем такой код и выполним:</p>
<pre><strong>class</strong> Bar <strong>extends</strong> Foo<br>{<br><strong>function</strong> __construct()<br>    {<br>        var_dump( $<strong>this</strong>-&gt;prop );<br>    }<br>}</pre>
<pre>$obj = <strong>new</strong> Bar;</pre>
<p>Вывод:</p>
<pre>Notice: Undefined property: Bar::$prop in /in/t8CFo on line 23 NULL</pre>
<p>Согласно принципам инкапсуляции наше приватное свойство скрыто даже от наследника. Выходит, что по логике, если выполнить код:</p>
<pre>$obj2 = <strong>new</strong> Bar;<br>$obj1 = <strong>new</strong> Foo;</pre>
<pre><strong>var_dump</strong>( $obj2-&gt;prop );<br><em>// Notice: Undefined property: Bar::$prop in /in/nPWa6 on line 31 NULL</em></pre>
<pre><strong>var_dump</strong>( $obj1-&gt;prop );<br><em>// Fatal error: Uncaught Error: Cannot access private property Foo::$prop in /in/nPWa6:32 Stack trace:</em></pre>
<p>Все работает корректно.</p>
<p>Но если мы напишем такой код:</p>
<pre>( <strong>new</strong> Foo )-&gt;show( <strong>new</strong> class <strong>extends</strong> Foo { } );</pre>
<p>Вдруг выясняется что мы получаем ответ:</p>
<pre>string(6) "Hello!"</pre>
<p>И вот это и есть особенность PHP. Если вы вызываете приватное свойство объекта от класса внутри методов этого класса, то приватное свойство будет доступно. И если мы возьмем пример, который был задан на собеседовании в самом начале:</p>
<pre>( <strong>new</strong> Foo )-&gt;show( <strong>new</strong> Foo );</pre>
<p>То так же выведется значение приватного свойства.</p>
<h4>Итого</h4>
<p>Это особенность PHP, про которую нужно знать чтобы не наступить на грабли. В методах класса можно получить доступ к приватным свойствам у экземпляра класса, созданного от этого класса. И конкретно про эту особенность и другие, вас могут спросить на собеседовании на вакансию PHP разработчика.</p>
<p><em>Все примеры можно проверить на всех версиях интерпретаторов прямо онлайн </em><a href="https://3v4l.org/PE1EV" target="_blank" rel="noopener noreferrer">https://3v4l.org/PE1EV</a></p>



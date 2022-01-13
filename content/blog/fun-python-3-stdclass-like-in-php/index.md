---
title: "Fun Python #3: stdClass like in PHP"
date: "2020-01-12T18:32:52.000Z"
description: "Сегодня я узнал… Я тут недавно сделал пост, в котором показал как можно делать dotted dict и подумал что это аналог stdClass в P"
---

<style>
    pre {
        background: white !important;
        color: #402d8b !important;
    }
    pre strong {
        color: red !important;
    }
</style>
<h4>Сегодня я узнал…</h4>
<p>Я тут недавно сделал пост, в котором показал как можно делать <code>dotted dict</code> и подумал что это аналог stdClass в PHP.</p>
<p><a href="https://medium.com/@frontman/fun-python-2-stdclass-like-in-php-c5d5895d9bdb">https://medium.com/@frontman/fun-python-2-stdclass-like-in-php-c5d5895d9bdb</a></p>
<p>Я был не совсем прав. Аналогом stdClass из PHP можно считать следующий вариант:</p>
<pre>a = <strong>type</strong>("stdClass", (), {<br>    "foo": 123,<br>    "bar": <strong>lambda</strong> x: x + 1<br>})<br><br>print(a.bar(a.foo)) # 124<br>print(<strong>type</strong>(a)) # &lt;class 'type'&gt;</pre>
<p>В Python-е все является объектом, и классы не исключение, а значит, эти классы кто-то создаёт. Собственно все классы создает type, который является базовым классом. У каждого класса есть type, а типом самого type является он сам. Это рекурсивное замыкание, которое реализовано внутри Python с помощью С:</p>
<pre><strong>type</strong>(<strong>type</strong>) # &lt;class 'type'&gt;</pre>
<p>Кстати, второй аргумент в type — это кортеж, в котором перечисляют классы от которых нужно унаследоваться:</p>
<pre><strong>class</strong> B:<br>   buz: "abc"</pre>
<pre>a = <strong>type</strong>("stdClass", (B,), {})<br>print(a.buz) # abc</pre>
<p>Собственно вот что я сегодня узнал про классы в Python ?</p>




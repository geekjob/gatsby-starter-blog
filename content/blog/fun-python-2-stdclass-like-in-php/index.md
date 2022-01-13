---
title: "Fun Python #2: stdClass like in PHP"
date: "2020-01-06T03:03:51.000Z"
description: "Ну или как создать dotted dict
При работе с Python частенько, по привычке, хочется притянуть что-нибудь из
других языков. Не все"
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
<h4>Ну или как создать dotted dict</h4>
<p>При работе с Python частенько, по привычке, хочется притянуть что-нибудь из других языков. Не всегда это полезно и правильно, но…</p>
<p>В PHP можно создать объект, похожий на dict в Python, но с возможностью обращаться через оператор доступа к свойствам. Проще показать:</p>
<pre>$mydict = (<strong>object</strong>) [ # new stdClass<br>    'foo' =&gt; 123,<br>    'bar' =&gt; <strong>fn</strong>($x)<strong>=&gt;</strong> $x + 1<br>];</pre>
<pre>$mydict-&gt;foo; # = 123</pre>
<p>Ну и аналог в JavaScript:</p>
<pre>mydict = {<br>    foo: 123,<br>    bar: x <strong>=&gt;</strong> x + 1<br>}</pre>
<pre>mydict.foo // = 123</pre>
<p>Ну и по привычке я ожидал, что смогу в Python писать так:</p>
<pre>mydict = {<br>   'foo': 123,<br>   'bar': <strong>lambda</strong> x: x + 1<br>}</pre>
<pre>mydict.foo # Error</pre>
<p>Иногда такое хочется и кажется удобным. Реализовать такой функционал, как оказалось, очень даже просто в пару строк кода:</p>
<pre><strong>class</strong> StdClass(dict):<br><strong>__getattr__</strong> = <strong>dict</strong>.get<br><strong>__setattr__</strong> = <strong>dict</strong>.<strong>__setitem__</strong><br><strong>__delattr__</strong> = <strong>dict</strong>.<strong>__delitem__</strong></pre>
<p>Все. Мы просто немного расширили стандартный класс <code>dict</code> и теперь можем творить такие чудеса:</p>
<pre>mydict = StdClass({<br>    'foo': 123,<br>    'bar': <strong>lambda</strong> x: x + 1<br>})<br><strong>print</strong>(mydict.bar( mydict.foo ))<br>mydict.buz = 'abc'</pre>
<p>Просто, имхо, это сильно приятнее чем писать:</p>
<pre><strong>print</strong>(mydict['bar']( mydict['foo'] ))<br>mydict['buz'] = 'abc'</pre>




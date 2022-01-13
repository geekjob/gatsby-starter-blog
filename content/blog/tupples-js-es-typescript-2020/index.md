---
title: "Кортежи в JS/ES и TypeScript  в 2020"
date: "2020-07-01T10:05:35.00Z"
description: "Record & Tuple proposal and TypeScript 4.0   Относительно недавно (в мае) Робин Рикард и Рик Баттон сделали предложение  «Record"
---

<h3 id="record-tuple-proposal-and-typescript-4-0">Record &amp; Tuple proposal and TypeScript 4.0</h3><p></p><p>Относительно недавно (в мае) Робин Рикард и Рик Баттон сделали предложение <a href="https://github.com/tc39/proposal-record-tuple" rel="nofollow">«Record &amp; Tuple»</a>, которое добавляет два новых примитивных объектов в JavaScript:</p><ul><li>кортежи (tuples) — неизменяемая и сравниваемая по значению версия массивов</li><li>записи (records) — неизменяемая и сравниваемая по значению версия простых объектов</li></ul><p>Основная цель новых типов - это возможность сравнивать эти объекты по значения. Сейчас, как вы знаете, все объекты не равны друг другу.</p><p>А в TypeScript 4.0 добавляют еще и <a href="https://github.com/Microsoft/TypeScript/issues/28259">labels to tuple elements</a>.</p><p>Но если вам нужны кортежи уже сейчас, как структуры данных, то их можно, в принципе эмулировать. Еще два года назад я писал подробно про кортежи в JS и TypeScript.</p><h4 id="-">Что такое кортеж?</h4><p>Коротко напомню, что кортежи несут еще один смысл:</p><blockquote><em><em>Кортеж (tuple) — упорядоченный набор фиксированной длины.</em></em></blockquote><p>Сейчас во многих языках программирования существует такая конструкция. Где-то кортежи встроены в язык, а где-то реализуются средствами библиотек. Кортежи есть, например, в языках Erlang, F#, Groovy, Haskell, Lisp, C#, D, Python, Ruby, Go, Rust, Swift и многих других…</p><p>Кортеж, как структура данных, примечателен тем, что в него нельзя добавлять элементы, а так же нельзя менять местами элементы и нарушать порядок следования.</p><p>На самом деле вы уже используете кортежи в JavaScript неявно и даже не подозреваете об этом. Кортежи неявно используются во всех языках программирования, даже в Си и Ассемблере.</p><blockquote><em><em>Список аргументов функции или список инициализации массива является неявным кортежем</em></em></blockquote><p>Список аргументов функции является кортежем. Ведь список аргументов — это список фиксированной длины. В функциональных языках некарированные функции нескольких аргументов принимают параметры в виде одного аргумента, являющегося кортежем.</p><p>Список инициализации массива — это тоже кортеж. Даже обычный блок кода — это тоже кортеж. Только элементами его являются не значения или объекты, а синтаксические конструкции.</p><h4 id="-js-es2020">Явно реализуем кортежи в JS/ES2020</h4><p>Так как в JS нет синтаксической конструкции для объявления кортежа, мы создадим функцию tuple (прям как в Python):</p><pre><code class="language-javascript">const tuple = (...args) =&gt; Object.freeze(args)

// Usage:
const tup = tuple ( 1, 2, 3, 4 )

tup[0] = 13 // ничего не произойдет

console.log( tup ) // [1,2,3,4]

//</code></pre><p>Мы получили неизменяемый список фиксированной длины.</p><p>Так же можно реализовать разные частные случаи кортежей, например - пара.</p><h3 id="--1">Частный случай кортежа  —  пара</h3><p>Как понятно из названия пара может содержать только 2 значения, в то время как кортеж — любое количество. Реализация пары на JavaScript:</p><pre><code class="language-javascript">
const pair = (...args) =&gt; Object.freeze(args.slice(0,2))
// или так, ведь мы знаем что у нас могут быть только 2 аргумента
const pair = (x, y) =&gt; Object.freeze([x,y])

// Пример использования:

const par = pair ( 1, 2, 3 ) // 3 не добавится

par[0] = 3 // нельзя изменить
par[4] = 4 // нельзя добавить

console.log(par) // [1,2]

//</code></pre><h3 id="-typescript">Кортежи в TypeScript</h3><p>TypeScript уже давно позволяет типизировать структуры данных и дает нам возможность описать кортеж, содержащий разные типы. Допустим мы хотим кортеж, который содержит сразу два типа:</p><pre><code class="language-typescript">
const myTuple: [string, number] = ['foo', 123]

myTuple[0] = 123

//
// Type '123' is not assignable to type 'string'.
//</code></pre><p>Так же кортеж можно описать через интерфейс, расширив базовый тип Array:</p><pre><code class="language-typescript">
interface MyTuple&lt;T,U&gt; extends Array&lt;T|U&gt; {
    0: T;
    1: U;
}

const mytuple: MyTuple&lt;boolean, number&gt; = [true, 123];

//</code></pre><p>Таким образом можно создавать списки с фиксированными типами. Но если вспомнить что такое кортеж — это упорядоченный набор фиксированной длины. А у нас получились объекты, в которые можно добавить новые элементы.</p><h4 id="--2">Упорядоченный набор фиксированной длины</h4><p>Мы можем указать длину нашего кортежа и TS будет проверять ее:</p><pre><code class="language-typescript">

interface MyTuple extends Array&lt;number | string&gt; {
    0: number;
    1: string;
    length: 2; // это литеральный тип '2', это не значение!
}


const mytuple: MyTuple = [123, 'abc', 'foo']

//
// Type '[number, string, string]'
// is not assignable to type 'Tuple'. Types of property
//</code></pre><p>Как видите, TS говорит нам, что мы не можем объявить кортеж с тремя элементами, так как мы заявили всего 2. Но, как помните из предыдущих упоминаний, все это артефакты. Поэтому для рантайма нам нужно добавить заморозку объекта.</p><p>Если вы хотите создать настоящий кортеж, описанный по всем правилам, чтобы TypeScript помог вам защититься на этапе разработки, а так же защитить его в рантайме, вам нужно описывать кортежи следующим образом:</p><pre><code class="language-typescript">

interface MyTuple extends ReadonlyArray&lt;string|number&gt; {
    0: string;
    1: number;
    length: 2;
}


const tup: MyTuple = &lt;MyTuple&gt;Object.freeze(['foo', 123])
// или
const tup: MyTuple = Object.freeze(['foo', 123]) as MyTuple;
// или
const tup: MyTuple = ['foo', 123]; Object.freeze(tup);

</code></pre><p>Описание кортежа таким способом дает следующие преимущества:</p><ul><li>нельзя создать изначально кортеж больше заданной длины</li></ul><pre><code class="language-typescript">


const tup: MyTuple = &lt;MyTuple&gt;Object.freeze(['foo', 123, 456])


/*
Type '[string, number, number]'
is not assignable to type 'MyTuple'.
Types of property 'length' are incompatible.
Type '3' is not assignable to type '2'.
*/</code></pre><ul><li>типы элементов упорядочены и их нельзя менять местами</li></ul><pre><code class="language-javascript">
tup[0] = 123

// Type '123' is not assignable to type 'string'
</code></pre><ul><li>нельзя модифицировать существующие элементы</li><li>нельзя добавлять новые элементы</li></ul><pre><code class="language-javascript">
tup[3] = 456

// Index signature in type 'MyTuple' only permits reading

</code></pre><h2 id="-typescript-4-0">Кортежи в TypeScript 4.0</h2><p>Собственно что предлагается в новой версии TS в области кортежей - это добавление нового синтаксиса:</p><pre><code class="language-typescript">
type MyTupple = [length: number, count: number];


function createMyTupple(/* ... */): [length: number, count: number] {
  /* ... */
}

</code></pre><p>Про новый TS 4.0 подробнее по ссылке:</p><figure class="kg-card kg-embed-card"><blockquote class="wp-embedded-content"><a href="https://devblogs.microsoft.com/typescript/announcing-typescript-4-0-beta/">Announcing TypeScript 4.0 Beta</a></blockquote>
<script type='text/javascript'>
<!--//--><![CDATA[//><!--
		/*! This file is auto-generated */
		!function(d,l){"use strict";var e=!1,o=!1;if(l.querySelector)if(d.addEventListener)e=!0;if(d.wp=d.wp||{},!d.wp.receiveEmbedMessage)if(d.wp.receiveEmbedMessage=function(e){var t=e.data;if(t)if(t.secret||t.message||t.value)if(!/[^a-zA-Z0-9]/.test(t.secret)){var r,a,i,s,n,o=l.querySelectorAll('iframe[data-secret="'+t.secret+'"]'),c=l.querySelectorAll('blockquote[data-secret="'+t.secret+'"]');for(r=0;r<c.length;r++)c[r].style.display="none";for(r=0;r<o.length;r++)if(a=o[r],e.source===a.contentWindow){if(a.removeAttribute("style"),"height"===t.message){if(1e3<(i=parseInt(t.value,10)))i=1e3;else if(~~i<200)i=200;a.height=i}if("link"===t.message)if(s=l.createElement("a"),n=l.createElement("a"),s.href=a.getAttribute("src"),n.href=t.value,n.host===s.host)if(l.activeElement===a)d.top.location.href=t.value}}},e)d.addEventListener("message",d.wp.receiveEmbedMessage,!1),l.addEventListener("DOMContentLoaded",t,!1),d.addEventListener("load",t,!1);function t(){if(!o){o=!0;var e,t,r,a,i=-1!==navigator.appVersion.indexOf("MSIE 10"),s=!!navigator.userAgent.match(/Trident.*rv:11\./),n=l.querySelectorAll("iframe.wp-embedded-content");for(t=0;t<n.length;t++){if(!(r=n[t]).getAttribute("data-secret"))a=Math.random().toString(36).substr(2,10),r.src+="#?secret="+a,r.setAttribute("data-secret",a);if(i||s)(e=r.cloneNode(!0)).removeAttribute("security"),r.parentNode.replaceChild(e,r)}}}}(window,document);
//--><!]]>
</script><iframe sandbox="allow-scripts" security="restricted" src="https://devblogs.microsoft.com/typescript/announcing-typescript-4-0-beta/embed/" width="600" height="338" title="&#8220;Announcing TypeScript 4.0 Beta&#8221; &#8212; TypeScript" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" class="wp-embedded-content"></iframe></figure>


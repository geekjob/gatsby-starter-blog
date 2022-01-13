---
title: "Runtime Strong типизация в Javascript"
date: "2016-01-26T10:43:19.000Z"
description: "Пример реализации RTTS на TypeScript  Предвкушая релиз Angular2 хочется больше понять мотивацию разработчиков и понять как и что"
---

<h2 id="-rtts-typescript">Пример реализации RTTS на TypeScript</h2>
<p>Предвкушая релиз Angular2 хочется больше понять мотивацию разработчиков и понять как и что устроено будет. Изучая на раскопках следы AtScript, который предлагалось использовать изначально как альтернативу TypeScript, а точнее даже ECMAScript наткнулся на упоминание RTTS — RunTime Type System.</p>
<p>Предлагалось использовать аннотации типов, синтаксис которых взяли из стандарта ECMASCript 4, который был реализован в версиях ActionScipt. Но, в отличие от TypeScript, эти аннотации должны были проверяться не IDE на стадии компиляции (точнее не только на стадии компиляции), а и во время исполнения кода.</p>
<p>Некоторые скептики часто приводят такой аргумент, не в пользу TypeScript, мол а что толку-то от статической типизации? На стадии компиляции сделали проверку, а во время выполнения уже не отследить и приходится либо добавлять в бизнес логику проверку типов либо пустить все на самотек, JS умный, он все приведет к нужному типу сам.</p>
<p>Мне стало интересно, а что если сделать самому свой синтаксис описания типов, которые будут проверяться в рантайме. Разбираться с AST и писать свой парсер не хочу. Хочу использовать стандартные инструменты. О! В предыдущих статьях было много сказано про декораторы, оператор декорирования и аннотации, т.е. мы можем использовать декораторы для контроля типов наших переменных используя простой и лаконичный синтаксис.</p>
<p>В итоге родилась библиотека <strong>rtts-ts</strong>. Это декораторы для TypeScript кода, которые позволяют аннотировать свойства, методы и параметры. Как это выглядит:</p>
<pre><strong>///&lt;require path="rtts/typings.d.ts" /&gt;</strong></pre>
<pre>// Делаем экспорт всех нужных декораторов в глобальную область<br><strong>import 'rtts';</strong><br><br>@type // annotate constructor<br>class A {<br><br><strong>@tstring</strong> public foo :string = 'abc';<br><strong>@tnumber</strong> static bar :number = 123;<br><br><strong>@tfloat</strong> protected baz :float = 123.321;<br><strong>@tint</strong>   private   lol :int   = 123;<br><br><br>    /* @type */ constructor(private <strong>@tnumber</strong> x :number) {}<br><br><strong>@type</strong> mixFoo(<strong>@tstring</strong> arg :string) :string {<br>        return this.foo + arg;<br>    }<br><br><strong>@type</strong> mixBar(<strong>@cast('int')</strong> arg :any) :number {<br>        return this.bar + arg;<br>    }<br><br><strong>@type({<br>        'arguments' : ['string', 'number'],<br>        'return'    : 'string'<br>    })</strong><br>    someDo(a :string, b :number) :string {<br>        return a + b;<br>    }<br><br>    // return type string<br><strong>@type('string')</strong> static someDo(<strong>@tstring</strong> a :string,<br><strong>@tnumber</strong> b :number) :string {<br>        return a + b;<br>    }<br>}</pre>
<p>Таким образом мы можем проверять типы на стадии компиляции, используя аннотации вида <strong>:тип</strong>, так и аннотации для рантайма, используя синтаксис <strong>@тип.</strong></p>
<p>Установить и попробовать можно из npm:</p>
<pre><strong>npm install rtts-ts</strong></pre>
<p>Версия библиотеки, пока 0.1, я еще не реализовал все возможности. Если интересно — присоединяйтесь.</p>
<hr>
<h4>Код на GitHub</h4>
<p><a href="https://github.com/i0z/rtts-ts">https://github.com/i0z/rtts-ts</a></p>



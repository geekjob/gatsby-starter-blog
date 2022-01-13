---
title: "Reflect API"
date: "2016-11-20T17:28:14.000Z"
description: "В браузерах Reflect— это встроенный объект, который позволяет создавать методы, перехватывающие операции JavaScript. При этом ме"
---

<h4>В браузерах</h4>
<p><strong>Reflect</strong> — это встроенный объект, который позволяет создавать методы, перехватывающие операции JavaScript. При этом методы называются так же, как и методы в Proxy handlers. Reflect &#8212; это не конструктор. Вы не можете использовать его с оператором <strong>new</strong> или вызывать Reflect как функцию. Все свойства и методы объекта Reflect являются статическими. Некоторые из этих методов — те же, что и соответствующие им методы класса Object.</p>
<h3>Примеры использования</h3>
<h4>Apply</h4>
<p>Вызов функции с заданным контекстом. Аналогичен методу apply в <code><a href="http://ilnurgi1.ru/docs/js/base/Function.html#Function" title="Function" target="_blank" rel="noopener noreferrer"><strong>Function</strong></a></code></p>
<pre><strong>function</strong> s(a, b){ <strong>return</strong> <strong>this</strong>.value + a + b }</pre>
<pre>Reflect.apply(s, {value: 100}, [10, 30]);<br><em>// 140</em></pre>
<h4><strong>Сonstruct</strong></h4>
<p>Вызов функции в качестве конструктора. Аналогичен оператору new.</p>
<pre><strong>function</strong> const1(a, b){};<br><strong>function</strong> const2(){};<br><strong>var</strong> newObj = Reflect.construct(const1, [1, 2], const2);</pre>
<h4><strong>defineProperty</strong></h4>
<p>Определяет новое или изменяет существующее свойство объекта. Возвращает логическое значение, была ли операция успешной Аналогичен методу defineProperty в Object, отличается тем, чьо возвращает логическое значение, а не модифицированный объект.</p>
<pre><em>// создание свойств</em><br><strong>var</strong> obj = {};<br><strong>Reflect</strong>.defineProperty(obj, 'name', {<br>    value: 'Foo',<br>    writable: <strong>true</strong>,<br>    configurable: <strong>true</strong>,<br>    enumerable: <strong>true</strong><br>})</pre>
<p>И так далее. Полный список всех методов:</p>
<ul>
<li>Reflect.apply</li>
<li>Reflect.construct</li>
<li>Reflect.defineProperty</li>
<li>Reflect.deleteProperty</li>
<li>Reflect.enumerate</li>
<li>Reflect.get</li>
<li>Reflect.getOwnPropertyDescriptor</li>
<li>Reflect.getPrototypeOf</li>
<li>Reflect.has</li>
<li>Reflect.isExtensible</li>
<li>Reflect.ownKeys</li>
<li>Reflect.preventExtensions</li>
<li>Reflect.set</li>
<li>Reflect.setPrototypeOf</li>
</ul>
<h4>Поддержка браузерами</h4>
<ul>
<li>Chrome</li>
<li>Firefox</li>
<li>Edge</li>
</ul>
<h3>Reflect Metadata API</h3>
<p>В TypeScript ради Angular2 был добавлен расширенный синтаксис декороторов. Одной из интересных особенностей декораторов является возможность получать информацию о типе декорируемого свойства или параметра. Чтобы это заработало, нужно подключить библиотеку reflect-metadata, которая расширяет стандартный объект Reflect и включить опцию emitDecoratorMetadata. После этого для свойств, которые имеют хотя бы один декоратор, можно вызвать Reflect.getMetadata с ключем “design:type”, и получить конструктор соответствующего типа.</p>
<p>Пример использования:</p>
<pre><strong>function</strong> strictType&lt;T&gt;(t :any, k :string, d:     TypedPropertyDescriptor&lt;T&gt;) :never|void {<br>  d.set = (value :T) :never|void =&gt; {<br>    let type = <strong>Reflect.getMetadata</strong>("design:type", t, k);<br>    if (!(value instanceof type))<br>        throw new TypeError("Invalid type!");<br>  }<br>}</pre>



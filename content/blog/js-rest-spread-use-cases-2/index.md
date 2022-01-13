---
title: "Юзкейсы rest-spread операторов #2"
date: "2019-03-19T16:06:59.00Z"
description: "Полезные трюки Я уже писал как-то про Юзкейсы …spread оператора [https://medium.com/@frontman/%D1%8E%D0%B7%D0%BA%D0%B5%D0%B9%D1%"
---

<h4>Полезные трюки</h4>
<p>Я уже писал как-то про <a href="https://medium.com/@frontman/%D1%8E%D0%B7%D0%BA%D0%B5%D0%B9%D1%81%D1%8B-spread-%D0%BE%D0%BF%D0%B5%D1%80%D0%B0%D1%82%D0%BE%D1%80%D0%B0-4d57b5e916e2" target="_blank" rel="noopener noreferrer">Юзкейсы …spread оператора</a>. За прошедшее время накопилось много чего еще интересного. Пришла пора рассказать про эти трюки, которые могут быть полезны в работе.</p>
<h4>Rename key</h4>
<pre><strong>var</strong> obj = { key: 'value' }</pre>
<pre>obj = (({ key, ...other })=&gt;({ newKey: key, ...other }))(obj)<br><em>// { newKey: 'value' }</em></pre>
<p>Таким образом вы можете поменять имя конкретного ключа.</p>
<h4>Условные выражения</h4>
<p>Вы можете использовать условные выражения внутри spread синтаксиса:</p>
<pre><strong>const</strong> getUserObject = (user, email) =&gt; ({<br>  ...user,<br>  ...(email &amp;&amp; { email })<br>});</pre>
<pre><strong>const</strong> user = { id: 1, name: 'Alex' }<br><strong>const</strong> email = '<a href="mailto:som@mail.ru" target="_blank" rel="noopener noreferrer">som@mail.ru</a>'</pre>
<pre>getUserObject(user, email);<br><em>// { id: 1, name: 'Alex', email: '</em><a href="mailto:som@mail.ru" target="_blank" rel="noopener noreferrer"><em>som@mail.ru</em></a><em>' }</em></pre>
<pre>getUserObject(user);<br><em>// { id: 1, name: 'Alex' }</em></pre>
<h4>Нормализация объектов или установка дефолтных значений</h4>
<p>Можно сделать красивую функцию для установки дефолтных значений:</p>
<pre><strong>const</strong> normalizeUserObject = ({<br>    uid = Date.now().toString(16),<br>    create = new Date,<br>    ...other<br>  }) =&gt; ({<br>    uid, create, ...other<br>  })<br>;</pre>
<pre><strong>const</strong> user = { name: 'Alex' }</pre>
<pre>normalizeUserObject(user);<br><em>// { uid: '1699600ff16', create: 2019-03-19T12:50:41.558Z,  name: 'Alex' }</em></pre>
<h4>Перестановка ключей</h4>
<p>С ходу не скажу юзкейс где и когда, но если вдруг, то:</p>
<pre><strong>var</strong> obj = {<br>  foo: 1,<br>  bar: 2,<br>  buz: 3<br>}</pre>
<pre><em>// move buz to top</em><br><strong>obj</strong> = (obj<strong>=&gt;</strong>({ buz: <strong>void</strong> <strong>null</strong>, ...<strong>obj</strong> }))(<strong>obj</strong>);<br><em>// { buz: 3, foo: 1, bar: 2 }</em></pre>
<pre><em>// move foo to the end</em><br><strong>obj</strong> = (({foo, ...<strong>obj</strong>})<strong>=&gt;</strong>({ ...<strong>obj</strong>, foo }))(<strong>obj</strong>);<br><em>// { buz: 3, bar: 2, foo: 1 }</em></pre>
<h4>Функциональный способ удалить ключ</h4>
<p>В мире мутабильности, одним словом в нормальном мире, чтобы удалить свойство вы бы написали просто:</p>
<pre>'use strict';</pre>
<pre><strong>const</strong> obj = {<br>  foo: 1,<br>  bar: 2,<br>  buz: 3<br>}</pre>
<pre><strong>delete</strong> obj.foo;</pre>
<pre>console.log(obj); // { bar: 2, buz: 3 }</pre>
<p>Но если вы функциональщик и поклонник монад, функторов и прочих ругательных слов, то вам религия не позволит так писать. Вы будете решать эту задачу так:</p>
<pre>'use strict';</pre>
<pre><strong>const</strong> obj = {<br>  foo: 1,<br>  bar: 2,<br>  buz: 3<br>}</pre>
<pre><strong>const</strong> removeProp = prop =&gt; ({ [prop]: _, ...rest }) =&gt; rest;<br><strong>const</strong> removeFoo = removeProp('foo')</pre>
<pre>removeFoo(obj)<br>// { bar: 2, buz: 3 }</pre>
<h4>Swap Key with Value</h4>
<p>В качестве идеи, не очень законченной… Не нравится реализация, пока думаю как сделать лучше, но если прям хочется поменять местами ключ и значение, можно наваять такую конструкцию:</p>
<pre><strong>const</strong> obj = {<br>  key: 'value',<br>  foo: 'bar'<br>}</pre>
<pre><strong>const</strong> swap_key = prop <strong>=&gt;</strong><br><strong>function</strong> ({ [prop]:_, ...rest }){<br><strong>return</strong> ({ [arguments[0][prop]]:prop,...rest })<br>  }<br>;</pre>
<pre>swap_key('key')(obj);<br>// { value: 'key', foo: 'bar' </pre>
<p>Ну такое, но рабочее.</p>




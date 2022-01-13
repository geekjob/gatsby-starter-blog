---
title: "Trace вместо console.log"
date: "2017-05-24T11:59:47.000Z"
description: "Для функциональной разработки
В функциональном программировании частенько нужно отладить цепочку map()
вызовов. Чтобы не писать "
---

<h4>Для функциональной разработки</h4>
<p>В функциональном программировании частенько нужно отладить цепочку map() вызовов. Чтобы не писать console.log внутри функции, можно внедрить функцию trace в цепочку вызовов. Пример такой функции:</p>
<pre><strong>const</strong> trace = <strong>tag</strong> =&gt; <strong>target</strong> =&gt; (console.log(<strong>tag</strong>, <strong>target</strong>), <strong>target</strong>);</pre>
<h4>Пример использования</h4>
<p>Возьмем для примера функции crypt и decrypt, про которые недавно я писал.</p>
<p>Чтобы понять что происходит на каждом шаге, мы можем внедрить нашу функцию trace между вызовами:</p>
<pre>const encrypt = (str, key) =&gt; str<br>  .split('')<br>  .<strong>map</strong>(<strong>trace</strong>(<em>'after split'</em>))<br>  .map(s=&gt;(s.charCodeAt()^key).toString(16))<br>  .<strong>map</strong>(<strong>trace</strong>('after XOR transformation'))<br>  .join('g')<br>;</pre>
<pre>const decrypt = (str, key) =&gt; str<br>  .split('g')<br>  .filter(Boolean)<br>  .<strong>map</strong>(<strong>trace</strong>('after filter'))<br>  .map(s=&gt; String.fromCharCode(parseInt(s,16)^key) )<br>  .<strong>map</strong>(<strong>trace</strong>('after decode'))<br>  .join('')<br>;</pre>



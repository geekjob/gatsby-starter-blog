---
title: "Call map() from String primitive"
date: "2017-06-21T17:03:00.000Z"
description: "ES7 hack with spread operator
[...123456..toString()].map(s => s.someDo()).map(parseFloat)

Если применить спред оператор к итер"
---

<h4>ES7 hack with spread operator</h4>
<pre><strong>[...123456..toString()]</strong>.map(s =&gt; s.someDo()).map(parseFloat)</pre>
<p>Если применить спред оператор к итерируемому объекту (а строка — это Array-like object), то можно быстро разбить строку без использования split()</p>



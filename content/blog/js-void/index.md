---
title: "Используем void в JS"
date: "2018-03-29T16:57:02.00Z"
description: "Зачем и как?    Небольшая заметка как и зачем может использоваться ключевое слово void в JavaScript. Слово void — это оператор в"
---

<!--kg-card-begin: html--><h4>Зачем и как?</h4>
<figure>
<p><img data-width="1200" data-height="630" src="https://cdn-images-1.medium.com/max/2560/1*A_h5kIlu9Wa0BtG83VwYtA.jpeg"><br />
</figure>
<p>Небольшая заметка как и зачем может использоваться ключевое слово void в JavaScript. Слово void — это оператор в JavaScript. Этот оператор позволяет вставлять выражения при этом всегда возвращает undefined.</p>
<h3>Void для IIEFE</h3>
<p>IIFE (Immediately-invoked function expression) — самовызывающаяся функция. Обычно такие функции описываются так:</p>
<pre>(<strong>function</strong>(arg){ expression })(arg)<br>!<strong>function</strong>(arg){ expression } (arg)<br>+<strong>function</strong>(arg){ expression } (arg)</pre>
<p>Но так же можно описывать IIFE функции используя void:</p>
<pre><strong>void</strong> <strong>function</strong>(arg){ expression } (arg)</pre>
<p>Преимущества данной записи в идиоматичности. Есть еще теория, что компилятор такой код обрабатывает быстрее, но это не точно.</p>
<h3>Void для истинного Undefined</h3>
<p>В JS есть специальный тип undefined, который так же записывается, как и называется и при этом не является ключевым словом. Поэтому undefined можно переопределить и подменить. Зачем это можно сделать — другой вопрос. Но если писать void вместо undefined, то это банально позволяет делать запись немного короче и добавлять идиоматичности, позволяя наполнять смыслом “пустоту”. Вы можете описывать любое выражение после void:</p>
<pre><strong>var</strong> foo = <strong>void</strong> 0;<br><strong>let</strong> bar = <strong>void</strong> null;<br><strong>let</strong> buz = <strong>void</strong> <em>'Комментарий, описывающий что это и зачем. Удобно'</em>;</pre>

<h3>Void и Arrow functions</h3>
<p>Если вдруг вам понадобилось использовать стрелочную функцию в качестве колбэк функции, которая ничего не должна возвращать, то можно делать с использованием void. На примере использования jQuery мы могли бы на современный лад писать используя стрелочную функцию:</p>
<pre>$(_=&gt;<strong>void</strong>( ...somedo... ))<br>// хотя проще тогда писать так $(_=&gt;{ ...somedo... })</pre>
<p>Это не лучший пример, но он отражает суть.</p>
<h3>Void для автоматического очищения временной переменной</h3>
<p>Задачка: поменять местами значения переменных. В отличие от чисел, со строками не так много вариантов. Допустим меняем с использованием временной переменной, но мы хотим, чтобы в итоге она была очищена. Можем использовать void для этих целей:</p>
<pre><strong>var</strong> a = 'abc';<br><strong>var</strong> b = 'cde';<br><strong>var</strong> c = <strong>void</strong>(c = a, a = b, b = c)</pre>
<pre>console.log(a, b, c);<br>// a = 'cde'<br>// b = 'abc'<br>// c = undefined</pre>
<h3>Головоломки с void</h3>
<p>Ну и небольшой вопрос с подвохом. Что будет и почему? ?</p>
<pre><strong>var</strong> x = <strong>void</strong> 'foo' + '!!!';</pre>
<!--kg-card-end: html-->


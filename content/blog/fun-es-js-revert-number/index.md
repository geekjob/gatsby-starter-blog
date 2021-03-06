---
title: "Fun ES #6: перевернуть число"
date: "2018-08-17T16:27:51.00Z"
description: "Задачки с собеседований. Сборник решений Задача про переворот строки [https://medium.com/@frontman/cbc91eda732f] вызвала интерес"
---

<!--kg-card-begin: html--><h4>Задачки с собеседований. Сборник решений</h4>
<p><a href="https://medium.com/@frontman/cbc91eda732f" target="_blank" rel="noopener noreferrer">Задача про переворот строки</a> вызвала интерес у многих читателей, как оказалось. И даже стали писать в личку. Например, Леонид Лебедев, верно подметил, что задачу на переворот числа можно решить без приведения к строке.</p>
<p>Да, можно. Но я не стал писать решения про переворот числа в тот пост, так как в мире фронтенд задавая задачку на переворот чаще ждут, что кандидат покажет владение синтаксисом и знание стандартных методов. И ждут именно те решения в 90% случаев. Если же брать разработчиков из мира C/С++, Java, то там эта же задача уже решается другими способами и проверяют там умение работать с памятью, знание алгоритмов и т.д.</p>
<p>Напомню условие задачи:</p>
<blockquote><p>Написать функцию, которая переворачивает <em>число</em>. Например, если мы передаем на вход 1234, то возвращает 4321. При этом нельзя приводить исходное число к строке.</p></blockquote>
<p>Действительно, число можно перевернуть не приводя его к строке:</p>
<pre><strong>function</strong> revert(n) {<br><strong>var</strong> x = 0;<br><strong>while</strong> (n &gt; 0) {<br>    x = x*10 + n%10;<br>    n = ~~(n / 10);<br>  }<br><strong>return</strong> x<br>}</pre>
<pre><strong>let</strong> n = 12367001109;<br>revert(n) // 90110076321</pre>
<p>Работает. Но, в отличие от строки, работа с числами очень зависит от реализации чисел в движке. В зависимости от алгоритмов, могут быть такие, где будут погрешности при математических операциях, в результате чего исходная последовательность будет ломаться. И надо понимать еще то, что числа с нулями на конце при перевороте будут терять эти нули:</p>
<pre><strong>let</strong> n = 12367001109<strong>0000</strong>;<br>revert(n) // 90110076321</pre>
<p>Можно придумать множество вариаций на переворот числа без смены типа (не считая что int приводится к float, но у нас в JS есть только number, а посему…).</p>
<h4>Усложняем</h4>
<p>Если вспоминать условие задачи про переворот строки, то там были еще и ограничения:</p>
<blockquote><p>При решении нельзя использовать циклы (for, while, do, etc…), итерационные методы типа map и forEach.</p></blockquote>
<p>Можем решить? В принципе почти любой цикл можно представить в виде рекурсии (вопрос только эффективно ли это).</p>
<h4>Решение 2: карирование и рекурсия</h4>
<p>А где же решение №1? Решение №1 было в предыдущем посте, где мы число предварительно приводили к строке. А это решение без приведения входного значения к строке:</p>
<pre><strong>function</strong> revert(n) {<br><strong>var</strong> res = [];<br><strong>void</strong> <strong>function</strong> _(n) {<br><strong>if</strong> (n &lt; 1) <strong>return</strong>;<br>     res.push( ~~(n % 10) );<br>     _(n/10);<br>   }(n);<br><strong>return</strong> +res.join('');<br>}</pre>
<p>Если хочется избавиться от join, чтобы прям уж совсем было тру и не придирались, что использовали “перебирающий” метод, то можно сразу работать со строкой:</p>
<pre><strong>function</strong> revert(n) {<br><strong>var</strong> res = '';<br><strong>void</strong> <strong>function</strong> _(n) {<br><strong>if</strong> (n &lt; 1) <strong>return</strong>;<br>     res += ~~(n % 10);<br>     _(n/10);<br>   }(n);<br><strong>return</strong> +res<br>}</pre>
<p>Условие выполнено.</p>
<p><strong>Вариация на ES6+ — выпендрежно-молодежная</strong></p>
<pre><strong>const</strong> revert = (n, res='', _) <strong>=&gt;</strong><br>( <br> (_ = (n) <strong>=&gt;</strong><br>  (<br>   (n &lt; 1) <strong>?</strong> (<strong>null</strong>) <strong>:</strong> ( res += ~~(n % 10), _(n/10) )<br>  )<br> )(n), +res<br>);</pre>
<p>Скобочный маньяк и программист на Lisp просто словили каеф от такого =)</p>
<p>А если вы еще и человек-парсер, то вы легко пишите и читаете все в 1 строку, а питонисты вас яро ненавидят:</p>
<pre><strong>const</strong> revert=(n,r='')<strong>=&gt;</strong>~~n<strong>?</strong>revert(n/10,r+~~(n%10)):+r</pre>
<p>Perl программистам пламенный привет!</p>
<h3>Итого</h3>
<p>В принципе вот в таком варианте задача уже сложна и здесь мы можем проверить склонность к математике и алгоритмам. В таком варианте задача уже не про синтаксис. Опять же, помним что проверяем. Что вы хотите от человека, которого берете к себе в команду? Если вы покопаетесь на форумах С++ разработчиков, вы сможете найти уйму разных решений, не все из которых получится хорошо портировать на JS. Но зачем фронтендеру это может понадобиться? (надо понимать что я отделаю фронтендеров от Node.js бэкендеров, где такими задачами могут мучать).</p>

<!--kg-card-end: html-->


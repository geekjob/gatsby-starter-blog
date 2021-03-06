---
title: "Алтернатива switch case в JS/PHP"
date: "2018-05-11T20:16:48.00Z"
description: "Switch-hash структуры и вопрос с php-собеседования    У вас бывало такое, что нужно где-то получить данные из switch-case блока,"
---

<!--kg-card-begin: html--><h4>Switch-hash структуры и вопрос с php-собеседования</h4>
<figure>
<p><img data-width="1856" data-height="718" src="https://cdn-images-1.medium.com/max/800/1*tyfa6pFFAUi57QtiBlmV4A.png"><br />
</figure>
<p>У вас бывало такое, что нужно где-то получить данные из switch-case блока, при этом это нужно единожды и это где-то нужно здесь и сейчас. Например при инициализации массива? И не хочется куда-то выносить код, заводить отдельные переменные, которые будут использованы единожды, заводить отдельные структуры и выносить все это в отдельный файл или неймспейс? Если да, то можно воспользоваться альтернативой: использовать объекты и/или ассоциативные массивы для реализации логики switch-case — так называемые switch-hash структуры.</p>
<p>Типичная ситуация может выглядеть как-то так в мире JS:</p>
<pre><strong>var</strong> switchval = 'c';<br><strong>var</strong> somearr = { foo: 1, somevalue: '' };</pre>
<pre><strong>switch</strong>(switchval) {<br><strong>case</strong> 'a': somearr.somevalue = 'foo';<br><strong>case</strong> 'b': somearr.somevalue = 'bar';<br><strong>default </strong>: somearr.somevalue = 'defualt';<br>}</pre>
<p>Немного громоздко, вам не кажется? Можно было бы написать как-то так:</p>
<pre><strong>var</strong> somearr = {<br>   foo: 1,<br>   somevalue: (<strong>function</strong>(switchval){<br><strong>switch</strong>(exprvalue) {<br><strong>case</strong> 'a': <strong>return</strong> 'foo';<br><strong>case</strong> 'b': <strong>return</strong> 'bar';<br><strong>default </strong>: <strong>return</strong> 'default';<br>      }<br>   })(switchval)<br>};</pre>
<p>Слава самовызывающимся анонимным лямбда функциям. И такой код частенько можно увидеть в разных опенсорс проектах, на гитхабе, в npm модулях. Но если мы можем писать так, так почему тогда не избавиться от IIFE заменить их вместе с блоком switch-case на объект или массив?</p>
<h3>Реализация switch-hash в JS</h3>
<pre><strong>const</strong> somevar = { a: 'foo', b: 'bar' }[switchval] || 'default';</pre>
<p>Этот код делает все тоже самое, но сильно короче, быстрее, не использует лишних конструкций.</p>
<p>В случае если у вас переменная выбора является числом, вы могли бы использовать массив:</p>
<pre><strong>let</strong> switchval = 3;<br><strong>let</strong> somevar = ['a','b'][switchval] || 'default';</pre>
<p>Не нужно switch-case блока, не нужно функций.</p>
<h3>Реализация switch-hash в PHP</h3>
<p>В PHP так же можно реализовать switch-array структуры, но специфика языка добавляет свои нюансы на реализацию:</p>
<pre><em>&lt;?php<br></em>$smvr = <strong>@</strong>['a'<strong>=&gt;</strong>'foo','b'<strong>=&gt;</strong>'bar'][$switchval] <strong>or</strong> $smvr = 'dfault';</pre>
<p>И точно так же в случае числовых switch-value используем не ассоциативный массив:</p>
<pre><em>&lt;?php</em><br>$smvr = <strong>@</strong>['foo','bar'][$switchval] <strong>or</strong> $smvr = 'dfault';</pre>
<p>В целом очень похоже на JS, но есть специфика. Первое — используем символ @, который считается плохой практикой использовать, как бы… Но вопрос в том когда и зачем. Психотерапевты когда начинают лечить, первым делом добиваются того, чтобы человек принял себя таким, какой он есть. ?</p>
<p>Если в PHP есть оператор подавления ошибок, то им можно пользоваться, если вы понимаете что делаете. Не надо хаить языки, на которых вы пишите. Просто примите и полюбите их такими, какие они есть. Если изучить особенности своего инструмента, то всегда можно создавать надежные быстрые программы. Но это оффтоп, я знаю что найдутся несогласные со мной ?</p>
<p>И так, с символом подавления ошибок разобрались. Идем дальше. В PHP можно использовать два вида логических операторов:</p>
<ul>
<li>|| — или</li>
<li>or — или</li>
</ul>
<p>И тут мы сразу натыкаемся на <strong>вопрос с собеседования по PHP:</strong></p>
<blockquote><p>В чем разница между операторами OR и || и почему выше в коде мы использовали идиоматическое OR а не символьное?</p></blockquote>
<p>На собеседовании вам может попасться такая задачка:</p>
<pre><em>&lt;?php</em><br>$a = 0;<br>$b = 1;</pre>
<pre>$foo = $a <strong>||</strong> $b;<br>$bar = $a <strong>or</strong> $b;</pre>
<pre>var_dump($foo, $bar); // ?</pre>
<p>Что будет выведено?</p>
<p>Если вы собеседуетесь на позицию php-fullstack , то вам добавят еще задачку из JS:</p>
<pre><strong>var</strong> a = 0, b = 1;<br><strong>var</strong> foo = a || b;<br>console.log(foo); // ?</pre>
<p>Разбираем по порядку.</p>
<ul>
<li>В PHP: $foo = true, $bar = 0</li>
<li>В JS: foo = 1</li>
</ul>
<p>Разбираемся с PHP.</p>
<p>В случае использования оператора || вычисляется сначала левая часть, так как это лево ассоциативный оператор, затем правая часть и затем вычисляется логическое ИЛИ, после чего результат присваивается в переменную.</p>
<p>В случае с оператором OR, все происходит похожим образом, за исключением присваивания результата, а точнее группировки из за которой не происходит присваивания.</p>
<pre>$a = 0 or 1;<br><em>// Эквивалентно записи</em><br>($a = 0) || 1;</pre>
<p>На основе этого вам может попасться вариация задачки:</p>
<pre>$s = ($a = 0 or 1);<br>$s = ($a = 0 || 1);<br>var_dump($s, $a);</pre>
<p>Собеседующий может менять вариации скобок, тем самым меняя группировку и поведение операторов.</p>
<h3>Итого</h3>
<ul>
<li>Вместо switch-case операторов можно использовать switch-hash структуры</li>
<li>В JS и в PHP результат работы оператора ИЛИ разный.</li>
<li>В JS сначала вычисляется левая часть ИЛИ и если она эквивалентна Bool(resultOfCalculation) === false, возвращается правая часть как есть. И это значение может быть присвоено в переменную. Про приведение типов и вычисления читай статью: <a href="https://medium.com/@frontman/9d6f1845ea96" target="_blank" rel="noopener noreferrer">https://medium.com/@frontman/9d6f1845ea96</a>
</li>
<li>В PHP есть 2 вида операторов ИЛИ и поведение у них отличается (|| vs or).</li>
<li>В PHP оператор “||” вычисляет сначала левую часть, затем правую и после этого вычисляет общий логический результат, который будет передан в плевую часть выражения</li>
<li>В PHP оператор OR сначала вычисляет левую часть и если она false, вычисляет правую. При этом происходит группировка левой и правой частей, в результате чего без явной группировки выражений нельзя присвоить результат логического вычисления. Эту особенность используют для реализаций условных вычислений и присвоений по аналогии с Bash скриптами. По этой же причине мы использовали этот оператор в switch-hash записи. По такой же аналогии можно работать с оператором AND и создавать короткую запись IF выражения. Например:</li>
</ul>
<pre><strong>Пример короткого IF на bash</strong></pre>
<pre><em>#!/bin/bash<br></em>[ -f 'some.txt' ] <strong>&amp;&amp; cat</strong> 'some.txt'</pre>
<pre>-----------------------------------</pre>
<pre><strong>Этот же эквивалент на PHP</strong></pre>
<pre><em>&lt;?php</em><br>file_exists('some.txt') <strong>and</strong> <strong>print</strong> file_get_contents('some.txt');</pre>
<ul>
<li>PHP и JS очень интересно могут отличаться друг от друга, что может приводить к интересным результатам. Читай статью:</li>
</ul>
<p><a href="https://medium.com/@frontman/fun-js-php-2-434b02ea4894">https://medium.com/@frontman/fun-js-php-2-434b02ea4894</a></p>
<h4>Switch-hash с использованием тернарного оператора</h4>
<p>Логическое ИЛИ можно заменить на короткую запись тернарного оператора и тогда в PHP можно сделать такую конструкцию:</p>
<pre>$smvr = ['a'=&gt;'foo','b'=&gt;'bar'][$switchval] <strong>??</strong> 'default';</pre>
<p>И да, такой вариант получается интереснее и короче. Можно сказать что основной рабочий вариант, который стоит использовать.</p>


<!--kg-card-end: html-->


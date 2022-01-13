---
title: "Integer и Float в Javascript"
date: "2016-01-27T22:56:25.00Z"
description: "10.01 способ привести и проверить Если у вас есть необходимость работать не просто с числовым типом (number) в Javascript, а уме"
---

<h4>10.01 способ привести и проверить</h4>
<p>Если у вас есть необходимость работать не просто с числовым типом (number) в Javascript, а уметь отделять Float от Integer, то предлагаю сборник юзкейсов. Рассмотрим следующие юзкейсы:</p>
<ol>
<li>Приведение к Integer</li>
<li>Приведение к Float</li>
<li>Проверить является ли число типа Int или типа Float</li>
</ol>
<p>Конечно в Javascript слишком тонка грань между Int и Float, тем не менее она существует и этим можно пользоваться.</p>
<p>Привести что угодно к типу Int в Javascript можно разными способами. Ниже перечислены все известные мне.</p>
<h4>ES6 функция Math.trunc</h4>
<pre>Math.trunc(x)</pre>
<blockquote><p>Метод <strong>Math.trunc()</strong> возвращает целую часть числа путём удаления всех дробных знаков.</p></blockquote>
<h4>Битовый сдвиг на 0</h4>
<pre>// &gt;&gt; or &gt;&gt;&gt;<br>2.0 <strong>&gt;&gt;</strong>  0; // 2 integer<br>3.1 <strong>&gt;&gt;&gt;</strong> 0; // 3 unsigned int</pre>
<h4>Битовое ИЛИ</h4>
<pre>2.0 | 0<br>2<br>3.1 | 0<br>3<br>-1.2| 0<br>1.2</pre>
<h4>Битовое отрицание</h4>
<pre>~~2.0<br>2<br>~~(-3.2)<br>-3<br>~~-4.1<br>4</pre>
<h4>Использование TypedArray</h4>
<pre>(new Int32Array([14.24434]))[0]<br>14</pre>
<h4><strong>Округление</strong></h4>
<p>Округление любой из функций, в зависимости от ваших потребностей.</p>
<pre>Math.round( noIntNumber )<br>Math.ceil( noIntNumber )<br>Math.floor( noIntNumber )</pre>
<h4><strong>parseInt</strong></h4>
<blockquote><p>Функция <strong>parseInt()</strong> принимает строку в качестве аргумента и возвращает целое число в соответствии с указанным основанием системы счисления.</p></blockquote>
<pre>parseInt(<em>string</em>, <em>radix</em>);</pre>
<p>string — значение, которое необходимо проинтерпретировать. Если значение параметраstring не принадлежит строковому типу, оно преобразуется в него. Пробелы в начале строки не учитываются.</p>
<p>radix — целое число в диапазоне между 2 и 36, представляющее собой основание системы счисления числовой строки, описанной выше. Всегда указывайте этот параметр,<strong> </strong>чтобы исключить ошибки считывания и гарантировать корректность исполнения. Когда основание системы счисления не указано, разные реализации могут возвращать разные результаты.</p>
<hr>
<h4>Привести число к Float</h4>
<p>Тут все просто, а методов не так много.</p>
<pre>parseFloat(string)</pre>
<blockquote><p>parseFloat — это высокоуровневая функция, не привязанная ни к одному объекту.</p></blockquote>
<p>parseFloat разбирает текстовую строку, ищет и возвращает из нее десятичное число. Если функция встретит знак, отличный от (+ или -), цифр(0–9), разделительной точки, или показателя степени, она вернет значение, предшествующее этому знаку, игнорируя все последующие символы . Допускаются позади и впереди идущие пробелы.</p>
<p>Если первый символ нельзя привести к числовому виду , parseFloat вернет NaN.</p>
<p>С точки зрения математики, значение NaN не является числом в какой-либо системе счисления. Чтобы определить, вернет ли parseFloat значение NaN в качестве результата, можно вызвать функцию <a href="https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/isNaN" title="Функция isNaN() определяет является ли литерал или переменная не числовым значением (NaN) или нет. При работе с функцией необходимо проявлять осторожность так как она работает некорректно. Если вам интересно подробнее можно посмотреть Number.isNaN() то как она описана в ECMAScript 6, в качестве альтернативного решения можно использовать typeof для проверки литерала или переменной на не числовое значение." target="_blank" rel="noopener noreferrer">isNaN</a>. Если NaN участвует в арифметических операциях, результатом также будет NaN.</p>
<p>parseFloat также может вернуть значение “бесконечность” — Infinity. Вы можете использовать isFinite функцию, чтобы определить, является ли результат конечным числом (not Infinity, -Infinity, или NaN).</p>
<p>Тип Number в Javascript по сути является типом Float.</p>
<p>Другие способы привести:</p>
<pre>let a = +'0.2'<br>0.2</pre>
<pre>let b = +'.31'<br>0.31</pre>
<hr>
<h4>Проверить является ли число типа Int</h4>
<h4><strong>ES6 Функция isInteger</strong></h4>
<pre>Number.isInteger(value)</pre>
<blockquote><p>Если целевое значение является целым числом, возвращает true, в противном случае возвращает false. Если значение является NaN или бесконечностью, возвращаетfalse.</p></blockquote>
<p>Полифил:</p>
<pre>Number.isInteger = Number.isInteger || function(value) {<br>  return typeof value === 'number'<br>         &amp;&amp; isFinite(value)<br>         &amp;&amp; Math.floor(value) === value;<br>};</pre>
<h4>Функции isInt и isFloat</h4>
<p>Самописные реализации функций для проверки на Integer и Float.</p>
<pre>function <strong>isInt</strong>(n){ return Number(n) === n &amp;&amp; n % 1 === 0 }<br><br>function <strong>isFloat</strong>(n){ return n === Number(n) &amp;&amp; n % 1 !== 0 }</pre>
<p>или даже так</p>
<pre>function <strong>isFloat</strong>(n) { return n === +n &amp;&amp; n !== (n|0) }<br><br>function <strong>isInteger</strong>(n) { return n === +n &amp;&amp; n === (n|0) }</pre>
<p>или так</p>
<pre>const <strong>isInt</strong> = n =&gt; parseInt(n) === n ;</pre>
<p>или так</p>
<pre>const isInt = n =&gt; !(n%1);<br>const isFloat = n =&gt; !!(n%1);</pre>



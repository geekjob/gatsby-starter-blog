---
title: "setTimeout и бесконечность"
date: "2017-06-24T19:33:00.000Z"
description: "Как отработает?
Если в setTimeout передать большое значение, например Number.MAX_VALUE, то через
какое время сработает таймер, к"
---

<h4>Как отработает?</h4>
<p>Если в setTimeout передать большое значение, например Number.MAX_VALUE, то через какое время сработает таймер, как вы думаете?</p>
<pre><strong>setTimeout</strong>(f =&gt;<strong> </strong>console.log('done'), Number.<strong>MAX_VALUE</strong>)</pre>
<p>Значение выведется точно так же, как если бы вы передали 0 (ноль). А что если передать бесконечность?</p>
<pre><strong>setTimeout</strong>(f =&gt;<strong> </strong>console.log('done'), <code><strong>Infinity</strong></code>)</pre>
<p>Точно такое же поведение.</p>
<h3>Бага?</h3>
<p>Ну как сказать. Просто setTimeout принимает в качестве второго аргумента int 32 значение. Если вы передадите 2147483647, то код отработает через 2147483647 милисекунд:</p>
<pre><strong>setTimeout</strong>(f =&gt;<strong> </strong>console.log('done'), <strong>2147483647</strong>)</pre>
<p>Если я не ошибся в математике, то это где-то 596 часов. Но вот если вы передадите число: 2147483647+1, то результат получим мгновенно:</p>
<pre><strong>setTimeout</strong>(f =&gt;<strong> </strong>console.log('done'), <strong>2147483648</strong>)</pre>
<p>Никаких ошибок. Вот такая вот канитель и трололо. Но это не максимальное число. Максимальное число, с которым будет работать setTimeout — это 49999861776383. Почему?</p>
<p>Как я понял, где-то в недрах реализации происходит следующая операция — беззнаковый сдвиг вправо:</p>
<pre><strong>49999861776383 &gt;&gt;&gt; 0</strong> === <strong>2147483647</strong></pre>
<p>Таким образом получаем:</p>
<pre><strong>setTimeout</strong>(f =&gt;<strong> </strong>console.log('done'), <strong>49999861776383</strong>) // сработает как 2147483647</pre>



---
title: "Node.js sleep, usleep, msleep"
date: "2018-11-13T22:08:26.00Z"
description: "Как затормозить поток и сделать паузу Очень частый вопрос, особенно от тех, кто пришел в мир JS из других языков. Этот вопрос вс"
---

<!--kg-card-begin: html--><h4>Как затормозить поток и сделать паузу</h4>
<p>Очень частый вопрос, особенно от тех, кто пришел в мир JS из других языков. Этот вопрос встречал даже на собеседованиях. В разных языках программирования и даже в Bash есть такие функции как sleep, usleep и другие. Прямо из коробки. Удобно.</p>
<p>Что делают ясно из названия (или мануала). Sleep — тормозит выполнение потока на время в секундах, а usleep в микросекундах.</p>
<p>В PHP это делается функцией sleep, которая в глобальной области:</p>
<pre>&lt;?<strong>php</strong> sleep(1);<code> # Time in seconds.</code></pre>
<p>В Python нужно заимпортить модуль time:</p>
<pre><code><strong>from</strong> time <strong>import</strong> sleep<br>sleep(1) # Time in seconds.</code></pre>
<p>В bash все просто, в системе есть программа /usr/bin/sleep:</p>
<pre><strong>$</strong> sleep 1</pre>
<h3>А как быть в Node.js?</h3>
<p>А зачем? Это нужно бывает в скриптах разного рода и при отладке, когда вы хотите глазками проследить за логом данных. Конечно же не для серверных приложений. Ни в коем случае! Упаси вас от лукавого блокировать поток выполнения.</p>
<p>Так вот вопрос, как блокировать, если не залезать в NPM и не скачивать готовый модуль? Да все, в принципе, просто.</p>
<h4>Пишем функцию sleep</h4>
<pre><strong>const</strong> exec <strong>=</strong> <strong>require</strong>('child_process').execSync;<br><strong>const</strong> sleep = <strong>time</strong> <strong>=&gt;</strong> (<br>   (time <strong>=</strong> parseInt(time)),<br>   (time <strong>&gt;</strong> 0<br>           ? exec(`sleep ${time}`)<br>           : <strong>null</strong><br>   )<br>);</pre>
<p>Ну вот и все. Мы синхронно вызываем команду sleep из системы. По такому же принципу можно вызвать и usleep.</p>
<h4>Пишем функцию usleep</h4>
<p>Эта функция принимает значения в микросекундах.</p>
<p>1 секунда = 1 000 000 микросекунд.</p>
<pre><strong>const</strong> exec <strong>=</strong> require('child_process').execSync;<br><strong>const</strong> usleep = <strong>time</strong> <strong>=&gt;</strong> (<br>   (time <strong>=</strong> parseInt(time)),<br>   (time <strong>&gt;</strong> 0<br>           ? exec(`usleep ${time}`)<br>           : <strong>null</strong><br>   )<br>);</pre>
<pre>usleep(1e6); // Timeout 1 second</pre>
<h4>Пишем функцию msleep на Atomics.wait</h4>
<p>Функцию msleep обычно не вкладывают в ЯП и ее нет в Bash, так как если есть usleep, то можно затормозить на нужное число милисекунд и msleep не нужна. Но мы ее напишем на чистом ванильном JS используя новую крутую фичу Atomics. А точнее заиспользуем метод wait.</p>
<p>Atomics.wait() — проверяет, содержится ли в указанной позиции массива представленное значение. Если нет, то находится в ожидании. Возвращает <code>"ok"</code>, <code>"not-equal"</code>или <code>"timed-out"</code>. Если ожидание не разрешено в вызывающем агенте, тогда выбросит исключение. Большинство браузеров не разрешают Atomics.wait в главном потоке браузера!</p>
<p>Atomics.wait() моделируется на основе futexes (“fast user-space mutex” — быстрый мьютекс пользовательского пространства) Linux и представляют собой способы ожидания момента, когда определенное состояние не станет true, и обычно используется как блокирующие конструкции.</p>
<p>Так вот, мы можем написать нативную функцию блокировки потока используя этот метод и немного магии:</p>
<pre><strong>const</strong> msleep <strong>=</strong> milliSeconds <strong>=&gt;</strong><br><strong>Atomics</strong>.wait(<br><strong>new</strong> Int32Array(<strong>new</strong> SharedArrayBuffer(4)),<br>        0, 0, miliSeconds<br>    )<br>;</pre>
<p>Больше про атомики можно узнать в <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Atomics" target="_blank" rel="noopener noreferrer">документации на MDN</a>.</p>
<h4>Async/await msleep</h4>
<p>Если у вас асинхронный код и вы используете async/await стиль, то вам для дебага (и не только) можно использовать простую реализацию msleep:</p>
<pre><strong>const</strong> msleep<em> </em>= time <strong>=&gt;<br>   new</strong> <em>Promise</em>(<br>       resolve <strong>=&gt;</strong> <em>setTimeout</em>(_<strong>=&gt;</strong>resolve(), time)<br>   )<br>;</pre>
<p>И тогда вы можете ее использовать в контексте async:</p>
<pre><strong>void async function</strong>(){<br><strong>let</strong> i = 10;<br><strong>do</strong> {<br><em>console</em>.log(`Debug log ${i}`);<br><strong>await</strong> <em>msleep</em>(1000);<br>   }<br><strong>while</strong>(i--&gt;0)<br>}();</pre>
<p>Такой вот вышел небольшой ЛикБез по тормозящим функциям в Node.js.</p>
<p>Готовый код Node.js модуля можно посмотреть на гитхабе по ссылке:</p>
<p><a href="https://github.com/NewHR/nodejs-sleep/blob/master/sleep.js">https://github.com/NewHR/nodejs-sleep/blob/master/sleep.js</a></p>

<!--kg-card-end: html-->


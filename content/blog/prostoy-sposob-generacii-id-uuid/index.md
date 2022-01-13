---
title: "Простой способ генерации символьных ID и UUID"
date: "2018-02-19T20:45:56.00Z"
description: "На JavaScript Если вдруг нужно быстро сгенерить символьные ID, которые представляют собой сочетание цифр и символов, при этом ва"
---

<!--kg-card-begin: html--><h4>На JavaScript</h4>
<p>Если вдруг нужно быстро сгенерить символьные ID, которые представляют собой сочетание цифр и символов, при этом вам не нужна высокая надежность и коллизии вам не страшны, то можно сделать это очень быстро следующим образом:</p>
<pre><strong>const</strong> id = `f${(~~(<strong>Math</strong>.random()*1e8)).toString(16)}`;<br>// Result: f5d47a64</pre>
<p>Можно так же сделать генерацию хешей от времени:</p>
<pre><strong>const</strong> id = `f${(+<strong>new</strong> Date).<strong>toString</strong>(16)}`;<br>// f161807f6409</pre>
<p>Только не стоит использовать такой подход для генерации сесионных ID и прочих секурных дел. Такое может пригодится, если нужно заполнить что-то рандомными значениями, сгенерить объект с рандомными ключами и так далее.</p>
<h3>Генерация UUID</h3>
<blockquote><p>
<strong>UUID (universally unique identifier)</strong> — это стандарт идентификации, используемый в создании программного обеспечения, стандартизированный Open Software Foundation. Основное назначени— позволить распределённым системам уникально идентифицировать информацию без центра координации. Наиболее распространённым использованием данного стандарта является реализация Globally Unique Identifier (GUID).</p></blockquote>
<p>UUID представляет собой 16-байтный (128-битный) номер. В шестнадцатеричной системе счисления UUID выглядит как:</p>
<pre>d29e9b42-9b97-ab6f-bc0c-2c3f938d10e4</pre>
<blockquote><p>Общее количество уникальных ключей UUID составляет 2128 = 25616 или около 3,4 × 1038. Это означает, что генерируя 1 триллион ключей каждую наносекунду, перебрать все возможные значения удастся лишь за 10 миллиардов лет.</p></blockquote>
<p>Собственно теперь вопрос, как сгенерить данную строку на JS. Вариант реализации:</p>
<pre>const <strong>uuid</strong> =()=&gt;'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g,(c,r)=&gt;('x'==с?(r=Math.random()*16|0):(r&amp;0x3|0x8)).toString(16));</pre>
<p>Но такой код не криптостойкий и есть вероятность коллизии, так как Math.random() может вести себя детерменировано (особенно если вас посетил гугл бот. Пруф: <a href="http://www.tomanthony.co.uk/blog/googlebot-javascript-random/" target="_blank" rel="noopener noreferrer">http://www.tomanthony.co.uk/blog/googlebot-javascript-random/</a>)</p>
<p>Для уменьшения коллизийи и улучшения криптонадежности можно использовать Crypto API:</p>
<pre>const <strong>uuid</strong> =()=&gt;([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g,c=&gt;(c^crypto.getRandomValues(new Uint8Array(1))[0]&amp;15 &gt;&gt; c/4).toString(16));</pre>
<!--kg-card-end: html--><p></p><p>Код ([1e7]+-1e3+-4e3+-8e3+-1e11) формирует строку "10000000-1000-4000-8000-100000000000". Далее .replace(/[018]/g - пробегаемся по символам, и с каждым 0, 1 и 8 производим манипуляции. Затем сдвиг: 15 &gt;&gt; c/4 - 0,1,8 =&gt; 15,15,3 после чего вызываем crypto.getRandomValues(new Uint8Array(1))[0] - генерим случайное число в диапазоне 0..255. Вызов crypto.getRandomValues(new Uint8Array(1))[0]&amp;15 &gt;&gt; c/4 - это не что иное как побитовое И, этот код сужает диапазон 0..255 до 0..15 или 0..3, если с=8. Вызов c^crypto.getRandomValues(new Uint8Array(1))[0]&amp;15 &gt;&gt; c/4 - ноль или один, или 8 черех XOR<strong> </strong>обрабатываются с предыдущим шагом. Полученный результат переводим в шестнадцатеричный формат и возвращаем вместо символа. Сдвиг и xor в данном коде нужны для большей энтропии.</p><p></p><!--kg-card-begin: html--><h4>Генерация GUID</h4>
<p>GUID — это разновидность UUID и его особенность заключается в формате. Так что при необходимости не составит труда переделать формат функции под GUID.</p>
<figure class="wp-caption">
<p><img data-width="594" data-height="160" src="https://cdn-images-1.medium.com/max/800/1*5SqBSrPvjeaVdlwIbS64jw.png"><figcaption class="wp-caption-text">UUID and GUID</figcaption></figure>
<!--kg-card-end: html-->


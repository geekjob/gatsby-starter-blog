---
title: "Пишем GCD функцию"
date: "2018-04-17T00:46:08.00Z"
description: "Задачки с собеседований    Очередная задачка с собеседований. На этот раз написать функцию для нахождения наибольшего общего дел"
---

<!--kg-card-begin: html--><h4>Задачки с собеседований</h4>
<figure>
<p><img data-width="1856" data-height="716" src="https://cdn-images-1.medium.com/max/800/1*g1CLvjyaDOUk8nrC1DdJrg.png"><br />
</figure>
<p>Очередная задачка с собеседований. На этот раз написать функцию для нахождения наибольшего общего делителя. Вариант решения будем писать на JS, но его легко повторить и на других языках, если понять суть.</p>
<p>Почему JS? Потому, что на нем можно изгаляться и показывать невероятные конструкции. Что касается самой задачи, я её встречал как на собеседовании JS разработчиков, так и в собеседованиях на других языках.</p>
<blockquote><p>
<strong>Наибольший общий делитель (НОД)</strong> — это число, которое делит без остатка два числа и делится само без остатка на любой другой делитель данных двух чисел. Проще говоря, это самое большое число, на которое можно без остатка разделить два числа, для которых ищется НОД.</p></blockquote>
<h3>Вариант НОД без рекурсии</h3>
<p>Напишем функцию GCD(Greatest Common Divisor) без рекурсии:</p>
<pre><strong>function </strong>gcd(x, y) {<br><strong>while </strong>(y !== 0) y = x % (x = y);<br><strong>return </strong>x;<br>}</pre>
<pre>console.log( gcd(21, 14) ); <em>// = 7</em></pre>
<h4>Эта же функция в ES6+ стиле ( just4fun )</h4>
<pre><strong>const</strong> gcd = ($,_)<strong>=&gt;</strong>((()<strong>=&gt;</strong>{<strong>while </strong>(_)(_)=($)%($=_)}) ($),($) );</pre>
<p>Спросите что это и зачем я так написал? Отвечу: ради удовольствия. Это чисто размять мозги. Б<strong>о</strong>льшая часть скобочек бессмысленна и добавлена ради симметрии и красоты запутанности. Код специально написан с повышенной когнитивной нагрузкой, чтобы произошла акселерация мнемонической деятельности мозга. Минимальный рабочий вариант без “выпендрежа” я показал уже и могу позволить себе теперь оттянуться.</p>
<p>Как он родился в таком виде? Я сам себе поставил ограничения:</p>
<ul>
<li>обязательно использовать while</li>
<li>нельзя использовать слово return</li>
</ul>
<p>Так я иногда развлекаюсь вечерами. Как говорится, кто прошел квест <a href="https://alf.nu/ReturnTrue" target="_blank" rel="noopener noreferrer">https://alf.nu/ReturnTrue</a> и кто туда задеплоил 4 задачи, тот по другому писать не умеет (мой ник MAY✪R , если вдруг что) ☺</p>
<p>Как-нибудь я сделаю разбор задач из этого квеста. Это не про собеседования в прямом смысле, но чтобы решить эти задачи нужно очень хорошо разбираться в вашем инструменте, в нашем случае в JS. Такие головоломки заставляют почитать спеку, документацию, поразбираться в том, как работает V8 и почему он делает то, что делает. Полезное занятие, я вам скажу.</p>
<p>Кстати, если убрать лишние скобочки, то эта функция будет выглядеть немного проще и понятнее:</p>
<pre><strong>const</strong> gcd = (x,y)<strong>=&gt;</strong>((_=&gt;{<strong>while</strong>(y) y=x %(x=y)})(),x);</pre>
<p>И конечно же если бы нужно было просто описать ее в ES6+ стиле, то мы просто написали копию первоначальной функции:</p>
<pre><strong>const </strong>gcd = (x, y) =&gt; {<br><strong>while </strong>(y !== 0) y = x % (x = y);<br><strong>return </strong>x;<br>}</pre>
<p>Но это же ску-чно.</p>
<h3>Рекурсивный алгоритм на ES6+</h3>
<p>Ну и напоследок рабочий вариант с использованием рекурсивной функции.</p>
<pre><strong>const </strong>gcd = (x, y) =&gt;  x ? gcd(y%x, x) : y;<br>// или<strong><br>const</strong> gcd = (x, y) =&gt; !y ? x : gcd(y, x%y);</pre>
<p>Никакой магии. Все по делу.</p>
<hr>
<p>Лайк, хлопок, шер. Слушайте меня в <a href="https://itunes.apple.com/ru/podcast/pro-web-it/id1366662242?mt=2" target="_blank" rel="noopener noreferrer">iTunes</a>, подписывайтесь на <a href="https://t.me/prowebit" target="_blank" rel="noopener noreferrer">Телеграм</a> канал или <a href="https://vk.com/mayorovprowebit" target="_blank" rel="noopener noreferrer">Вконтакте</a>.</p>
<!--kg-card-end: html-->


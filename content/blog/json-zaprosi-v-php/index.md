---
title: "JSON запросы в PHP"
date: "2019-10-03T00:06:05.00Z"
description: "Правильная обработка Один из современных способов взаимодействия фронтенда с бэкендом — это обмен данными в формате JSON. И, как"
---

<h2 id="-">Правильная обработка</h2>
<p>Один из современных способов взаимодействия фронтенда с бэкендом — это обмен данными в формате JSON. И, как показывает практика, не каждый может рассказать как же можно наладить такую взаимосвязь, обработать данные и в чем разница между следующими вариантами запросов.</p>
<p>Один из современных типичных способов передачи JSON с фронтенда на бэкенд выглядит так:</p>
<pre><strong>var </strong>data<strong> </strong>= {foo: {bar: [1,2,3]}};<br><br><strong>fetch</strong>('backend.php', {<br>      method : 'POST',<br>      cache  : 'no-cache',<br>      headers: {'Content-Type':'application/json'},<br>      body   : <strong>JSON</strong>.stringify(<strong>data</strong>)<br>   })<br>   .then(res=&gt;res.json())<br>   .then(<strong>console</strong>.log)<br>;</pre>
<p>Другой способ:</p>
<pre><strong>var</strong> body<strong> </strong>= <strong>new</strong> FormData;<br>body.append('foo', 123);<br>body.append('bar', [1,2,3]);<br>body.append('buz', 'abc');<br><br><strong>fetch</strong>('backend.php', {<br>      method: 'POST',<br>      cache : 'no-cache',<br><strong>body<br></strong>})<br>   .then(res=&gt;res.json())<br>   .then(<strong>console</strong>.log)<br>;</pre>
<p>Чем отличаются эти два варианта? Как правильно обработать данные на сервере?</p>
<h3>FORM URLENCODED</h3>
<p>Начнем со второго примера. Отличительная черта этого варианта отправки запроса это формат, который определяется заголовком:</p>
<pre>application/x-www-form-urlencoded</pre>
<p>По идее его можно было бы указать явно:</p>
<pre><strong>fetch</strong>('backend.php', {<br>   ...<br>   headers: {'Content-Type':'application/x-www-form-urlencoded'},<br>   ...<br>})</pre>
<p>Этот формат многим знаком, так как по сути это формат отправки данных из HTML форм. В этом формате значения кодируются парами ключ-значение, разделенных символом <code>'&amp;'</code>, и с <code>'='</code> между ключом и значением. Все значения передаются в виде строки и это важно! При попытке передать массив или объект, они будут представлены в виде строки. И бремя по кодированию этих объектов ложится на плечи фронтендера и бекендера, которые будут обратно приводить все к нужным типам.</p>
<p>На сервере получить такой формат очень просто, достаточно обратиться к встроенным глобальным перменным $_POST и $_REQUEST:</p>
<pre>$_POST['foo'] // string("123")<br>$_POST['bar'] // string("1,2,3")<br>$_POST['buz'] // string("abc")</pre>
<p>А чем же отличается принципиально первый запрос от второго?</p>
<p>В первую очередь тем, что вы не сможете их увидеть в привычных глобальных переменных $_REQUEST и $_POST. Они там не хранятся и их нужно получать другим способом. Вопрос жизненный и даже встречающийся на собеседованиях.</p>
<h3>JSON Request</h3>
<p>Если вы работаете с Node.js бэкендом, то там для обработки таких запросов по сути ничего специального не нужно. Вы по сути обращаетесь к объекту body из запроса. А вот в PHP эти данные автоматом не кладутся в супер глобальные переменные. Но есть способ получить такие данные.</p>
<p>До версии PHP 5.6 в языке была супер глобальная переменная <code>$HTTP_RAW_POST_DATA</code> , но с версии 7.0 она была удалена. И теперь для чтения сырых данных мы должны обратиться к входному потоку:</p>
<pre>php://input</pre>
<p>Это не сложно, просто нужно про это знать. Чтобы обработать JSON пишем такой код:</p>
<pre><strong>if</strong> ('application/json' == $<strong>_SERVER</strong>['CONTENT_TYPE']<br><strong>&amp;&amp;</strong> 'POST' == $<strong>_SERVER</strong>['REQUEST_METHOD'])<br>{<br>    $json = <strong>json_decode</strong>(<strong>file_get_contents</strong>('<em>php://input</em>'), <strong>true</strong>);<br>}</pre>
<p>Для того, чтобы соблюдать некоторый канон, я использую слово JSON и добавляю все это в $_REQUEST и $_POST:</p>
<pre><strong>if</strong> ('application/json' == $<strong>_SERVER</strong>['CONTENT_TYPE']<br><strong>&amp;&amp;</strong> 'POST' == $<strong>_SERVER</strong>['REQUEST_METHOD'])<br>{<br><strong>$_REQUEST</strong>['JSON'] = <strong>json_decode</strong>(<br><strong>file_get_contents</strong>('<em>php://input</em>'), <strong>true<br></strong>);<br><strong>$_POST</strong>['JSON'] = <strong>&amp; $_REQUEST</strong>['JSON'];<br>}</pre>
<p>Вот вроде бы и все. Простая тема, но порой даже такие простые вещи вызывают вопросы.</p>




---
title: "Fun Mongo #1: ObjectId"
date: "2020-01-12T19:51:40.000Z"
description: "Как устроен Primary Key
После долгой работы с реляционными БД и, в частности, с SQL, переход на
документную базу MongoDB не так "
---

<h4>Как устроен Primary Key</h4>
<p>После долгой работы с реляционными БД и, в частности, с SQL, переход на документную базу MongoDB не так прост, как кажется. Надо немного перестроить менталитет. Это как с PHP/Python перейти на Node.js — привыкнуть к асинхронности и колбэкам требует времени.</p>
<p>Так и с NoSQL, в частности с MongoDB. Первое что бросается в глаза — это необычные ID. Это не автоинкремент, как в других базах. Более того, из коробки вообще нет автоинкрементов и их нужно реализовывать самому, если они нужны.</p>
<p>Начнем с ObjectId. Кажется что это хеш и как же делать поиски вида:</p>
<pre>SELECT * FROM t WHERE id &gt; 1234</pre>
<p>На самом деле в MongoDB так же можно строить запросы по _id (поле айди в монге с префиксом):</p>
<pre>db.t.find({ _id: { $gt: ObjectId('5e1b270142dcae0010186f02') } })</pre>
<p>И так же по этому полю можно сортировать.</p>
<p>Не все знают, но это не просто хеш, это функция от времени, и хеш можно привести к DateTime. И делается это достаточно просто (пример на JS):</p>
<pre><strong>function</strong> objectIdToDateTime(objectId) {<br><strong>return</strong> <strong>new</strong> <strong>Date</strong>(<strong>parseInt</strong>(objectId.<strong>substring</strong>(0,8),16)*1e3)<br>}</pre>
<p>Пробуем наш айдишник:</p>
<pre>objectIdToDateTime('5e1b270142dcae0010186f02')<br>// Sun Jan 12 2020 17:02:41 GMT+0300</pre>
<p>В самой монге есть возможность получить время от ObjectId:</p>
<pre>ObjectId("5e1b270142dcae0010186f02").getTimestamp()<br>// ISODate("2020-01-12T17:02:41.000+03:00")</pre>
<p>Если хочется сгенерить ObjectId, то нужно сделать обратное преобразование:</p>
<pre><strong>function</strong> generateObjectId() {<br><strong>return</strong> <strong>Math</strong>.floor((<strong>new</strong> Date).getTime()/1e3)<br>               .<strong>toString</strong>(16) + '0'.<strong>repeat</strong>(16)<br>}</pre>
<p>Тут мы генерим первую часть хеша, но вот конец хеша у нас состоит из нулей. Оригинальный ObjectId во второй части содержит некий рандомный хеш. Мы можем использовать алгоритм для генерации UID:</p>
<pre><strong>function</strong> generateObjectId() {<br><strong>return</strong> <strong>Math</strong>.floor((<strong>new</strong> Date).<strong>getTime</strong>()/1e3).<strong>toString</strong>(16) +<br>    (('x'.<strong>repeat</strong>(16).<strong>replace</strong>(/x/g,<br>      _=&gt;(<strong>Math</strong>.random()*16|0).<strong>toString</strong>(16))<br>    ))<br>}</pre>

<p>Варианты получения UID можно прочитать в статье</p>- <a class="kg-bookmark-container" href="/prostoy-sposob-generacii-id-uuid/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">Простой способ генерации символьных ID и UUID</div><div class="kg-bookmark-description">На JavaScript
Если вдруг нужно быстро сгенерить символьные ID, которые представляют собой
сочетание цифр и символов, при этом вам не нужна высокая надежность и коллизии
вам не страшны, то можно сделать это очень быстро следующим образом: const id = `f${(~~(Math.random()*1e8)).toString(16)}`;
// Res…</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://tech.geekjob.ru/favicon.png"><span class="kg-bookmark-author">Александр Майоров</span><span class="kg-bookmark-publisher">Geekjob Tech</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://www.gravatar.com/avatar/8f8f604430a6a2116749fad87c9c86d5?s=250&amp;d=mm&amp;r=x"></div></a> <br/>
<p>Прелесть ObjectId в том, что не так просто вычислить следующий ID, в отличие от автоинкремента. Так же нельзя понять сколько в базе записей. Но зато можно получить дату создания записи.</p><p>А еще плюсом такой генерации Primary Key заключается в том, что мы можем получить PK до того, как запишем данные в базу. Таким образом удобно строить различные ORM, позволяющие создавать полноценный объект коллекции, до его записи в базу. Конечно в SQL базах так же можно получить last id и все такое, но это будет сложнее и потребует транзакций, чтобы он не успел измениться. Здесь же мы даже не обращаемся к базе.</p><p>В следующем посте разберем как создавать автоинкременты в MongoDB.</p>


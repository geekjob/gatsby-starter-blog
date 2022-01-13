---
title: "Качаем музыку для воркаутов"
date: "2017-02-28T11:51:30.000Z"
description: "
Скоро открытие страйкбольного сезона. А я за зиму распух и на меня не налезает
бронежилет. Стал эдакий “рядовой фисташка”. Купи"
---

<h4></h4>
<p>Скоро открытие страйкбольного сезона. А я за зиму распух и на меня не налезает бронежилет. Стал эдакий “рядовой фисташка”. Купил абонемент в X-Fit, взял классного персонального тренера… Но чтобы занятия были эффективны нужна музыка. Где ее взять быстро и налить плеер?</p>
<p>По запросу “free workout motivation music” нашел сайт c оной. Нет времени разбираться что там, работы много. Нужно все это залить в мой sony walkman nwz. Его прелесть в том, что он водонепроницаемый и с ним можно плавать в бассейне.</p>
<p>Первым делом открываем консоль и пишем код для сбора ссылок на странице:</p>
<pre>{<br><strong>let</strong> links = [];</pre>
<pre>    $('.playlist-btn-down.no-ajaxy')<br>        .<strong>map</strong>(function(){<br>            links.<strong>push</strong>(this.href)<br>        });</pre>
<pre>    <strong>console</strong>.log(links.<strong>join</strong>('n'));<br>}</pre>
<p>Сохраняем все ссылки в файл list.txt. Если не хотим сохранять вручную, копируя ссылки из консоли, можем написать функцию для скачивания:</p>
<pre><strong>const</strong> save = (data, filename) =&gt; {<br><strong>if</strong>(!data) <strong>return</strong> console.log('No data to save');<br><strong>if</strong>(!filename) filename = 'chrome.txt';<br><strong>if</strong>(<strong>typeof</strong> data === "object") data = <strong>JSON</strong>.stringify(data, <strong>void 0</strong>, 4);<br><br><strong>let</strong> blob = <strong>new</strong> Blob([data], {type: 'text/plain'}),<br>       e    = <strong>document</strong>.createEvent('MouseEvents'),<br>       a    = <strong>document</strong>.createElement('a');<br><br>   a.download = filename;<br>   a.href = <strong>window</strong>.URL.createObjectURL(blob);<br>   a.dataset.downloadurl =  ['text/plain', a.download, a.href].join(':');<br><br>   e.<strong>initMouseEvent</strong>('click', <strong>true</strong>, <strong>false</strong>, <strong>window</strong>, 0, 0, 0, 0, 0, <strong>false</strong>, <strong>false</strong>, <strong>false</strong>, <strong>false</strong>, 0, null);<br>   a.<strong>dispatchEvent</strong>(e);<br>};</pre>
<p>Вместо</p>
<pre><strong>console</strong>.log(links.<strong>join</strong>('n'));</pre>
<p>пишем</p>
<pre><strong>save</strong>(links.<strong>join</strong>('n'), 'list.txt');</pre>
<p>Тогда браузер сам предложит нам загрузить полученные данные.</p>
<p>Далее пишем простой баш скрипт:</p>
<pre><em>#!/bin/bash</em></pre>
<pre><strong>i</strong>=1<br><strong>list</strong>=$(cat list.txt)</pre>
<pre><strong>for</strong> url in $list<br><strong>do</strong><br><strong>n</strong>=$(printf "%03dn" $i) <em># числа вида 001, 012, 121</em><br><strong>wget</strong> <strong>$url</strong> -O ./wget/m<strong>$n</strong>.mp3<br>   ((i = i + 1))<br><strong>done</strong></pre>
<p>Все. Запускаем и идем работать. Через часик другой плеер будет полон всякой музыки для воркаутов =)</p>
<p>Почему не стал все делать wget’ом? Можно же было получить страницу и распарсить ее. Можно… Но я сделал как было быстрее. На все про все 10 минут и не более. Если бы файлы для скачивания имели расширение mp3, то вся суть закачки сводилась бы к 1й строке в bash:</p>
<pre><code><strong>wget</strong> -c -A '*.<strong>mp3</strong>' -r -l 1 -nd http://example.org/musics/</code></pre>
<p>Но на том сайте, откуда брал я, нет расширений, а есть скрипты, которые отдают музыку по ID. Так что такой вариант не прокатил бы. Так же при загрузке в качестве имени по дефолту подставлялся URL загрузчика, а это не гуд. В итоге пришлось имена назначать самому.</p>



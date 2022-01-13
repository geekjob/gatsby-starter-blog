---
title: "Fun Frontend: мониторим страницу без JS"
date: "2018-01-27T19:41:18.000Z"
description: "Задачки с собеседований и не только    Сегодня будет один из ответов на задачку с собеседования. Вопрос обычно звучит так: назов"
---

<h4>Задачки с собеседований и не только</h4>

<p>Сегодня будет один из ответов на задачку с собеседования. Вопрос обычно звучит так: назовите все способы передать данные на сервер из браузера. Мы не рассматриваем тут очевидные ответы, а рассмотрим интересные техники связанные только с CSS. Кстати, эти же техники могут использоваться в системах мониторинга и трекинга. И так, поехали.</p>
<h4>Передача данных на сервер используя только CSS</h4>
<p>Вся идея передачи данных на сервер через CSS базируетcя на одной простой идее — это загрузка URL через свойство url(), которое используется для разных целей. Все. А вот дальше уже можно фантазировать и фантазия может привести к тому, что зная эту технику можно сделать целую систему мониторинга сайта на одном лишь чистом CSS.</p>
<h4>Детектим клик по ссылке</h4>
<pre>#somelink1:active::after {<br>    content: url("/tracker/?action=somelink1");<br>}</pre>
<h4>Детектим браузер</h4>
<p>В CSS пишем:</p>
<pre>@supports (-webkit-appearance:none) and (not (-ms-ime-align:auto)){<br>    #chrome_detect::after {<br>        content: url("/tracker/?browser=chrome");<br>    }<br>}<br><br>@supports (-moz-appearance:meterbar) {<br>    #firefox_detect::after {<br>        content: url("/tracker/?browser=firefox");<br>    }<br>}<br><br>@supports (-ms-ime-align:auto) {<br>    #edge_detect::after {<br>        content: url("/tracker/?browser=edge")<br>    }<br>}</pre>
<p>В страницу встраиваем следующие теги:</p>
<pre>&lt;div id="chrome_detect"&gt;&lt;/div&gt;&lt;div id="firefox_detect"&gt;&lt;/div&gt;<br>&lt;div id="edge_detect"&gt;&lt;/div&gt;</pre>
<p>Если нужные старые IE, то подключаем условные комментарии.</p>
<h4>Определяем ориентацию</h4>
<pre>CSS:</pre>
<pre><a href="http://twitter.com/media" title="Twitter profile for @media" target="_blank" rel="noopener noreferrer">@media</a> (orientation: portrait) {<br> #orientation::after {<br>   content: url(“/tracker/?orientation=portrait”);<br> }<br>}</pre>
<pre><a href="http://twitter.com/media" title="Twitter profile for @media" target="_blank" rel="noopener noreferrer">@media</a> (orientation: landscape) {<br> #orientation::after {<br>   content: url(“/tracker/?orientation=landscape”);<br> }<br>}</pre>
<pre>HTML:<br>&lt;div id="orientation"&gt;&lt;/div&gt;</pre>
<h4>Определяем размер экрана</h4>
<pre>CSS:<br><a href="http://twitter.com/media" title="Twitter profile for @media" target="_blank" rel="noopener noreferrer">@media</a> (min-device-width: 360px) {<br>    #width::after {<br>        content: url("/tracker/?width=360");<br>    }<br>}</pre>
<pre>/*<br>...360px, 640px, 720px, 1024px, 1280px, 1366px, 1920px, 3840px...<br>*/</pre>
<pre>@media (min-device-width: 4096px) {<br>    #width::after {<br>        content: url("/tracker/?width=4096");<br>    }<br>}</pre>
<pre>HTML:<br>&lt;div id="width"&gt;&lt;/div&gt;&lt;div id="height"&gt;&lt;/div&gt;</pre>
<p>То же самое проделываем для heights и прописываем стандартные размеры: 2160px, 1366px, 1080px, 1024px, 768px, 720px, 690px, 667px, 640px, 600px, 576px, 568px, 540px, 504px, 480px, 360px, 320px, 240px.</p>
<h4>Input detection</h4>
<p>Можно получить данные из input’ов</p>
<pre>#checkbox:checked {<br>    content: url("/tracker/?action=checkbox");<br>}</pre>
<p>Данные, которые вводятся в input:</p>
<pre>CSS:<br>#mail:valid {<br>    background-image: url("/tracker/?action=input-email-valid");<br>}<br>#mail:invalid {<br>    background-image: url("/tracker/?action=input-email-error");<br>}</pre>
<pre>HTML:<br>&lt;input type="mail" id="mail" required&gt;</pre>
<p>и так далее. Все ограничивается вашей фантазией.</p>
<h4>Измерить длительность</h4>
<p>Можно узнать как долго было какое-то действие. Например можно понять как долго курсор был над объектом:</p>
<pre>@keyframes duraloop {<br>     0% {background-image: url("/tracker/?duration=0")}<br>    10% {background-image: url("/tracker/?duration=10")}<br>    20% {background-image: url("/tracker/?duration=20")}<br>...<br>    100% {background-image: url("/tracker/?duration=100")}<br>}<br><br>#duration:hover::after {<br>    animation: duraloop 5s infinite;<br>    animation-name: duraloop;<br>    animation-duration: 10s;<br>    animation-iteration-count: infinite;<br>    content: url("/tracker/?duration=-1");<br>}</pre>
<p>Таким образом можно считывать длительность фокуса и прочие вещи.</p>
<h4>Прочее</h4>
<p>Еще осталось правило font-face, которое так же можно использовать для отправки данных на сервер.</p>
<p>Github с готовым proof of concept и демо можно найти по ссылке:</p>
<p><a href="https://github.com/jbtronics/CrookedStyleSheets">https://github.com/jbtronics/CrookedStyleSheets</a></p>
<p>Если есть идеи — делайте пулреквесты.</p>



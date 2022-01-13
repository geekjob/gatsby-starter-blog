---
title: "Доступ к камере в iOS"
date: "2016-11-20T15:47:18.00Z"
description: "Как получить доступ к видео с камеры в браузере А вот интересная задача. Хочу сделать веб приложение под браузер, в котором нужн"
---

<!--kg-card-begin: html--><h4>Как получить доступ к видео с камеры в браузере</h4>
<p>А вот интересная задача. Хочу сделать веб приложение под браузер, в котором нужно получить доступ к веб-камере. Снимать видео-поток и производить манипуляции. Вроде бы все просто, у нас есть различные HTML5 API для этих целей. Но не так все гладко. Даже вообще не гладко, к сожалению…</p>
<p>Сначала давайте разберемся, можно ли вообще получить доступ к веб-камере из веб-страницы.</p>
<h4>Получаем фото в iOS из браузера</h4>
<p>Для получения любого файла из браузера мы создаем тег input с типом file. Для того, чтобы был доступ к фото, мы указываем аттрибут accept. Разрешаем загружать только фотографии:</p>
<pre>&lt;<strong>input</strong> <strong>type</strong>="file" <strong>accept</strong>="image/*" <strong>capture</strong>="camera"&gt;</pre>
<h4>Получаем доступ к фото</h4>
<p>Если мы делаем простое веб-приложение, по типу инстаграма, то нам нужно получить доступ к загруженному изображению. Сделать это просто. Код HTML выглядит так:</p>
<pre>&lt;<strong>input</strong> <strong>type</strong>="file" <strong>accept</strong>="image/*" <strong>capture</strong>="camera" <strong>id</strong>="pic"&gt;<br>&lt;<strong>img</strong> <strong>id</strong>="img"&gt;</pre>
<p>Ну и немного JS:</p>
<pre><strong>if</strong> (!('URL' in <strong>window</strong>) &amp;&amp; ('webkitURL' in <strong>window</strong>))<br><strong>window</strong>.URL = <strong>window</strong>.webkitURL;</pre>
<pre><strong>$</strong>(f=&gt;{<br><strong>$</strong>('#pic').<strong>on</strong>('change', <strong>function</strong>(e){<br><strong>if</strong> (e.target.files.length == 1 &amp;&amp;      <br>           e.target.files[0].type.indexOf("image/") == 0<br>       ){<br><strong>$</strong>('#img').attr(<br>             'src',<br><strong>URL</strong>.createObjectURL(e.target.files[0])<br>           )<br>       }<br>   })<br>})</pre>
<h4>Получаем видео из браузера в iOS</h4>
<p>Разрешаем загружать только видео:</p>
<pre>&lt;<strong>input</strong> <strong>type</strong>="file" <strong>accept</strong>="video/*" <strong>capture</strong>="camcorder"&gt;</pre>
<p>В случае, если не задавать атрибут capture, вам будет предложены все варианты получения медиаконтента: от камеры до фотопотока.</p>
<figure>
<p><img data-width="640" data-height="1136" src="https://cdn-images-1.medium.com/max/800/1*009RmriZVk85l_S4LEgcQw.jpeg"><br />
</figure>
<h3>Демо</h3>
<p><a href="http://ios.majorov.su/" target="_blank" rel="noopener noreferrer">http://ios.majorov.su/</a></p>
<figure>
<p><img data-width="330" data-height="330" src="https://cdn-images-1.medium.com/max/800/1*OdXihMUf3-vJUr6_e5NSHQ.png"><br />
</figure>
<hr>
<h3>getUserMedia в iOS</h3>
<p>К сожалению на сегодня (конец 2016 года) в Safari (да и в любом браузере на iOS) невозможно получить доступ видеопотоку. Если вы знаете как это сделать, то напишите в комментариях. Мне будет очень интересно.</p>
<!--kg-card-end: html-->


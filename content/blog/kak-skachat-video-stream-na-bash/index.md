---
title: "Как скачать видеострим на Bash"
date: "2019-12-06T17:32:05.00Z"
description: "Download and combine m3u *.ts to .mp4 Бывает такое: была запись в приватном канале (допустим семинар). Затем тебе же открывают д"
---

<h4>Download and combine m3u *.ts to .mp4</h4>
<p>Бывает такое: была запись в приватном канале (допустим семинар). Затем тебе же открывают доступ к прошедшему стриму (допустим это твое выступление). Хочется сохранить для истории для себя видео, но скачать никак не получится какими-то готовыми расширениями или сервисами (все под паролем + защита от дурака и вот это все…).</p>
<p>Недавно была похожая задача. Для себя хотел сохранить свое выступление. И так, что делаем, пошаговая инструкция.</p>
<h3>Настраиваем wget</h3>
<p>Если есть авторизация и проверка по рефереру, то стоит заранее настроить <code>wget</code> и передать заголовки. Если заголовков много, то самый простой способ это создать <code>~/.wgetrc</code> файл и туда записать все нужные заголовки с куками и авторизацией. Например:</p>
<pre>cat ~/.wgetrc</pre>
<pre>header = Accept: */*<br>header = Cache-Control: no-cache<br>header = Host: *****.ru<br>header = Origin: <a href="http://mbox.sbtg.ru" target="_blank" rel="noopener noreferrer">https://******.ru</a><br>header = Referer: <a href="http://mbox.sbtg.ru/habr8/a.aspx" target="_blank" rel="noopener noreferrer">http://*****.ru/some/path</a><br>header = Accept-Encoding: gzip, deflate<br>header = User-Agent: Mozilla/5.0(Intel MacOSX)AppleWebKit/537.36<br>...</pre>
<h3>Находим файл m3u</h3>
<p>Далее открываем developer tools в браузере и ищем во вкладке сетевой активности файл .m3u</p>
<p>Открываете и видите там что-то похожее:</p>
<pre>EXTM3U<br><em>#EXT-X-VERSION:3<br>#EXT-X-MEDIA-SEQUENCE:0<br>#EXT-X-TARGETDURATION:6<br>#EXT-X-DISCONTINUITY<br>#EXTINF:6.000,<br></em>0.ts<br><em>#EXTINF:6.000,<br></em>1.ts<br><em>#EXTINF:6.000,<br></em>...<br><em>#EXTINF:6.000,<br></em>4315.ts<br><em>#EXTINF:1.805,<br></em>4316.ts</pre>
<p>Собственно нужно получить последнее число, в моем примере это 4316.ts</p>
<p>Далее скачиваем все файлы .ts куда-нибудь в директорию:</p>
<pre>URL="https://someurl/path/"</pre>
<pre><strong>wget</strong> $URL'/'{0..4316}.ts</pre>
<p>Если вдруг выдает ошибку что очень длинная строка аргумента, разбейте на несколько пачек ваш запрос:</p>
<pre>wget $URL'/'{0..1315}.ts<br>wget $URL'/'{1316..2315}.ts<br>wget $URL'/'{2316..3315}.ts<br>wget $URL'/'{3316..4315}.ts</pre>
<p>После того как вы скачали все файлы, вы получили кучу микро фильмов. Вам надо их как-то склеить. Самый простой способ склеить — это просто слить все в один файл:</p>
<pre><strong>echo</strong> {0..4315}.ts | tr <strong>" " "n" </strong><em>&gt; tslist<br></em><strong>echo</strong> -n <strong>'' </strong><em>&gt; video.mp4<br></em><strong>while </strong>read line<br><strong>do<br></strong>echo <strong>"cat </strong>$line<strong> &gt;&gt; video.mp4"<br></strong><em>cat $line &gt;&gt; video.mp4<br></em><strong>done </strong><em>&lt; tslist</em></pre>
<p>Это вариант очень простой, но есть но! Такой файл сможет прочитать, например, VLC Player, но не сможет QuickTime. Если нужно чтобы это был валидный mp4 формат, то переименовываем наш video.mp4 в video.ts и далее пропускаем его через ffmpeg:</p>
<pre><strong>mv</strong> video.mp4 video.ts</pre>
<pre><code><strong>ffmpeg</strong> -i video.ts -acodec copy -vcodec copy video.mp4</code></pre>
<p>И вот это уже нормальный валидный mp4 файл, который читается нормально видеоплеерами.</p>
<p>Если вы готовите видео для YouTube, то вы можете не перекодировать и загрузить сразу video.ts вариант — ютубчик сам все распарсит и сконвертирует.</p>
<p>Такой вот нехитрый способ скачать запись видео стрима и превратить его в mp4 файл.</p>
<p>Если вы знаете как улучшить этот пример, напишите, пожалуйста, в комментарии.</p>
<h3>UPD</h3>
<p>После прочтения мне предложили такой вариант:</p>
<pre><strong>ffmpeg</strong> -i "https://path/2/list.m3u" -c copy -bsf:a aac_adtstoasc "out.mp4"</pre>
<p>FFMpeg вроде как умеет конвертировать списки m3u, но есть но для моей задачи. В моем случае файлы m3u и *.ts были не только под паролем, но и с защитой в виде проверки кук и реферера. Так что в моем варианте всеравно нужно было скачать сначала все файлы, а уже потом их конвертировать. Но если у вас есть прямой доступ, то можно так не заморачиваться и сделать все проще.</p>



---
title: "Быстро проверить работу FastCGI"
date: "2016-01-09T18:27:54.00Z"
description: "Подключиться к PHP-FPM напрямую При работе с docker контейнерами, в частности при настройке PHP/HHVM, бывает потребность в быстр"
---

<h3 id="-php-fpm-">Подключиться к PHP-FPM напрямую</h3><p>При работе с docker контейнерами, в частности при настройке PHP/HHVM, бывает потребность в быстрой проверке доступности поднятого php или hhvm. Для этих целей есть хороший инструмент: <strong>cgi-fcgi .</strong></p>
<h4>Установка</h4>
<p>В RHEL/CentOS он ставится легко и просто следующей командой:</p>
<pre>yum --enablerepo=epel install fcgi</pre>
<p>В Ubuntu название инструмента и синтаксис для установки немного другой:</p>
<pre>apt-get install libfcgi0ldbl</pre>
<h4>Проверяем PHP-FPM / HHVM</h4>
<p>Проверить работоспособность php-fpm или hhvm очень просто:</p>
<pre>cgi-fcgi -bind -connect 127.0.0.1:9000</pre>
<p>При необходимости (если вдруг настройки для пинга изменены через файл конфигурации) можно задавать параметры через переменные окружения:</p>
<pre>SCRIPT_NAME=/ping <br>SCRIPT_FILENAME=/ping <br>REQUEST_METHOD=GET <br>cgi-fcgi -bind -connect 127.0.0.1:9000</pre>
<p>На выходе получим такой ответ:</p>
<pre>Content-Type: text/plain<br>Expires: Thu, 01 Jan 1970 00:00:00 GMT<br>Cache-Control: no-cache, no-store, must-revalidate, max-age=0<br>pong</pre>
<p>Таким образом можно так же проверять страницу статуса или какой-то произвольный URL, хотя для этих целей можно использовать так же wget, curl, telnet…</p>
<hr>
<h4>Ссылки по теме</h4>

- <a href="https://www.thatsgeeky.com/2012/02/directly-connecting-to-php-fpm/">Directly connecting to PHP-FPM</a> <br/>



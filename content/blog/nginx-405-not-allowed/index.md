---
title: "Nginx 405 Not Allowed"
date: "2016-12-06T10:14:32.00Z"
description: "POST файла на сервер с PHP Nginx выдает ошибку 405 Not Allowed, если для доступа к файлам используется POST, который запрещен дл"
---

<h4>POST файла на сервер с PHP</h4>
<p>Nginx выдает ошибку 405 Not Allowed, если для доступа к файлам используется POST, который запрещен для доступа к статическим файлам. Можно заставить веб-сервер думать, что все хорошо, просто перенаправляя ошибку дальше:</p>
<pre>server {<br>     listen       80;<br>     server_name  ...;</pre>
<pre>     index  index.html index.htm;<br><br>     location / {<br>         #...<br>     }</pre>
<pre>     error_page  404     /404.html;<br>     error_page  403     /403.html;<br><strong>error_page  405     =200 $uri;</strong></pre>
<pre>     # ...<br>}</pre>
<p>Если в Nginx используется модуль fastcgi, то в некоторых случаях веб-сервер может некорректно воспринимать скрипты, которые вызываются методом POST. Для этого запрашиваемый URL разбивается на адрес самого скрипта и запрашиваемых параметров:</p>
<pre>location ~.php(.*) {<br> fastcgi_pass 127.0.0.1:9000;<br><strong>fastcgi_split_path_info ^(.+.php)(.*)$;<br></strong>fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;<br><strong>fastcgi_param PATH_INFO $fastcgi_path_info;<br></strong>fastcgi_param PATH_TRANSLATED <strong>$document_root$fastcgi_path_info;<br> include /etc/nginx/fastcgi_params;<br></strong>}</pre>
<p>Но и этот вариант мне не помог.</p>
<h4>Финальное решение, которое заработало</h4>
<pre><strong>error_page 405 =200 @405</strong>;<br><br>location <strong>@405</strong> {<br>    include <strong>fastcgi.conf</strong>;<br>}<br><br>location ~ .php(.*) {<br>    fastcgi_split_path_info ^(.+.php)(.*)$;<br>    include <strong>fastcgi.conf;</strong><br>}</pre>
<p>В случае 405 ошибки проксируем все на FastCGI сервер и там уже решаем что делать.</p>
<p>Если знаете как сделать лучше — напишите в комментариях, пожалуйста.</p>
<h4>UPD</h4>
<p>Так же такая ошибка возникает в случаях, если вы пытаетесь отправить большой файл, больше чем указано в лимитах PHP конфига.</p>



---
title: "Быстро проверить работу FastCGI"
date: "2016-01-09T18:27:54.00Z"
description: "Подключиться к PHP-FPM напрямую При работе с docker контейнерами, в частности при настройке PHP/HHVM, бывает потребность в быстр"
---

<h3 id="-php-fpm-">Подключиться к PHP-FPM напрямую</h3><!--kg-card-begin: html--><p>При работе с docker контейнерами, в частности при настройке PHP/HHVM, бывает потребность в быстрой проверке доступности поднятого php или hhvm. Для этих целей есть хороший инструмент: <strong>cgi-fcgi .</strong></p>
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

<!--kg-card-end: html--><figure class="kg-card kg-embed-card"><blockquote class="wp-embedded-content"><a href="https://www.thatsgeeky.com/2012/02/directly-connecting-to-php-fpm/">Directly connecting to PHP-FPM</a></blockquote>
<script type='text/javascript'>
<!--//--><![CDATA[//><!--
		!function(a,b){"use strict";function c(){if(!e){e=!0;var a,c,d,f,g=-1!==navigator.appVersion.indexOf("MSIE 10"),h=!!navigator.userAgent.match(/Trident.*rv:11\./),i=b.querySelectorAll("iframe.wp-embedded-content");for(c=0;c<i.length;c++){if(d=i[c],!d.getAttribute("data-secret"))f=Math.random().toString(36).substr(2,10),d.src+="#?secret="+f,d.setAttribute("data-secret",f);if(g||h)a=d.cloneNode(!0),a.removeAttribute("security"),d.parentNode.replaceChild(a,d)}}}var d=!1,e=!1;if(b.querySelector)if(a.addEventListener)d=!0;if(a.wp=a.wp||{},!a.wp.receiveEmbedMessage)if(a.wp.receiveEmbedMessage=function(c){var d=c.data;if(d)if(d.secret||d.message||d.value)if(!/[^a-zA-Z0-9]/.test(d.secret)){var e,f,g,h,i,j=b.querySelectorAll('iframe[data-secret="'+d.secret+'"]'),k=b.querySelectorAll('blockquote[data-secret="'+d.secret+'"]');for(e=0;e<k.length;e++)k[e].style.display="none";for(e=0;e<j.length;e++)if(f=j[e],c.source===f.contentWindow){if(f.removeAttribute("style"),"height"===d.message){if(g=parseInt(d.value,10),g>1e3)g=1e3;else if(~~g<200)g=200;f.height=g}if("link"===d.message)if(h=b.createElement("a"),i=b.createElement("a"),h.href=f.getAttribute("src"),i.href=d.value,i.host===h.host)if(b.activeElement===f)a.top.location.href=d.value}else;}},d)a.addEventListener("message",a.wp.receiveEmbedMessage,!1),b.addEventListener("DOMContentLoaded",c,!1),a.addEventListener("load",c,!1)}(window,document);
//--><!]]>
</script><iframe sandbox="allow-scripts" security="restricted" src="https://www.thatsgeeky.com/2012/02/directly-connecting-to-php-fpm/embed/" width="600" height="338" title="&#8220;Directly connecting to PHP-FPM&#8221; &#8212; That&#039;s Geeky" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" class="wp-embedded-content"></iframe></figure>


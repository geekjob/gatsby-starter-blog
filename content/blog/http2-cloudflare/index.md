---
title: "Как легко и без SMS получить и настроить HTTPS / HTTP/2"
date: "2018-02-09T21:12:16.00Z"
description: "Каждый web-разработчик в 2018 году уже должен уметь и знать    Начиная с июля 2018 года пользователи Chrome будут получать преду"
---

<!--kg-card-begin: html--><h4>Каждый web-разработчик в 2018 году уже должен уметь и знать</h4>
<figure>
<p><img data-width="1520" data-height="550" src="https://cdn-images-1.medium.com/max/2560/1*5J6ULfBAvgLF8PBM4B__Qw.jpeg"><br />
</figure>
<p>Начиная с июля 2018 года пользователи Chrome будут получать предупреждения о небезопасности посещения сайтов по протоколу HTTP.</p>
<figure class="wp-caption">
<p><img data-width="640" data-height="231" src="https://cdn-images-1.medium.com/max/800/1*odObSnd6UegqkbYygAgLXw.png"><figcaption class="wp-caption-text">пока еще лайтово</figcaption></figure>
<p>Пруф:</p>
<p><a href="https://security.googleblog.com/2018/02/a-secure-web-is-here-to-stay.html">https://security.googleblog.com/2018/02/a-secure-web-is-here-to-stay.html</a></p>
<p>Если вы еще не используете защищенное соединение HTTPS и HTTP/2, то советую научиться делать это сейчас. <strong>Умение работать с HTTPS и что такое HTTP/2 уже спрашивают даже на собеседованиях.</strong></p>
<h3>Как легко и быстро получить и настроить HTTPS / HTTP2</h3>
<h4>Автоматическое получение SSL сертификатов</h4>
<p>Вся сложность всегда заключалась в сертификатах и в том, что они стоили денег. На сегодня есть проект <a href="https://letsencrypt.org/" target="_blank" rel="noopener noreferrer">Lets Encrypt</a> (<a href="https://letsencrypt.org/" target="_blank" rel="noopener noreferrer">https://letsencrypt.org/</a>) и вам не составит труда получить сертификат и прописать его в ваш сервер (будь то Apache, Nginx или даже Node.js сервер). Просто море информации как это сделать.</p>
<p>Мелкие трудности — это необходимость продлевать сертификат каждые 3 месяца. Но тут можно использовать разные сборки Docker контейнеров (если вы фронтендер и все еще не пользуетесь Docker — советую так же освоить ибо эта штука очень облегчает работу и деплой на продакшен, особенно Nodejs приложений).</p>
<p>Например я для своих нужд создал 2 варианта Docker с Nginx на борту и с возможностью автовыписки сертификатов:</p>
<p><a href="https://security.googleblog.com/2018/02/a-secure-web-is-here-to-stay.html">https://security.googleblog.com/2018/02/a-secure-web-is-here-to-stay.html</a><br />
<a href="https://security.googleblog.com/2018/02/a-secure-web-is-here-to-stay.html">https://security.googleblog.com/2018/02/a-secure-web-is-here-to-stay.html</a></p>
<p>Разница между ними в том, что один из них собран еще и с модулем <a href="https://developers.google.com/speed/pagespeed/module/" target="_blank" rel="noopener noreferrer">Google Page Speed</a>, который автоматически сжимает картинки, минифицирует код скриптов, добавляет lazy loading и так далее…</p>
<p>Чуть больше инфы про эти докер контейнеры я писал уже ранее</p>
<p><a href="https://security.googleblog.com/2018/02/a-secure-web-is-here-to-stay.html">https://security.googleblog.com/2018/02/a-secure-web-is-here-to-stay.html</a></p>
<p>Но есть способ еще проще, если вы не хотите заморачиваться с Docker и настройкой сервера.</p>
<h3>Автополучение сертификатов через Cloudflare</h3>
<p>Cloudflare — это DNS хостинг. У него очень много интересных фишек для маленьких проектов с запросами энтерпрайз уровня. Что идет из коробки: Round-Robin, поддержка HTTP/2 и Push’ей, автоматические сертификаты с автопродлением и многое другое. Вот сертификаты нам сейчас и нужны. Про остальное расскажу в следующий раз.</p>
<p>Собственно вся суть настройки сводится к тому, что вы просто прописываете у своего регистратора домена DNS от Cloudflare и все. Далее уже управляете DNS записями в админке Cloudflare. Он сам выпишет вам сертификаты и сам их продлит. Изи, изи! Риал ток!</p>
<figure class="wp-caption">
<p><img data-width="2170" data-height="1016" src="https://cdn-images-1.medium.com/max/800/1*S8RWqMFVYqrcCmctkFTmeA.png"><figcaption class="wp-caption-text">Добавляем записи DNS и указываем что нужно использовать проксирование</figcaption></figure>
<figure class="wp-caption">
<p><img data-width="1990" data-height="956" src="https://cdn-images-1.medium.com/max/800/1*ltBW-P9QRqnr5bjwoJRRgQ.png"><figcaption class="wp-caption-text">В разделе Crypto в секции SSL выставляем тип Flexible</figcaption></figure>
<p>В таком случае Cloudflare — это прокси балансировшик, который пропускает трафик через свои серверы и передает уже вам. У себя на сервере вы поднимаете HTTP сервер без SSL. А чтобы пользователи всегда использовали SSL соединение, можно указать опцию Always use HTTPS</p>
<figure class="wp-caption">
<p><img data-width="1976" data-height="262" src="https://cdn-images-1.medium.com/max/800/1*Oob1-4gyTpxEBXQCEW95sA.png"><figcaption class="wp-caption-text">Теперь все запросы на HTTP будут редиректиться на HTTPS</figcaption></figure>
<p>Так что в 2018 году будь то фронтендер или бекендер — не важно. Важно что начать использовать HTTPS и HTTP/2 стало проще простого, можно даже самому не заморачиваться с сертификатами.</p>
<!--kg-card-end: html-->


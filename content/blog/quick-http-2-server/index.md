---
title: "HTTP/2 сервер за минуту"
date: "2017-10-12T12:57:14.000Z"
description: "С автоматическим выписыванием SSL и PageSpeed
Привет! У меня бывают периодически ситуации, где нужно с нуля быстро понднять
новы"
---

<h4>С автоматическим выписыванием SSL и PageSpeed</h4>
<p>Привет! У меня бывают периодически ситуации, где нужно с нуля быстро понднять новый сервер и задеплоить на него какое-то приложение (лендинг, MVP, прочее). Для этих целей использую облачные VDS , которые поднимаются за минуту. Но далее начинается типичный этап настройки.</p>
<p>И вот однажды надоело мне повторять рутину и я сделал простой Docker контейнер, который умеет автоматически получать сертификаты от Let’s Encrypt и даже автоматически продлевать их.</p>
<p>Готовый докер можно взять с <a href="https://hub.docker.com/r/newhr/http2-server/" target="_blank" rel="noopener noreferrer">https://hub.docker.com/r/newhr/http2-server/</a></p>
<h4>Как все это работает</h4>
<p>Лучше всего скачать с гитхаба репу</p>
<p><a href="https://github.com/NewHR/http2-server">https://github.com/NewHR/http2-server</a></p>
<p>и сконфигурировать только файл <a href="https://github.com/NewHR/http2-server/blob/master/docker-compose.yml" target="_blank" rel="noopener noreferrer">https://github.com/NewHR/http2-server/blob/master/docker-compose.yml</a></p>
<p>В нем прописываете параметры</p>
<pre>volumes:<br>            - ./etc/nginx:/etc/nginx<br>            - ./etc/letsencrypt:/etc/letsencrypt<br>            - ./pagespeed:/var/pagespeed<br>            - /www/sites:/www/sites<br>            - /var/log:/var/log</pre>
<pre>environment:<br>            - TIMEZONE=Europe/Moscow<br>            - LETSENCRYPT=false<br>            - LE_EMAIL=ваш@mail<br>            - LE_RT=70d время обновления сертификата</pre>
<h4>Как прописываются домены?</h4>
<p>Доменное имя пишется в имени nginx конфига в директории services</p>
<p>В конфиге используются плейсхолдеры (нетрудно догадаться что и как). Допустим, у меня есть домен new.hr, vacancy.new.hr и так далее…</p>
<p>Я создаю следующие файлы</p>
<pre>{http2-server-dir}/etc/nginx/services<br>   - new.hr.conf<br>   - vacancy.new.hr.conf</pre>
<p>Докер образ при запуске распарсит эти файлы, извлечет имена доменов, получит для них сертификаты и подставит внутри конфигов нужные параметры. Вы можете брать за основу конфиг файлы, которые уже идут в репозитории для примера</p>
<h3>Добавляем Google PageSpeed module</h3>
<p>Если вы планируете использовать этот докер для лендингов со статикой, то советую вариант докер контейнера Hipster Server</p>
<p><a href="https://github.com/NewHR/http2-server">https://github.com/NewHR/http2-server</a></p>
<p>Работает так же, как и предыдущий, но внутри собран модуль Google Page Speed, который делает автоматическую оптимизацию сайта, что повышает его скорринг и положительно влияет на SEO параметры и скорость загрузки сайта в целом.</p>
<p><em>Изи, изи! Итс риал ток! =)</em></p>
<p>П.С.: По всем вопросам, пишите, присылайте пулреквесты…</p>



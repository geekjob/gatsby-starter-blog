---
title: "Ghost Blog, Nginx, HTTPS и бесконечный редирект"
date: "2018-05-04T01:09:07.000Z"
description: "Зарисовки DevOps
Нашел противный баг в блоге Ghost [https://ghost.org/ru/], который я запускаю
прямо из официального докер конте"
---

<h4>Зарисовки DevOps</h4>
<p>Нашел противный баг в блоге <a href="https://ghost.org/ru/" target="_blank" rel="noopener noreferrer">Ghost</a>, который я запускаю прямо из <a href="https://hub.docker.com/_/ghost/" target="_blank" rel="noopener noreferrer">официального докер контейнера</a>. На этом движке крутится наш корпоративный блог.</p>
<p>Суть баги: в конфиге докер контейнера прописываете ссылку на блог с HTTPS (<em>у нас же 2k18 и сейчас без https и http/2 живет только ленивый</em>):</p>
<pre><em>#docker-compose.yml</em></pre>
<pre>ghost:<br>    image: ghost:latest<br>    container_name: blog<br>    restart: always<br><em>    </em>ports:<br>        - ...<br>    environment:<br>          ...<br><strong>        url      : https://blog.newhr.ru</strong><br>        NODE_ENV : production<br>    volumes:<br>          ...</pre>
<p>Запускаете и получаете бесконечные редиректы 301. Если же меняете url на ссылку с http, то все работает. Где там внутри кода проблемы — вот чес. слово, нет времени разбираться. Фиксится это все на уровне конфигов (хе хей, devops way).</p>
<p>В качестве веб-сервера у меня используется Nginx. В конфиге для блога прописываем следующий хак:</p>
<pre>server {<br>    listen 80;<br>    listen [::]:80;<br>    server_name blog.newhr.ru;<br>    ...<br>    location / {<br><strong>...<br>        proxy_set_header X-Forwarded-Proto https; </strong><em>//вместо</em><strong><em> </em></strong><em>$scheme</em><strong><br></strong>        proxy_intercept_errors on;<br>        proxy_buffering off;<br>        ...<br>        proxy_pass http://127.0.0.1;<br>    }<br>}</pre>
<p>Жестко захардкодив передачу заголовка X-Forwarded-Proto все заработало корректно. Почему так происходит — можно догадаться, но вот лезть в код и фиксить его совершенно нет времени.</p>
<p>Кто пофиксит багу и запушит пулреквест, тот сделает кармически правильный поступок ?</p>
<p>Если знаете как это можно пофиксить другими способами — всегда рад услышать альтернативное мнение.</p>



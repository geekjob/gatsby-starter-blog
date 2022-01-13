---
title: "Composer, Laravel5/Lumen, Cloud и RAM"
date: "2018-08-29T19:24:47.00Z"
description: "Проблемы на пустом месте Есть у меня небольшой инстанс в облаке. 1Гб ОЗУ, диск на 40Гб. Чисто для экспериментов всяких. Недорого"
---

<!--kg-card-begin: html--><h4>Проблемы на пустом месте</h4>
<p>Есть у меня небольшой инстанс в облаке. 1Гб ОЗУ, диск на 40Гб. Чисто для экспериментов всяких. Недорого. Несколько лет работает исправно, делаю всякие RnD на нем. И вот решил я попробовать что такое Laravel и Lumen. Ставлю — вроде бы ставится, но нет директории vendor и отсутствует файл автолоада.</p>
<p>Я и так и эдак, включил вербоз мод (-vvv) и стал дебажить. Думал может композер неверно стоит или не работает. Разное перепробовал. В итоге нашел, что где-то во время установки композер падает с ошибкой:</p>
<pre>proc_open(): fork failed — Cannot allocate memory</pre>
<p>Я не ожидал такого подвоха. Попробовал на своем ноуте с 8Гб ОЗУ — все ок. Оказывается композеру просто не хватает памяти. Если у вас такая же проблема, то выходы:</p>
<ul>
<li>собрать все на своем компьютере и залить файлы на нужный сервер</li>
<li>собрать все на другом более мощном инстансе и залить файлы на нужный сервер</li>
<li>создать файл подкачки</li>
</ul>
<h3>Создаем SWAP</h3>
<p>У меня CentOS7, но так же это справедливо для большинства Linux систем. На Ubuntu все тоже самое.</p>
<pre># Проверяем отсутствие свапфайла<br><strong>swapon -s</strong></pre>
<pre># Смотрим есть ли место и что с памятью<br><strong>free -m<br>df -h</strong></pre>
<pre># Выделяем своп<br><strong>fallocate -l 2G /swapfile<br>chmod 0600 /swapfile<br>mkswap /swapfile<br>swapon /swapfile</strong></pre>
<pre># Добавляем в автозагрузку<br><strong>mcedit /etc/fstab<br></strong><em>/swapfile none swap sw 0 0</em></pre>
<pre># Подкручиваем настройки<br><strong>sysctl vm.swappiness=10<br>sysctl vm.vfs_cache_pressure=50</strong></pre>
<pre><strong>mcedit /etc/sysctl.conf</strong><br><em>vm.swappiness=10<br>vm.vfs_cache_pressure = 50</em></pre>
<p>Вот как-то так решается проблема с композером и большими фреймворками. Для меня это было неожиданно.</p>
<h3>Ограничение памяти для PHP</h3>
<p>Еще один совет выглядит как запуск композера через PHP с ограничениями + ключи для композера:</p>
<pre>$ <strong>php</strong> -dmemory_limit=750M composer.phar update --no-scripts --prefer-dist<br>$ <strong>php</strong> artisan --dump-autoload</pre>
<p>Не пробовал, так как проблему решил через файл подкачки. А в итоге для более комфортной работы просто увеличил память на сервере, благо это облака и все можно сделать одним кликом. Стало чуть дороже, но зато комфортнее.</p>
<hr>
<p>Лайк, хлопок, шер. Слушайте меня в <a href="https://itunes.apple.com/ru/podcast/pro-web-it/id1366662242?mt=2" target="_blank" rel="noopener noreferrer">iTunes</a>, подписывайтесь на <a href="https://t.me/prowebit" target="_blank" rel="noopener noreferrer">Телеграм</a> канал или <a href="https://vk.com/mayorovprowebit" target="_blank" rel="noopener noreferrer">Вконтакте</a>.</p>
<!--kg-card-end: html-->


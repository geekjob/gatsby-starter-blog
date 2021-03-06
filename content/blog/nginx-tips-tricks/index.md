---
title: "Nginx tips & tricks"
date: "2018-02-26T18:03:16.00Z"
description: "Выгружаем конфиг из памяти    У Nginx есть 2 полезных ключа:   * -t  * -T  Первый ключ позволяет протестировать на корректность "
---

<!--kg-card-begin: html--><h4>Выгружаем конфиг из памяти</h4>
<figure>
<p><img data-width="1024" data-height="574" src="https://cdn-images-1.medium.com/max/800/1*1GTyynSi7TZNnMovAD3IWg.jpeg"><br />
</figure>
<p>У Nginx есть 2 полезных ключа:</p>
<ul>
<li>-t</li>
<li>-T</li>
</ul>
<p>Первый ключ позволяет протестировать на корректность подключаемый конфиг. Это полезно, если у вас автогенерация конфигов или еще какая автоматизация. Прежде чем сделать релоад, сначала выполнить nginx -t. Так что нормальный кейс для автоматизациии:</p>
<pre>nginx -t<br>nginx reload</pre>
<p>А вот может сложиться ситуация когда вам нужно сохранить конфиги в один файл, как их видит nginx. Для этих целей есть ключ -T:</p>
<pre>nginx -T &gt; dump.conf</pre>
<p>Но это не данные из памяти процесса. Это именно склейка конфигов — то, как их будет смотреть и парсить Nginx сервер.</p>
<h3>Как достать конфиги из памяти запущенного Nginx?</h3>
<p>Тут нам понадобятся gdb и какая-то магия в виде умения запустить нужные команды:</p>
<pre><code># Узнаем PID процесса<br><strong>ps ax | grep nginx</strong><br></code>10063 pts/1    S+     0:00 grep --color=auto nginx<br><strong>12467</strong> ?        Ss     0:00 nginx: master process /usr/sbin/nginx -c /etc/nginx/nginx.conf<br>12469 ?        S      0:42 nginx: worker process</pre>
<pre><code># Сохраняем PID для удобства<br><strong>pid=</strong></code><strong>12467</strong><code><br><br># Генерируем gdb команды<br><strong>cat /proc/$pid/maps | awk '$6 !~ "^/" {split ($1,addrs,"-"); print "dump memory mem_" addrs[1] " 0x" addrs[1] " 0x" addrs[2] ;}END{print "quit"}' &gt; gdbcmds<br><br></strong># Запускаем gdb с флагом -x чтобы сдампить участки памяти в файлы с префиксом mem_*<br><strong>gdb -p $pid -x gdbcmds</strong><br><br># Ищем нужные куски nginx.conf в файлах<br><strong>grep server_name mem_*</strong></code></pre>
<p>Да, придется потратить время, чтобы все собрать и склеить, но если вдруг вы потеряли все конфиги и у вас есть только запущенный рабочий сервер — то это может быть единственным способом сохранить конфигурационные файлы.</p>
<!--kg-card-end: html-->


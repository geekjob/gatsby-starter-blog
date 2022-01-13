---
title: "Прописать Nodejs сервис в автозагрузку"
date: "2016-09-28T13:59:29.00Z"
description: "На CentOS 7 на примере приватного NPM реестра Sinopia На проекте используем Sinopia в качестве приватного NPM реестра. Появилась"
---

<!--kg-card-begin: html--><h4>На CentOS 7 на примере приватного NPM реестра Sinopia</h4>
<p>На проекте используем Sinopia в качестве приватного NPM реестра. Появилась необходимость прописать его в автозагрузку. Самый очевидный способ — оформить его как сервис.</p>
<p>У меня написан небольшой скрипт для запуска и перезапуска <strong>sinopia.sh</strong>.</p>
<pre>#!/usr/bin/env bash</pre>
<pre>wdir=/path/2/sinopia</pre>
<pre>case "$1" in<br>  "start")<br>    $0 stop<br>    nohup $wdir/sinopia-loop.sh &amp;<br>    ps ax | grep sinopia<br>    ;;<br>  "stop")<br>    killall sinopia-loop.sh<br>    kill $(cat ./sinopia.pid)<br>    killall sinopia<br>    ps ax | grep sinopia<br>    echo &gt; sinopia.pid<br>  ;;<br>  "restart")<br>    $0 stop<br>    $0 start<br>  ;;<br>  *)<br>    echo "Usage: start|stop|restart"<br>  ;;<br>esac</pre>
<pre>#EOF#</pre>
<p>Файл <strong>sinopia-loop.sh</strong></p>
<pre>#!/bin/sh</pre>
<pre>OUTFILE=sinopia.out<br>ERRFILE=sinopia.err<br>CMD="/usr/local/bin/sinopia"</pre>
<pre>echo $$ &gt; sinopia.pid<br>echo &gt; $OUTFILE<br>echo &gt; $ERRFILE</pre>
<pre>while true<br>do<br>  echo &gt;&gt; $OUTFILE<br>  echo &gt;&gt; $ERRFILE<br>  date &gt;&gt; $OUTFILE<br>  date &gt;&gt; $ERRFILE<br>  echo "Starting $CMD" &gt;&gt; $OUTFILE<br>  echo "Starting $CMD" &gt;&gt; $ERRFILE<br>  #$CMD 1&gt;&gt;$OUTFILE 2&gt;&gt;$ERRFILE<br>  $CMD 1&gt;&gt;/dev/null 2&gt;&gt;$ERRFILE<br>done</pre>
<pre>#EOF#</pre>
<p>Теперь наш скрипт sinopia.sh перемещаем в</p>
<pre>ln -s sinopia.sh /etc/init.d/sinopia</pre>
<p>И далее прописываем следующим образом:</p>
<pre># chkconfig --add sinopia<br># chkconfig sinopia on</pre>
<p>Вам скажут что нельзя подключить так как не поддерживается chkconfig у данного сервиса. Все это правится легко и просто. Надо немного поменять наш /etc/init.d/sinopa</p>
<pre><strong>#!/bin/sh</strong><br>#<br># sinopia - this script starts and stops the sinopia daemon<br>#<br><strong># chkconfig:   - 85 15</strong><br>#</pre>
<p>И повторить операции. И вуаля, ваш сервис теперь стартует при перезапуске ОС. Да, мы не оформили наш скрипт сервиса по всем правилам, но, нам нужна и важна главная команда start. Все остальное мы будем делать в ручном режиме.</p>
<!--kg-card-end: html-->


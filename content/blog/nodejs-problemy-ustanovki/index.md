---
title: "Прорблемы установки Nodejs"
date: "2016-08-17T13:36:23.00Z"
description: "Последней версии в Docker на Centos В докере на Centos я ставлю последнюю версию Nodejs следующим образом:  RUN curl --silent --"
---

<!--kg-card-begin: html--><h4>Последней версии в Docker на Centos</h4>
<p>В докере на Centos я ставлю последнюю версию Nodejs следующим образом:</p>
<pre>RUN curl --silent --location "https://rpm.nodesource.com/setup_6.x" | bash - &amp;&amp; yum install -y nodejs</pre>
<p>Когда версия Nodejs обновилась (текущая 6.4.0), то модй Dockerfile перестал собираться, выдавая ошибку:</p>
<pre>Package nodejs-6.4.0–1nodesource.el7.centos.x86_64.rpm is not signed</pre>
<p>Почему-то RPM оказался без подписи. Обойти проблему можно, выключив проверку на подпись:</p>
<pre>yum install <strong>--nogpgcheck</strong> -y nodejs</pre>
<!--kg-card-end: html-->


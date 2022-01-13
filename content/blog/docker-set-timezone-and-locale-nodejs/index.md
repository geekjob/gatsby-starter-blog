---
title: "Docker: установка таймзоны и локали"
date: "2019-10-29T18:00:05.00Z"
description: "На примере Node.js Если вы собираете свой докер для Node.js, то позаботьтесь о настройке правильной локали и таймзоны. Если их н"
---

<h2 id="-node-js">На примере Node.js</h2><p>Если вы собираете свой докер для Node.js, то позаботьтесь о настройке правильной локали и таймзоны. Если их не настроить, то методы <code>toLocaleString()</code> будут работать не так, как вы ожидали, да и серверное время, в связи с этим, будет отличаться.</p><p>Когда я озаботился о настройке локали в докер образе, который я собирал на базе <a href="https://hub.docker.com/_/node/" rel="noopener noreferrer">официального Node:lts</a>, я столкнулся с тем, что это может быть не тривиальной задачей и придется посетить не один пост на SO, прежде чем найдете ответы, смиксуете их и все заработает как надо.</p><p>Вот мой финальный рецепт, который я использую:</p><pre><code class="language-bash">FROM node:lts

ENV TZ 'Europe/Moscow'
ENV LC_ALL ru_RU.UTF-8
ENV LANG ru_RU.UTF-8
ENV LANGUAGE ru_RU.UTF-8

RUN echo $TZ &gt; /etc/timezone
RUN apt-get update &amp;&amp; DEBIAN_FRONTEND=noninteractive \
      &amp;&amp; apt-get install -y locales tzdata systemd

RUN sed -i -e 's/# ru_RU.UTF-8 UTF-8/ru_RU.UTF-8 UTF-8/' /etc/locale.gen \
      &amp;&amp; dpkg-reconfigure --frontend=noninteractive locales \
      &amp;&amp; update-locale LANG=ru_RU.UTF-8

RUN echo "LANGUAGE=ru_RU.UTF-8" &gt;&gt; /etc/default/locale &amp;&amp; 
    echo "LC_ALL=ru_RU.UTF-8" &gt;&gt; /etc/default/locale

RUN rm /etc/localtime &amp;&amp; 
    ln -snf /usr/share/zoneinfo/$TZ /etc/localtime &amp;&amp; 
    dpkg-reconfigure -f noninteractive tzdata

RUN localedef -c -f UTF-8 -i ru_RU ru_RU.UTF-8
RUN apt-get clean
</code></pre>


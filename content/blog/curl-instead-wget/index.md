---
title: "Curl вместо Wget"
date: "2018-04-28T16:19:18.000Z"
description: "В докер контейнерах
Часто в докер контейнерах встречается такой способ скачивания файлов:


RUN yum -y update &&
    yum install"
---

<h4 id="-">В докер контейнерах</h4><p>Часто в докер контейнерах встречается такой способ скачивания файлов:</p><pre><code class="language-bash">
RUN yum -y update &amp;&amp;
    yum install -y wget &amp;&amp;
wget "http://rpms.famillecollet.com/enterprise/remi-release-7.rpm" &amp;&amp;
    ...</code></pre><p>Встает вопрос, зачем ставить лишний инструмент? Wget легко и просто можно заменить идущим из коробки curl’ом (ну не всегда идущим, но шанс того, что он есть выше чем у того же wget).</p><p>То что написано выше можно заменить следующей строкой:</p><pre><code class="language-bash">
RUN curl -O "http://rpms.famillecollet.com/enterprise/remi-release-7.rpm" &amp;&amp;
    ...</code></pre><p>Ну а если вы работаете в системе где нет wget, но , по каким-то причинам, вам нужен wget, вы можете создать себе такой алиас (как вариант):</p><pre><code class="language-bash">
echo 'alias wget="curl -O"' &gt;&gt; ~/.bash_profile

wget "http://rpms.famillecollet.com/enterprise/remi-release-7.rpm"
</code></pre><p></p>


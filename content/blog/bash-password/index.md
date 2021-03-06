---
title: "Добавить пользователя и сменить пароль через скрипт"
date: "2018-04-21T20:03:29.00Z"
description: "DevOps зарисовки Задача: есть докер с некоторым сервисом. Нужно динамически добавлять и удалять пользователей внутри контейнера "
---

<!--kg-card-begin: html--><h4>DevOps зарисовки</h4>
<p>Задача: есть докер с некоторым сервисом. Нужно динамически добавлять и удалять пользователей внутри контейнера через скрипт. При этом иметь скрипт инициализации на случай деплоя с нуля.</p>
<p>Решение: нужно через bash, а даже через sh (в alpine по дефолту не установлен bash) уметь добавлять пользователей.</p>
<p>Варианты:</p>
<pre><code>PASSWD="somepassword" ; echo -e "$PASSWDn$PASSWD" <br>    |docker exec -i container passwd</code></pre>
<p>Еще предлагают варианты добавить флаг</p>
<pre><code>passwd </code><strong>--stdin</strong></pre>
<p>У меня такой вариант не сработал. Т.е. скрипт отрабатывает, но пароль в итоге не выставился нужный. Какой был установлен — не понял. Мой финальный вариант с добавлением пользователя и сменой пароля выглядит так:</p>
<pre><strong>#!/bin/sh</strong></pre>
<pre>PASS='job'; <strong>echo</strong> -e "<em>$PASS</em>n<em>$PASS</em>" <br>   |<strong>docker</strong><em> </em>exec -i container <strong>adduser</strong> geek</pre>
<pre><strong>echo</strong> "geek:<em>$PASS</em>" |<strong>docker</strong><em> </em>exec -i container <strong>chpasswd</strong></pre>
<p>Такой скрипт сработал. Он добавляет пользователя и устанавливает ему пароль. Судя по всему в первом проходе при добавлении пользователя пароль “бьется” или вовсе не передается на вход, но при этом мы обходим интерактивность (так как adduser просит задать пароль в интерактивном режиме).</p>
<p>Если знаете как сделать лучше — напишите в комментарии, пожалуйста. А я пока заюзал такой вариант и он решает мои задачи.</p>
<h3>UPD</h3>
<p>Посоветовали одну репу, в которой есть примеры скриптов для работы с пользователями внутри докера: <a href="https://github.com/schors/tgdante2/tree/master/dante/files/scripts" target="_blank" rel="noopener noreferrer">https://github.com/schors/tgdante2/tree/master/dante/files/scripts</a></p>
<!--kg-card-end: html-->


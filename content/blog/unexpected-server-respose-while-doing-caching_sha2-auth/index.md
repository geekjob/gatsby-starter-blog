---
title: "Unexpected server respose while doing caching_sha2 auth"
date: "2018-09-12T23:54:50.00Z"
description: "PHP 7.2.8 Очередные заметки на полях, вдруг кому-то пригодится. Если вы столкнулись с ошибкой:  > Fatal error: Uncaught PDOExcep"
---

<h4>PHP 7.2.8</h4>
<p>Очередные заметки на полях, вдруг кому-то пригодится. Если вы столкнулись с ошибкой:</p>
<blockquote><p>Fatal error: Uncaught PDOException: PDO::__construct(): Unexpected server respose while doing caching_sha2 auth: 109 in &#8230;</p></blockquote>
<p>Кстати да, в самом тексте тоже ошибка, слово response написано без буквы n — ошибка в ошибке, так сказать.</p>
<p>Так вот, если вы встретились с такой ошибкой, то чинится это таким вот вариантом:</p>
<pre>ALTER USER 'root'@'localhost' IDENTIFIED WITH caching_sha2_password BY 'your password';</pre>
<pre>ALTER USER 'root'@'%' IDENTIFIED WITH caching_sha2_password BY 'your password';</pre>
<p>Но при таком раскладе получается что вы закрываете доступ к тому же MySQL Workbench, который будет ругаться ошибкой:</p>
<blockquote><p>
<strong>Cannot Connect to Database Server<br /></strong>Your connection attempt failed for user &#8216;user&#8217; from your host to server at 1хх.ххх.ххх.хх9:3306:</p></blockquote>
<blockquote><p>Authentication plugin &#8216;caching_sha2_password&#8217; cannot be loaded: dlopen(/usr/local/mysql/lib/plugin/caching_sha2_password.so, 2): image not found</p></blockquote>
<p>Я вышел из ситуации создав отдельно пользователя для скриптов и отдельно пользователя для доступа через СУБД.</p>
<pre><strong>ALTER</strong> <strong>USER</strong> 'user'@'%' <strong>IDENTIFIED</strong> <strong>WITH</strong> <strong><em>mysql_native_password</em></strong> <strong>BY</strong> 'password';</pre>
<pre><strong>CREATE</strong> <strong>USER</strong> 'user'@'1xx.xxx.xxx.xx7' <strong>IDENTIFIED</strong> <strong>BY</strong> 'password';<br><strong>GRANT</strong> <strong>ALL</strong> <strong>PRIVILEGES</strong> <strong>ON</strong> *.* <strong>TO</strong> 'user'@'1xx.xxx.xxx.xx7';</pre>
<pre><strong>ALTER</strong> <strong>USER</strong> 'user'@'1xx.xxx.xxx.xx7' <strong>IDENTIFIED</strong> <strong>WITH</strong> <strong><em>caching_sha2_password</em></strong> <strong>BY</strong> 'password';</pre>
<pre><strong>FLUSH</strong> <strong>PRIVILEGES</strong>;</pre>
<p>Понятное дело что для безопасности не все привелегии выдаются, чисто из экономии кода. Главное понятен смысл. Для воркбенча используется mysql_native_password, для PDO используется caching_sha2_password.</p>
<p>Вот как-то так.</p>
<p>Если знаете способы лучше — напишите в комментарии, пожалуйста.</p>



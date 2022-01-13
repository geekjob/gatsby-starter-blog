---
title: "Recovery password MySQL 8.0"
date: "2018-09-12T23:18:30.000Z"
description: "On Windows Server Reset MySQL 8.0 password on Windows Server  Заметки на полях. Потерял пароль. Стал восстанавливать и столкнулс"
---

<h4>On Windows Server</h4>

<p>Заметки на полях. Потерял пароль. Стал восстанавливать и столкнулся с тем, что много разных источников показывают разные варианты. Но у меня сработал только один. Возможно кому-то это пригодится (ну или я сам снова потеряю пароль =)).</p>
<p>Останавливаем сервер через:</p>
<pre>Control Panel → Administrative Tools → Services → MySQL80 → [stop]</pre>
<p>Создаем файл (для удобства прям в корне диска):</p>
<pre>notepad mysql-init.sql</pre>
<pre><strong>SET</strong> PASSWORD <strong>FOR</strong> 'root'@'%' = 'new password';<br><strong>SET</strong> PASSWORD <strong>FOR</strong> 'root'@'localhost' = 'new password';</pre>
<p>Далее заходим в “C:Program FilesMySQLMySQL Server 8.0bin” и создаем батник:</p>
<pre>notepad recovery.cmd</pre>
<pre><strong>mysqld</strong> --defaults-file="C:\ProgramData\MySQL\MySQL Server 8.0\my.ini" --init-file="C:\mysql-init.sql" --console</pre>
<p>Далее запускаем через контекстное меню от имени администратора.</p>
<p>После этого останавливаем скрипт и запускаем MySQL сервер через службу сервисов:</p>
<pre>Control Panel → Administrative Tools → Services → MySQL80 → [start]</pre>
<p>Вот как-то так.</p>



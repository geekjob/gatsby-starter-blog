---
title: "OSXFUSE file system is not available"
date: "2017-09-28T20:00:08.00Z"
description: "On Mac OS High Sierra. Or not?    Если вдруг вы пользовались SSHFS на маке и обновились до последней версии, а она реально хорош"
---

<h4>On Mac OS High Sierra. Or not?</h4>

<p>Если вдруг вы пользовались SSHFS на маке и обновились до последней версии, а она реально хорошо и подкупает тем, что мак реально работает быстрее, то вы могли получить такое сообщение при попытке смонтировать удаленный хост как директорию. Что делать?</p>
<p>Я просто обновился, выполнив следующие команды:</p>
<pre><code>brew cask reinstall osxfuse<br>brew reinstall sshfs</code></pre>
<p>и все заработало. Возможно это кому-то будет полезно.</p>
<p>А для тех, кто не знал что это, показываю пример команды:</p>
<pre><code><strong>sshfs</strong> username@hostname:/remote/directory/path <br>      /local/mount/point <br>      -ovolname=[имя смонтированной директории]</code></pre>



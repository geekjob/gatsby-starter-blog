---
title: "Chrome Headless ставим на CentOS"
date: "2017-11-01T20:30:34.00Z"
description: "Ставим безголовый хром на семерку и решаем ошибки запуска Сегодня речь о том, как установить на CentOS 7 безголовый хром. Это бу"
---

<!--kg-card-begin: html--><h4>Ставим безголовый хром на семерку и решаем ошибки запуска</h4>
<p>Сегодня речь о том, как установить на CentOS 7 безголовый хром. Это будут зарисовки рабочих будней. Кому-то может пригодиться. Зарисовка первая — инсталляция. Поехали…</p>
<h4>Ставим из RPM пакета</h4>
<pre><strong>wget</strong> <a href="https://dl.google.com/linux/direct/google-chrome-stable_current_x86_64.rpm" target="_blank" rel="noopener noreferrer">https://dl.google.com/linux/direct/google-chrome-stable_current_x86_64.rpm</a></pre>
<pre><strong>yum install -y</strong> ./google-chrome-stable_current_*.rpm</pre>
<p>Так же всегда есть возможность поставить через yum. Хотите что-то более свежее? Ставим нестабильную версию:</p>
<pre><strong>yum</strong> <strong>install -y</strong> google-chrome-unstable</pre>
<h3>Ошибка при запуске</h3>
<pre>Invalid node channel message<br>Trace/breakpoint trap</pre>
<p>У меня нашелся сервер, на котором возникла такая ошибка. Запускаться хром не хотел. В этом случае мне помогло следующее:</p>
<ul>
<li>поставил нестабильную версию (смотри выше)</li>
<li>поставил дополнительные модули и шрифты иксов:</li>
</ul>
<pre><strong>yum install</strong>  <br>    ipa-gothic-fonts <br>    xorg-x11-fonts-100dpi <br>    xorg-x11-fonts-75dpi <br>    xorg-x11-utils <br>    xorg-x11-fonts-cyrillic <br>    xorg-x11-fonts-Type1 <br>    xorg-x11-fonts-misc <strong>-y</strong></pre>
<p>В итоге все заработало.</p>
<!--kg-card-end: html-->


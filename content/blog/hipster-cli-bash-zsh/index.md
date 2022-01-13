---
title: "Хипстерский терминал"
date: "2019-02-25T02:17:30.00Z"
description: "Кастомизируем Bash, Zsh На конференциях у некоторых докладчиков можно увидеть терминалы в очень красивой боевой раскраске, прям "
---

<!--kg-card-begin: html--><h4>Кастомизируем Bash, Zsh</h4>
<p>На конференциях у некоторых докладчиков можно увидеть терминалы в очень красивой боевой раскраске, прям муа ?. Выглядит очень сочно, стильно. Одним словом — по фронтендерски, модно, молодежно, хипстерня!</p>
<p>Стал разбираться что это и выяснил что продвинутую стилизацию поддерживает Zsh.</p>
<figure>
<p><img data-width="1906" data-height="634" src="https://cdn-images-1.medium.com/max/800/1*GLAqqFAnmRw8GJqMUQmm3g.jpeg"><br />
</figure>
<p>Если хочется чего-то такого, то по ссылке подробный мануал по кастомизации и настройке:</p>
<p><a href="https://medium.freecodecamp.org/how-you-can-style-your-terminal-like-medium-freecodecamp-or-any-way-you-want-f499234d48bc">https://medium.freecodecamp.org/how-you-can-style-your-terminal-like-medium-freecodecamp-or-any-way-you-want-f499234d48bc</a></p>
<p>Если вы не хотите уходить с Bash и пересаживаться на Zsh, то вы можете получить терминал похожий на темизированный Zsh (как на скриншоте):</p>
<figure>
<p><img data-width="2000" data-height="533" src="https://cdn-images-1.medium.com/max/800/1*XgqdpK3DVQySz0wIzwcTbw.png"><br />
</figure>
<p>Но вам потребуются дополнительные скрипты, а конкретно установить Powerline — как я понял это что-то типа обертки, приложение написано на Python. Все подробности по ссылке:</p>
<p><a href="https://medium.freecodecamp.org/how-you-can-style-your-terminal-like-medium-freecodecamp-or-any-way-you-want-f499234d48bc">https://medium.freecodecamp.org/how-you-can-style-your-terminal-like-medium-freecodecamp-or-any-way-you-want-f499234d48bc</a></p>
<p>Отдельный инструмент Powerline Git status: позволяет красиво выводить информацию о текущем проекте (если вы используете Git):</p>
<p><a href="https://medium.freecodecamp.org/how-you-can-style-your-terminal-like-medium-freecodecamp-or-any-way-you-want-f499234d48bc">https://medium.freecodecamp.org/how-you-can-style-your-terminal-like-medium-freecodecamp-or-any-way-you-want-f499234d48bc</a></p>
<h3>Native Vanilla Bash prompt</h3>
<p>Не хочу сложностей и заморочек. Есть варианты? Да, я смог собрать себе стиль, отдаленно напоминающий то что описано выше. Без вспомогательных приложений и скриптов, просто настроив общие стили и прописав свой PS1. Что у меня получилось:</p>
<h4>User mode</h4>
<figure>
<p><img data-width="944" data-height="146" src="https://cdn-images-1.medium.com/max/800/1*hrq69TGkhQYfXOa4c45_xA.jpeg"><br />
</figure>
<p>Вся эта красота описывается 1й строчкой в .bashrc:</p>
<pre>PS1="n[e[48;5;28;1;5;33m]▶[e[48;5;28;97m]  A  [e[48;5;34;38;5;232m][e[1;5;33m]▶[e[38;5;232m]  u@h  [e[48;5;30m][e[1;5;33m]▶[e[38;5;15m] w [e[40;1;5;33m]▶  [e[40;32m][$txtcyn]$git_branch[$txtred]$git_dirty[$txtrst]n[e[1;5;33m]❱ [e[m][e[32m]"</pre>
<p>Тут есть переменные, которые отвечают за индикацию состояния GIT:</p>
<pre><strong>function</strong> find_git_branch()<br>{<br><strong>local</strong> branch<br><strong>if</strong> branch=$(git rev-parse --abbrev-ref HEAD 2&gt; /dev/null); then<br><strong>if</strong> [[ "$branch" == "HEAD" ]]; then<br>      branch='detached*'<br><strong>fi</strong><br>    git_branch="($branch)"<br><strong>else</strong><br>    git_branch=""<br><strong>fi</strong><br>}</pre>
<pre><strong>function</strong> find_git_dirty()<br>{<br><strong>local</strong> status=$(git status --porcelain 2&gt; /dev/null)<br><strong>if</strong> [[ "$status" != "" ]]; then<br>    git_dirty='*'<br><strong>else</strong><br>    git_dirty=''<br><strong>fi</strong><br>}</pre>
<pre>PROMPT_COMMAND="find_git_branch; find_git_dirty; $PROMPT_COMMAND"</pre>
<h4>Root mode</h4>
<p>Для рута немного другой стиль:</p>
<pre>PS1="n[e[0;31m]☰[e[0;33m]  t [e[0;31m]❱[e[m] u@h [e[0;31m]❱[e[0;33m] w [e[m][e[0;31m]❱n❱❱❱ [e[m][e[0;91m]"</pre>
<figure>
<p><img data-width="944" data-height="146" src="https://cdn-images-1.medium.com/max/800/1*S2B_EdkCLb-lL_7JKUa8kQ.jpeg"><br />
</figure>
<p>Попроще и без git индикаторов.</p>
<p>У меня есть небольшая репка, в которой можно найти комплект скриптов для улучшения терминала:</p>
<p><a href="https://medium.freecodecamp.org/how-you-can-style-your-terminal-like-medium-freecodecamp-or-any-way-you-want-f499234d48bc">https://medium.freecodecamp.org/how-you-can-style-your-terminal-like-medium-freecodecamp-or-any-way-you-want-f499234d48bc</a></p>
<p>Все это использую на своих девелоперских машинках.</p>
<!--kg-card-end: html-->


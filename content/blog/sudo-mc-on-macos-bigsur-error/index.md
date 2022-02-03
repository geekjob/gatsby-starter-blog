---
title: "Проблемы sudo mc на macOS Big Sur"
date: "2021-07-27T21:02:58.00Z"
description: "На macOS Big Sur у меня появились проблемы при запуске Midnight Commander под рутом. С первого раза не запускается, выдавая ошиб"
---

<figure class="kg-card kg-image-card"><img src="https://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/images/2021/07/--------------2021-07-28---00.01.59.png" class="kg-image" alt srcset="https://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/images/size/w600/2021/07/--------------2021-07-28---00.01.59.png 600w, https://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/images/size/w1000/2021/07/--------------2021-07-28---00.01.59.png 1000w, https://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/images/size/w1600/2021/07/--------------2021-07-28---00.01.59.png 1600w, https://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/images/2021/07/--------------2021-07-28---00.01.59.png 1726w" sizes="(min-width: 720px) 720px"></figure><p>На macOS Big Sur у меня появились проблемы при запуске Midnight Commander под рутом. С первого раза не запускается, выдавая ошибку. Но бывает что и со второго и третьего раза не запускается. Ошибка выглядит как гейзенбаг - то есть, то нет...</p><pre><code class="language-bash">❱ sudo mcedit /etc/hosts                                                 
common.c: unimplemented subshell type 1
read (subshell_pty...): No such file or directory (2)
</code></pre><p>И, возможно, они появились после недавних манипуляций с апгрейдом Bash до 5й версии, когда я играл со сменой командной строки. Хоть я и поставил Bash5, все же я вернул по умолчанию ZSH.</p><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="/install-bash-v5-on-macos/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">Ставим Bash5 на MacOS</div><div class="kg-bookmark-description">Я, может, из старой гвардии, поэтому привык к Bash и для меня zsh - менеекомфортный. Хотя я знаю что zsh мощен, его можно сделать по хипстерскипривлекательным и вообще... Но я все же имею опыт именно с Bash. Короче, на серверах , обычно по дефолту идет Bash 4й версии, а вот на MacOS онсовсем ста…</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://tech.geekjob.ru/favicon.png"><span class="kg-bookmark-author">Geekjob Tech</span><span class="kg-bookmark-publisher">FullStack CTO</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://tech.geekjob.ruhttps://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/images/size/w100/2021/07/gj-logo-square.png"></div></a></figure><p>Так вот, решаем проблему следующим образом. Сначала проверяем шел, который установлен для суперпользователя:</p><pre><code class="language-bash">❱ dscl . -read /Users/root UserShell
UserShell: /bin/sh</code></pre><p>Если видите /bin/sh, то нужно поменять на bash или zsh (на ваше усмотрение):</p><pre><code class="language-bash">❱ sudo dscl . -change /Users/root UserShell /bin/sh /bin/bash
# И проверяем результат
❱ dscl . -read /Users/root UserShell</code></pre><h2 id="-">Альтернативный способ</h2><p>Второй способ, более простой в плане понимания, особенно если вы юниксоид. Сначала входите в учётку рут пользователя и затем из под рута меняете шел командой chsh:</p><pre><code class="language-bash">❱ 
❱ sudo su
Password:
sh-3.2# chsh -s /usr/local/bin/bash
Changing shell for root.
❱ exit
❱ 
❱ 
❱ dscl . -read /Users/root UserShell
UserShell: /usr/local/bin/bash
❱ </code></pre><p>Проблема решена</p>


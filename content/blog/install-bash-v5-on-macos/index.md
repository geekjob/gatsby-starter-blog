---
title: "Ставим Bash5 на MacOS"
date: "2021-07-21T10:49:05.00Z"
description: "Я, может, из старой гвардии, поэтому привык к Bash и для меня zsh - менее комфортный. Хотя я знаю что zsh мощен, его можно сдела"
---

<p>Я, может, из старой гвардии, поэтому привык к Bash и для меня zsh - менее комфортный. Хотя я знаю что zsh мощен, его можно сделать по хипстерски привлекательным и вообще... Но я все же имею опыт именно с Bash.</p><p>Короче, на серверах , обычно по дефолту идет Bash 4й версии, а вот на MacOS он совсем старенький, версии 3.</p><pre><code class="language-bash">$ bash --version
GNU bash, version 3.2.57(1)-release (x86_64-apple-darwin18)Copyright (C) 2007 Free Software Foundation, Inc.</code></pre><p><strong>Зачем обновляться?</strong></p><p>Хороший вопрос. Не готов расписывать все улучшения. Вы всегда можете найти чейндж лист.</p><p><strong>Как обновить</strong></p><p>Как ни страноо, все просто:</p><pre><code class="language-bash">brew install bash</code></pre><p>Смотрим что у нас есть в системе:</p><pre><code class="language-bash">$ which -a bash
/usr/local/bin/bash
/bin/bash

$ /usr/local/bin/bash --version
GNU bash, version 5.1 (x86_64-apple-darwin18.2.0)
Copyright (C) 2019 Free Software Foundation, Inc.
License GPLv3+: GNU GPL version 3 or later 

$ /bin/bash --version
GNU bash, version 3.2.57(1)-release (x86_64-apple-darwin18)
Copyright (C) 2007 Free Software Foundation, Inc.</code></pre><p>Чтобы переключиться на новую верисю, сначала добавляем в белый список, а потом переключаемся:</p><pre><code class="language-bash"> sudo vim /etc/shells
 chsh -s /usr/local/bin/bash
 </code></pre><p>Ну собственно и все. Достаточно перезапустить терминал и вы будете в новой версии Bash.</p>


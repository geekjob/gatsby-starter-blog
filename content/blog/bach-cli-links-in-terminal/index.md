---
title: "Создаем кликабельные гиперссылки ссылки в терминале"
date: "2019-01-20T02:07:29.00Z"
description: "iTerm2, bash, tips & tricks    Недавно задался вопросом как создать гиперссылки в терминале и нашел способ, который у меня зараб"
---

<!--kg-card-begin: html--><h4>iTerm2, bash, tips &amp; tricks</h4>
<figure>
<p><img data-width="744" data-height="250" src="https://cdn-images-1.medium.com/max/800/1*bxvk5hJ6OeE-r76am_lUjQ.jpeg"><br />
</figure>
<p>Недавно задался вопросом как создать гиперссылки в терминале и нашел способ, который у меня заработал в iTerm2 в Mac OS. Вы можете создавать кликабельные ссылки такой хитрой командой:</p>
<pre><strong>echo</strong> -e '33]8;;'"<strong>${url}</strong>"'a'"<strong>${link_title}</strong>"'33]8;;a'</pre>
<p>Вы объявляете $url и $link_title, и на выходе получаете такую вот красоту:</p>
<figure>
<p><img data-width="302" data-height="134" src="https://cdn-images-1.medium.com/max/800/1*tbTfATDdNyUd2DpkS1OPWQ.gif"><br />
</figure>
<p>Этот метод работает не во всех терминалах. Для других терминалов попробуйте такой вариант:</p>
<pre>echo -e 'e]8;;http://example.come\This is a linke]8;;e\'</pre>
<p>Лично у меня он не сработал. Этот вариант взят <a href="https://gist.github.com/egmontkob/eb114294efbcd5adb1944c9f3cb5feda" target="_blank" rel="noopener noreferrer">из этого документа</a>. Но у меня не получилось создать ссылку таким образом ни в iTerm2, ни в стандартном терминале. Возможно все эти методы специфичны для разных терминалов.</p>

<!--kg-card-end: html-->


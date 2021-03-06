---
title: "Добавляем кнопку DarkTheme в браузер за 2 минуты"
date: "2018-01-06T02:27:25.00Z"
description: "CSS инверсия по мотивам вебстандартов В последнее время из за jetlag’a много провожу времени за компьютером в номере в кромешной"
---

<!--kg-card-begin: html--><h4>CSS инверсия по мотивам вебстандартов</h4>
<p>В последнее время из за jetlag’a много провожу времени за компьютером в номере в кромешной тьме. На дворе 5 утра, мне уже не спится, свет в номере включить не могу, так как я не один. Читать черное по белому и переключаться в IDE с темным фоном прям напрягает.</p>
<p>Решил найти компонент для включения темной темы страниц в браузере. Нашел. Поставил… Сразу начал выть кулер. Полез смотреть код темы — много JS кода, хотя суть же проста — сделать инверсию. Не понравилось, что кто-то будет майнить или еще что делать у меня в браузере в оплату такого простого расширения.</p>
<p>Вспомнил, что в подкасте Вбестандартов <a href="https://medium.com/u/24cb145f6684" target="_blank" rel="noopener noreferrer">Vadim Makeev</a> рассказывал про то, как сделать темную тему на чистом CSS. Нашел статью:</p>
<p><a href="https://medium.com/web-standards/a-theme-switcher-96174d95be75">https://medium.com/web-standards/a-theme-switcher-96174d95be75</a></p>
<p>Вся суть темы сводится к следующим строкам:</p>
<pre><code>:<strong>root</strong> { <br><strong>background-color</strong>: #fefefe;<br><strong>filter</strong>: invert(100%);<br>}</code></pre>
<pre><code><strong>*</strong> { <br><strong>background-color</strong>: inherit;<br>}</code></pre>
<pre><code><strong>img:not</strong>([src*=".svg"]), <strong>video</strong> {  <br><strong>filter</strong>: invert(100%);<br>}</code></pre>
<p>Расширение писать не стал, ведь для рабочей MVP достаточно сделать букмарклет. Код букмарклета готовый для встраивания и его девелоп версия:</p>
<p><a href="https://gist.github.com/frontdevops/8aea1e0252dd826488dad63319e3ec88">https://gist.github.com/frontdevops/8aea1e0252dd826488dad63319e3ec88</a></p>
<p>Букмарклет можно красиво назвать используя UTF8 графику или эмодзи. В итоге получится что-то такое:</p>
<figure class="wp-caption">
<p><img data-width="158" data-height="118" src="https://cdn-images-1.medium.com/max/800/1*_KAKzRuzzzw40_JmHam3UA.png"><figcaption class="wp-caption-text">utf8 графика и эмодзи создают эффект кнопки</figcaption></figure>
<p>Ну и результат работы такого импровизированного “расширения”:</p>
<figure class="wp-caption">
<p><img data-width="640" data-height="422" src="https://cdn-images-1.medium.com/max/800/1*J3l8oDuFg3hf8D-1wfb__Q.gif"><figcaption class="wp-caption-text">Результат работы плагина</figcaption></figure>
<p>Код точно работает в Chrome на десктопе, остальное уже за вами. Расширение, допиливание фич (если они нужны) и так далее. Мою задачу эта штука вполне решает ?</p>
<!--kg-card-end: html-->


---
title: "Дебажим JSON API"
date: "2021-08-14T12:38:20.000Z"
description: "Быстрый дамп в DevTools Это пост из серии лайфхаков. Не знал, но вспомнил. Если вам нужно посмотреть вывод данных, отдаваемых ка"
---

<h2 id="-devtools">Быстрый дамп в DevTools</h2><p>Это пост из серии лайфхаков. Не знал, но вспомнил. Если вам нужно посмотреть вывод данных, отдаваемых каким-то JSON API сервисом, то используя fetch и console.table это делается так просто и быстро, как два байта переслать.</p><p>В качестве сервера данных для примера будем использовать специальный сервис, который генерит JSON ответ:</p><pre><code class="language-js">const jsonApiUri = "http://www.filltext.com/?rows=32&amp;id={number|1000}&amp;firstName={firstName}&amp;lastName={lastName}&amp;email={email}&amp;phone={phone|(xxx)xxx-xx-xx}&amp;description={lorem|16}"</code></pre><p>И всего одной строчкой кода мы можем вывести все эти данные в табличном виде:</p><p><strong><strong>fetch</strong></strong>(jsonApiUri<a href="http://www.filltext.com/?rows=32&amp;id={number|1000}&amp;firstName={firstName}&amp;lastName={lastName}&amp;email={email}&amp;phone={phone|(xxx)xxx-xx-xx}&amp;description={lorem|16}%27).then(r=" rel="noopener nofollow">).<strong><strong>then</strong></strong>(r=</a>&gt;r.<strong><strong>json</strong></strong>()).<strong><strong>then</strong></strong>(<strong><strong>console</strong></strong>.<strong><strong>table</strong></strong>)</p><p>На выходе получим такую вот красивую таблицу:</p>


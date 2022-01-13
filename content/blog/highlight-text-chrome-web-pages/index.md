---
title: "Спецификация Scroll to Text Fragments"
date: "2021-07-28T21:16:30.000Z"
description: "Ссылки на WEB страницы с подсветкой контекста Я не смог придумать адекватный заголовок, так что попробую объяснить суть идеи.  В"
---

<h2 id="-web-">Ссылки на WEB страницы с подсветкой контекста</h2><p>Я не смог придумать адекватный заголовок, так что попробую объяснить суть идеи.</p><p>Все браузеры на базе Chromium (включая Opera, MS Edge, Яндекс.Браузер) умеют вот какую штуку:</p><pre><code>Если дописать в конце URL такой хештег:

#:~:text=текст+котрый+есть+на+странице</code></pre><p>Допустим прямо на этой странице я подсвечу этот текст через ссылку:</p><div style="text-align:center">
    <a href="/highlight-text-chrome-web-pages/#:~:text=%D0%94%D0%BE%D0%BF%D1%83%D1%81%D1%82%D0%B8%D0%BC%20%D0%BF%D1%80%D1%8F%D0%BC%D0%BE%20%D0%BD%D0%B0%20%D1%8D%D1%82%D0%BE%D0%B9%20%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B5%20%D1%8F%20%D0%BF%D0%BE%D0%B4%D1%81%D0%B2%D0%B5%D1%87%D1%83%20%D1%8D%D1%82%D0%BE%D1%82%20%D1%82%D0%B5%D0%BA%D1%81%D1%82%20%D1%87%D0%B5%D1%80%D0%B5%D0%B7%20%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D1%83">DEMO</a>
</div><p>Должен быть результат вида:</p>- <a href="https://habr.com/ru/company/new_hr/blog/507534/#:~:text=%D0%90%D0%BD%D0%B0%D0%BB%D0%B8%D1%82%D0%B8%D0%BA%D0%B0%20%D0%B4%D0%BB%D1%8F%20%D1%85%D0%B0%D0%BD%D1%82%D0%B8%D0%BD%D0%B3%D0%B0%20%D1%80%D0%B0%D0%B7%D1%80%D0%B0%D0%B1%D0%BE%D1%82%D1%87%D0%B8%D0%BA%D0%BE%D0%B2" target="_blank">Аналитика для хантинга разработчиков </a> <br/>
- <a class="kg-bookmark-container" href="https://wicg.github.io/scroll-to-text-fragment/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">Text Fragments</div><div class="kg-bookmark-description"></div><div class="kg-bookmark-metadata"><span class="kg-bookmark-author">W3C</span><span class="kg-bookmark-publisher">Nick Burris</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://www.w3.org/StyleSheets/TR/2016/logos/W3C"></div></a> <br/>
<p>Полный формат выглядит так:</p><pre><code>following format:

#:~:text=[prefix-,]textStart[,textEnd][,-suffix]
          context  |-------match-----|  context
          </code></pre>


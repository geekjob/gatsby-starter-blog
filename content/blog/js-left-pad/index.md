---
title: "Left-pad для чисел"
date: "2016-09-03T23:07:45.000Z"
description: "Как дополнить число нулями
Вроде бы простая задача. С ней сталкивался хотя бы раз любой разработчик. Как
отформатировать число, "
---

<h4 id="-">Как дополнить число нулями</h4><p>Вроде бы простая задача. С ней сталкивался хотя бы раз любой разработчик. Как отформатировать число, дополнив его нулями с левой стороны. К примеру хотим отобразить дату или время и нам нужно отобразить 01.01.2016 00:01:02. Либо мы просто хотим отобразить какое-то число и добить его нулями с левой стороны. Для примера рассмотрим двузначные числа. Хипстеры просто пойдут и поставят библиотеку left-pad из npm. Более опытные разработчики решат задачу, в зависимости от своего опыта. Кстати, хороший вопрос для собеседования.</p><p>Начиная решать задачу в лоб первое что приходит в голову — это делать проверку, если число меньше 10, то привести его к строке и добавить 0. Вполне себе рабочий вариант.</p><p>Можно использовать регулярные выражения:</p><pre><code class="language-javascript">
num.toString().replace(/^([0-9])$/, '0$1'); // 01
</code></pre><p>Можно написать что-то в таком духе:</p><pre><code class="language-javascript">
('0'+num).slice(-2);
</code></pre><p>Все это решает задачу, но есть более правильный и простой способ.</p><h4 id="-tolocalestring">Метод toLocaleString</h4><p>Метод <strong><strong>toLocaleString()</strong></strong> возвращает строку с языко-зависимым представлением. В этот метод можно передавать вторым аргументом объект с параметрами, как нужно форматировать строку. Наша задача будет решаться так:</p><pre><code class="language-javascript">
num.toLocaleString(
    'ru-RU',
    {
        minimumIntegerDigits: 2,
        useGrouping: false
    }
)

// 04</code></pre><p>Больше информации по параметрам можно получить по ссылке:</p>- <a class="kg-bookmark-container" href="https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Number/toLocaleString"><div class="kg-bookmark-content"><div class="kg-bookmark-title">Number.prototype.toLocaleString()</div><div class="kg-bookmark-description">Метод toLocaleString() возвращает строку с языко-зависимым представлением числа.</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://developer.mozilla.org/static/img/favicon144.e7e21ca263ca.png"><span class="kg-bookmark-publisher">Веб-документация MDN</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://developer.mozilla.org/static/img/opengraph-logo.72382e605ce3.png"></div></a> <br/>
<p>И да, не надо ставить left-pad из npm ради такой простой логики.</p>


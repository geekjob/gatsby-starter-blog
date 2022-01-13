---
title: "Left pad в JS"
date: "2016-12-15T23:42:22.00Z"
description: "Все на много проще с startPad Я как-то писал про Left pad для чисел и приводил разные примеры. Но на дворе почти 2017 год и все "
---

<h4 id="-startpad">Все на много проще с startPad</h4><p>Я как-то писал про Left pad для чисел и приводил разные примеры. Но на дворе почти 2017 год и все делается теперь еще проще.</p><h4 id="-">Предыдущий пост</h4><blockquote><em><em>Вроде бы простая задача. С ней сталкивался хотя бы раз любой разработчик. Как отформатировать число, дополнив его нулями с левой стороны?</em> <em>Хипстеры просто пойдут и поставят библиотеку left-pad из npm. Более опытные разработчики решат задачу, в зависимости от своего опыта. Кстати, хороший вопрос для собеседования.</em></em></blockquote><p>Кто-то прочтет этот пост и воспользуется советами из него:</p><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="/js-left-pad/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">Left-pad для чисел</div><div class="kg-bookmark-description">Как дополнить число нулями
Вроде бы простая задача. С ней сталкивался хотя бы раз любой разработчик. Как
отформатировать число, дополнив его нулями с левой стороны. К примеру хотим
отобразить дату или время и нам нужно отобразить 01.01.2016 00:01:02. Либо мы
просто хотим отобразить какое-то число и …</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://tech.geekjob.ru/favicon.png"><span class="kg-bookmark-author">Александр Майоров</span><span class="kg-bookmark-publisher">Geekjob Tech</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://www.gravatar.com/avatar/8f8f604430a6a2116749fad87c9c86d5?s=250&amp;d=mm&amp;r=x"></div></a></figure><h4 id="-left-pad-2017-">Как делается left pad в 2017 году</h4><p>… но в 2017 году все будут делать это по другому. У нас появились 2 функции (два метода в объекте String):</p><ol><li>String.prototype.<strong><strong>padStart</strong></strong>()</li><li>String.prototype.<strong><strong>padEnd</strong></strong>()</li></ol><p>Эти методы заполняют значениями до нужной длины строки. Проще показать на примере:</p><pre><code class="language-javascript">'abc'.padStart(10);         // "       abc"
'abc'.padStart(10, "foo");  // "foofoofabc"
'abc'.padStart(6,"123465"); // "123abc"

'abc'.padEnd(10);         // "abc       "
'abc'.padEnd(10, "foo");  // "abcfoofoof"
'abc'.padEnd(6,"123456"); // "abc123"</code></pre><p>На сегодня (конец 2016 года) все эти методы работают только в Firefox. Данные методы пока являются рекомендациями в стандарт ES2017 и находятся на стадии 4.</p><h4 id="polyfills">Polyfills</h4><p>Я бы предложил такой вариант полифилов:</p><pre><code class="language-javascript">String.prototype.padStart = function(len, pad = ' '){
    var str = this.toString();
    while(str.length &lt; len) str = pad + str;
    return str;
}

String.prototype.padEnd = function(len, pad = ' '){
    var str = this.toString();
    while(str.length &lt; len) str += pad;
    return str;
}</code></pre><h2 id="--1">Ссылки по теме</h2><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="https://github.com/tc39/proposal-string-pad-start-end"><div class="kg-bookmark-content"><div class="kg-bookmark-title">tc39/proposal-string-pad-start-end</div><div class="kg-bookmark-description">ECMAScript spec proposal for String.prototype.{padStart,padEnd} - tc39/proposal-string-pad-start-end</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://github.githubassets.com/favicons/favicon.svg"><span class="kg-bookmark-author">tc39</span><span class="kg-bookmark-publisher">GitHub</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://avatars3.githubusercontent.com/u/1725583?s=400&amp;v=4"></div></a></figure><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/String/padStart"><div class="kg-bookmark-content"><div class="kg-bookmark-title">String.prototype.padStart()</div><div class="kg-bookmark-description">Метод padStart() заполняет текущую строку другой строкой (несколько раз, если нужно) так, что итоговая строка достигает заданной длины. Заполнение осуществляется в начале (слева) текущей строки.</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://developer.mozilla.org/static/img/favicon144.e7e21ca263ca.png"><span class="kg-bookmark-publisher">Веб-документация MDN</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://developer.mozilla.org/static/img/opengraph-logo.72382e605ce3.png"></div></a></figure><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/padEnd"><div class="kg-bookmark-content"><div class="kg-bookmark-title">String.prototype.padEnd()</div><div class="kg-bookmark-description">The padEnd() method pads the current string with a given string (repeated, if needed) so that the resulting string reaches a given length. The padding is applied from the end of the current string.</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://developer.mozilla.org/static/img/favicon144.e7e21ca263ca.png"><span class="kg-bookmark-publisher">MDN Web Docs</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://developer.mozilla.org/static/img/opengraph-logo.72382e605ce3.png"></div></a></figure>


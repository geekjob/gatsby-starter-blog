---
title: "Защита Email от Spamer’ов"
date: "2019-12-03T20:01:17.000Z"
description: "Update В предыдущем посте я показал как прятать имейлы от спамеров на чистом CSS:  Защита Email от Spamer’ов на CSSNojs, only CS"
---

<h3 id="update">Update</h3><p>В предыдущем посте я показал как прятать имейлы от спамеров на чистом CSS:</p>- <a class="kg-bookmark-container" href="/zashita-ot-spamerov-na-pure-css/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">Защита Email от Spamer’ов на CSS</div><div class="kg-bookmark-description">Nojs, only CSS!
Да да, No JS
Сейчас поведаю про интересный способ защиты имейлов от спамеров используя только
CSS. И так, сначала ревертим наш имейл, можем это сделать на JS: ‘major@geekjob.ru’.split(″).reverse().join(″)
// ur.bojkeeg@rojam Далее этот имейл вставляем в HTML: &lt;span class=“antib…</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://tech.geekjob.ru/favicon.png"><span class="kg-bookmark-author">Александр Майоров</span><span class="kg-bookmark-publisher">Geekjob Tech</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://www.gravatar.com/avatar/8f8f604430a6a2116749fad87c9c86d5?s=250&amp;d=mm&amp;r=x"></div></a> <br/>
<p>Минус такого подхода — при попытке скопировать имейл человеком, он так же перевернут и получется что защита от всех, даже от людей. В комментариях писали что такой метод плох и мы портим жизнь людям. Я согласен, но тут скорее был показан просто сам трюк и его красота. Но если хочется его использовать в продакшене, то его можно проапдейтить с помощью JS.</p>
<h4>Суть идеи</h4>
<p>Мы копируем имейл во время его выделения, переворачиваем его и кладем в буффер обмена уже перевернутым. От идеи к реализации:</p>
<pre>&lt;<strong>style</strong>&gt;<br>  .antibot {<br>    unicode-bidi: bidi-override;<br>    direction: rtl;<br>  }<br>&lt;/<strong>style</strong>&gt;</pre>
<pre>&lt;<strong>span</strong> class="antibot"&gt;ur.bojkeeg@rojam&lt;/<strong>span</strong>&gt;<br>&lt;<strong>span</strong> id="copy2cb"&gt;↗️&lt;/<strong>span</strong>&gt;</pre>
<h4>JavaScript</h4>
<pre><strong>var</strong> antibot = <strong>document</strong>.querySelector('.antibot');<br><strong>var</strong> copy2cb = <strong>document</strong>.querySelector('#copy2cb');</pre>
<pre>antibot.<strong>onmouseup</strong> = doSomethingWithSelectedText;<br>antibot.<strong>onkeyup</strong> = doSomethingWithSelectedText;</pre>
<pre>copy2cb.<strong>addEventListener</strong>('click', <strong>function</strong>(){<br>  copyToClipboard(reverse(antibot.innerText))<br>});</pre>
<pre><strong>function</strong> reverse(s) { <strong>return</strong> s.split('').reverse().join('') }</pre>
<pre><strong>function</strong> doSomethingWithSelectedText() {<br><strong>var</strong> selectedText = getSelectedText();<br><strong>if</strong> (selectedText) {<br>    selectedText = reverse(selectedText);<br><strong>console</strong>.log(selectedText);<br>    copyToClipboard(selectedText);<br>  }<br>}</pre>
<pre><strong>function</strong> getSelectedText() {<br><strong>var</strong> text = '';<br><strong>if</strong> (<strong>typeof</strong> <strong>window</strong>.getSelection != <strong>void</strong> 0) {<br>    text = <strong>window</strong>.getSelection().toString();<br>  }<br><strong>else</strong> <strong>if</strong> (<strong>typeof</strong> <strong>document</strong>.selection != void 0 &amp;&amp;     document.selection.type == 'Text') {<br>    text = <strong>document</strong>.selection.createRange().text;<br>  }<br><strong>return</strong> text;<br>}</pre>
<pre><strong>function</strong> copyToClipboard(text) {<br>  var textarea = <strong>document</strong>.createElement("textarea");<br>  textarea.textContent = text;<br>  textarea.style.position = "fixed";<br><strong>document</strong>.body.appendChild(textarea);<br>  textarea.select();<br><strong>try</strong> {<br>    return document.execCommand("cut");<br>  } <strong>catch</strong> (ex) {<br>    console.warn("Copy to clipboard failed.", ex);<br>    return false;<br>  } <strong>finally</strong> {<br>    document.body.removeChild(textarea);<br>  }<br>}</pre>
<p>Код на JSBin <a href="https://jsbin.com/gaxaqocaku/edit?js,output" target="_blank" rel="noopener noreferrer">https://jsbin.com/gaxaqocaku/edit?js,output</a></p>
<p>Идея конечно имеет ряд недостатков, но все же она имеет право на жизнь. Ее можно еще доработать и додумать… Ну или использовать принципиально иной способ с генерацией имейла на JS, как это делают многие. Кстати, в CloudFlare есть опция защиты имейлов на сайте — они автоматически превращаются в JS код с генерацией имейла.</p>




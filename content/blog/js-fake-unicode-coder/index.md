---
title: "Пишем функцию кодирования невидимок"
date: "2017-08-15T15:16:18.000Z"
description: "На суррогатных парах
Все уже успели почитать твит

> for(A in
{A????????????????????????????????????????????????????????????????"
---

<h4>На суррогатных парах</h4>
<p>Все уже успели почитать твит</p>
<blockquote class="twitter-tweet" data-width="550" data-dnt="true">
<p lang="und" dir="ltr">for(A in {A????????????????????????????????????????????????????????????????:0}){alert(unescape(escape(A).replace(/u.{8}/g,[])))};</p>
<p>&mdash; Fake “Unicode.” ↙️ (@FakeUnicode) <a href="https://twitter.com/FakeUnicode/status/882419542990831616?ref_src=twsrc%5Etfw">July 5, 2017</a></p></blockquote>
<p><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></p>
<p>Статью с разбором</p>
<p><a href="https://www.stefanjudis.com/blog/hidden-messages-in-javascript-property-names/">https://www.stefanjudis.com/blog/hidden-messages-in-javascript-property-names/</a></p>
<p>И даже перевод статьи на Хабре</p>
<p><a href="https://www.stefanjudis.com/blog/hidden-messages-in-javascript-property-names/">https://www.stefanjudis.com/blog/hidden-messages-in-javascript-property-names/</a></p>
<p>Но как закодировать такой текст?</p>
<h3>Функция кодирования невидимок на суррогатных парах</h3>
<pre><strong>const</strong> code = (s) =&gt;<br>  s[0] + <strong>unescape</strong>(<br>    [...s.slice(1)]<br>      .<strong>reduce</strong>(<br>        (s,c) =&gt; s<br>          + '%uDB40%uDD' +<br>          c.<strong>charCodeAt</strong>()<br>           .<strong>toString</strong>(16)<br>           .<strong>toUpperCase</strong>(),<br>        ''<br>      )<br>  )<br>;</pre>
<pre><strong>var</strong> a = <strong>code</strong>('Hello, Habrahabr from Tutu.ru!');<br>console.log(a.length)<br>console.log(a)</pre>
<p>После того, как скопируете полученное, можно использовать так:</p>
<pre>"H?????????????????????????????".length === 59</pre>
<p>А далее можете это использовать в уже упомянутом коде в статье</p>



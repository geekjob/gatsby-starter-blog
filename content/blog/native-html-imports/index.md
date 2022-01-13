---
title: "Native HTML Imports"
date: "2019-04-19T16:27:44.000Z"
description: "Рабочие HTML импорты Этот микропост скорее заметки на полях для себя, чтоб не протерять. Если хочется заимпортить HTML в страниц"
---

<h2 id="-html-">Рабочие HTML импорты</h2><p>Этот микропост скорее заметки на полях для себя, чтоб не протерять. Если хочется заимпортить HTML в страницу (а нативные импорты давно уж как депрекатед), то можно использовать такой трюк:</p><pre><code class="language-html">
&lt;iframe
onload="this.before(this.contentDocument.body.children[0]);this.remove()"
src="/parts/somepart.html"&gt;&lt;/iframe&gt;
</code></pre><p>Особенность такого варианта: как и во Vue.js нужно все оборачивать в родительский <code>div</code>, так как мы используем <code>children[0]</code> . При желании можно модифицировать этот вариант. Например, используя <code>spread operator</code> :</p><pre><code class="language-html">
&lt;iframe
onload="this.before(...this.contentDocument.body.children);this.remove()"
src="hello2.htm"&gt;&lt;/iframe&gt;
</code></pre>


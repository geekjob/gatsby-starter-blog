---
title: "Logical assignment in JS"
date: "2020-05-16T17:35:04.00Z"
description: "Логические присваивания в движке V8.4 Уже доступен в браузерах и Node.js под флагами новый синтаксис логических выражений с прис"
---

<h2 id="-v8-4">Логические присваивания в движке V8.4</h2><p>Уже доступен в браузерах и Node.js под флагами новый синтаксис логических выражений с присваиванием. Язык все пухнет и разрастается. Для опытных разработчиков это будет удобно, для новичков - это будет отвал башки. Про что собственно речь?</p><p>Есть такое предложение, которое уже на Stage 3, которое декларирует следующее: вместо того, чтобы писать код вида:</p><pre><code class="language-javascript">// Display a default message if it doesn’t override anything.
// Buggy! May cause inner elements of msgElement to
// lose focus every time it’s called.

function setDefaultMessageBuggy() {
  msgElement.innerHTML = msgElement.innerHTML || '&lt;p&gt;No messages&lt;p&gt;';
}</code></pre><p>Мы так уже привыкли писать испокон веков и вроде бы все ок, но в данном примере вроде как есть проблемы производительности, так как будет присвоено в элемент значение самого элемента, что может вызвать репаинт, потому что в результате в msgElement будут удалены все внутренние элементы из DOM дерева, а затем присвоены заново.</p><p>Новый синтаксис помимо короткой записи будет так же оптимизирован:</p><pre><code class="language-javascript">// Display a default message if it doesn’t override anything.
// Only assigns to innerHTML if it’s empty. Doesn’t cause inner
// elements of msgElement to lose focus.

function setDefaultMessage() {
  msgElement.innerHTML ||= '&lt;p&gt;No messages&lt;p&gt;';
}</code></pre><p>Ну и в целом такая запись короче, что повлечет за собой сокращение кода на N байт.</p><p>Варианты логических присваиваний:</p><pre><code class="language-javascript">// "Or Or Equals" (or, the Mallet operator :wink:)
a ||= b;
a || (a = b);

// "And And Equals"
a &amp;&amp;= b;
a &amp;&amp; (a = b);

// "QQ Equals"
a ??= b;
a ?? (a = b);</code></pre><h3 id="-">Поддержка</h3><p>Фича есть в бабаеле, по флагами в Chrome, Firefox, Safari и в Node.js под флагом <code>--harmony-logical-assignment</code> .</p><h3 id="--1">Материалы по теме</h3>- <a class="kg-bookmark-container" href="https://github.com/tc39/proposal-logical-assignment"><div class="kg-bookmark-content"><div class="kg-bookmark-title">tc39/proposal-logical-assignment</div><div class="kg-bookmark-description">A proposal to combine Logical Operators and Assignment Expressions - tc39/proposal-logical-assignment</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://github.githubassets.com/favicons/favicon.svg"><span class="kg-bookmark-author">tc39</span><span class="kg-bookmark-publisher">GitHub</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://avatars3.githubusercontent.com/u/1725583?s=400&amp;v=4"></div></a> <br/>



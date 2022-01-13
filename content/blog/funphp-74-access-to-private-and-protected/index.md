---
title: "FunPHP 7.4: access to private and protected"
date: "2019-11-15T15:04:57.00Z"
description: "Паблик Морозов на собеседовании Есть у меня статья про то, как Паблик Морозов на собеседовании получал доступы к private и prote"
---

<h4 id="-">Паблик Морозов на собеседовании</h4><p>Есть у меня <a href="https://medium.com/@frontman/php-access-to-private-and-protected-b1028b974169" rel="noopener noreferrer">статья про то, как Паблик Морозов на собеседовании получал доступы к private и protected полям</a>. С выходом PHP 7.4, который зарелизится 28 ноября 2019 года, можно переписать пару примеров. Один из таких примеров с использованием лямбд.</p><p>Простая универсальная отмычка на PHP 7.4:</p><pre><code class="language-php">&lt;?php

function &amp; crackprop(object $obj, string $prop) {

return (Closure::bind(fn&amp;()=&gt;$this-&gt;$prop,$obj,$obj))();}
</code></pre><pre><code class="language-php">&lt;?php

$pm = new PublicMorozov;

$foo = &amp;crackprop($pm, 'foo');
$foo = 456;

var_dump($foo);
var_dump($pm-&gt;foo());
</code></pre><p>Подробности про доступ к закрытым полям читайте в предыдущей статье:</p>- <a class="kg-bookmark-container" href="/fun-php-5-access-to-private-and-protected/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">FunPHP#5: access to private and protected</div><div class="kg-bookmark-description">Паблик Морозов на собеседовании
PHP protected &amp; private property hacker На собеседованиях каких вопросов только не встретишь. Матерые волки, собеседуя
php-гуру, могут спрашивать разные нетривиальные вещи. Одна из таких вещей:
паттерн “Паблик Морозов”. &gt; Паблик Морозов — антипаттерн, позволяющий по…</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://tech.geekjob.ru/favicon.png"><span class="kg-bookmark-author">Александр Майоров</span><span class="kg-bookmark-publisher">Geekjob Tech</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://www.gravatar.com/avatar/8f8f604430a6a2116749fad87c9c86d5?s=250&amp;d=mm&amp;r=x"></div></a> <br/>
<p></p>


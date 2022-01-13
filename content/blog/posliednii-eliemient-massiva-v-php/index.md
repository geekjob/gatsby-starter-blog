---
title: "Последний элемент массива в PHP"
date: "2020-04-29T11:02:09.00Z"
description: "Спортивное и полезное   В статье будут не только полезные варианты, но и just for fun — показать что так тоже можно.  Я как-то п"
---

<h2 id="-">Спортивное и полезное</h2><p></p><p>В статье будут не только полезные варианты, но и just for fun — показать что так тоже можно.</p><p>Я как-то писал подробный разбор как получить последний элемент массива в JavaScript:</p><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="/js-nayti-kraynego-v-spiske/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">Найти крайнего в списке</div><div class="kg-bookmark-description">Last in list. Hacks and tricks with Array in JS Сегодня пара слов про работу с массивами в JS. В целом работа с массивами (akaсписками) в JavaScript — это большая тема. Что-то уже я когда-то описывал. Все водну большую статью пихать не хочется — я сам не люблю лонгриды. Данный постнавеян недав…</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://tech.geekjob.ru/favicon.png"><span class="kg-bookmark-author">Geekjob Tech</span><span class="kg-bookmark-publisher">Александр Майоров</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://www.gravatar.com/avatar/8f8f604430a6a2116749fad87c9c86d5?s&#x3D;250&amp;d&#x3D;mm&amp;r&#x3D;x"></div></a></figure><p>Такую же задачу иногда приходится решать и в PHP. В целом методов много и даже можно повторить варианты из предыдущей статьи, но в PHP есть пара вариантов, которые лучше всего использовать.</p><h2 id="-end">Вариант первый - end</h2><p>Если ничего не изобретать, то чтобы получить последний элемент массива, можно воспользоваться функцией end:</p><pre><code class="language-php">&lt;?php

$a = ['a', 'b', 'c'];

$last = end($a);

</code></pre><p>Этот вариант продакшен реди, так сказать. Но есть еще куча способов решить эту задачу.</p><h2 id="--1">Вариант с деструктуризацией</h2><p>Этот вариант по сути копирует возможности JS:</p><pre><code class="language-php">&lt;?php

[$last] = array_slice($a, -1);
</code></pre><h2 id="-list">Вариант с list</h2><p>Если массив небольшой, с заранее известным количеством элементов (как у нас 3): то вы можете написать такую инструкцию:</p><pre><code class="language-php">&lt;?php

list(,,$last) = $a;</code></pre><p>А еще можно создать новый массив со срезом по индексу:</p><pre><code class="language-php">&lt;?php

list($last[2]) = $a;
</code></pre>


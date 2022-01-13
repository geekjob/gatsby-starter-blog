---
title: "Optional Chaining in PHP"
date: "2020-06-29T11:04:09.000Z"
description: "Есть ли возможность?
В JS есть такая штука как Optional Chaining. Про эту фичу есть в заметке

JS/ES2020: Optional Chainingand N"
---

<h2 id="-">Есть ли возможность?</h2><p>В JS есть такая штука как Optional Chaining. Про эту фичу есть в заметке</p>- <a class="kg-bookmark-container" href="/js-optional-chainingand-nullish-coalescing/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">JS/ES2020: Optional Chainingand Nullish Coalescing</div><div class="kg-bookmark-description">На дворе 2020 год, а в ES2020 уже есть 2 долгожданные фичи, которые облегчатработу. Но самое интересное, что эти фичи уже точно можно использовать впродакшене. Давайте рассмотрим их с примерами и поймем профит. Во первых - эти фичи уже доступны в браузерах: Т.е. эти фичи вполне можно использоват…</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://tech.geekjob.ru/favicon.png"><span class="kg-bookmark-author">Geekjob Tech</span><span class="kg-bookmark-publisher">Александр Майоров</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://www.gravatar.com/avatar/8f8f604430a6a2116749fad87c9c86d5?s&#x3D;250&amp;d&#x3D;mm&amp;r&#x3D;x"></div></a> <br/>
<p>Суть проста: мы можем обратиться к несуществующей ветви объекта и при этом не получить ошибку. А есть ли такая возможность в PHP? Более того, в пхп у нас есть не только объекты как экземпляры класса, но и такая структура данных как ассоциативный массив (по сути словарь в терминах того же python).</p><p>Если в PHP обратиться к несуществующей ветке объекта или словаря (ассоциативного массива), то будут два типа ошибок:</p><ul><li>Notice в случае доступа к несуществующему полю у существующего</li><li>Warning в случае  доступа к несуществующему полю у несуществующего</li></ul><p>Кто-то предлагает просто все это дело мьютить символом собака:</p><pre><code class="language-php">&lt;?php declare(strict_types=1);

$a = [];
$r = @$a['b']['c']['d'];

// Без скрытия сообщений об ошибках
// Notice: Undefined index: b
// Warning: Trying to access array offset on value of type null
// Warning: Trying to access array offset on value of type null


#EOF#</code></pre><p>В случае с объектом типа stdClass:</p><pre><code class="language-php">&lt;?php declare(strict_types=1);

$a = (object)[];
$r = @$a-&gt;b-&gt;c-&gt;d;

// Без скрытия сообщений об ошибках
// Warning: Undefined property: stdClass::$a
// Warning: Attempt to read property 'b' on null
// Warning: Attempt to read property 'c' on null


#EOF#</code></pre><p>Но скрытие ошибок не лучший вариант, более того, это не избавляет от срабатывания кастомных обработчиков ошибок.</p><p>Другой вариант - использовать <code>isset</code>. Прелесть оператора в том, что ему можно передать всю цепочку:</p><pre><code class="language-php">&lt;?php


$r = isset($a['b']['c']['d']) ? $a['b']['c']['d'] : null;



#EOF#</code></pre><p> И это не вызовет ошибок. Но запись все еще длинная. Самый лучший и верный вариант это использовать Nullish Coalescing (объединение с Null) оператор:</p><pre><code class="language-php">&lt;?php declare(strict_types=1);


$r = $a['b']['c']['d'] ?? null;

$r = $a-&gt;b-&gt;c-&gt;d ?? null;



#EOF#</code></pre><p>Коротко, без генерации ошибок. Не путать с краткой записью тернарного оператора ( <code>?:</code> ), который делает логическую проверку, но не делает проверку на <code>isset</code>.  Более того, логическая проверка меняет поведение и результат будет иной. Так что самый верный вариант - это Nullish Coalescing оператор.</p><h2 id="-empty">Использование Empty</h2><p>В PHP есть еще одна встроенная функция - empty. Она точно так же как <code>isset</code> делает проверку на существование, но дополнительно еще делает проверку на пустое значение. Пустое значение это:</p><ul><li><code>""</code> (пустая строка)</li><li><code>0</code> (целое число)</li><li><code>0.0</code> (число с плавающей точкой)</li><li><code>"0"</code> (строка)</li><li><strong><code><strong>NULL</strong></code></strong></li><li><strong><code><strong>FALSE</strong></code></strong></li><li><code>array()</code>, <code>[]</code> (пустой массив)</li></ul><p>Это так же может быть удобно, если вам нужно еще дополнительно сделать проверку:</p><pre><code class="language-php">&lt;?php

empty($a['b']['c']['d']);


#</code></pre><p>В случае с <code>isset</code> и <code>empty</code> переменная может вообще не существовать изначально, точно так же как и с оператором Nullish Coalescing.</p><p>Вот такой вот простой лайфхак.</p>


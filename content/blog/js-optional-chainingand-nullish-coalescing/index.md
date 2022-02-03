---
title: "JS/ES2020: Optional Chaining and Nullish Coalescing"
date: "2020-06-13T19:23:37.00Z"
description: "На дворе 2020 год, а в ES2020 уже есть 2 долгожданные фичи, которые облегчат работу. Но самое интересное, что эти фичи уже точно"
---

<p>На дворе 2020 год, а в ES2020 уже есть 2 долгожданные фичи, которые облегчат работу. Но самое интересное, что эти фичи уже точно можно использовать в продакшене. Давайте рассмотрим их с примерами и поймем профит.</p><p>Во первых - эти фичи уже доступны в браузерах:</p><figure class="kg-card kg-image-card"><img src="https://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/images/2020/06/--------------2020-06-11---14.33.10.png" class="kg-image"></figure><figure class="kg-card kg-image-card"><img src="https://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/images/2020/06/--------------2020-06-11---14.33.30.png" class="kg-image"></figure><p>Т.е. эти фичи вполне можно использовать даже на некоторых продакшенах без транспайлеров. Во 2х - эти фичи есть в бабеле и TS, а если вы пишите на Vue, React или Angular - то вы точно используете какой-то транспайлер.</p><p>В Node.js эти фичи так же доступны, но с 14й версии, так что если у вас LTS - пока рано юзать нативно, но скоро можно будет.</p><p>Собственно что дают эти фичи и на сколько они взаимозаменяемы?</p><h2 id="nullish-coalescing">Nullish Coalescing</h2><p>Эта фич давно есть в других языках, и яркий представитель веб мира - PHP. В PHP не требуется заранее объявлять переменные, поэтому с помощью этого оператора можно проверять существование переменной и возвращать дефолтный результат:</p><pre><code class="language-php">&lt;?php

$res = $a ?? 1;
print($res);</code></pre><p>В JS обращение к несуществующей переменной - это всегда ошибка, но(!). Вы можете общаться через глобальную область (если вы работаете в глобальной области):</p><pre><code class="language-javascript">let res = globalThis.a ?? 1
console.log(res)
</code></pre><p>Вы можете сказать, но раньше же мы писали:</p><pre><code class="language-javascript">var res = window.a || 1;</code></pre><p>Да, но тут есть но(!) и оно важное. Тут вернется дефолтное значение если <code>a</code> будет при булевом преобразовании давать false. А нам нужно проверить, есть ли значение иначе вернуть дефолтное:</p><pre><code class="language-javascript">function f(x) { return x || 1 }
f(0) // = 1

function f(x) { return x ?? 1 }
f(0) // = 0</code></pre><p>В данном случае у нас более правильное сравнение, так как <code>0</code> в данном случае валидное значение которое мы хотим обработать.</p><h2 id="optional-chaining">Optional Chaining</h2><p>Оу, эту фичу ждали давно и она реально оправдана имхо. Теперь очень легко работать с встроенным querySelector, так как мы можем без ошибок писать теперь:</p><pre><code class="language-javascript">let $div = docuemnt
    .querySelector('#nonexists')
   ?.innerText
   ?.replaceAll('foo', 'bar')</code></pre><p>Красота да и только. Точнее удобство, не красота. Но явно это удобно.</p><p>Ну и ко всему этому добавьте еще Logical assigment и мы получим просто десятки новых вариантов присвоить дефолтное значение или построить выражение, альтернативное тернарному оператору. Да, тернарный оператор кажется каким-то анахронизмом после таких сахаров.</p><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="/js-logical-assignment/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">Logical assignment in JS</div><div class="kg-bookmark-description">Логические присваивания в движке V8.4
Уже доступен в браузерах и Node.js под флагами новый синтаксис логических
выражений с присваиванием. Язык все пухнет и разрастается. Для опытных
разработчиков это будет удобно, для новичков - это будет отвал башки. Про что
собственно речь? Есть такое предложени…</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://tech.geekjob.ru/favicon.png"><span class="kg-bookmark-author">Александр Майоров</span><span class="kg-bookmark-publisher">Geekjob Tech</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://tech.geekjob.ruhttps://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/images/2020/05/--------------2020-05-16---20.34.06.png"></div></a></figure>


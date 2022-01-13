---
title: "IDN — Punycode"
date: "2020-02-05T18:25:38.00Z"
description: "Работаем с кириллическими доменами Собственно речь пойдет о том, как работать с кирилическими (и не только) доменами в PHP, Node"
---

<!--kg-card-begin: html--><h4>Работаем с кириллическими доменами</h4>
<p>Собственно речь пойдет о том, как работать с кирилическими (и не только) доменами в PHP, Node.js, Bash/Zsh и Python. Почему такой выбор языков? Это стек проекта <a href="https://geekjob.ru" target="_blank" rel="noopener noreferrer">GeekJob.ru</a>, над которым я работаю.</p>
<blockquote><p>
<strong>IDN</strong> (<em>Internationalized Domain Names</em> — интернационализованные доменные имена) — это доменные имена, которые содержат символы национальных алфавитов.</p></blockquote>
<blockquote><p>К IDN относятся как адреса с нелатинскими буквами на традиционных доменах верхнего уровня, так и нелатинские домены — домены верхнего уровня, составленные из букв нелатинских алфавитов планеты: кириллица, арабский алфавит и др. IDN домены также существуют в крупных международных доменных зонах.</p></blockquote>
<blockquote><p>
<strong>Punycode</strong> — стандартизированный метод преобразования последовательностей Unicode-символов в так называемые ACE-последовательности (<em>ASCII Compatible Encoding</em> — кодировка, совместимая с ASCII), которые состоят только из алфавитно-цифровых символов, как это разрешено в доменных именах. Punycode был разработан для однозначного преобразования доменных имен в последовательность ASCII-символов.</p></blockquote>
<p>Что из себя представляет такой домен в виде пуникода:</p>
<pre>https://александр-майоров.рф</pre>
<pre>В виде punycode последовательности будет выглядеть так:</pre>
<pre><a href="https://xn----7sbabkjf0beiqjsayfh.xn--p1ai/" target="_blank" rel="noopener noreferrer">https://xn----7sbabkjf0beiqjsayfh.xn--p1ai/</a></pre>
<p>В такой вид, например, приводит JS класс URL:</p>
<pre>new URL('https://александр-майоров.рф')</pre>
<pre>href: "https://xn----7sbabkjf0beiqjsayfh.xn--p1ai/"<br>origin: "https://xn----7sbabkjf0beiqjsayfh.xn--p1ai"<br>protocol: "https:"<br>host: "xn----7sbabkjf0beiqjsayfh.xn--p1ai"<br>hostname: "xn----7sbabkjf0beiqjsayfh.xn--p1ai"</pre>
<p>А каким образом получить назад читаемый вид? Я выбрал стратегию, в которой в базе хранится оригинальное название домена, без конвертации. Поэтому на бэкенде у меня такие ссылки преобразуются. Пойдем по порядку, как сделать это в Node.js ?</p>
<h4>Node.js</h4>
<p>В Ноде до недавнего времени модуль punycode был встроен, но затем был вынесен (пруф <a href="https://nodejs.org/api/punycode.html" target="_blank" rel="noopener noreferrer">https://nodejs.org/api/punycode.html</a>)</p>
<p>Теперь модуль существует независимо от ноды в виде <a href="https://github.com/bestiejs/punycode.js" target="_blank" rel="noopener noreferrer">Punycode.js</a></p>
<p>Устанавливаем:</p>
<pre>npm install punycode --save</pre>
<p>Ну и далее работаем так:</p>
<pre>punycode.toUnicode('xn----7sbabkjf0beiqjsayfh.xn--p1ai');</pre>
<p>Важно! Конвертер должен принимать домен, без префикса протокола. Иначе на выходе будет неожиданный результат.</p>
<h4>PHP</h4>
<p>В PHP работа с IDN встроена и достаточно просто вызвать встроенную функцию:</p>
<pre>&lt;?php</pre>
<pre>echo idn_to_utf8('xn----7sbabkjf0beiqjsayfh.xn--p1ai');</pre>
<p>Пруф: <a href="https://www.php.net/manual/ru/function.idn-to-utf8.php" target="_blank" rel="noopener noreferrer">https://www.php.net/manual/ru/function.idn-to-utf8.php</a></p>
<h4>Python</h4>
<p>В питоне уже встроена возможность работать с IDN доменами и есть кодек idna, и все это доступно в строках. Но есть нюансы.</p>
<p>Если мы хотим получить punycode, то мы можем вызвать метод encode у обычной строки:</p>
<pre>uri = "александр-майоров.рф"<br>print(uri.<strong>encode("idna")</strong>)</pre>
<p>И на выходе мы получаем бинарную строку. А вот если хотим сделать наоборот, то мы должны так же работать с бинарными строками. Поэтому если у вас на входе обычная строка, то чтобы ее преобразовать пишем такой код:</p>
<pre>uri = <strong>bytearray</strong>('xn----7sbabkjf0beiqjsayfh.xn--p1ai', 'utf8')<br>print(uri.<strong>decode("idna")</strong>)</pre>
<h4>Bash/Zsh</h4>
<p>Если же вам нужно работать с доменами в шеле, то тут тоже есть нужные утилиты, одна из которых idn</p>
<p>Она есть почти под все платформы. Умеет как кодировать, так и декодировать:</p>
<pre>idn "александр-майоров.рф"</pre>
<pre>и наоборот:</pre>
<pre>idn -u "xn----7sbabkjf0beiqjsayfh.xn--p1ai"</pre>
<!--kg-card-end: html-->


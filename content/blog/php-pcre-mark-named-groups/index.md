---
title: "PHP PCRE MARK & Named groups"
date: "2021-08-10T11:46:25.000Z"
description: "Заметка про группировки в регулярных выражениях при использовании preg_match_all  Сколько лет я в индустрии, более 20 лет в разр"
---

<p>Заметка про группировки в регулярных выражениях при использовании preg_match_all</p><p>Сколько лет я в индустрии, более 20 лет в разработке и в PHP... За свою жизнь много использовал регулярные Perl и POSIX совместимые регулярные выражения и только недавно узнал что в PCRE регулярках помимо именованных груп есть еще и маркированные группы.</p><p>И вроде как они даже по потреблению ресурсов выигрывают перед именованными (как минимум нет дублирования значений).</p><p>Короче, суть: в регулярных выражениях можно получить группы искомых вхождений:</p><pre><code class="language-php">if (preg_match_all('~([a-z])|(\d)~', 'a 1 bc 23 def', $a))
{
    var_dump($a);
}
</code></pre><p>Получим следующий вывод:</p><pre><code class="language-php">array(3) {
  [0]=&gt;
  array(9) {
    [0]=&gt;
    string(1) "a"
    [1]=&gt;
    string(1) "1"
    [2]=&gt;
    string(1) "b"
    [3]=&gt;
    string(1) "c"
    [4]=&gt;
    string(1) "2"
    [5]=&gt;
    string(1) "3"
    [6]=&gt;
    string(1) "d"
    [7]=&gt;
    string(1) "e"
    [8]=&gt;
    string(1) "f"
  }
  [1]=&gt;
  array(9) {
    [0]=&gt;
    string(1) "a"
    [1]=&gt;
    string(0) ""
    [2]=&gt;
    string(1) "b"
    [3]=&gt;
    string(1) "c"
    [4]=&gt;
    string(0) ""
    [5]=&gt;
    string(0) ""
    [6]=&gt;
    string(1) "d"
    [7]=&gt;
    string(1) "e"
    [8]=&gt;
    string(1) "f"
  }
  [2]=&gt;
  array(9) {
    [0]=&gt;
    string(0) ""
    [1]=&gt;
    string(1) "1"
    [2]=&gt;
    string(0) ""
    [3]=&gt;
    string(0) ""
    [4]=&gt;
    string(1) "2"
    [5]=&gt;
    string(1) "3"
    [6]=&gt;
    string(0) ""
    [7]=&gt;
    string(0) ""
    [8]=&gt;
    string(0) ""
  }
}</code></pre><p>В нулевом массиве всегда будут все вхождения, а вот далее мы применили группировки. И тут прям из примера видно что ничего не понятно или понятно, но с трудом - дублируется информация, много лишнего.</p><h3 id="-">Именованные группы</h3><p>Да, это так и в PCRE есть возможность задавать именованные группы, чтобы пользоваться ими было проще. Простой пример абстрактной задачи - найти все числа и буквы, указав что есть число, а что буква</p><pre><code class="language-php">&lt;?php declare(strict_types=1);


preg_match_all('~(?P&lt;alpha&gt;[a-z]+)|(?P&lt;digit&gt;\d+)~', '1 a 2 bc 34 56 def', $a);
foreach (array_filter($a, 'is_string', ARRAY_FILTER_USE_KEY) as $key =&gt; $items)
    if (is_array($items) &amp;&amp; !empty($items))
        foreach($items as $val)
            if (!empty($val))
                print "'$val' is $key\n";
</code></pre><p>Получаем такой вывод:</p><pre><code>'a' is alpha
'bc' is alpha
'def' is alpha
'1' is digit
'2' is digit
'34' is digit
'56' is digit</code></pre><h3 id="--1">Маркированные группы</h3><p>И вот только недавно в мануалах я нашел что-то про маркированные группы:</p>- <a class="kg-bookmark-container" href="http://pcre.org/current/doc/html/pcre2pattern.html"><div class="kg-bookmark-content"><div class="kg-bookmark-title">pcre2pattern specification</div><div class="kg-bookmark-description"></div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="http://pcre.org/favicon.ico"></div></div></a> <br/>
<p>Абзац про "<strong>Recording which path was taken"</strong></p><p>Суть: каждую группу можно пометить маркером. В отличие от именованных групп, маркированные работают немного по другому, от этого и синтаксис другой:</p><pre><code class="language-php">&lt;?php declare(strict_types=1);


preg_match_all('~(?:[a-z]+)(*:alpha)|(?:\d+)(*:digit)~', '1 a 2 bc 34 56 def', $a);
foreach($a[0] as $key =&gt; $val)
    print "'$val' is {$a['MARK'][$key]} \n";
</code></pre><p>Так выглядит предыдущий алгоритм, но с применением марикрованных груп.</p><p>Синтаксис:</p><pre><code>(?:some regex)(*MARK:nameofgroup)

 или сокращенная запись
 
(?:some regex)(*:nameofgroup)</code></pre><p>И в том и в том случае на выходе будет сформирован ключ MARK в котором будут указаны имена групп для каждого найденного совпадения.</p><pre><code class="language-php">array(2) {
  [0]=&gt;
  array(7) {
    [0]=&gt;
    string(1) "1"
    [1]=&gt;
    string(1) "a"
    [2]=&gt;
    string(1) "2"
    [3]=&gt;
    string(2) "bc"
    [4]=&gt;
    string(2) "34"
    [5]=&gt;
    string(2) "56"
    [6]=&gt;
    string(3) "def"
  }
  ["MARK"]=&gt;
  array(7) {
    [0]=&gt;
    string(5) "digit"
    [1]=&gt;
    string(5) "alpha"
    [2]=&gt;
    string(5) "digit"
    [3]=&gt;
    string(5) "alpha"
    [4]=&gt;
    string(5) "digit"
    [5]=&gt;
    string(5) "digit"
    [6]=&gt;
    string(5) "alpha"
  }
}</code></pre><p>Резюмируя: иногда может быть удобнее и эффективнее работать с маркированными группами вместо именованных.</p>


---
title: "PHP Short Plural function"
date: "2020-04-29T10:22:46.000Z"
description: "Склоняем числительные на PHP 7.4 Небольшая зарисовка на тему как сделать склонение числительных на PHP 7.4 используя новый синта"
---

<h2 id="-php-7-4">Склоняем числительные на PHP 7.4</h2><p>Небольшая зарисовка на тему как сделать склонение числительных на PHP 7.4 используя новый синтаксис лямбд:</p><pre><code class="language-php">&lt;?php

function create_plural(array $a): callable
{
    return fn(int $n): string =&gt; sprintf(
        $a[
            (20 &gt; ($n %=100) &amp;&amp; $n &gt; 4)
                ? 2
                : [2,0,1,1,1,2][ (($n %= 10) &lt; 5) ? $n : 5]
        ], $n
    );
}


$plural_day = create_plural(['%s день','%s дня','%s дней']);

var_dump(
	$plural_day(1), // 1 день
	$plural_day(2), // 2 дня
	$plural_day(5)  // 5 дней
);

</code></pre>


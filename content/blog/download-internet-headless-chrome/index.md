---
title: "Читаем offline"
date: "2017-12-28T22:20:48.000Z"
description: "Как заархивировать интернет на дискеты
На новогодние праздники улетаю на 2 недели в Японию. Перелет — 10 часов. Самое
время чита"
---

<h4>Как заархивировать интернет на дискеты</h4>
<p>На новогодние праздники улетаю на 2 недели в Японию. Перелет — 10 часов. Самое время читать. Что читать? Например переводы <a href="https://medium.com/u/34515607191" target="_blank" rel="noopener noreferrer">Andrey Melikhov</a> и его блог “Девшахта”. Ручками сохранять — не наш метод. Удобным вам способом собираете нужные ссылки, а затем пишите вот такой простой bash скрипт, который с помощью хедлес хрома сохранит все в PDF:</p>
<pre>#/bin/bash<br><strong>list</strong>=`cat medium.txt`<br><strong>for</strong> lnk <strong>in</strong> $list<br><strong>do</strong><br> [ "break" == $lnk ] &amp;&amp; <strong>break</strong><br><strong>echo</strong> $lnk<br> fn=<em>"$(basename ${lnk::${#lnk}-13}).pdf"</em><br> /Applications/Google Chrome.app/Contents/MacOS/Google Chrome <br>   --headless --disable-gpu <br>   --print-to-pdf="$fn" $lnk<br><strong>done</strong></pre>
<p>Список ссылок храните в файле, по 1й ссылке на строку.</p>
<p>Вариант для скачивания ХабраХабра:</p>
<pre>#/bin/bash<br><strong>list</strong>=`cat habra.txt`<br><strong>for</strong> lnk in $list<br><strong>do</strong><br> [ "break" == $lnk ] &amp;&amp; <strong>break<br> echo</strong> $lnk<br> fn=<em>"$(basename $lnk).pdf"</em><br> /Applications/Google Chrome.app/Contents/MacOS/Google Chrome <br>    --headless --disable-gpu <br>    --print-to-pdf="$fn" $lnk<br><strong>done</strong></pre>
<p>Отличия только в именовании сохраненных файлов. Как собрать ссылки — это уже каждый решает для себя сам. Можно тем же хедлес хромом, но я решил все же пройтись по страницам и выбрать статьи по заголовкам. Все же не хочу скачивать весь интернет. Но ленивые могут накатать скрипт.</p>
<p>Итого в полет я беру 42 статьи и книгу по Rust =)</p>



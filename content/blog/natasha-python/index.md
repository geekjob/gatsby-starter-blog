---
title: "Библиотека Natasha"
date: "2018-07-12T14:34:53.00Z"
description: "ImportError: cannot import name ‘TagMorphTokenizer’ from ‘yargy.tokenizer’ В своих проектах ( New.HR [https://newhr.ru], GeekJob"
---

<!--kg-card-begin: html--><h4>ImportError: cannot import name ‘TagMorphTokenizer’ from ‘yargy.tokenizer’</h4>
<p>В своих проектах ( <a href="https://newhr.ru" target="_blank" rel="noopener noreferrer">New.HR</a>, <a href="https://geekjob.ru" target="_blank" rel="noopener noreferrer">GeekJob.ru</a> ) я использую библиотеку для извлечения фактов Natasha.</p>
<blockquote><p>Natasha — библиотека для поиска и извлечения именованных сущностей (<a href="https://en.wikipedia.org/wiki/Named-entity_recognition" target="_blank" rel="noopener noreferrer">Named-entity recognition</a>) из текстов на русском языке. В библиотеке собраны грамматики и словари для парсера <a href="https://github.com/natasha/yargy" target="_blank" rel="noopener noreferrer">Yargy</a>.</p></blockquote>
<p>Написана она на питоне и очень не плохо показывает себя. Есть свои косяки и недочеты, но эта библиотека у меня работает в связке с эвристиками и другими библиотеками. Так вот к чему это я. После недавнего обновления вдруг перестал запускаться парсер выдавая ошибку:</p>
<pre>ImportError: cannot import name ‘TagMorphTokenizer’ from ‘yargy.tokenizer’</pre>
<p>Если вы столкнулись с этой проблемой, то лечится это следующим образом:</p>
<pre><code><strong>pip</strong> <strong>install</strong> natasha==0.10.0 yargy==0.11.0</code></pre>
<p>Ишью по этому поводу создано. Для тех кто не знал — попробуйте, интересная опенсорс разработка для обработки неструктурированных текстов.</p>
<p>Доументация по библиотеке <a href="http://natasha.readthedocs.io/ru/latest/" target="_blank" rel="noopener noreferrer">http://natasha.readthedocs.io/ru/latest/</a></p>
<!--kg-card-end: html-->


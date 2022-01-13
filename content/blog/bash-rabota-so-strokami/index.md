---
title: "Работа со строками в Bash"
date: "2016-01-09T18:40:50.000Z"
description: "Это памятка, т. к. периодически забываю.  Извлечение подстроки ${string:position} — с position до конца ${string:position:length"
---

<p><em>Это памятка, т. к. периодически забываю.</em></p>
<h4>Извлечение подстроки</h4>
<pre>${string:position} — с position до конца<br>${string:position:length} - с position длиной length символов<br>${string: -length} - последние length символов</pre>
<h4>Удаление части строки</h4>
<pre>${string#substring} — до первого с начала<br>${string##substring} — до последнего с начала<br>${string%substring} — до первого с конца<br>${string%%substring} — до последнего с конца</pre>
<h4>Замена подстроки</h4>
<pre>${string/substring/replacement} — первое вхождение</pre>
<pre>${string//substring/replacement} — все вхождения</pre>
<pre>${var/#Pattern/Replacement} — Если в переменной var найдено совпадение с Pattern, причем совпадающая подстрока расположена в начале строки (префикс), то оно заменяется на Replacement. Поиск ведется с начала строки ${var/%Pattern/Replacement} — Если в переменной var найдено совпадение с Pattern, причем совпадающая подстрока расположена в конце строки (суффикс), то оно заменяется на Replacement. Поиск ведется с конца строки</pre>
<pre>${#string} — Длина строки</pre>
<h4>Пример</h4>
<pre>a="12345"<br>echo "${a}"<br>echo "${a:3}"<br>echo "${a#12}"<br>echo "${a/12/21}"</pre>



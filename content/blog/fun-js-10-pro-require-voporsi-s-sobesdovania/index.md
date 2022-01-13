---
title: "FunES#10: Про require()"
date: "2019-10-09T02:50:13.00Z"
description: "Очередная задачка с собеседования Представим такую ситуацию, вы разрабатываете приложение на Node.js. Ваша рабочая ОС — Mac OS и"
---

<h2 id="-">Очередная задачка с собеседования</h2><!--kg-card-begin: html-->
<p>Представим такую ситуацию, вы разрабатываете приложение на Node.js. Ваша рабочая ОС — Mac OS или Windows. Вы пишите что-то типа:</p>
<pre>company.js:<br>----------<br><strong>module</strong>.exports = {<br>   name: 'GeekJOB.ru'<br>};</pre>
<pre>----------<br>main.js:<br>----------</pre>
<pre><strong>const</strong> Company_1 = <strong>require</strong>('./company');<br><strong>const</strong> Company_2 = <strong>require</strong>('./company');<br>Company_1.name = 'New.HR';</pre>
<pre><br>console.log(Company_1) // ???<br>console.log(Company_2) // ???<br>console.log(Company_1 <strong>===</strong> Company_2) // ???</pre>
<p>Итак вопросы:</p>
<ul>
<li>Что будет в объектах?</li>
<li>Будут ли равны эти два объекта?</li>
<li>Будут ли ошибки?</li>
</ul>
<p>Слушаем ответы и продолжаем задавать вопросы. Теперь напишем еще пару строчек:</p>
<pre><strong>const</strong> Company_3 = <strong>require</strong>('./Company');<br><br>console.log(Company_3) // ???<br>console.log(Company_3 <strong>===</strong> Company_1) // ???<br>console.log(Company_3 <strong>===</strong> Company_2) // ???</pre>
<p>И что теперь?</p>
<p>Далее вы деплоите все это на Linux сервер (CentOS, Ubuntu, etc) и вопрос:</p>
<ul>
<li>Изменится ли что-либо?</li>
</ul>
<h3>Спойлеры</h3>
<pre>console.log(Company_1) // New.HR<br>console.log(Company_2) // New.HR<br>console.log(Company_1 <strong>===</strong> Company_2) // TRUE</pre>
<pre>console.log(Company_3) // GeekJOB.ru<br>console.log(Company_3 <strong>===</strong> Company_1) // FALSE<br>console.log(Company_3 <strong>===</strong> Company_2) // FALSE</pre>
<p>И когда вы задеплоите все это на Linux сервер, то результаты будут такими:</p>
<pre>console.log(Company_1) // New.HR<br>console.log(Company_2) // New.HR<br>console.log(Company_1 <strong>===</strong> Company_2) // TRUE</pre>
<pre>internal/modules/cjs/loader.js:638<br>    throw err;<br>    ^<br>Error: Cannot find module './Company'</pre>
<h3>Объяснение</h3>
<p>Все очень просто. Mac OS и Windows имеют регистронезависимую файловую систему, отсюда нет разницы между Company.js и company.js</p>
<p>Но вот Linux, как правило, используют регистрозависимые файловые системы, а посему можно создать в одной директории два файла сразу Company.js и company.js и это будут два разных файла.</p>
<p>Но(!), хоть файловые системы регистронезависимы, тем не менее кеш модульной системы различает регистры, поэтому файл company.js будет прочтен дважды и закеширован как два разных модуля на Mac OS и Windows системах.</p>
<p>Ну вот и все, никакой магии, но часы отладки, если не знать таких нюансов.</p>

<!--kg-card-end: html-->


---
title: "Comma separated parser"
date: "2017-11-28T16:37:42.00Z"
description: "В Nodejs быстро и без регулярок Вдруг встала задача принять данные с разделителем на сервере в Nodejs и распарсить их в объект. "
---

<h4>В Nodejs быстро и без регулярок</h4>
<p>Вдруг встала задача принять данные с разделителем на сервере в Nodejs и распарсить их в объект. Пример таких данных:</p>
<pre><strong>const</strong> rawstr = <em>'name:Alexander;position:CTO;job:New.HR'</em>;</pre>
<p>Я очень быстро могу придумать несколько способов, начиная от регулярных выражений, заканчивая фнукциями разбивания на массивы. Но есть способ лучше! В Nodejs есть объект <strong>querystring</strong>.</p>
<p>Пример парсера с использованием querystring:</p>
<pre><strong>const</strong> querystring = <strong><em>require</em></strong>(<em>'querystring'</em>);</pre>
<pre><strong>const</strong> rawstr = <em>'name:Alexander;position:CTO;job:New.HR'</em>;<br><strong>const</strong> result = querystring.<em>parse</em>(rawstr, ';', ':');</pre>
<pre><strong>console</strong>.log(result);<br><em>&gt; { name: "Alexander", position: "CTO", job: "New.HR" }</em></pre>
<p>Документация на данный объект и больше информации по ссылке:</p>
<p><a href="https://nodejs.org/api/querystring.html#querystring_querystring_parse_str_sep_eq_options">https://nodejs.org/api/querystring.html#querystring_querystring_parse_str_sep_eq_options</a></p>



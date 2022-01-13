---
title: "Sitemap.xml"
date: "2019-09-18T15:51:52.000Z"
description: "На Bash за 5 минут, без регистрации и SMS
Раньше я писал свои генераторы Sitemap на PHP. Затем я привык пользоваться
разными гот"
---

<h2 id="-bash-5-sms">На Bash за 5 минут, без регистрации и SMS</h2>
<p>Раньше я писал свои генераторы Sitemap на PHP. Затем я привык пользоваться разными готовыми генераторами, которые имеют ограничения либо платные. В очередной раз встал вопрос генерации Sitemap.xml для нового отредизайненного <a href="https://geekjob.ru" target="_blank" rel="noopener noreferrer">GeekJOB.ru</a></p>
<p>И тут что-то подумалось, а что если написать свой генератор на базе WGET? Ведь он умеет рекурсивно собирать ссылки по сайту. Нам нужно будет только проставить время и вес собранных ссылок. Вроде интересная задача, го решать…</p>
<h3>Ликбез</h3>
<p>Sitemap.xml — это XML-файл, в котором перечислены URL-адреса. Это в простом варианте. Более расширенный вариант предполагает наличие метаданных: дата последнего изменения, частота изменений, приоритет. Все это нужно чтобы поисковые системы могли более грамотно сканировать сайт.</p>
<p>Пример файла:</p>
<pre><em>&lt;?</em>xml version="1.0" encoding="UTF-8"<em>?&gt;<br></em>&lt;urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"<br> xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"&gt;<br>   &lt;url&gt;<br>      &lt;loc&gt;<strong>https://geekjob.ru/</strong>&lt;/loc&gt;<br>      &lt;lastmod&gt;<strong>2019-09-18T14:12:23+03:00</strong>&lt;/lastmod&gt;<br>      &lt;priority&gt;<strong>1.00</strong>&lt;/priority&gt;<br>   &lt;/url&gt;<br>   &lt;url&gt;<br>      &lt;loc&gt;<strong>https://geekjob.ru/vacancy</strong>&lt;/loc&gt;<br>      &lt;lastmod&gt;<strong>2019-09-18T14:12:23+03:00</strong>&lt;/lastmod&gt;<br>      &lt;priority&gt;<strong>0.80</strong>&lt;/priority&gt;<br>   &lt;/url&gt;<br>&lt;/urlset&gt;</pre>
<h3>Пишем Bash скрипт</h3>
<p>Собственно суть: собираем с помощью WGET рекурсивно ссылки с сайта и собираем файл:</p>
<pre><strong>#!/bin/bash<br><br><em>sitedomain</em></strong>=https://geekjob.ru<br><br><strong>rm</strong> -v linklist.txt<br><strong>wget</strong> --spider --recursive --level=inf -nv --output-file=linklist.txt --reject '*.js,*.css,*.ico,*.txt,*.gif,*.jpg,*.png,*.pdf,*.txt' --ignore-tags=img,link,script --header="Accept: text/html" --follow-tags=a <strong><em>$sitedomain</em></strong></pre>
<pre><strong>grep</strong> -i URL linklist.txt | awk -F 'URL:' '{print $2}' | awk '{$1=$1};1' | awk '{print $1}' <em>&gt; clearlinks.txt</em></pre>
<pre><strong>header</strong>='&lt;?xml version="1.0" encoding="UTF-8"?&gt;&lt;urlset<br> xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"<br> xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"<br> xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9<br> http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"&gt;' <br><strong>echo</strong> <em>$header &gt; sitemap.xml</em></pre>
<pre><strong>lastmod</strong>=$(date "+%Y-%m-%dT%H:%M:%S+03:00")<br><strong>limit</strong>=1024<br><strong>itr</strong>=0</pre>
<pre><strong>while read <em>link<br></em>do</strong><br>    (( itr++ )) ; [ <em>$itr </em>-eq <em>$limit</em> ] &amp;&amp; break<br><em># Костыльный способ весовки, мне он подходит, для вас - решайте сами<br>    priority</em>=0.80<br><strong>if</strong> [ <em>$itr </em>-eq 1 ]<br><strong>then</strong><br><em>priority</em>=1.00<br><strong>else</strong><br><strong>if</strong> [ <em>$itr </em>-gt 50 ];<strong>then</strong><br><em>priority</em>=0.76<br><strong>fi</strong><br><strong>if</strong> [ <em>$itr </em>-gt 128 ];<strong>then</strong><br><em>priority</em>=0.64<br><strong>fi</strong><br><strong>if</strong> [ <em>$itr </em>-gt 256 ];<strong>then</strong><br><em>priority</em>=0.51<br><strong>fi</strong><br><strong>if</strong> [ <em>$itr </em>-gt 512 ];<strong>then</strong><br><em>priority</em>=0.42<br><strong>fi</strong><br><strong>if</strong> [ <em>$itr </em>-gt 700 ];<strong>then</strong><br><em>priority</em>=0.33<br><strong>fi</strong><br><strong>fi</strong><br><em># Отформатированный вывод<br>    #echo -e "t&lt;url&gt;ntt&lt;loc&gt;$link&lt;/loc&gt;ntt&lt;lastmod&gt;$lastmod&lt;/lastmod&gt;ntt&lt;priority&gt;$priority&lt;/priority&gt;nt&lt;/url&gt;" &gt;&gt; sitemap.xml<br><br>    # Без лишних табуляторов<br></em><strong>echo</strong> -e "&lt;url&gt;&lt;loc&gt;<em>$link</em>&lt;/loc&gt;&lt;lastmod&gt;<em>$lastmod</em>&lt;/lastmod&gt;&lt;priority&gt;<em>$priority</em>&lt;/priority&gt;&lt;/url&gt;" <em>&gt;&gt; sitemap.xml<br></em><strong>done</strong> <em>&lt; clearlinks.txt</em></pre>
<pre><strong>echo</strong> -e "&lt;/urlset&gt;" <em>&gt;&gt; sitemap.xml</em></pre>
<pre><em>#EOF#</em></pre>
<p>Не знаю на сколько надо объяснять что в этом скрипте, вроде бы все просто. Если есть вопросы — задавайте в комментариях.</p>




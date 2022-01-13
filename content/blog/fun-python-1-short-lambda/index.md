---
title: "Fun Python #1: короткие лямбды"
date: "2020-01-06T02:42:45.000Z"
description: "Идиоматичные фильтры Как я писал в предыдущих постах, недавно, с 1 января 2020 года, я стал писать на Python. Я успел уже узнать"
---

<h4>Идиоматичные фильтры</h4>
<p>Как я писал в предыдущих постах, недавно, с 1 января 2020 года, я стал писать на Python. Я успел уже узнать что такое SQLAlchemy, и у меня немного порвало шаблон когда я увидел код такого вида:</p>
<pre><strong><em>def</em></strong><em> </em>tag_search(<em>slug</em>):<br>    tag = Tag.query.filter(<strong>Tag.slug == <em>slug</em></strong>).first_or_404()</pre>
<p>После других языков (например PHP, JavaScript, etc…) кажется что тут ошибка, ведь по сути мы передаем в функцию filter результат сравнения, который будет Bool. Но нет… Мы передаем объект, как результат работы операторов сравнения. И эта особенность Python меня очень порадовала.</p>
<p>Дабы проверить эту гипотезу, я немного поразбирался с перегрузкой операторов и тут меня осенила одна идея. А ведь можно сделать класс для замены лямбд, передаваемых в функции фильтрации.</p>
<p>Допустим есть такой список:</p>
<pre>a = [1, -4, 6, 8, -10, 0, 2, 4, -3, -12, 0]</pre>
<p>Я хочу его отфильтровать, получив все числа больше нуля. Я бы написал такой код:</p>
<pre>b = list(filter(<strong>lambda</strong> x: x &gt; 0, a))</pre>
<p>И, в принципе, так учат писать учебники и разные уроки по языку Python. Но, узнав про элегантную перегрузку операторов, благодаря SQLAlchemy, я подумал, а что если создать такой класс:</p>
<pre><strong>class</strong> X:<br><strong>def</strong> <strong>__ne__</strong>(<strong>self</strong>, obj): <strong>return</strong> <strong>lambda</strong> x: x != obj<br><strong>def</strong> <strong>__eq__</strong>(<strong>self</strong>, obj): <strong>return</strong> <strong>lambda</strong> x: x == obj<br><strong>def</strong> <strong>__gt__</strong>(<strong>self</strong>, obj): <strong>return</strong> <strong>lambda</strong> x: x &gt; obj<br><strong>def</strong> <strong>__ge__</strong>(<strong>self</strong>, obj): <strong>return</strong> <strong>lambda</strong> x: x &gt;= obj<br><strong>def</strong> <strong>__lt__</strong>(<strong>self</strong>, obj): <strong>return</strong> <strong>lambda</strong> x: x &lt; obj<br><strong>def</strong> <strong>__le__</strong>(<strong>self</strong>, obj): <strong>return</strong> <strong>lambda</strong> x: x &lt;= obj</pre>
<p>И теперь мы можем писать так:</p>
<pre>b = list(<strong>filter(x &gt; 0, a)</strong>)</pre>
<p>Мелочь, но как же идиоматично выглядит такая запись (мое имхо). Мы просто говорим что фильтруем список где x-овый элемент больше нуля. Конечно это может порвать шаблон, особенно если за плечами очень большой опыт разработки на других языках, где такое невозможно.</p>
<p>И я бы подумал что это очень плохой тон разработки на Python, но, господа, мне хочется тыкнуть в лицо библиотекой SQLAlchemy, которая пользуется популярностью и сказать, а почему им можно? ?</p>
<p>Если вы знаете еще подобные примеры — напишите в комментариях пожалуйста.</p>




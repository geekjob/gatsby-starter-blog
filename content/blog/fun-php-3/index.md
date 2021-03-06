---
title: "Fun PHP #3"
date: "2018-01-25T12:07:46.00Z"
description: "Значения по ссылке    Дано:  <?php  function getCount(&$a) { return count($a); }  $cnt = getCount( $foo ); var_dump($cnt);  $cnt"
---

<!--kg-card-begin: html--><h4>Значения по ссылке</h4>
<figure>
<p><img data-width="1010" data-height="482" src="https://cdn-images-1.medium.com/max/800/1*_-Bm_N5NPppDQgKHcf_W7g.png"><br />
</figure>
<p>Дано:</p>
<pre><strong>&lt;?php</strong><br><br><strong>function</strong> getCount(<strong>&amp;$a</strong>) { return count($a); }<br><br>$cnt = getCount( $foo );<br><strong>var_dump</strong>($cnt);<br><br>$cnt = getCount( $foo['bar'] );<br><strong>var_dump</strong>($cnt);<br><br><em>#EOF</em></pre>
<p>Возникает вопрос, а что за $foo ? Отвечаю: не определен. Нет его. Что будет?</p>
<p>Логично же, что ошибка, да?</p>
<p>Нет, не совсем логично. Код отработает без ошибок и предупреждений, если у вас следующие версии интерпретатров:</p>
<ul>
<li>PHP 5.6.0–5.6.30</li>
<li>PHP 7.0.0–7.1.13</li>
<li>HHVM 3.18.5–3.22.0</li>
</ul>
<p>При передаче объекта по ссылке, интерпретатор не проверяет его содержимое и структуру. Эта фича существовала до версии PHP 7.2 и уже с этой версии начали генерировать варнинги.</p>
<pre>Warning: count(): Parameter must be an array or an object that implements Countable in /in/EV9Fh on line 3 int(0)</pre>
<pre>Warning: count(): Parameter must be an array or an object that implements Countable in /in/EV9Fh on line 3 int(0)</pre>
<p>В принципе поведение логичное с точки зрения Си разработчика. Если параметр определен по ссылке, то он может быть инициализирован внутри функции, в которой он определен. Это сделано для возврата функцией сразу нескольких значений — эдакий Си стайл, где можно закинуть указателей, а потом в них напихать нужные значения.</p>
<p>С версии 7.2 начинают сыпаться предупреждения, но они нам говорят о том, что мы передаем значения неверного типа, а не о том, что мы оперируем несуществующими переменными.</p>
<p>Пруф на тест: <a href="https://3v4l.org/EV9Fh" target="_blank" rel="noopener noreferrer">https://3v4l.org/EV9Fh</a></p>
<p>Опять же эта задачка в копилку к задаче:</p>
<p><a href="https://medium.com/@frontman/fun-php-1-19ad75ee78bb">https://medium.com/@frontman/fun-php-1-19ad75ee78bb</a></p>
<p>При рефакторинге большого приложения очень сильно может подгадить такое поведение. Но тут надо понимать зачем и как писать такой код и когда стоит пользоваться ссылками, а когда нет.</p>
<h3>UPD</h3>
<p>Комментарий моего коллеги, с которым я когда-то работал в мамбе (<a href="https://www.facebook.com/mipxtx" target="_blank" rel="noopener noreferrer">https://www.facebook.com/mipxtx</a>):</p>
<blockquote><p>До версии 7.2 в функции count() не было проверок типов. Если бы ты обратился в своей функции к переданной переменной на чтение, то получил бы ворнинг так или иначе.</p></blockquote>
<p>Про обращение все верно и при обращении ворнинги будут всегда — это логично. Фишка задачи именно в том, как обрабатываются параметры по ссылке.</p>
<blockquote><p>Ты передаешь ссылку на элемент массива, указывая таким образом, что хочешь после выполнения получить массив с таким-то элементом. А вообще в пхп нет никакого смысла передавать параметры по ссылкам. Память ты не сэкономишь, они все copy-on-write. А возвращаемый результат функции должен быть одним. Несколько результатов нарушают принципы SOLID напрямую.</p></blockquote>

<!--kg-card-end: html-->


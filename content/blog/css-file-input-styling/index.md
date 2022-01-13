---
title: "Стилизация и кастомизация File Inputs"
date: "2016-09-08T14:03:29.000Z"
description: "Правильный путь
Небольшой туториал на тему как кастомизировать тег input с учетом семантики и
доступности, используя тег label и"
---

<h4>Правильный путь</h4>
<p>Небольшой туториал на тему как кастомизировать тег input с учетом семантики и доступности, используя тег label и немного JavaScript.</p>
<p>Изменение внешнего вида инпутов, как правило, не вызывает трудностей, но file input отличается от остальных. Это связано с безопасностью и с тем, что каждый браузер по своему отображает этот элемент. Проблема в том, чтои на это почти нельзя повлиять. Но если очень хочется…</p>
<h3>Demo</h3>
<p>Для нетерпеливых сразу ссылка на <a href="https://majorov.su/tutorials/custom-fileInputs/index.html" target="_blank" rel="noopener noreferrer">DEMO</a></p>
<h3>Проблемы</h3>
<p>С помощью JS мы не можем имитировать клик на file input. Вот что говорится об этом в описании спецификации к DOM:</p>
<blockquote><p>Simulate a mouse-click. For INPUT elements whose type attribute has one of the following values: “button”, “checkbox”,<br />“radio”, “reset”, or “submit”.</p></blockquote>
<blockquote><p>&#8212; No Parameters<br />&#8212; No Return Value<br />&#8212; No Exceptions</p></blockquote>
<p>То есть методом click мы можем тригерить клик почти на всех типах инпутов, но не на input file. Это сделано чтобы обезопасить клиента: иначе вебстраница могла бы получать любые файлы с компьютера клиента. Хотя с другой стороны, по клику вызывается только окно выбора файла. Так или иначе, в MDN Firefox этот факт обозначен как баг.</p>
<p>Решение есть. И не одно.</p>
<p>Одно из распространенных решений: создается инпут с нулевой прозрачностью и ставится поверх кнопки или изображения, которые представляют собой кнопку выбора файла.</p>
<p>Основная трудность в следующем. Мы не можем свободно влиять на размеры кнопок «обзор», чтобы подогнать input под размер перекрываемой картинки. В Firefox вообще не можем изменить внешний вид файл-инпута средствами CSS (кроме высоты). То есть задача заключается определении оптимального размера перекрываемой картинки, чтобы минимальное количество пикселей было не кликабельно, а пустые области не реагировали на клик.</p>
<p>Но есть способ лучше и правильнее, на мой взгляд. Это кастомизация тега label и тригеринг клика через него.</p>
<p>И так, минимальный HTML код для кастомизации file input тега:</p>
<pre>&lt;input type="file" name="file" id="file" class="inputfile" /&gt;<br>&lt;label for="file"&gt;Choose a file&lt;/label&gt;</pre>

<h3>Фиксим баги в Firefox</h3>
<pre>input.addEventListener('focus', function(){ input.classList.add( 'has-focus' ); });</pre>
<pre>input.addEventListener('blur', function(){ input.classList.remove( 'has-focus' ); });</pre>
<pre>.inputfile:focus + label,<br>.inputfile.has-focus + label {<br>    outline: 1px dotted #000;<br>    outline: -webkit-focus-ring-color auto 5px;<br>}</pre>
<p><a href="https://majorov.su/tutorials/custom-fileInputs/index.html" target="_blank" rel="noopener noreferrer">DEMO</a></p>
<hr>
<p><em>Это вольный краткий перевод статьи </em><a href="http://tympanus.net/codrops/2015/09/15/styling-customizing-file-inputs-smart-way/" target="_blank" rel="noopener noreferrer"><em>Styling &amp; Customizing File Inputs the Smart Way</em></a></p>



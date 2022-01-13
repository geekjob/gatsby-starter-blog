---
title: "Стилизация и кастомизация File Inputs"
date: "2016-09-08T14:03:29.00Z"
description: "Правильный путь Небольшой туториал на тему как кастомизировать тег input с учетом семантики и доступности, используя тег label и"
---

<!--kg-card-begin: html--><h4>Правильный путь</h4>
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
<figure>
<p><img data-width="760" data-height="556" src="https://cdn-images-1.medium.com/max/800/0*2-GXQ5L6kDFK449l.gif"><br />
</figure>
<p>Как видите триггер на клик срабатывает через наш label, но мы видим так же наш тег input.</p>
<h3>Скрываем input</h3>
<pre>.inputfile {<br>	width: 0.1px;<br>	height: 0.1px;<br>	opacity: 0;<br>	overflow: hidden;<br>	position: absolute;<br>	z-index: -1;<br>}</pre>
<h3>Стилизуем label</h3>
<pre>.inputfile + label {<br>    font-size: 1.25em;<br>    font-weight: 700;<br>    color: white;<br>    background-color: black;<br>    display: inline-block;<br>}</pre>
<pre>.inputfile:focus + label,<br>.inputfile + label:hover {<br>    background-color: red;<br>}</pre>
<h3>Доступность</h3>
<p>Чтобы пользовтель понимал что это активный элемент и именно его нужно кликнуть, добавим курсор “указатель”:</p>
<pre>.inputfile + label {<br>	cursor: pointer; /* "hand" cursor */<br>}</pre>
<p>До</p>
<figure>
<p><img data-width="300" data-height="180" src="https://cdn-images-1.medium.com/max/800/0*bdXkqVNPqFhLsOeC.gif"><br />
</figure>
<p>После</p>
<figure>
<p><img data-width="300" data-height="180" src="https://cdn-images-1.medium.com/max/800/0*GgG8Qt6iruqqJN1a.gif"><br />
</figure>
<h3>Навигация клавиатурой</h3>
<p>Добавим возмрожность навигации клавиатурой:</p>
<pre>.inputfile:focus + label {<br>	outline: 1px dotted #000;<br>	outline: -webkit-focus-ring-color auto 5px;<br>}</pre>
<p>-webkit-focus-ring-color auto 5px — это небольшой трюк для эмуляции дефолтного стиля выбранного элемента в браузерах Chrome, Opera и Safari.</p>
<figure>
<p><img data-width="760" data-height="180" src="https://cdn-images-1.medium.com/max/800/0*uR4eLfnMuHMIRe-S.gif"><br />
</figure>
<h3>Доступность в Touch устройствах</h3>
<pre>&lt;label for="file"&gt;&lt;strong&gt;Choose a file&lt;/strong&gt;&lt;/label&gt;</pre>
<pre>.inputfile + label * {<br>	pointer-events: none;<br>}</pre>
<h3>Улучшаем с помощью JS</h3>
<pre>&lt;input type="file" name="file" id="file" class="inputfile" data-multiple-caption="{count} files selected" multiple /&gt;</pre>
<p>Напишем небольшой контроллер, который будет менять представление в зависимости от режима.</p>
<pre>var inputs = document.querySelectorAll('.inputfile');<br>Array.prototype.forEach.call(inputs, function(input){<br>  var label	 = input.nextElementSibling,<br>      labelVal = label.innerHTML;</pre>
<pre>  input.addEventListener('change', function(e){<br>    var fileName = '';<br>    if( this.files &amp;&amp; this.files.length &gt; 1 )<br>      fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );<br>    else<br>      fileName = e.target.value.split( '\' ).pop();</pre>
<pre>		if( fileName )<br>      label.querySelector( 'span' ).innerHTML = fileName;<br>    else<br>      label.innerHTML = labelVal;<br>	});<br>});</pre>
<figure>
<p><img data-width="760" data-height="480" src="https://cdn-images-1.medium.com/max/800/0*DiG02Qc1dD0rSSY7.gif"><br />
</figure>
<h3>Фиксим баги в Firefox</h3>
<pre>input.addEventListener('focus', function(){ input.classList.add( 'has-focus' ); });</pre>
<pre>input.addEventListener('blur', function(){ input.classList.remove( 'has-focus' ); });</pre>
<pre>.inputfile:focus + label,<br>.inputfile.has-focus + label {<br>    outline: 1px dotted #000;<br>    outline: -webkit-focus-ring-color auto 5px;<br>}</pre>
<p><a href="https://majorov.su/tutorials/custom-fileInputs/index.html" target="_blank" rel="noopener noreferrer">DEMO</a></p>
<hr>
<p><em>Это вольный краткий перевод статьи </em><a href="http://tympanus.net/codrops/2015/09/15/styling-customizing-file-inputs-smart-way/" target="_blank" rel="noopener noreferrer"><em>Styling &amp; Customizing File Inputs the Smart Way</em></a></p>
<!--kg-card-end: html-->


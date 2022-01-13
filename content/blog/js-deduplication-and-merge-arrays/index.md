---
title: "Дедупликация и слияние массивов"
date: "2016-08-22T14:19:03.000Z"
description: "в JavaScript от ES5 до ES7+ Всем привет! Бывают случаи в работе фронтендера, когда возникает необходимость слияния 2х массивов. "
---

<h4>в JavaScript от ES5 до ES7+</h4>
<p>Всем привет! Бывают случаи в работе фронтендера, когда возникает необходимость слияния 2х массивов. А иногда даже не просто слияние, а еще и дедупликация (удаление повторяющихся значений). Такие задачи могут возникать не только в работе, но и на собеседовании (тадаа ☺).</p>
<p>Пойдем по порядку. Сначала разберемся как сливать массивы или создавать новый на базе существующих. А затем уже посмотрим как их “чистить” от дубликатов.</p>
<p>Этот пост — сборник способов, которые я знаю и которые могут быть применены. Пост написан ради академического интереса и чтобы не забыть. ☺</p>
<h4>Слияние массивов</h4>
<p>На собеседовании я иногда спрашиваю, как слить два массива. Часто люди предлагают цикл, в котором проходятся по элементам и добавляют их новый. Более продвинутые предлагают добавить метод в prototype, более опытные предлагают добавить метод через defineProperty, чтобы сделать свойство не перечисляемым в экземплярах класса. Я не говорю про различные jQuery и Lodash/Underscoer unique меторды, которые мне не интересны… Все эти методы рабочие, безусловно, но с приходом ES6+ это можно сделать легко и быстро, с минимум кода. Но даже в ES5 эта задача так же решается просто.</p>
<h4>Дано</h4>
<pre><em>var</em> <strong>a</strong> = [1,2,3,4],<br><strong>b</strong> = [3,4,5,6],<br><strong>c</strong>; // результирующий</pre>
<pre>//Результат проверяем следующим образом:</pre>
<pre>console.log(Array.isArray(<strong>c</strong>) === <strong>true</strong>);<br>console.log(<strong>c</strong>); // результат слияния 2х массивов</pre>
<pre>/*<br>1. В первой части статьи должно выполниться c == [1,2,3,4,3,4,5,6]<br>2. Во второй части c == [1,2,3,4,5,6]<br>*/</pre>
<p>Будем считать что по условию задачи мы на выходе всегда должны иметь результат в переменной <strong>c</strong>, даже если в этом нет необходимости. Важно — результат должен проходить проверку на <em>Array.isArray()</em>.</p>
<h4>Слияние через перебор</h4>
<p>Такой ответ часто дают на собеседованиях. Я покажу усредненный вариант таких случаев. Варианты эти имеют преимущество в случае, если вам нужно будет сделать какие-то дополнительные действия с данными перед слиянием.</p>
<pre><em>&gt; for</em> (<em>var</em> <strong>c</strong>=a, <strong>i</strong>=0; <strong>i</strong>&lt;<strong>b</strong>.length; <strong>i</strong>++) <strong>a</strong>.push(<strong>b</strong>[i]);<br>&gt; console.log(<strong>c</strong>);<br>&gt; [<em>1, 2, 3, 4</em>, 3, 4, 5, 6]</pre>
<p>Как видим это обычный цикл, в котором мы добавляем в массив <strong>a</strong> элементы из массива <strong>b</strong>. Вариация такого цикла:</p>
<pre>&gt; <em>for</em> (var <strong>c</strong>=<strong>b</strong>,<strong>i</strong>=<strong>b</strong>.length; <strong>i</strong> --&gt; 0;) <strong>b</strong>.unshift(<strong>a</strong>[<strong>i</strong>]);<br>&gt; console.log(<strong>c</strong>);<br>&gt; [<em>1, 2, 3, 4</em>, 3, 4, 5, 6]</pre>
<p>Результат на выходе такой же, но мы используем массив b в качестве результирующего, ссылку на который мы сохраняем в переменной <strong>c</strong>.</p>
<h4>Слияние через push</h4>
<p>Слить массивы можно и без использования циклов:</p>
<pre><strong>c</strong> = <strong>a</strong>,Array.prototype.push.apply(<strong>a</strong>,<strong>b</strong>)</pre>
<p>или даже так</p>
<pre><strong>c</strong> = <strong>a</strong>,<strong>a</strong>.push.apply(<strong>a</strong>,<strong>b</strong>)</pre>
<p>или так</p>
<pre><strong>c</strong> = <strong>b</strong>,<strong>b</strong>.unshift.apply(<strong>b</strong>,<strong>a</strong>)</pre>
<h4>Использование reduce</h4>
<p>Еще один интересный способ слить массивы — метод reduce.</p>
<pre><strong>c</strong> = <strong>b</strong>.reduce((<strong>a</strong>,<strong>b</strong>)=&gt;(<strong>a</strong>.push(<strong>b</strong>),<strong>a</strong>),<strong>a</strong>)</pre>
<p>или даже так</p>
<pre><strong>c</strong> = <strong>a</strong>.reduceRight((<strong>a</strong>,<strong>b</strong>)=&gt;(<strong>a</strong>.unshift(<strong>b</strong>),<strong>a</strong>),<strong>b</strong>)</pre>
<h4>Метод concat</h4>
<p>О да, в JavaScript есть уже метод для слияния массивов.</p>
<blockquote><p>Метод <strong>concat()</strong> возвращает новый массив, состоящий из массива, на котором он был вызван, соединённого с другими массивами и/или значениями, переданными в качестве аргументов.</p></blockquote>
<p>Выходит что все что было написано выше вообще не нужно, ведь у нас есть этот метод. Тогда все что описано было выше, мы можем переписать таким образом:</p>
<pre><strong>c</strong> = [].concat(<strong>a</strong>,<strong>b</strong>)</pre>
<p>или</p>
<pre><strong>c</strong> = <strong>a</strong>.concat(<strong>b</strong>)</pre>
<h4>Spread syntax</h4>
<blockquote><p>
<strong>Spread оператор </strong>позволяет расширять выражения в тех местах, где предусмотрено использование нескольких аргументов (при вызовах функции) или ожидается несколько элементов (для массивов).</p></blockquote>
<p>Выходит что мы можем написать так</p>
<pre><strong>c</strong> = <strong>a</strong>,<strong>a</strong>.push(...<strong>b</strong>)</pre>
<p>и получить опять же слитые массивы воедино. Но тогда выходит что мы можем вообще отказаться от push и все за нас сделает интерпретатор языка:</p>
<pre><strong>c</strong> = [...<strong>a</strong>, ...<strong>b</strong>]</pre>
<p>Победитель нашего челенджа по мёрджу 2х массивов.</p>
<hr>
<h3>Дедупликация элементов</h3>
<p>Как слить массивы мы уже поняли. Есть куча разных способов. А как их слить так, чтобы не было повторяющихся элементов?</p>
<h4>Метод filter</h4>
<pre>&gt;<strong> c</strong> = <strong>a</strong>.concat(<strong>b</strong>.filter(<strong>i</strong>=&gt;<strong>a</strong>.indexOf(<strong>i</strong>)===-1));<br>&gt; console.log(<strong>c</strong>);<br>&gt; [<em>1, 2, 3, 4</em>, 5, 6]</pre>
<h4>Set</h4>
<p>С приходом ES2015 у нас появились новые структуры данных. К примеру Set.</p>
<blockquote><p>Объект <strong>Set</strong> позволяет сохранять <em>уникальные</em> значения любого типа.</p></blockquote>
<p>Супер! Это же упрощает нашу жизнь. Мы можем слить массивы используя Set:</p>
<pre><strong>c</strong> = new Set([...<strong>a</strong>, ...<strong>b</strong>])</pre>
<p>Но есть одно но! Мы получили экземпляр объекта Set, но никак не Array, в итоге наша проверка Array.isArray не проходит. Нам надо переписать наш вариант следующим образом:</p>
<pre><strong>c</strong> = [ ...<em>new</em> Set([...a,...b])]</pre>
<p>Вот теперь мы получили самый лаконичный и читабельный способ получить слияние 2х массивов с исключением повторяющихся элементов. Да здравствует ECMAScript.Next ! ☺</p>
<h4>Array.of</h4>
<blockquote><p>Метод <strong>Array.of()</strong> создаёт новый экземпляр массива Array из произвольного числа агрументов, вне зависимости от числа или типа аргумента.</p></blockquote>
<pre><strong>c</strong> = Array.of(...<strong>new</strong> Set(Array.of(...<strong>a</strong>, ...<strong>b</strong>)))</pre>
<h4>Array.from</h4>
<blockquote><p>Метод <strong>Array.from()</strong> создаёт новый экземпляр Array из массивоподобного или итерируемого объекта.</p></blockquote>
<pre><strong>c</strong> = Array.from(<strong>new</strong> Set(<strong>a</strong>.concat(<strong>b</strong>)))</pre>



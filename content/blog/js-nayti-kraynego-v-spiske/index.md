---
title: "Найти крайнего в списке"
date: "2018-02-14T02:18:01.00Z"
description: "Last in list. Hacks and tricks with Array in JS    Сегодня пара слов про работу с массивами в JS. В целом работа с массивами (ak"
---

<!--kg-card-begin: html--><h4>Last in list. Hacks and tricks with Array in JS</h4>
<figure>
<p><img data-width="800" data-height="444" src="https://cdn-images-1.medium.com/max/800/1*Q3fAq_vF-c2CLggcC2FuVg.jpeg"><br />
</figure>
<p>Сегодня пара слов про работу с массивами в JS. В целом работа с массивами (aka списками) в JavaScript — это большая тема. Что-то уже я когда-то описывал. Все в одну большую статью пихать не хочется — я сам не люблю лонгриды. Данный пост навеян недавним собеседованием.</p>
<p><strong>Как получить значение последнего элемента массива?</strong></p>
<p>Начал сам придумывать варианты решения и как-то увлекся, в итоге нагенерил кучу способов. Зачем? Зачем трюкач, владеющий мечами, крутит ими виртуозно, так что завораживает взгляд? Вот это примерно про тоже. Помимо спортивного интереса умение быстро придумать разные варианты означает что вы владеете своим инструментом и понимаете какие методы есть, что они делают и какой будет результат.</p>
<p>Умение показать нестандартный вариант — это про креатив, про то, что вы можете думать шире рамок и ограничений. В работе вы не будете так писать — да. Но тут речь не только о работе.</p>
<blockquote><p>Think outside the box!</p></blockquote>
<h3>Получить последний элемент</h3>
<p>Как получить доступ к первому знают все. А как взять последний элемент?</p>
<h4>Вариант классический</h4>
<pre>a[a.length-1]</pre>
<p>Все просто, без объяснений. Но слишком просто. Без креатива и души =)</p>
<h4><strong>Вариант slice()</strong></h4>
<blockquote><p>Метод slice() возвращает новый массив, содержащий копию части исходного массива.</p></blockquote>
<pre>a.<strong>slice</strong>(-1)[0] // = 4<br>// или<br><code>a.<strong>slice</strong>(-1).<strong>pop</strong>()</code></pre>
<p>Кстати, чтобы взять значение предпоследнего элемента, нужно всего лишь указать диапазон:</p>
<pre>a.<strong>slice</strong>(-2, -1)[0]  // = 3</pre>
<h4>Деструктуризация</h4>
<p>Вариант скорее про возможности и красоту многообразия JS:</p>
<pre><strong>const</strong> [last] = a.<strong>slice</strong>(-1)<br><strong>console</strong>.log(last)</pre>
<p>Но почему бы и нет, м? В принципе даже очень ок, если вы собираетесь в итоге значение куда-то присвоить.</p>
<p>★<em> Данный вариант получает приз зрительских симпатий, так как он имеет право на жизнь и даже право на то, чтобы попасть в продакшен.</em></p>
<h4>Array.pop</h4>
<p>Взять значение последнего элемента можно и через метод pop() , но у него есть но. Он изменяет текущий массив. Но что если:</p>
<pre>[...a].<strong>pop</strong>()</pre>
<p>Это уже скорее “спортивный” вариант, который можно использовать в различных челенджах и головоломках. Но если подходить формально — задача решена. В принципе если захотеть, то можно нагенерить еще кучу разновидностей подобного рода. Array.from и все такое…</p>
<h4>Reverse</h4>
<p>Этот метод скорее просто показан что так тоже можно, но уж точно не нужно.</p>
<pre>a.<strong>reverse</strong>()[0]</pre>
<p>Шутка ли, но я когда-то такое в боевом проекте видел (или в npm пакете).</p>
<h4>reduceRight</h4>
<blockquote><p>Метод <code><strong>reduceRight()</strong></code> применяет функцию к аккумулятору и каждому значению массива (справа-налево), сводя его к одному значению.</p></blockquote>
<pre>a.reduceRight((a,i)=&gt;a||i)</pre>
<p>Выглядит уже как магия, но по факту никакой магии. Но это явно и не самый короткий вариант, неочевидный, да и просто неоптимальный. Но он имеет право на жизнь ибо он решает нашу задачу.</p>
<p>☆ <em>Данный вариант получает приз за самую большую когнитивную нагрузку.</em></p>
<p>Если ваш проект будет обиловать таким кодом, его захотят переписать с нуля. Возможно вы этого и хотите, а? ?</p>
<h4>jQuery</h4>
<p>Внезапно, да? Но если вдруг у вас уже проект на JQ, то пользуйтесь его мощью:</p>
<pre><strong>$</strong>([1,2,3,4]).<strong>get</strong>(-1) // = 4</pre>
<p>И да, JQ это не стыдно, если что. Он решает свой пул задач и очень даже хорошо.</p>
<h3>Строки</h3>
<p>Все вышеописанное работает и для строк, так как строки — это array-like объекты. Они имеют длину и реализуют интерфейс итератора. Так что вы даже итерироваться можете по ним:</p>
<pre><strong>for</strong> (<strong>let</strong> s of "abc") {<br>   console.log(s)<br>}</pre>
<p>Таким образом со строками все тоже самое:</p>
<pre><code>"abcdef".<strong>slice</strong>(-1).<strong>pop</strong>()<br></code><strong>const</strong> [last] = "abcdef".<strong>slice</strong>(-1)</pre>
<p>Кроме методов map, reduce и им подобным. Если очень хочется, строку придется сначала конвертнуть в массив:</p>
<pre>[..."abcdef"].reduceRight((a,i)=&gt;a||i)</pre>
<p>Будьте осторожны, за такой код вас могут сжечь на костре.</p>
<hr>
<h3>Аштшыр</h3>
<p>— что означает Finish, если переключить раскладу на клавиатуре. Думаю что хватит. Вообще хотел немного про другое рассказать, но вдруг оказалось что простой вопрос превратился в лонгрид. Про списки в JavaScript я буду еще много говорить. Мне приходится работать со списками очень много и гонять их в хвост и гриву, сортировать, фильтровать и чего только не делать с ними почти что каждый день.</p>
<!--kg-card-end: html-->


---
title: "Создаем иммутабельные объекты на TypeScript"
date: "2018-04-08T02:38:32.00Z"
description: "Readonly, readonly, const    Астрологи объявили неделю immutable & const в JS/TS. Продолжая тему иммутабельности в JS [https://m"
---

<!--kg-card-begin: html--><h4>Readonly, readonly, const</h4>
<figure>
<p><img data-width="929" data-height="359" src="https://cdn-images-1.medium.com/max/800/1*_JCtpx6gZAw5LMJCU0w1pA.png"><br />
</figure>
<p>Астрологи объявили неделю immutable &amp; const в JS/TS. <a href="https://medium.com/@frontman/b346353d9cce" target="_blank" rel="noopener noreferrer">Продолжая тему иммутабельности в JS</a>, хочется затронуть TypeScript. На этом языке можно объявлять неизменяемые объекты чисто символически, которые будут в рантайме мутировать. А можно создавать тру константы объекты с дополнительной защитой, которую может дать TypeScript.</p>
<p>Рассмотрим простой пример:</p>
<figure>
<p><img data-width="1068" data-height="690" src="https://cdn-images-1.medium.com/max/800/1*k8XZS9IQBptyiRE3cxWBdA.png"><br />
</figure>
<p>Все работает логично, TS не позволяет модифицировать ссылку на объект, но позволяет менять сам объект. Про это было сказано в статье:</p>
<p><a href="https://medium.com/@frontman/const-%D0%B2-js-%D0%B4%D0%B5%D0%BB%D0%B0%D0%B5%D1%82-%D1%81%D0%B2%D0%BE%D1%8E-%D1%80%D0%B0%D0%B1%D0%BE%D1%82%D1%83-%D0%BF%D1%80%D0%B0%D0%B2%D0%B8%D0%BB%D1%8C%D0%BD%D0%BE-b346353d9cce">https://medium.com/@frontman/const-%D0%B2-js-%D0%B4%D0%B5%D0%BB%D0%B0%D0%B5%D1%82-%D1%81%D0%B2%D0%BE%D1%8E-%D1%80%D0%B0%D0%B1%D0%BE%D1%82%D1%83-%D0%BF%D1%80%D0%B0%D0%B2%D0%B8%D0%BB%D1%8C%D0%BD%D0%BE-b346353d9cce</a></p>
<p>Там же в статье мы говорили, что если хотим сделать константный объект, то нам нужно помимо использования слова const еще и сделать freeze объекта. Пробуем:</p>
<figure>
<p><img data-width="1142" data-height="542" src="https://cdn-images-1.medium.com/max/800/1*iqkseJ5DfG1mJrEhVl4-iQ.png"><br />
</figure>
<p>Как видим TS правильно отрабатывает ситуацию и сообщает на этапе компиляции (транспиляции), что мы пытаемся модифицировать замороженное свойство. Но глубокой заморозки нет, вложенные поля объекта будут модифицироваться. Пробуем <a href="https://medium.com/@frontman/const-%D0%B2-js-%D0%B4%D0%B5%D0%BB%D0%B0%D0%B5%D1%82-%D1%81%D0%B2%D0%BE%D1%8E-%D1%80%D0%B0%D0%B1%D0%BE%D1%82%D1%83-%D0%BF%D1%80%D0%B0%D0%B2%D0%B8%D0%BB%D1%8C%D0%BD%D0%BE-b346353d9cce" target="_blank" rel="noopener noreferrer">функцию глубокой заморозки</a>, которую мы написали в прошлой статье:</p>
<pre><strong>const</strong> obj = immutable({ ... })</pre>
<p>И внезапно TS перестает ругаться на модификацию. Т.е. для runtime мы создали иммутабельный объект, а для статического анализатора это неочевидно. И при рефакторинге очень легко сломать код, так как TS не будет сообщать о модификации. Что делать?</p>
<h3>Readonly and readonly</h3>
<p>В TypeScript есть механизмы для описывания иммутабельных объектов. Есть модификатор полей свойств и есть отдельный генерик тип.</p>
<h4>Модификатор readonly</h4>
<p>Ключевое слово <strong>readonly</strong> — позволяет определить свойства, которые доступны только для чтения. Этот модификатор является дополнением модификаторов public, private и protected и является частью системы типов TS. Он используется компилятором только для проверки.</p>
<p>Так как модификатор readonly — это только артефакт при компиляции, то он не является защитой от присваивания значений в рантайме и нам нужно самим обеспечивать иммутабельность для рантайма.</p>
<p>Модификатор readonly можно добавлять только в описания свойств, поэтому нам нужно описать интерфейс или тип и уже работать с ним. В принципе это и есть TS Way — четкое фиксирование структур. Убираем гибкость объектов в пользу определенности. Не должно быть внезапных свойств, все должно быть заранее продумано и объявлено.</p>
<pre><strong>type</strong> MyConstObject = {<br><strong>readonly </strong>foo: number,<br><strong>readonly</strong> a: {<br><strong>readonly</strong> b: {<br><strong>readonly</strong> c: 'string'<br>        } <br>    }<br>}</pre>
<pre>// или</pre>
<pre><strong>interface</strong> MyConstObject {<br><strong>readonly </strong>foo: number,<br><strong>readonly</strong> a: {<br><strong>readonly</strong> b: {<br><strong>readonly</strong> c: 'string'<br>        } <br>    }    <br>}</pre>
<figure>
<p><img data-width="1220" data-height="614" src="https://cdn-images-1.medium.com/max/800/1*sdBvqYJz7YhvDh24LdPvEA.png"><br />
</figure>
<p>Все работает корректно. А что если у нас простой объект, без вложенных элементов или мы хотим заморозить только первый уровень? Нам же не надо использовать функцию и мы можем обойтись Object.freeze (или нам нужно и мы просто хотим). Пробуем:</p>
<figure>
<p><img data-width="1202" data-height="960" src="https://cdn-images-1.medium.com/max/800/1*R8xu10BhjZEHqQR5d-K91g.png"><br />
</figure>
<p>Получаем сообщение об ошибке, так как у нас несовпадение типов. Да, это минус сильной явной типизации — нужно за всем следить и явно указывать что вы ожидаете. Магии не будет. Самый простой способ починить эту ошибку и рассказать компилятору что мы делаем — это использовать Type Casting:</p>
<pre><strong>const</strong> obj :MyConstObject = &lt;MyConstObject&gt;<strong>Object</strong>.freeze({ ... })</pre>
<pre>// или</pre>
<pre><strong>const</strong> obj :MyConstObject = <strong>Object</strong>.freeze({ ... }) <strong>as</strong> MyConstObject</pre>
<p>Второй вариант можно использовать как в TS так и в TSX для React. Первый вариант только для TS. Но когда мы разбирали ошибки, то выяснили что существует интерфейс, а почитав документацию узнали что их целое семейство.</p>
<h3>Интерфейс Readonly и его наследники</h3>
<p>Чтобы не расставлять модификатор readonly ко всем свойствам (представьте их штук 30 в объекте), мы можем использовать генерик Readonly. Более того, мы можем сделать более грамотный код, описав интерфейс объекта и отдельно его иммутабельную версию. Это позволит более гибко переиспользовать интерфейсы и кастомные типы.</p>
<pre>// Базовое описание объекта, можем переиспользовать и мутировать<br><strong>interface</strong> MyObject {<br>    foo: number,<br>    a: {<br>        b: {<br>            c: 'string'<br>        } <br>    }<br>}</pre>
<pre>// Добавляем иммутабельности<br><strong>type</strong> MyObjectConst = <strong>Readonly</strong>&lt;MyObject&gt;;</pre>
<pre><strong>//</strong> Используем<strong><br>const</strong> obj :MyObjectConst = &lt;MyObjectConst&gt; <strong>Object</strong>.freeze({ ... })</pre>
<p>Такой подход более гибкий и правильный и соответствует принципам SOLID.</p>
<h3>Иммутабельный массив</h3>
<p>С помощью генериков в TypeScript мы можем описывать любые структуры данных. Например мы хотим создать readonly массив. Для этого опишем такую структуру:</p>
<pre><strong>interface</strong> ImmutableArray&lt;T&gt; {<br><strong>readonly</strong> [key: <strong>number</strong>]: T<br>}</pre>
<pre><strong>const</strong> arr: ImmutableArray&lt;<strong>number</strong>&gt; = [1, 2, 3];</pre>
<pre>arr[0] = 4; // Index signature in type 'ImmutableArray&lt;number&gt;' only permits reading.</pre>
<p>Но в TS уже есть встроенные типы (интерфейсы) для некоторых базовых структур данных. Например есть такой генерик — ReadonlyArray. И поэтому нам даже не нужно самим описывать свой тип для массива, можем использовать готовый:</p>
<pre><strong>const</strong> arr: <strong>ReadonlyArray</strong>&lt;<strong>number</strong>&gt; = [1, 2, 3];<br>arr[0] = 4;</pre>
<p>И да, не забываем добавить для рантайма фриз объекта:</p>
<pre><strong>const</strong> arr: <strong>ReadonlyArray</strong>&lt;<strong>number</strong>&gt; = <strong>Object</strong>.freeze([1,2,3]);</pre>
<pre>// или</pre>
<pre><strong>const</strong> arr: <strong>ReadonlyArray</strong>&lt;<strong>number</strong>&gt; = [1,2,3];<br><strong>Object</strong>.freeze([1,2,3]); // массив фризится по ссылке</pre>
<p>На сегодня TypeScript стал очень популярным и его выбирают бэкенд разработчики на разных языках со строгой и явной типизацией. Поэтому есть отдельные вакансии TypeScript разработчиков. </p>

<p>Конкретно в этой вакансии нужен фронтендер в команду к С++ бэкендерам. И на таких собеседованиях по TypeScript помимо ООП паттернов и принципов SOLID так же могут спрашивать и про разные структуры данных. И за такие знания дают очень шикарные условия работы.</p>
<!--kg-card-end: html-->


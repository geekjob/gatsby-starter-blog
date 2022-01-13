---
title: "Создаем иммутабельные объекты на TypeScript"
date: "2018-04-08T02:38:32.000Z"
description: "Readonly, readonly, const



Астрологи объявили неделю immutable & const в JS/TS. Продолжая тему
иммутабельности в JS [https://m"
---

<h4>Readonly, readonly, const</h4>
- <a href="https://medium.com/@frontman/b346353d9cce" target="_blank" rel="noopener noreferrer">Продолжая тему иммутабельности в JS</a> <br/>
- <a href="https://medium.com/@frontman/const-%D0%B2-js-%D0%B4%D0%B5%D0%BB%D0%B0%D0%B5%D1%82-%D1%81%D0%B2%D0%BE%D1%8E-%D1%80%D0%B0%D0%B1%D0%BE%D1%82%D1%83-%D0%BF%D1%80%D0%B0%D0%B2%D0%B8%D0%BB%D1%8C%D0%BD%D0%BE-b346353d9cce">https://medium.com/@frontman/const-%D0%B2-js-%D0%B4%D0%B5%D0%BB%D0%B0%D0%B5%D1%82-%D1%81%D0%B2%D0%BE%D1%8E-%D1%80%D0%B0%D0%B1%D0%BE%D1%82%D1%83-%D0%BF%D1%80%D0%B0%D0%B2%D0%B8%D0%BB%D1%8C%D0%BD%D0%BE-b346353d9cce</a> <br/>
- <a href="https://medium.com/@frontman/const-%D0%B2-js-%D0%B4%D0%B5%D0%BB%D0%B0%D0%B5%D1%82-%D1%81%D0%B2%D0%BE%D1%8E-%D1%80%D0%B0%D0%B1%D0%BE%D1%82%D1%83-%D0%BF%D1%80%D0%B0%D0%B2%D0%B8%D0%BB%D1%8C%D0%BD%D0%BE-b346353d9cce" target="_blank" rel="noopener noreferrer">функцию глубокой заморозки</a> <br/>

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



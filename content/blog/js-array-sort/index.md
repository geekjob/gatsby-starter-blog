---
title: "Сортировка массивов в JS"
date: "2018-11-20T13:26:03.00Z"
description: "Дьявол в деталях Array().sort()    Недавно на собеседовании вопрос услышал про сортировку. Он простой как 2 копейки и сразу можн"
---

<!--kg-card-begin: html--><h4>Дьявол в деталях Array().sort()</h4>
<figure>
<p><img data-width="959" data-height="956" src="https://cdn-images-1.medium.com/max/800/1*ScZDzZTRQJrmEph6CHVCZA.jpeg"><br />
</figure>
<p>Недавно на собеседовании вопрос услышал про сортировку. Он простой как 2 копейки и сразу можно вспомнить, даже не зная, что и почему. Но он забавный.</p>
<h4>Как отсортировать элементы массива?</h4>
<p>Дано:</p>
<pre><strong>var</strong> a = [1,0,3,2,5,4,9,8,6]</pre>
<p>Ответ, вроде бы, очевиден и он даже работает:</p>
<pre>a.sort()<br>[0, 1, 2, 3, 4, 5, 6, 8, 9]</pre>
<p>Уточняем, как работает сортировка и спрашиваем, как отсортируется массив:</p>
<pre>[1,0,11,10,9,7,2].sort()</pre>
<p>У кандидата начинают закрадываться подозрения что где-то есть подвох. Но предыдущий пример вроде бы сработал же… И тут он видит результат:</p>
<pre>[0, 1, 10, 11, 2, 7, 9]</pre>
<p>Далее задается вопрос — а чо так? И тут вот либо человек быстро соображает и, зная особенности языка, говорит почему так (не знал, но вспомнил), либо начинает говорить что это магия и JS такой джаваскрипт. Бага, плохой и вообще… Вот далее ответ для тех, кто считает что JS плохой.</p>
<h3>JavaScript хороший</h3>
<p>JS хороший, просто надо знать базу. По дефолту метод sort() сортирует все элементы как строки, вне зависимости от того, что в массиве. Чтобы отсортировать числа, вам нужно заменить встроенную функцию сортировки на свою пользовательскую:</p>
<pre>[0, 1, 10, 11, 2, 7, 9].sort((a,b)=&gt;a-b)</pre>
<p>Вот теперь все работает корректно. Нет магии, язык не сломан, нет багов, все работает как и задумывалось. Оно может не очевидно и не оправдывает ожидания (ведь могли бы добавить проверку типов). Но все же оно работает правильно и как задумано.</p>
<!--kg-card-end: html-->


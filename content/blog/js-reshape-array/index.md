---
title: "Сделать reshape массива"
date: "2017-10-08T12:31:11.00Z"
description: "Превращаем вектор в матрицу Допустим есть одномерный массив. Для примера сгенерим его и заполним числами от 0 до 9  const arr1 ="
---

<h4>Превращаем вектор в матрицу</h4>
<p>Допустим есть одномерный массив. Для примера сгенерим его и заполним числами от 0 до 9</p>
<pre><strong>const</strong> arr1 = <strong>Array</strong>.apply(<strong>null</strong>,{length:9}).<strong>map</strong>(Number.call, Number)</pre>
<p>Теперь нам надо превратить его в матрицу 3&#215;3, к примеру. Что делаем?</p>
<p>Код решейпа (вариант):</p>
<pre><strong>const</strong> arr2 = [];</pre>
<pre><strong>while</strong> (arr1.<strong>length</strong>) arr2.<strong>push</strong>(arr1.<strong>splice</strong>(0,3));</pre>
<pre><strong>console</strong>.table(arr2)</pre>
- <a class="kg-bookmark-container" href="https://jsfiddle.net/frontdevops/uxtyj38u/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">Edit fiddle - JSFiddle - Code Playground</div><div class="kg-bookmark-description">Test your JavaScript, CSS, HTML or CoffeeScript online with JSFiddle code editor.</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://jsfiddle.net/img/favicon.png"><span class="kg-bookmark-author">JSFiddle</span><span class="kg-bookmark-publisher">Code Playground</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://www.gravatar.com/avatar/8f8f604430a6a2116749fad87c9c86d5?s=80"></div></a> <br/>



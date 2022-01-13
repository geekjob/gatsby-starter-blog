---
title: "Получить данные из псевдоэлементов after и before"
date: "2016-08-30T10:21:48.000Z"
description: "С помощью JavaScript
Если у вас есть сгенерированный CSS-контент и вам надо получить доступ к
значениям через JS, то есть способ"
---

<h4>С помощью JavaScript</h4>
<p>Если у вас есть сгенерированный CSS-контент и вам надо получить доступ к значениям через JS, то есть способ сделать это:</p>
<pre>var content = window.<strong>getComputedStyle</strong>(document.querySelector('.element'),':<strong>after</strong>').getPropertyValue('<strong>content</strong>');</pre>
<p>Или же можно обратиться сразу к свойству content:</p>
<pre>var content = window.<strong>getComputedStyle</strong>(document.querySelector('.<strong>element</strong>'),':after').<strong>content</strong>;</pre>



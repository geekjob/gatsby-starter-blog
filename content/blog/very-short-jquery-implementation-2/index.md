---
title: "Самая короткая реализация jQuery"
date: "2016-08-09T22:44:58.000Z"
description: "Эмуляция 3х функций
var $ = document.querySelector.bind(document);
Element.prototype.on = Element.prototype.addEventListener;
El"
---

<h4>Эмуляция 3х функций</h4>
<pre>var $ = document.querySelector.bind(document);<br>Element.prototype.on = Element.prototype.addEventListener;<br>Element.prototype.find = function(selector){ return this.querySelector(selector) }</pre>
<h4>Использование</h4>
<pre>$('div.someClass').find('button').on('click', function(){ alert('Yeah!') });</pre>



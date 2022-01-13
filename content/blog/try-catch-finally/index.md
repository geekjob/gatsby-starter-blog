---
title: "Try/Catch/Finally"
date: "2019-02-19T17:51:12.00Z"
description: "Задачки с собеседований и не только Материал в этом посте справедлив для многих языков программирования. Но, как всегда, примеры"
---

<!--kg-card-begin: html--><h4>Задачки с собеседований и не только</h4>
<p>Материал в этом посте справедлив для многих языков программирования. Но, как всегда, примеры буду показывать на JS, так как мне просто нравится это магический, напичканный костылями, язык ☺</p>
<p>В мире программирования есть общие вопросы, которые задаются на разные позиции в разных областях. Один из таких вопросов: как работает перехват исключений, а именно рассказать как поведет себя блок:</p>
<pre><strong>try</strong> {} <strong>catch</strong> {} <strong>finally</strong> {}</pre>
<p>Многие знают как ловить исключения и как работает блок try/catch. Но вот добавление блока finally может сильно поменять логику и, даже, удивить, если не знать правил его работы. Этот вопрос можно услышать на собеседовании по Java, C#, PHP и нашем любимом JavaScript.</p>
<p>Вроде бы не такой-то уж и сложный вопрос, но в нем легко запутаться. Рассмотрим такой случай:</p>
<figure>
<p><img data-width="782" data-height="432" src="https://cdn-images-1.medium.com/max/800/1*t_RGN1-Gmb6_G9Rq4c3KSQ.jpeg"><br />
</figure>
<p>Что вернется? В принципе все просто, вернется 2, так мы выбросили исключение, то отработает блок catch и из него будет возврат.</p>
<h4>Что если добавить блок finally ?</h4>
<figure>
<p><img data-width="1230" data-height="720" src="https://cdn-images-1.medium.com/max/800/1*65K2yXtN_iFSQfgSDmtOvg.jpeg"><br />
</figure>
<p>Здесь уже интереснее и вы видите, что даже если в блоке catch есть возврат, то он игнорируется и возврат происходит из блока finally.</p>
<h4>Finally и success</h4>
<p>А что если у нас не выбрасывается исключение?</p>
<figure>
<p><img data-width="1046" data-height="490" src="https://cdn-images-1.medium.com/max/800/1*M0I79eINicuiUm-XV7MgfQ.jpeg"><br />
</figure>
<p>Вот тут уже возникают сомнения, что и как должно отработать, если нет опыта работы с finally или вы еще не запомнили эти правила. Вывод будет следующий:</p>
<pre>"try block"<br>"finally block"<br>5</pre>
<p>Да, у нас блок finally отрабатывает всегда.</p>
<h4>Усложняем вопрос: 2 блока finally</h4>
<figure>
<p><img data-width="1422" data-height="874" src="https://cdn-images-1.medium.com/max/800/1*xr0gqRWDjg7fBLfX5Ca5yA.jpeg"><br />
</figure>
<p>Ответ: после первого блока finally далее уже код не будет отрабатываться (если мы выходим из блока через return)и там может быть все что угодно.</p>
<p>Выносим return из finally блока, и что же будет тогда?</p>
<figure>
<p><img data-width="950" data-height="482" src="https://cdn-images-1.medium.com/max/800/1*CrglDpnMPKpFWg0lls9ZvA.jpeg"><br />
</figure>
<p>Ответ:</p>
<pre>"try block"<br>"finally block"<br>1</pre>
<p>Возврат будет из блока try, но finally будет отрабатывать всегда, так что в этом блоке можно даже что-то еще посчитать хоть ответ уже и вернулся:</p>
<figure>
<p><img data-width="1188" data-height="720" src="https://cdn-images-1.medium.com/max/800/1*JZxDsgM_i577-wdi_e_Cjg.jpeg"><br />
</figure>
<h4>А как отработает такой Node.js код?</h4>
<p>Интересный вопрос, м?</p>
<figure>
<p><img data-width="988" data-height="668" src="https://cdn-images-1.medium.com/max/800/1*otGZvO7icTpFptWUQlzfOg.jpeg"><br />
</figure>
<p>Как мы видим тут уже исключение в исключении. Код отработает точно так же, как и, к примеру, в Java. В Java вызов System.exit() не позволяет сработать блоку finally.</p>
<p>В Node.js аналогичная ситуация: process.exit() не дает отработать блоку finally.</p>
<p>Для тех, кто пишет на PHP, вопрос как отработает этот код:</p>
<pre><strong>&lt;?php</strong> <strong>declare</strong>(<em>strict_types=1</em>);</pre>
<pre><strong>try</strong> {<br>    var_dump('try');<br>    foo();<br>}<br><strong>catch</strong> (Error $e) {<br>    var_dump('catch');<br><strong>exit</strong>(1);<br>}<br><strong>finally</strong> {<br>    var_dump('finally');<br>}</pre>
<p>Ответ не даю. Догадаетесь сами ?</p>

<!--kg-card-end: html-->


---
title: "TypeScript declarations"
date: "2016-07-27T16:32:45.00Z"
description: "Разница в поведении или как научить IDE подсказкам TypeScript славится хорошей поддержкой в правильных хороших IDE. В частности,"
---

<!--kg-card-begin: html--><h4>Разница в поведении или как научить IDE подсказкам</h4>
<p>TypeScript славится хорошей поддержкой в правильных хороших IDE. В частности, я использую WebStorm/PhpStorm. Бывает, что хочется не указывать тип у переменной (хотя это плозая практика), так как мы используем функцию с генериком и по смыслу понятно что тип заранее известен и другой уже не должен вернуться. Давайте покажу на примере, чтобы было понятнее. Как говорится, дано:</p>
<p><a href="https://gist.github.com/frontdevops/4e8a91497f3dddf9bd7a75d4c08d7ed1">https://gist.github.com/frontdevops/4e8a91497f3dddf9bd7a75d4c08d7ed1</a></p>
<p>И мы получаем <strong>не</strong>работающий результат, хотя и ожидали другого:</p>
<figure class="wp-caption">
<p><img data-width="1238" data-height="580" src="https://cdn-images-1.medium.com/max/800/1*lal5HkK6kvrjuzTPbKWgeA.png"><figcaption class="wp-caption-text">Нет подсказок от интерфейса ComponentButton</figcaption></figure>
<p>Варианты решения проблемы, не залезая в декларацию и не разбираясь что там:</p>
<p><a href="https://gist.github.com/frontdevops/882a99790dc85439a39241a9636865f7">https://gist.github.com/frontdevops/882a99790dc85439a39241a9636865f7</a></p>
<p>И вот мы получили результат, который хотели:</p>
<figure class="wp-caption">
<p><img data-width="1200" data-height="616" src="https://cdn-images-1.medium.com/max/800/1*-cZ-Gx6PXzZyM1JSg9Rsbg.png"><figcaption class="wp-caption-text">Круто круто, все работает! Есть подсказки =)</figcaption></figure>
<p>Но правильно ли это? Мы же не исправили проблему в корне, а просто обошли правила, точнее подогнали их под себя. Все это правится в корне и вся соль кроется в самой декларации. Мы указали что у нас <em>require</em> некая переменная типа функция с аргументами и неким результатом. А надо указать что у нас функция, а не перменная! Т.е. мы пишем вместо</p>
<pre>declare var <strong><em>require</em></strong>: &lt;T&gt;(s :string) =&gt; T;</pre>
<p>вот это вот все:</p>
<pre>declare function <em>require</em>&lt;T&gt;(s :string): T;</pre>
<p>Вот теперь у нас все будет работать без typecast и прочих подсказок компилятору:</p>
<figure class="wp-caption">
<p><img data-width="1218" data-height="652" src="https://cdn-images-1.medium.com/max/800/1*7c8hUNYdmbt7NEJ4kbpbMg.png"><figcaption class="wp-caption-text">Вот теперь все работает как надо и без подсказок.</figcaption></figure>
<h3>Мораль</h3>
<p>Описывайте правильно ваши декларации. =)</p>
<p>П.С.: функция require дана для примера.</p>
<!--kg-card-end: html-->


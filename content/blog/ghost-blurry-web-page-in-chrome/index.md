---
title: "Ghost: Blurry web page in Chrome"
date: "2019-03-05T17:34:03.00Z"
description: "Bug with enable experimental web platform features У нас есть блог blog.new.hr [https://blog.newhr.ru] и он работает (успешно) н"
---

<!--kg-card-begin: html--><h4>
<code>Bug with </code>enable experimental web platform features</h4>
<p>У нас есть блог <a href="https://blog.newhr.ru" target="_blank" rel="noopener noreferrer">blog.new.hr</a> и он работает (успешно) на Node.js (но речь сейчас не о том ☺). Крутится все это на движке <a href="https://ghost.org/" target="_blank" rel="noopener noreferrer">Ghost</a>. Удобная современная платформа, но есть в ней и косячки, которые приходится исправлять.</p>
<p>В этот раз косячок нетривиальный и не сразу улавливаемый. Некоторые наши читатели под Chrome на Windows или Linux писали, что они видят блог размытым. И выглядело это все так:</p>
<figure class="wp-caption">
<p><img data-width="1552" data-height="1596" src="https://cdn-images-1.medium.com/max/800/1*-H3Lq_QvihmHvZfKxXIAIw.jpeg"><figcaption class="wp-caption-text">backdrop-filter bug in Ghost blog platform</figcaption></figure>
<p>При этом у многих все работало ок, на той же Windows. Чтобы отловить баг ставилась виртуалка с нужными параметрами, брался физически компьютер с нужными параметрами — баг не повторялся. Пришлось покопаться и выяснилось что баг проявляется только при определенных условиях:</p>
<ul>
<li>На сайте включена “Подписка”</li>
<li>У вас Linux или Windows</li>
<li>У вас браузер Chrome</li>
<li>В браузере включены экспериментальные фичи</li>
</ul>
<p>Вот сам факт того что есть связь между опцией “Подписка на блог” и проблемами в браузере уже взрывает мозг.</p>
<figure class="wp-caption">
<p><img data-width="1786" data-height="282" src="https://cdn-images-1.medium.com/max/800/1*5BFp8QoXvBprhDXwWllzYA.jpeg"><figcaption class="wp-caption-text">Опция Подписки в блоговом движке Ghost</figcaption></figure>
<p>И вот когда эта опция была включена, а у вас Windows/Linux, браузер Chrome и в вашем браузере по какой-то причине включена опция “Включить экспериментальные фичи веб-платформ”, то тут баг и проявлялся.</p>
<p>Эти фичи по дефолту отключены и если они включены, то вы или кто-то включил их у вас. И если они включены, то вы должны понимать, что эти фичи экспериментальные и они могут привести к проблемам. Включить или выключить фичу можно через страницу настроек:</p>
<pre>chrome://flags/#enable-experimental-web-platform-features</pre>
<figure class="wp-caption">
<p><img data-width="1482" data-height="212" src="https://cdn-images-1.medium.com/max/800/1*gtXhwI6JO2TCHOOc9fTtPA.jpeg"><figcaption class="wp-caption-text">chrome://flags/#enable-experimental-web-platform-features</figcaption></figure>
<p>Эту фичу настоятельно рекомендуется отключить (если только вы явно понимаете зачем она вам нужна). Если вы веб-разработчик, тем более… Если это не браузер для экспериментов (а для экспериментов лучше иметь dev версии), то не нужно включать флаги, ибо потом будете удивляться тому, что у вас и у клиентов разное поведение сайта.</p>
<p>С другой стороны меня посетила мысль что нужно тестировать проект еще и в браузерах с включенными экспериментальными фичами и в Dev версиях, так как наша целевая аудитория — это гики. И тут как раз тот случай, когда высока вероятность что на сайт придут люди с необычными браузерами. ?</p>
<p>Если вы разработчик, то настоятельно рекомендуется быть аккуратнее с необычными фичами и тестировать их во всех браузерах. Вроде бы банальщина, но те, кто писал тему Casper для движка Ghost, не следовали этому правилу и вставили в CSS свойство <strong>backdrop-filter</strong>.</p>
<p>Так вот, в Chrome эта фича работает только если включен вышеупомянутый флаг. И в реализации этой фичи в браузере есть баг, который и проявлялся таким вот необычным способом, когда браузер пытался обработать свойство backdrop-filter.</p>
<h3>А вообще зачем этот backdrop-filter ?</h3>
<p>Ну вообще фича интересная. Свойство backdrop-filter определено в спецификации Filter Effect Level 2.</p>
<p><a href="https://drafts.fxtf.org/filter-effects-2/#BackdropFilterProperty">https://drafts.fxtf.org/filter-effects-2/#BackdropFilterProperty</a></p>
<p>Оно позволяет применять фильтры к подложке элемента(backdrop), а не к его фону (background). Эти свойства доступны начиная с Safari 9. С этим свойством можно получить сложные эффекты, например такие как размытие подложки, как в iOS:</p>
<figure class="wp-caption">
<p><img data-width="314" data-height="410" src="https://cdn-images-1.medium.com/max/800/1*yz-Wu4BirXbsL8WrvbWcjA.gif"><figcaption class="wp-caption-text">backdrop-filter in action in Safari</figcaption></figure>
<p>Всего-лишь небольшой кусочек кода:</p>
<pre>.header {<br>     background-color: rgba(255,255,255,.7);<br>     -webkit-backdrop-filter: blur(4px)<br>     backdrop-filter: blur(4px)<br>}</pre>
<p>и у вас очень крутой эффект. <a href="https://output.jsbin.com/curasup" target="_blank" rel="noopener noreferrer">Demo on JSBin</a>.</p>
<p>Доступность:</p>
<ul>
<li>Эта фича доступна в Safari и iOS с префиксом -webkit-.</li>
<li>В Chrome и Opera только при включенном флаге ( о чем уже говорили выше).</li>
<li>(!) В Edge так же доступно с префиксом -webkit- (не -ms).</li>
</ul>
<figure class="wp-caption">
<p><img data-width="1142" data-height="350" src="https://cdn-images-1.medium.com/max/800/1*6goPDN--8M9zprqsbB0w7g.jpeg"><figcaption class="wp-caption-text">backdrop-filter browsers support</figcaption></figure>
<p>Но! Но в Chrome даже с флагами эта фича очень бажная:</p>
<figure class="wp-caption">
<p><img data-width="310" data-height="408" src="https://cdn-images-1.medium.com/max/800/1*gU3m4EPvhNmZRJ8hlnOLPA.gif"><figcaption class="wp-caption-text">backdrop-filter in Chrome with enabled experimental web-platform features</figcaption></figure>

<!--kg-card-end: html-->


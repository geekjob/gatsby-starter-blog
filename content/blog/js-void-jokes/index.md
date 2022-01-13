---
title: "Нестандартные способы получить неопределенность"
date: "2017-07-28T13:31:24.000Z"
description: "В нашем любимом JS
Как можно получить undefined в JS/ES ? Ну можно использовать слово undefined. А
можно креативно подойти к про"
---

<h4>В нашем любимом JS</h4>
<p>Как можно получить undefined в JS/ES ? Ну можно использовать слово undefined. А можно креативно подойти к процессу, так чтобы ваш код не сразу могли понять последователи:</p>
<pre>console.log(<strong> void 0</strong> === undefined );<br>console.log( <strong>void 'послание программисту'</strong> === undefined );<br>console.log( <strong>1[0]</strong> === undefined );<br>console.log( <strong>0..n</strong> === undefined );<br>console.log( <strong>false[0]</strong> === undefined );<br>console.log( <strong>true[1]</strong> === undefined );<br>console.log( <strong>false.true</strong> === undefined );<br>console.log( <strong>''.null</strong> === undefined );<br>console.log( <strong>'послание'['программисту']</strong> === undefined );<br>console.log( <strong>(_=&gt;_).nop</strong> === undefined );<br>console.log( <strong>{}.nop</strong> === undefined );<br>console.log( <strong>''['']</strong> === undefined );<br>console.log( <strong>[][0]</strong> === undefined );<br>console.log( <strong>[]._</strong> === undefined );</pre>
<pre>// etc...</pre>
<p>Вот как-то так ?</p>
<h3>UPD</h3>
<p>Варианты от читателей из комментариев:</p>
<pre><strong>/_/._</strong></pre>
<pre><em>// Бензовоз</em><br><strong>(_=_=_=_=_=&gt;_)[_]</strong></pre>
<pre><em>// Грузовик</em><br><strong>(()=&gt;{})()</strong></pre>
<pre><em>// Взрыв мозга</em><br><strong>(_=[])[_?!!_++:~~~~_--]</strong></pre>
<p>Пишите в комментариях свои способы нестандартно получить undefined</p>
<hr>
<p>Лайк, хлопок, шер. Слушайте меня в <a href="https://itunes.apple.com/ru/podcast/pro-web-it/id1366662242?mt=2" target="_blank" rel="noopener noreferrer">iTunes</a>, подписывайтесь на <a href="https://t.me/prowebit" target="_blank" rel="noopener noreferrer">Телеграм</a> канал или <a href="https://vk.com/mayorovprowebit" target="_blank" rel="noopener noreferrer">Вконтакте</a>.</p>



---
title: "Обзор JS REPL playgrounds"
date: "2019-02-19T18:17:56.00Z"
description: "И один для PHP Небольшой обзор разных playground инструментов для быстрого запуска кода и проверки гипотез.  Browser/DevTools Об"
---

<!--kg-card-begin: html--><h4>И один для PHP</h4>
<p>Небольшой обзор разных playground инструментов для быстрого запуска кода и проверки гипотез.</p>
<h3>Browser/DevTools</h3>
<p>Обычно всякие быстрые RnD я делал либо в браузере прямо в DevTools — удобно для очень коротких набросков, в идеале однострочников.</p>
<p>Более сложные вещи делаю в браузере, но уже в DevTools →Sources → Snipets — удобно, быстро, сохраняется в браузере, использует всю мощь текущей версии браузера.</p>
<figure class="wp-caption">
<p><img data-width="1818" data-height="1148" src="https://cdn-images-1.medium.com/max/800/1*IiI09F0WgtEgExStDVh3Ew.jpeg"><figcaption class="wp-caption-text">Chrome REPL: DevTools →Sources → Snipets</figcaption></figure>
<h3>CodePen / JSFiddle / JSBin</h3>
<p>CodePen/JSFiddle/JSBin — удобно, но есть но… Из за того что код в них прогоняется через eval + происходят различные трансформации, бывали ситуации когда код в этих плейграундах код выдавал ошибку, в то время как в браузере все было ок.</p>
<h3>Node.js</h3>
<p>Если код для ноды — то пишу JS файлик, запускаю под нодой — смотрю результат. В принципе ок. Но тут нужна IDE или редактор + запуск кода (переключение к терминал в простейшем случае).</p>
<h3>RunJS</h3>
<p>Давеча удобный инструмент для RnD в JS нашел на просторах сети — <a href="https://projects.lukehaas.me/runjs/" target="_blank" rel="noopener noreferrer">RunJS</a>. Это модный playground на Electron для набросков мыслей на JavaScript.</p>
<figure>
<p><img data-width="1174" data-height="804" src="https://cdn-images-1.medium.com/max/800/1*Nnrj8tk7_56airhCJ229dA.jpeg"><br />
</figure>
<p>Позволяет быстро накидать мысли и проверить гипотезу. И не нужно писать console.log() каждый раз — эта штука сама все распечатает.</p>
<p>Ну и красивые скриншоты в итоге можно сделать. Подумал что это интересный инструмент для офромения статей по теме JS.</p>
<h4><a href="https://quokkajs.com/" target="_blank" rel="noopener noreferrer">QuokkaJS.com</a></h4>
<p>Это плагин для VSCode — <a href="https://quokkajs.com/" target="_blank" rel="noopener noreferrer">QuokkaJS</a>. Эта штука превращает ваш VSCode в плэйграунд. Можно видеть выполнение кода сразу при написании.</p>
<figure>
<p><img data-width="800" data-height="500" src="https://cdn-images-1.medium.com/max/800/1*ukcsChGYEreBhhAksiYceA.gif"><br />
</figure>
<p>Но я люблю более простые вещи, так что мне оч зашел RunJS.</p>
<h4><a href="https://runkit.com/" target="_blank" rel="noopener noreferrer">Runkit.com</a></h4>
<p>Еще один playground с множеством развесистых плюшек: может быть интересен для вывода графики или быстрой визуализации данных.</p>
<figure>
<p><img data-width="1422" data-height="1350" src="https://cdn-images-1.medium.com/max/800/1*fZTAkoEwsUYN6oGn4diQHA.jpeg"><br />
</figure>
<h3>TypeScriptLang.com</h3>
<p>Самый лучший плейгрануд в браузере для проверки кода на TypeScript имхо. Очень быстрый мощный редакторю Из минусов — это как реализовано выполнение кода (не очень удобно).</p>
<p><a href="https://www.typescriptlang.org/play/index.html">https://www.typescriptlang.org/play/index.html</a></p>
<figure>
<p><img data-width="2268" data-height="1042" src="https://cdn-images-1.medium.com/max/800/1*TVCrhmrtEa75a1Er5yDb0A.jpeg"><br />
</figure>
<h3>Babel</h3>
<p><a href="https://www.typescriptlang.org/play/index.html">https://www.typescriptlang.org/play/index.html</a></p>
<p>Мощный REPL для поиграть и проверить какие-то вещи. Но надо сказать что бабель сейчас можно включить в том же JSFiddle и других. Скорее просто что-то проверить именно как это компилится в бабеле.</p>
<figure>
<p><img data-width="2164" data-height="1450" src="https://cdn-images-1.medium.com/max/800/1*HcATQ6PcDcHyeXlWnUEeqw.jpeg"><br />
</figure>
<h3>PHP Repl</h3>
<p>А на последок PHP Repl (который я уже использовал в своих статьях для демонстрации кода)</p>
<p><a href="https://www.typescriptlang.org/play/index.html">https://www.typescriptlang.org/play/index.html</a></p>
<figure>
<p><img data-width="2174" data-height="1234" src="https://cdn-images-1.medium.com/max/800/1*TPl_CQR9th3k5f-oQ8b_GA.jpeg"><br />
</figure>
<p>Позволяет выполнить код пакетно на разных версиях интерпретатора, что довольно удобно для проверки багов в языке.</p>
<!--kg-card-end: html-->


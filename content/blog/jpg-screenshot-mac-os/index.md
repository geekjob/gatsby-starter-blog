---
title: "JPG Screenshot на Mac OS"
date: "2019-10-04T21:10:06.00Z"
description: "Как сменить формат файла   По дефолту скриншоты в маке сохраняются в формате PNG. Иногда бывают скриншоты сложных изображений и "
---

<!--kg-card-begin: html--><h4>Как сменить формат файла</h4>
<figure class="wp-caption">
<p><img data-width="1418" data-height="380" src="https://cdn-images-1.medium.com/max/800/1*gceWlLMgj73NIKYKVrxRmw.png"></figure>
<p>По дефолту скриншоты в маке сохраняются в формате PNG. Иногда бывают скриншоты сложных изображений и в формате JPG картинка весила бы меньше. Как поменять? Открываем терминал и пишем следующие строчки.</p>
<h4>JPG</h4>
<pre>defaults write com.apple.screencapture <strong>type</strong> <strong>jpg</strong>; killall SystemUIServer</pre>
<h4>PDF</h4>
<pre>defaults write com.apple.screencapture <strong>type</strong> <strong>PDF</strong>; killall SystemUIServer</pre>
<h4>Вернуть все как было в PNG</h4>
<pre>defaults write com.apple.screencapture <strong>type</strong> <strong>png</strong>; killall SystemUIServer</pre>

<!--kg-card-end: html-->


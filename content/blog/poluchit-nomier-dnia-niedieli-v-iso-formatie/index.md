---
title: "Получить номер дня недели в ISO формате"
date: "2020-07-08T13:42:59.000Z"
description: "Tips & tricks. Полезняхи в JS/ES #8
Получить номер дня недели в ISO формате
Метод getDay() объекта Date возвращает Вс с индексом"
---

<h3 id="tips-tricks-js-es-8">Tips &amp; tricks. Полезняхи в JS/ES #8</h3><h4 id="-iso-">Получить номер дня недели в ISO формате</h4><p>Метод <code>getDay()</code> объекта Date возвращает Вс с индексом <code>0</code>. Мы в СНГ привыкли, что неделя начинается с Пн. Поэтому, чтобы получить день недели, где <code>0</code> — это Пн мы можем использовать такой трюк:</p><pre><code class="language-javascript">


let day = ((new Date).getDay() +6) % 7



//EOF//</code></pre>


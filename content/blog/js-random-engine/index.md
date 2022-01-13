---
title: "Случайные числа не случайны"
date: "2018-02-27T16:17:17.000Z"
description: "Как создать генератор случайных чисел на JS и предсказать Math.random()    Вы когда-нибудь задумывались, как работает Math.rando"
---

<h4>Как создать генератор случайных чисел на JS и предсказать Math.random()</h4>
- <a href="https://ru.wikipedia.org/wiki/%D0%A2%D0%B5%D1%81%D1%82_%D0%BD%D0%B0_%D1%81%D0%BB%D0%B5%D0%B4%D1%83%D1%8E%D1%89%D0%B8%D0%B9_%D0%B1%D0%B8%D1%82" target="_blank" rel="noopener noreferrer">тест на следующий бит</a> <br/>
- <a href="https://v8project.blogspot.ru/2015/12/theres-mathrandom-and-then-theres.html" target="_blank" rel="noopener noreferrer">https://v8project.blogspot.ru/2015/12/theres-mathrandom-and-then-theres.html</a> <br/>
- <a href="https://github.com/adblockplus/v8-googlesource/blob/chromium/2416/src/math.js#L135" target="_blank" rel="noopener noreferrer">https://github.com/adblockplus/v8-googlesource/blob/chromium/2416/src/math.js#L135</a> <br/>
- <a href="https://alf.nu/ReturnTrue" target="_blank" rel="noopener noreferrer">https://alf.nu/ReturnTrue</a> <br/>
- <a href="https://twitter.com/rdvornov" target="_blank" rel="noopener noreferrer">Роман Дворнов</a> <br/>
- <a href="https://bl.ocks.org/mmalone/bf59aa2e44c44dde78ac" target="_blank" rel="noopener noreferrer">https://bl.ocks.org/mmalone/bf59aa2e44c44dde78ac</a> <br/>

<p>Видите эти равномерности на левом слайде? Изображение показывает проблему с распределением значений. На картинке слева видно, что значения местами сильно группируются, а местами выпадают большие фрагменты. Как следствие — числа можно предсказать.</p>
<p>Выходит что мы можем отреверсить Math.random() и предсказать, какое было загадано число на основе того, что получили в данный момент времени. Для этого получаем два значения через Math.random(). Затем вычисляем внутреннее состояние по этим значениям. Имея внутреннее состояние можем предсказывать следующие значения Math.random() при этом не меняя внутреннее состояние. Меняем код так так, чтобы вместо следующего возвращалось предыдущее значение. Собственно все это и описано в коде-решении для задачи random4. Но потом алгоритм изменили (подробности читайте в спеке). Его можно будет сломать, как только у нас в JS появится нормальная работа с 64 битными числами. Но это уже будет другая история.</p>
<p>Новый алгоритм выглядит так:</p>
<pre><strong>uint64_t</strong> state0 = 1;<br><strong>uint64_t</strong> state1 = 2;<br><strong>uint64_t</strong> xorshift128plus() {<br><strong>uint64_t</strong> s1 = state0;<br><strong>uint64_t</strong> s0 = state1;<br>   state0 = s0;<br>   s1 ^= s1 &lt;&lt; 23;<br>   s1 ^= s1 &gt;&gt; 17;<br>   s1 ^= s0;<br>   s1 ^= s0 &gt;&gt; 26;<br>   state1 = s1;<br><strong>return</strong> state0 + state1;<br>}</pre>
<p>Его все так же можно будет просчитать и предсказать. Но пока у нас нет “длинной математики” в JS. Можно попробовать через TypedArray сделать или использовать специальные библиотеки. Возможно кто-то однажды снова напишет предсказатель. Возможно это будешь ты, читатель. Кто знает ?</p>
<h3><code>Сrypto Random Values</code></h3>
<p>Метод <code>Math.random()</code> не предоставляет криптографически стойкие случайные числа. Не используйте его ни для чего, связанного с безопасностью. Вместо него используйте Web Crypto API (API криптографии в вебе) и более точный метод <code>window.crypto.getRandomValues()</code>.</p>
<p>Пример генерации случайного числа:</p>
<pre><strong>let</strong> [rvalue] = <strong>crypto</strong>.<strong>getRandomValues</strong>(<strong>new</strong> <strong>Uint8Array</strong>(1));<br><strong>console</strong>.log( rvalue )</pre>
<p>Но, в отличие от ГПСЧ Math.random(), этот метод очень ресурсоемкий. Дело в том, что данный генератор использует системные вызовы в ОС, чтобы получить доступ к источникам энтропии (мак адрес, цпу, температуре, etc…).</p>
<hr>
<h3>Материалы про Math.random()</h3>
<p>Больше про random в спецификации:</p>
<p><a href="https://v8project.blogspot.ru/2015/12/theres-mathrandom-and-then-theres.html">https://v8project.blogspot.ru/2015/12/theres-mathrandom-and-then-theres.html</a></p>
<p>Хорошая статья про работу рандомайзера</p>
<p><a href="https://v8project.blogspot.ru/2015/12/theres-mathrandom-and-then-theres.html">https://v8project.blogspot.ru/2015/12/theres-mathrandom-and-then-theres.html</a></p>
<p>Пример реализации предсказателя с Math.random()</p>
<p><a href="https://gist.github.com/fta2012/57f2c48702ac1e6fe99b#file-replicatedrandomchrome-js" target="_blank" rel="noopener noreferrer">https://gist.github.com/fta2012/57f2c48702ac1e6fe99b#file-replicatedrandomchrome-js</a></p>
<hr>
<p><strong>Кстати, следить за обновлениями и прочими материалами от меня можно в телеграм канале: </strong><a href="https://web.telegram.org/#/im?p=@prowebit" target="_blank" rel="noopener noreferrer"><strong>@prowebit</strong></a></p>
<p><strong>В этом канале публикую не только статьи из этого блога, но и различные новости и мысли. Подписывайтесь ?</strong></p>



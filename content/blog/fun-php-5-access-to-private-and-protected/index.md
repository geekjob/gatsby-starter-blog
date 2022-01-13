---
title: "FunPHP#5: access to private and protected"
date: "2019-03-04T04:01:16.00Z"
description: "Паблик Морозов на собеседовании PHP protected & private property hacker  На собеседованиях каких вопросов только не встретишь. М"
---

<!--kg-card-begin: html--><h4>Паблик Морозов на собеседовании</h4>
<figure class="wp-caption">
<p><img data-width="1424" data-height="608" src="https://cdn-images-1.medium.com/max/800/1*Rk9Iumybng_BNEgim47tuA.jpeg"><figcaption class="wp-caption-text">PHP protected &amp; private property hacker</figcaption></figure>
<p>На собеседованиях каких вопросов только не встретишь. Матерые волки, собеседуя php-гуру, могут спрашивать разные нетривиальные вещи. Одна из таких вещей: паттерн “Паблик Морозов”.</p>
<blockquote><p>Паблик Морозов — антипаттерн, позволяющий получить доступ к закрытым полям класса.</p></blockquote>
<p>Встречаются как-то два программиста. Один — тимлид, другой php-гуру, оба с опытом дохреналет (писали на PHP, когда его еще не было). Начинается беседа, аки битва двух богатырей. Один задает вопросы коварнее другого. Другой парирует и отбивается, как ниндзя.</p>
<figure class="wp-caption">
<p><img data-width="679" data-height="467" src="https://cdn-images-1.medium.com/max/800/1*qfTCqjTko4Dj5SQz-0mPnw.jpeg"><figcaption class="wp-caption-text">PHP ninja job interview</figcaption></figure>
<p>Вопрос: бла бла, ООП… Бла бла бла, инкапсуляция, бла бла бла… А можно ли получить значение из private поля экземпляра класса?</p>
<p>Конечно можно, для этого есть Reflection API. Допустим есть класс:</p>
<pre><strong>class</strong> PublicMorozov {<br><strong>public</strong> $woo = 1;<br><strong>private</strong> $foo = 2;<br><strong>protected</strong> $bar = 3;<br><strong>public</strong> <strong>function</strong> foo() { <strong>return</strong> $this-&gt;foo; }<br>}</pre>
<p>Чтобы считать значения из инкапсулированных свойств (и даже изменить) мы можем использовать такой код:</p>
<pre>$class = <strong>new</strong> <strong>ReflectionClass</strong>("PublicMorozov");<br>$property = $class-&gt;<strong>getProperty</strong>("foo");<br>$property-&gt;<strong>setAccessible</strong>(true);<br><br>$pm = <strong>new</strong> PublicMorozov();<br>var_dump( $property-&gt;<strong>getValue</strong>($pm) );<br>$property-&gt;<strong>setValue</strong>($pm, 456);<br><br>var_dump( $pm-&gt;foo() );</pre>
<p>— Да, все верно, мы можем читать и писать в защищенные свойства через Reflection API. А еще способы знаешь?</p>
<p>— Ммм, ну можно это переписать так:</p>
<pre>$pm = <strong>new</strong> PublicMorozov();<br><br>$property = <strong>new</strong> <strong>ReflectionProperty</strong>("PublicMorozov", "foo");<br>$property-&gt;<strong>setAccessible</strong>(true);<br><br>var_dump( $property-&gt;<strong>getValue</strong>($pm) );<br>$property-&gt;<strong>setValue</strong>($pm, 456);<br><br>var_dump( $pm-&gt;foo() );</pre>
<p>— Да это же то же самое, ну немного короче. А что если… А если без использования Reflection API, м?</p>
<p>— Хм, ну есть несколько хаков…</p>
<p>— Не стенсяйся, показыавай!</p>
<p>— Ну мы можем написать кложуру, забиндить ее контекст на экземпляр класса и внутри вызвать значение, после чего вернуть его (значение):</p>
<pre>$pm = <strong>new</strong> PublicMorozov();<br><br>$foo = <strong>Closure</strong>::bind(<br><strong>function</strong>(PublicMorozov $pm){<strong>return</strong> $pm-&gt;foo;},<strong>null</strong>,$pm)($pm);</pre>
<pre>var_dump($foo);</pre>
<p>— Нормалды, нормалды… Но я бы сократил запись:</p>
<pre>$foo = <strong>Closure</strong>::bind(<br><strong>function</strong>(){<strong>return</strong> <strong>$this</strong>-&gt;foo;},$pm,'PublicMorozov')($pm)<br>;</pre>
<pre><em>// или даже так</em></pre>
<pre>$foo = <strong>Closure</strong>::bind(<strong>function</strong>(){<strong>return</strong> <strong>$this</strong>-&gt;foo;},$pm,$pm)($pm);</pre>
<p>Эту же запись можно еще укоротить:</p>
<pre>$foo = ((<strong>function</strong>(){<strong>return $this</strong>-&gt;foo;})-&gt;<strong>bindTo</strong>($pm,$pm))();</pre>
<p>— Ух ты! Да, прикольно.</p>
<p>— А поменять значение можем? Опять же без Reflection API.</p>
<p>— В принципе, да. Почему бы и нет. Мы можем вернуть не значение, а ссылку на свойство:</p>
<pre>$foo = <strong>&amp;</strong> <strong>Closure</strong>::bind(<br><strong>function</strong> <strong>&amp; </strong>(PublicMorozov $pm){<strong>return</strong> $pm-&gt;foo;},<strong>null</strong>,$pm)($pm)<br>;<br><br>$foo = 456;<br><br>var_dump($foo); // 456<br>var_dump( $pm-&gt;foo() ); // 456</pre>
<p>— Круто! Все верно. И опять же я бы сделал это короче:</p>
<pre>$foo = <strong>&amp;</strong>((<strong>function</strong> <strong>&amp;</strong> (){<strong>return $this</strong>-&gt;foo;})-&gt;<strong>bindTo</strong>($pm,$pm))();</pre>
<p>А еще таким образом можно сделать простую универсальную отмычку для манкипатчинга, используя твой метод:</p>
<pre><strong>function</strong> <strong>&amp;</strong> crackprop(<strong>object</strong> $obj, <strong>string</strong> $prop) {<br><strong>return</strong> ( <strong>Closure</strong>::bind<br>      (<br><strong>function</strong> <strong>&amp;</strong> () <strong>use</strong> ($prop) { <strong>return</strong> $this-&gt;$prop; }<br>         , $obj, $obj<br>      )<br>   )();<br>}<br><br>$foo = <strong>&amp;</strong>crackprop($pm, 'foo');<br>$foo = 456;<br><br>var_dump($foo);<br>var_dump($pm-&gt;foo());</pre>
<p>Или, опять же, короче, как бы я написал:</p>
<pre><strong>function &amp;</strong> crackprop(<strong>object</strong> $obj, <strong>string</strong> $prop) {<br><strong>return</strong> (<br>    (<strong>function</strong> <strong>&amp;</strong> () <strong>use</strong> ($prop) { <strong>return</strong> <strong>$this</strong>-&gt;$prop; })<br>       -&gt;<strong>bindTo</strong>($obj, $obj))()<br>   ;<br>}</pre>
<p>— Все что выше было проделано для private свойств сработает для protected?</p>
<p>— Да, все то же самое можно проделать и с protected.</p>
<p>— Напоследок по этой теме, чисто по фану, можешь еще назвать способ получить доступ к защищенным свойствам?</p>
<p>— Да, есть еще один способ, я не стал его озвучивать так как это, вроде бы, уже давно всем известный хак, работавший еще с давних версий PHP. По сути это к вопросу как формируются имена защищенных свойств. Мы можем получить значения так:</p>
<pre><strong>function</strong> _protected(<strong>object</strong> $obj, <strong>string</strong> $prop) {<br><strong>return</strong> ((<strong>array</strong>) $obj)["*$prop"];<br>}<br><strong>function</strong> _private(<strong>object</strong> $obj, <strong>string</strong> $prop) {<br><strong>return</strong> ((<strong>array</strong>) $obj)["".get_class($obj)."$prop"];<br>}</pre>
<pre>$foo = _private($pm, 'foo');<br>$bar = _protected($pm, 'bar');</pre>
<p>Имя приватного свойства формируется как:</p>
<pre>ClassNameproperty</pre>
<p>а protected имеет формат:</p>
<pre>*property</pre>
<p>Раз заговорили про фан, то мы можем написать универсальную функцию на этом механизме с удобным способом через чейнинг:</p>
<pre><strong>function</strong> crack(<strong>object</strong> $obj) {<br><strong>return</strong> <strong>new</strong> <strong>class</strong> ($obj) {<br><strong>public function</strong> __construct(<strong>object</strong> $obj) {<br><strong>$this</strong>-&gt;o = (<strong>array</strong>) $obj;<br><strong>$this</strong>-&gt;c = get_class($obj);<br>      }<br><strong>public function </strong>__get(<strong>string</strong> $p) {<br>         $r = <strong>@$this</strong>-&gt;o["*$p"];<br>         is_null($r) <strong>or</strong> $r = <strong>@$this</strong>-&gt;o["{<strong>$this</strong>-&gt;c}$p"];<br><strong>return</strong> $r;<br>      }<br>   };<br>}<br><br>$pm = <strong>new</strong> PublicMorozov();<br><br>var_dump( crack($pm)-&gt;foo ); // 2<br>var_dump( crack($pm)-&gt;bar ); // 3</pre>
<p>— Но производительность такой красоты сильно проседает, естественно. Кстати, по такой же схеме можно создать экземпляр класса stdClass с приватными и протектекд полями:</p>
<pre>$obj = (<strong>object</strong>) [<br>   "stdClassfoo" <strong>=&gt;</strong> 1,<br>   "*bar" <strong>=&gt;</strong> 2,<br>];<br><br>var_dump($obj);</pre>
<pre><em>object(stdClass)#1 (2) {<br>  ["foo":"stdClass":private]=&gt;<br>  int(1)<br>  ["bar":protected]=&gt;<br>  int(2)<br>}</em></pre>
<p>— Вообще вы задаете такие интересные вопросы… А чем мне придется тут заниматься?</p>
<p>— Оу, ну у нас все хорошо, новые технологии, модный стек. Просто есть немного легаси кода, который нужно сапортить и, иногда, патчить. Но, судя по твоим ответам, у тебя все получится, даже не сомневайся. Мы делаем тебе оффер ?</p>

<!--kg-card-end: html--><h3></h3><h3></h3>


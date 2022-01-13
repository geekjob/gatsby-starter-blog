---
title: "FunPHP#7"
date: "2019-05-22T15:47:00.00Z"
description: "Поговорим про PHP7 Относительно недавно писал про Паблика Морозова [https://medium.com/@frontman/php-access-to-private-and-prote"
---

<h2 id="-php7">Поговорим про PHP7</h2>
<p>Относительно недавно писал про <a href="https://medium.com/@frontman/php-access-to-private-and-protected-b1028b974169" target="_blank" rel="noopener noreferrer">Паблика Морозова</a>. Появились новые мысли и захотелось немного добавить. Вдохновение почерпнул из доклада <a href="https://medium.com/u/bb77dc6767eb" target="_blank" rel="noopener noreferrer">Alexander Lisachenko</a> <a href="https://phprussia.ru/2019/abstracts/5151" target="_blank" rel="noopener noreferrer">который был недавно на PHPRussia</a>.</p>
<p>У Александра был доклад про магию (я очень порадовался что в мире есть единомышленники) и если вы интересуетесь магией, то вам явно стоит увидеть этот доклад (теперь уже в записи). Александр там упомянул <a href="https://www.php.net/manual/en/filters.php" target="_blank" rel="noopener noreferrer">stream filetrs</a>, которые есть в PHP начиная с 5й версии (если не ошибаюсь). Когда впервые я увидел эти фильтры я не понял для чего их можно применить на практике, чтобы прям была польза. Ведь по сути это возможность парсить подключаемый файл перед парсингом интерпретатора, что можно сделать и без фильтров (что я и делал еще во времена PHP4 (когда-то был у меня самописный фреймворк со своим синтаксическим сахаром aka DSL)).</p>
<p>Были разные идеи применения для обфускации, например(были времена работы в вебстудии когда делиться кодом было не принято). Но вот чтобы применить эти фильтры для того, чтобы Паблик Морозов мог взломать защищенные методы — эта идея пришла только сейчас, с подачи Александра.</p>
<p>И так, суть, в PHP есть возможность регистрировать свои фильтры, которые потом можно применить при инклуде. Допустим мы пишем такой фильтр:</p>
<pre>&lt;?php</pre>
<pre><strong>class</strong> UnlockFilter <strong>extends</strong> PHP_User_Filter {<br><strong>private</strong> $_data;<em><br></em><strong>function</strong> onCreate() {<br>      $<strong>this</strong>-&gt;_data = '';<br><strong>return</strong> <strong>true</strong>;<br>   }<br><strong>   public</strong> <strong>function</strong> filter($in, $out, <strong>&amp;</strong>$consumed, $closing) {<em><br></em><strong>while</strong>($bucket = stream_bucket_make_writeable($in)) {<br>         $<strong>this</strong>-&gt;_data .= $bucket-&gt;data;<br>         $<strong>this</strong>-&gt;bucket = $bucket;<br>         $consumed = 0;<br>      }<em><br></em><strong>if</strong>($closing) {<br>         $consumed += strlen($<strong>this</strong>-&gt;_data);<br>         $str = preg_replace(<br>            '~private|protected~', 'public', $<strong>this</strong>-&gt;_data<br>         );<br>         $this-&gt;bucket-&gt;data = $str;<br>         $this-&gt;bucket-&gt;datalen = strlen($<strong>this</strong>-&gt;_data);<br>         if(!<strong>empty</strong>($<strong>this</strong>-&gt;bucket-&gt;data))<br>            stream_bucket_append($out, $this-&gt;bucket)<br>         ;<br><strong>return</strong> PSFS_PASS_ON;<br>      }<br><strong>return</strong> PSFS_FEED_ME;<br>   }<br>}</pre>
<p>Далее мы его регистрируем:</p>
<pre>stream_filter_register('unlock', 'UnlockFilter');</pre>
<p>И вот теперь мы можем подключить файл, в котором есть класс полностью защищенный (а нам по каким-то причинам ну очень надо все раскрыть):</p>
<pre><strong>include</strong> 'php://filter/read=unlock/resource=foo.php';</pre>
<p>Что делает фильтр? По сути это просто тупо автозамена ключевых слов, такой парсинг перед парсингом, после чего код выполняется. Вы не модифицируете оригинальный файл, но модифицируете загружаемый код на лету. Следующи шаг взлома — это просто ручками залезть и поменять все приваты и протектед ?</p>
<p>Чем плох такой подход в лоб? Тем, что мы не разбираемся что заменяем и меняем все подряд. Более умный подход — это реализовать фильтр с разбором исходного кода. Для этого можно использовать как встроенный в PHP <a href="https://www.php.net/manual/ru/book.tokenizer.php" target="_blank" rel="noopener noreferrer">tokenizer</a>, так и более продвинутые библиотеки наподобие <a href="https://pecl.php.net/package/ast" target="_blank" rel="noopener noreferrer">PHP AST</a>.</p>
<p>Кстати, частенько спрашивают, а зачем знать магию? Где это применять? Теперь как пример могу смело приводить фреймворк <a href="https://github.com/goaop/framework" target="_blank" rel="noopener noreferrer">Go!AOP</a> (Аспектно-Ориентированный Фреймворк) все от того же <a href="https://medium.com/u/bb77dc6767eb" target="_blank" rel="noopener noreferrer">Alexander Lisachenko</a>, который работает с применением магии. Кстати, по такому же принципу работают unfinal или <a href="https://github.com/Codeception/AspectMock" target="_blank" rel="noopener noreferrer">AspectMock</a>.</p>
<p>Вообще спорный вопрос, что есть магия, тем более если это описано в документации и это документированные возможности языка. Почему-то считается, что если есть что-то в языке, что мало кому известно (или мало применяется) — это сразу магия. Может просто почаще перечитывать документацию? ?</p>
<p>Если развивать идею применения фильтров, то можно создавать свои варианты шаблонизаторов, различные DSL или вовсе выдумать свой диалект PHP. Глядя на фронтенд сообщество с его бабелями и обилием диалектов, начинаешь думать, а почему бы и нет? Возможно вернемся к этим фантазиям в другой статье, где я покажу разные идеи применения фильтров для написания собственного DSL. Кстати, Александр предложил написать статью и разобрать его фреймворк GoAOP. По его словам мало людей в мире могут это сделать ?. Если вам, мои читатели, это интересно — напишите в комментариях, пожалуйста, нужно ли разобрать или в сети достаточно информации?</p>
<p>Продолжим… Если вы помните, то Паблик Морозов всячески показывал как получить доступ к приватным и протекдем свойствам и методам. Мы там пропустили примеры закрытых классов — когда есть приватный конструктор.</p>
<p>Допустим есть какой-то синглтон:</p>
<pre>&lt;?php declare(strict_types=1);</pre>
<pre><strong>class</strong> Singleton {<br><strong>private</strong> <strong>static</strong> <em>$instance</em>;<br><strong>public</strong> $foo = 0;<br><br><strong>private</strong> <strong>function</strong> __construct() {<br>      $this-&gt;foo = 123;<br>   }<br><br><strong>public</strong> <strong>static</strong> <strong>function</strong> instance(): <strong>self</strong> {<br>      if (!<strong>self</strong>::<em>$instance</em>)<br><strong>self</strong>::<em>$instance </em>= <strong>new</strong> <strong>self</strong>;<br><strong>return</strong> <strong>self</strong>::<em>$instance</em>;<br>   }<br>};</pre>
<p>Нужна возможность получить больше 1го инстанса, что делать?</p>
<p>Самый простой случай это просто склонировать созданный объект и далее его модифицировать:</p>
<pre>$foo1 = Singleton::instance();<br>$foo2 = clone $foo1;</pre>
<p>По этой причине закрывают клонирование через добавление:</p>
<pre>private function __clone() {}</pre>
<p>Вот теперь уже просто склонировать не получится. Но, вспоминая примеры Паблика Морозова, мы можем обойти этот запрет через:</p>
<pre>$foo1 = Singleton::instance();<br>$foo2 = (<strong>function</strong>() { <strong>return</strong> <strong>clone</strong> $<strong>this</strong>; })-&gt;bindTo($foo1, Singleton::<strong>class</strong>)();<br><br>$foo1-&gt;foo = 456;<br>var_dump($foo1); <em>// 456<br></em>var_dump($foo2); <em>// 123</em></pre>
<p>А что если это не Singleton и нет никакого метода instance?</p>
<pre><strong>class</strong> Closed {<br><strong>private</strong> $foo = 0;<br><strong>private</strong> <strong>function</strong> __construct() { $<strong>this</strong>-&gt;foo = 123; }<br><strong>private</strong> <strong>function</strong> __clone() {}<br><strong>public</strong> <strong>function</strong> getFoo() { <strong>return</strong> $<strong>this</strong>-&gt;foo; }<br>}</pre>
<p>Вообще полностью закрытый класс. Мы можем заглянуть в документацию и посмотреть что нам предлагает ReflectionAPI, а предлагает он нам создать класс в обход конструктора:</p>
<pre>$foo = (<strong>new</strong> ReflectionClass(Closed::<strong>class</strong>))<br>          -&gt; newInstanceWithoutConstructor()<br>;</pre>
<pre>var_dump($foo-&gt;getFoo()); // = int(0)</pre>
<p>Но есть минус и заключается он в том, что не будет выполнена логика, зашитая в конструктор. Мы его можем вызвать опять же через функцию извне, привязав ее к контексту:</p>
<pre>(<strong>function</strong>() { <strong>return</strong> $<strong>this</strong>-&gt;__construct(); })-&gt;bindTo($foo, Closed::<strong>class</strong>)();</pre>
<pre>var_dump($foo-&gt;getFoo()); // = int(123)</pre>
<p>Но если мы так заморочились, не проще ли сразу получить нужный инстанс через внешнюю функцию через привязку к контексту?</p>
<pre>$foo = (<strong>function</strong>() { <strong>return</strong> <strong>new</strong> <strong>static</strong>; })<br>        -&gt;bindTo(<strong>null</strong>, Closed::<strong>class</strong>)()<br>;</pre>
<p>Ну вот и все. И конструктор сработал, и инстанс получили.</p>
<p>В конце статьи про Паблика Морозова был показан хак, как создавать stdClass с приватными свойствами. И в комментариях там писали что можно использовать для взлома десериализатор. Суть: мы можем сериализовать класс и посмотреть как он выглядит, если бы у него все методы были паблик:</p>
<pre>&lt;?php</pre>
<pre><strong>class</strong> Closed { <strong>function</strong> __construct() {} }<br><br>var_dump( serialize(<strong>new</strong> Closed()) );</pre>
<p>Получается строка:</p>
<pre>string(17) "O:6:"Closed":0:{}"</pre>
<p>Т.е. мы можем взять и составить такую же строку и провернуть все наоборот:</p>
<pre><strong>class</strong> Closed { <strong>private</strong> <strong>function</strong> __construct() {} }<br>$foo = <strong>unserialize</strong>(<br><strong>sprintf</strong>(<br><em>'O:%d:"%s":0:{}'</em>,<br><strong>strlen</strong>(Closed::<strong>class</strong>), Closed::<strong>class</strong><br>         )<br>      )<br>;</pre>
<p>И мы получим инстанс класса, от которого как бы нельзя было инстанцироваться. Эта же техника применима и к методам и свойствам.</p>




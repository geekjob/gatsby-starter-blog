---
title: "Про приведение типов в JS и магию. Часть 2"
date: "2019-03-10T16:41:56.000Z"
description: "Что еще надо знать
> «Где отсутствует точное знание, там действуют догадки,
а из десяти догадок девять — ошибки»
Этот материал б"
---

<h4 id="-">Что еще надо знать</h4><blockquote>«Где отсутствует точное знание, там действуют догадки,<br>а из десяти догадок девять — ошибки»</blockquote>- <a class="kg-bookmark-container" href="/privedenie-tipov-v-js/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">Приведение типов в JS</div><div class="kg-bookmark-description">Магия или простые правила? &gt; «Где отсутствует точное знание, там действуют
догадки, а из десяти догадок девять — ошибки» &gt; (с) Максим Горький Данный материал, в первую очередь, вам не только поможет пройти собеседования на
позицию Frontend разработчика, но вам лично прояснит как же все-таки р…</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://tech.geekjob.ru/favicon.png"><span class="kg-bookmark-author">Александр Майоров</span><span class="kg-bookmark-publisher">Geekjob Tech</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://tech.geekjob.ru/content/images/2020/04/1_qLzx9tDMLoj2o9Hy15X8Fw.png"></div></a> <br/>

<p>И не забываем, что после вызова методов для преобразования примитивов, если левый и правый операнды все еще разных типов, то начинают работать механизмы, описанные в предыдущей статье: <a href="https://medium.com/@frontman/%D0%BF%D1%80%D0%B8%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D0%B5-%D1%82%D0%B8%D0%BF%D0%BE%D0%B2-%D0%B2-js-9d6f1845ea96" target="_blank" rel="noopener noreferrer">Приведение типов в JS</a>. Если, к примеру, результат этих функций число, а вы складываете его с boolean, то преобразования будут продолжаться.</p>
<p>Фишка valueOf в том, что его нет почти ни у кого и у всех по дефолту реализован toString. Есть только одно исключение, у кого реализован valueOf и этот метод вызывается независимо от toString.</p>
<h4>Исключения</h4>
<p>По историческим причинам объект <code>Date</code> является исключением. Дело в том, что у большинства объектов по дефолту не реализован valueOf и вызывается toString. Но у Date реализованы и toString, и valueOf:</p>
<pre>''+<strong>new</strong> Date   // 'Thu Mar 07 2018 21:14:50 GMT+0300'<br>  +<strong>new</strong> Date   // 1551982490848</pre>
<p>Исключение тут еще в том, что сложение со строкой вызывает toString, хотя согласно логике должен вызываться всегда valueOf, что и выделяет объект Date среди прочих. И опять, это не магия, это правило (точнее исключение), которое надо запомнить и этого будет достаточно…</p>
<p>— Или не исключение? Можете создать объект похожий по поведению на Date?</p>
<p>Мне сложно сказать, как был реализован объект Date раньше, но сегодня его поведение можно повторить. Решение этой задачи будет чуть ниже.</p>
<p>— А как работают valueOf и toString при строгих равенствах? Ммм?</p>
<p>— Отличный вопрос!</p>
<pre>console.log(<br>    1 == { valueOf: _=&gt;console.log('detect') }<br>)<br>// print 2 lines: detect and false</pre>
<pre>// and if:<br>console.log(<br>    1 === { valueOf: _=&gt;console.log('detect') }<br>)<br>// print 1 line: false</pre>
<p>При строгих сравнениях магические методы не вызываются. Запомнили, идем дальше. Хоть это и попало в блок “исключения”, но это не исключение. Это правило.</p>
<h3>Symbol</h3>
<p>С приходом в JS такого типа как Symbol, у нас появились и новый тип, и новые магические методы. Если раньше на вопрос “Сколько типов в JS” вы отвечали:</p>
<p>JavaScript определяет 6 типов данных:</p>
<ul>
<li>5 типов данных примитивы: Number, String, Boolean и два специальных типа Undefined и Null (при этом typeof null = “object”)</li>
<li>И тип Object.</li>
</ul>
<p>То в 2019 этот ответ уже давно является ошибочным и на него надо отвечать так: <strong>современный</strong> <strong>стандарт ECMAScript6+ определяет 7 типов данных</strong>: все что сказали выше плюс еще <strong>тип Symbol</strong>.</p>
<p>Symbol — это новый примитивный тип данных, который служит для создания уникальных идентификаторов. Символ получается с помощью функции Symbol:</p>
<pre><strong>let</strong> symbol = <strong>Symbol()</strong>;<br><strong>typeof</strong> symbol === 'symbol'</pre>
<p>— Если это примитив, то его так же можно вернуть из <code>toString</code> и <code>valueOf</code>, м?</p>
<p>— О, интересный вопрос!</p>
<pre><strong>const</strong> obj = {<br><strong>toString</strong>() {console.log('Call toString')<br><strong>return</strong> <strong>Symbol</strong>.for("lol")<br>  }<br>}</pre>
<pre>  +obj  //TypeError: Cannot convert a Symbol value to a number<br>''+obj // TypeError: Cannot convert a Symbol value to a string</pre>
<p>Хмм. Чет ломается логика. А ты говорил… Ха ха, жабаскрипт косячный!</p>
<p>То что оно не конвертится, не значит что нельзя вернуть. Доказательство:</p>
<pre>obj == Symbol.for("lol") // true</pre>
<p>С <code>valueOf</code> все тоже самое и все работает согласно правилам.</p>
<h4>Well-known Symbols</h4>
<p>Существует так же глобальный реестр символов, который позволяет иметь общие глобальные символы, которые можно получить из реестра по имени. Для чтения (или создания, при отсутствии) глобального символа служит вызов метода <code>Symbol.for(name)</code>.</p>
<p>Особенность символов в том, что если в объект записать свойство-символ, то оно не участвует в итерациях:</p>
<pre><strong>const</strong> obj = {<br>  foo: 123,<br>  bar: 'abc',<br>  [<strong>Symbol</strong>.for('obj.wow')]: <strong>true</strong><br>};</pre>
<pre><strong>Object</strong>.keys(obj); // foo, bar</pre>
<pre>obj[<strong>Symbol</strong>.for('obj.wow')]; // true</pre>
<p>Символы активно используются внутри самого стандарта ES. Есть много системных символов, их список есть в спецификации, в таблице <a href="http://www.ecma-international.org/ecma-262/6.0/index.html#table-1" target="_blank" rel="noopener noreferrer">Well-known Symbols</a>. Для краткости символы принято обозначать как “@@name”, а доступны они как свойства объекта<code>Symbol</code>.</p>
<p>Многие уже успели познакомиться с<code>Symbol.iterator</code></p>
<p>К примеру, хотим так:</p>
<pre><strong>const</strong> obj = { foo: 123, bar: 'abc' };</pre>
<pre><strong>for</strong> (<strong>let</strong> v of obj) v; // TypeError: obj is not iterable</pre>
<p>Но не можем. Но если хочется, то можем:</p>
<pre><strong>const</strong> obj = {<br>    foo: 123,<br>    bar: 'abc',<br>    [<strong>Symbol</strong>.iterator]() {<br><strong>const</strong> values = <strong>Object</strong>.values(<strong>this</strong>);<br><strong>return</strong> { // Iterator object<br>            next: ()=&gt;({<br>              done : 0 === values.length,<br>              value: values.pop(),<br>            })<br>        }<br>    }<br>}<br><strong>for</strong> (<strong>let</strong> v <strong>of</strong> obj) console.log(v);</pre>
<p>Громоздко, поэтому мы можем создать класс вида:</p>
<pre><strong>class</strong> IObject {<br><strong>constructor</strong>(obj) {<br><strong>for</strong> (<strong>let</strong> k <strong>in</strong> obj) {<br><strong>if</strong> (!obj.hasOwnProperty(k)) <strong>continue</strong>;<br><strong>this</strong>[k] = obj[k]<br>        }<br>    }</pre>
<pre>    [<strong>Symbol</strong>.iterator]() {<br><strong>const</strong> values = <strong>Object</strong>.values(<strong>this</strong>);<br><strong>return</strong> { // Iterator interface<br>            next: ()=&gt;({<br>              done : 0 === values.length,<br>              value: values.pop(),<br>            })<br>        }<br>    }    <br>}</pre>
<pre><strong>const</strong> obj = <strong>new</strong> IObject({<br>    foo:  123 ,<br>    bar: 'abc',<br>});<br><strong>for</strong> (<strong>let</strong> v <strong>of</strong> obj) console.log(v);</pre>
<p>Мы немного отвлеклись, речь не про итераторы…</p>
<p>Так вот, <a href="http://www.ecma-international.org/ecma-262/6.0/index.html#table-1" target="_blank" rel="noopener noreferrer">в этой таблице</a> мы видим два символа:</p>
<ul>
<li>@@toPrimitive</li>
<li>@@toStringTag</li>
</ul>
<p>Ухты, что за воу? Давайте разбираться&#8230;</p>
<h3>Symbol.toPrimitive</h3>
<p>Это новый “магический” метод, призванный заменить toString и valueOf. Его принципиальное отличие: он принимает аргумент — тип, к которому желательно привести:</p>
<pre><strong>const</strong> obj = {<br><strong>[Symbol.toPrimitive]</strong>(hint) {<br><strong>return</strong> {<br>         number: 100,<br>         string: 'abc',<br>         default: true<br>      }[hint]<br>   }<br>};<br><br>console.log( +obj ); // 100<br>console.log( obj + 1 ); // 2<br>console.log( 1 - obj ); // -99<br>console.log( `${obj}` ); // abc<br>console.log( obj + '1' ); // true1<br>console.log( 'a' + obj ); // atrue</pre>
<p>Всего доступно 3 типа хинтинга:</p>
<pre>"number"<br>"string"<br>"default"</pre>
<p>Если реализован метод @@toPrimitive, то toString и valueOf не вызываются.</p>
<p>Точнее так, valueOf — алиас на @@toPrimitive, при этом явный вызов будет передавать тип хинтинга default:</p>
<pre>console.log( obj.valueOf() ); // true</pre>
<p>Если вы явно вызовите toString, то будет вызван метод родителя, @@toPrimitive не будет участвовать.</p>
<p>Но!</p>
<pre><strong>const</strong> obj = {<br><strong>toString</strong>() { console.log('toString'); return 1 },<br><strong>valueOf</strong>() { console.log('valueOf'); return 1 },<br><strong>[Symbol.toPrimitive]</strong>(hint) {<br><strong>return</strong> {<br>         number: 100,<br>         string: 'abc',<br>         default: true<br>      }[hint]<br>   }<br>};</pre>
<p>если явно не вызывать методы toString и valueOf — то они не будут вызываться. Если вызвать явно — то они отработают явно как обычные методы.</p>
<p>Если вы попробуете вернуть не примитив, то будет ошибка вида:</p>
<pre>TypeError: Cannot convert object to primitive value</pre>
<p>А теперь про задачу, которую спрашивал выше. Можно ли реализовать поведение как у объекта Date? Ответ: да, можно, как раз благодаря новому @@toPrimitive:</p>
<pre><strong>const</strong> Dollar = {<br>   num: 66.26,<br><strong>[Symbol.toPrimitive]</strong>(hint) {<br><strong>switch</strong> (hint) {<br><strong>case</strong> 'number': <strong>return</strong> <strong>this</strong>.valueOf();<br><strong>case</strong> 'string': <strong>default</strong>: <strong>return</strong> <strong>this</strong>.toString()<br>      }<br>   },<br><strong>valueOf</strong>() { <strong>return</strong> <strong>this</strong>.num },<br><strong>toString</strong>(){ <strong>return</strong> `1 доллар = ${<strong>this</strong>.num} рублей на дату ${(<strong>new</strong> Date).toLocaleString()}` }<br>};<br><br>console.dir(   +Dollar);<br>console.dir('' +Dollar);<br><br>console.dir(Dollar.valueOf()  );<br>console.dir(Dollar.toString() );</pre>
<p>Мы получим два разных вывода:</p>
<pre>66<br>'1 доллар = 66 рублей на дату 2019-03-08'</pre>
<p>Вот и выходит что то, что раньше считалось исключением, сегодня можно считать нормальным поведением, реализованным через @@toPrimitive, которое мы так же можем повторить.</p>
<h3>Symbol.toStringTag</h3>
<p>Этот well-known symbol, который содержит в себе строку — тег, который выводится при дефолтном вызове toString:</p>
<pre>// built-in <code>toStringTag :<br>Object.prototype.toString.call('foo');     // "[object String]"<br>Object.prototype.toString.call([1, 2]);    // "[object Array]"<br>Object.prototype.toString.call(3);         // "[object Number]"<br>Object.prototype.toString.call(true);      // "[object Boolean]"<br>Object.prototype.toString.call(undefined); // "[object Undefined]"<br>Object.prototype.toString.call(null);      // "[object Null]"<br>Object.prototype.toString.call(new Map());       // "[object Map]"<br>Object.prototype.toString.call(function* () {}); // "[object GeneratorFunction]"<br>Object.prototype.toString.call(Promise.resolve()); // "[object Promise]"</code></pre>
<p>Вы можете переопределять это свойство для своих классов, чтобы при дебаге вывод был более информативным, но при этом стандартизирован:</p>
<pre><strong>class</strong> ValidatorClass{<strong>get</strong> [<strong>Symbol</strong>.toStringTag](){<strong>return</strong> 'Validator'}}</pre>
<pre><strong>let</strong> <strong>o<em> </em></strong>= <strong>new</strong> ValidatorClass<br><br><strong>console</strong>.log(<strong>o</strong>.toString())</pre>
<pre>// Выдаст [object Validator] вместо [object Object].</pre>
<p>Symbol.toStringTag возвращает всегда строку. Если не строку, то будет проигнорирован и сработает дефолтный Symbol.toStringTag из родителя. Если есть toString, valueOf или Symbol.toPrimitive — их приоритет выше, поэтому не будет срабатывать дефолтный вызов, в котором используется этот таг.</p>
<p>@@toStringTag всегда будет с префиксом [object].</p>
<pre><strong>const</strong> o = {<br>   foo: 123,<br><strong>get</strong> [<strong>Symbol</strong>.toStringTag](){ <strong>return</strong> JSON.stringify(<strong>this</strong>) }<br>};<br><br>console.log(o+''); // [object {"foo":123}]</pre>
<h3>Node.js и inspect</h3>
<p>Мы могли бы закончить на этом, но все же нам надо еще сказать пару слов про магию в контексте Node.js (в браузерах этого нет).</p>
<pre><strong>const</strong> obj = {<br>   foo: 123,<br><strong>inspect</strong>() {console.log('Call Inspect');<br><strong>return</strong> 300<br>   }<br>};<br>console.log(obj) // ???</pre>
<p>До недавнего времени такой код мог взрывать мозг, опять же из-за незнания и особенностей уже API Node.js. Это зарезервированный метод в Node.js. Был зарезервирован, но уже нет. Если вы объявляли метод inspect, то могли удивляться тому, что вываливалось в консоль.</p>
<p>Но сейчас уже все ок, у нас нода 10+ и в ней больше не вызывается метод inspect. Но! Но с приходом символов появилась альтернативная магия. Благодаря символам можно расширять API не боясь поломать пользовательский код, поэтому есть ряд well-known symbols, которые специфичны только для ноды, среди которых:</p>
<pre><strong>const</strong> obj = {<br>   foo: 123,<br><strong>[util.inspect.custom]</strong>() { <strong>return</strong> 300 }<br>};<br><br>console.log( obj ); // 300</pre>
<p>Да да, все верно, в консоль выводится 300. Прям как в HR анекдоте:</p>
<pre>— Зарплата фронтендеров?<br>— 300!<br>— Что 300 ?<br>— А что зарплата фронтендеров?</pre>
<p>Разные npm пакеты пользуются этим механизмом, поэтому если хотите увидеть реальное состояние дел, то пользуйтесь console.dir или:</p>
<pre><strong>const</strong> util = <strong>require</strong>('util');<br>util.<strong>inspect</strong>.defaultOptions.customInspect = <strong>false</strong>;</pre>
<pre><strong>const</strong> obj = {<br>   foo: 123,<br><strong>[util.inspect.custom]</strong>() { return 300 }<br>};<br><br>console.log( obj );<br>console.dir( obj );</pre>
<pre>// В обоих случаях вывод будет одинаковым:<br>{ foo: 123,<br>  [Symbol(nodejs.util.inspect.custom)]: [Function: [nodejs.util.inspect.custom]] }</pre>
<p>Вообще некоторые рекомендуют использовать util.inspect для отладки, вместо console.log и/или console.dir, но это спорный вопрос.</p>
<p>Так же util.inspect.custom принимает аргументы (как и console.dir) и вы можете внутри реализовать умный inspect, реагирующий на настройки:</p>
<pre><strong>[util.inspect.custom]</strong>(depth, options) {<br><em>/*<br></em><strong><em>depth</em></strong><em>: 2<br></em><strong><em>options</em></strong><em>: {<br>  budget: {},<br>  indentationLvl: 0,<br>  seen: [],<br>  stylize: [Function: stylizeWithColor],<br>  showHidden: false,<br>  depth: 2,<br>  colors: true,<br>  customInspect: true,<br>  showProxy: false,<br>  maxArrayLength: 100,<br>  breakLength: 60,<br>  compact: true,<br>  sorted: false,<br>  getters: false }<br>*/<br></em>}</pre>
<h3>Закругляемся</h3>
<p>Уф, вроде бы все. Зачем все это? Это подготовительный этап к следующей статье.</p>
<p>А если про практический смысл: понимая как работает ваш инструмент, вы сможете делать меньше ошибок (и быстрее их отлавливать) даже без использования TypeScript и прочих инструментов (которые иногда создают иллюзию безопасности). Да да, я считаю что лишние транспайлеры и обертки над языком — это дополнительные точки отказа, которые могут привести к проблемам. Если ванильный код вы можете легко отдебажить, то результат работы транспайлеров и прочих постобработок может быть непредсказуемым и содержать в себе ошибки (такое уже было в практике и не раз). Но это уже другая тема для холивара и я ее обязательно наброшу и разовью.</p>




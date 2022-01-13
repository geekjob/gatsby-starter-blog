---
title: "Релиз TypeScript 2"
date: "2016-09-23T15:28:34.000Z"
description: "Вышел релиз языка и уже доступна версия 2.0.3 22 сентября разработчики Microsoft объявили о выходе релиза TypeScript 2.0!  Это с"
---

<h4>Вышел релиз языка и уже доступна версия 2.0.3</h4>
<p>22 сентября разработчики Microsoft объявили о выходе релиза TypeScript 2.0!</p>
<p>Это событие не может остаться без внимания, т.к. TypeScript несет с собой множество новых фич, а так же обновленния существующих.</p>
<p>За подробностями добро пожаловать под кат, а, чтобы сразу опробовать прочитанное, устанавливайте новую версию. Если вы прямо сейчас выполните:</p>
<pre>npm i -g typescript</pre>
<p>то вы получите наисвежайшую последнюю версию языка 2.0.3!</p>
<h3>Null- and undefined-aware types</h3>
<p>В TypeScript есть два специальных типа, Null и Undefined, чьими значения являются null и undefined соответственно. Раньше отсутствовала возможность явно дать имена этим типам, но теперь null и undefinedмогут использоваться, как типы, независимо от режима проверки типов.</p>
<p>Ранее проверка типов считала, что null и undefined могут быть присвоены любому типу. Фактически, null и undefined были допустимыми значениями для любого типа и было невозможно намеренно исключить их (и как следствие невозможно обнаружить ошибочное их использование).</p>
<h3>Non-nullable Types</h3>
<p><a href="https://msdnshared.blob.core.windows.net/media/2016/09/nonnullable-types-fade.mp4" target="_blank" rel="noopener noreferrer">https://msdnshared.blob.core.windows.net/media/2016/09/nonnullable-types-fade.mp4</a></p>
<p>В TS есть два специальных типа, Null и Undefined, значения которых null и undefined соответственно. Раньше отсутствовала возможность явно дать имена этим типам, но теперь null и undefined могут использоваться как типы, независимо от режима проверки.</p>
<p>Раньше компилятор считал, что null и undefined могут быть присвоены любому типу. Фактически, null и undefined были допустимыми значениями для любого типа и было невозможно намеренно отказаться от них и, как следствие, невозможно обнаружить ошибочное их использование.</p>
<p>Флаг</p>
<pre>--strictNullChecks</pre>
<p>позволяет переключить компилятор в новый режим строгой проверки Null типа.</p>
<p>В режиме strictNullChecks значения null и undefined уже не являются подтипами составных типов и могут быть значениями только самих себя и any.</p>
<p>Поэтому, несмотря на то, что “T” и “T | undefined” считаются синонимами в обычном режиме (т.к. undefined является подтипом для любого T), они становятся разными типами в строгом режиме и только “T | undefined” разрешает undefined значения. Эти же правила истины для пары “T” и “T | null”.</p>
<p>Примеры:</p>
<pre>let x: number;<br>let y: number | undefined;<br>let z: number | null | undefined;</pre>
<pre>x = 1;  // Ок<br>y = 1;  // Ок<br>z = 1;  // Ок</pre>
<pre>x = undefined;  // Error<br>y = undefined;  // Ок<br>z = undefined;  // Ок</pre>
<pre>x = null;  // Error<br>y = null;  // Error<br>z = null;  // Ок</pre>
<pre>x = y;  // Error<br>x = z;  // Error<br>y = x;  // Ок<br>y = z;  // Error<br>z = x;  // Ок<br>z = y;  // Ок</pre>
<h4>Assigned-before-use checking</h4>
<p>Проверка присвоения перед использованием. В этом режиме компилятор требует, чтобы каждой ссылке на локальную переменную с типом отличным от undefined предшествовало присвоение.</p>
<h4>Пример</h4>
<pre><strong>let</strong> x: number;<br><strong>let</strong> y: number | null;<br><strong>let</strong> z: number | undefined;</pre>
<pre>x;  <em>// Error</em><br>y;  <em>// Error</em><br>z;  <em>// Ок</em></pre>
<pre>x = 1;<br>y = null;</pre>
<pre>x;  <em>// Ок</em><br>y;  <em>// Ок</em></pre>
<p>Компилятор проверяет, что переменным явно присвоены значения, выполняя анализ типов на основании механизма Flow Type Checking.</p>
<p>К необязательным аргументам и свойствам автоматически добавляется тип undefined, даже, если он явно не перечислен в объявлении этих типов. Например:</p>
<pre><em>// x: number | undefined</em><br>type T1 = (x?: number) =&gt; string; </pre>
<pre><em>// x: number | undefined</em><br>type T2 = (x?: number | undefined) =&gt; string;</pre>
<p>Эти два объявленных типа идентичны.</p>
<h4>Non-null and non-undefined type guards</h4>
<p>Ранее доступ к свойству или вызов функции генерировали ошибку на этапе компиляции, если тип объекта или функции включали undefined или null . Теперь TypeScript осуществляет не-null и не-undefined проверки.</p>
<pre>declare function f(x: number): string;</pre>
<pre>let x: number | null | undefined;</pre>
<pre>if (x) {<br>    f(x);  // Ок, у x тип number<br>}<br>else {<br>    // Ошибка, у x тип number? (по сути number|null|undefined)<br>    f(x);<br>}</pre>
<pre>let a = x != null ? f(x) : "";  // У a тип string<br>let b = x &amp;&amp; f(x);// У b тип string? (по сути string|null|undefined)</pre>
<p>Важно помнить, что к логичскому и<strong>(&amp;&amp;)</strong> применяется принцип короткого цикла вычислений. Если <strong>x</strong> имеет значение отличное от <strong>null</strong> и <strong>undefined</strong>, то будет произведено вычисление выражения <strong>f(x)</strong>, результат которого будет иметь тип <strong>string</strong>. Если же <strong>x</strong> типа <strong>null</strong> или <strong>undefined</strong>, то <strong>b</strong> примет значение <strong>x</strong>. Таким образом получается, что x может быть типа string или “null|undefined”, что можно сократить как “string?”</p>
<p>Благодаря не-null проверкам для сравнения с <strong>null</strong> или <strong>undefined</strong> можно использовать операторы сравнения<strong>. </strong>Пример:</p>
<pre>x != null<br>x === undefined</pre>
<h4>Dotted names in type guards</h4>
<p>Ранее производилась проверка только для локальных переменных и аргументов функций. Теперь так же “type guards” проверка работает и для переменной или аргумента функции при доступе к одному или более их свойствам.</p>
<pre>interface Options {<br> location?: {<br>    x?: number;<br>    y?: number;<br> };<br>}</pre>
<pre>function foo(options?: Options) {<br> if (options &amp;&amp; options.location &amp;&amp; options.location.x)<br>   const x = options.location.x;<br>}</pre>
<p>Компилятор знает, что у <strong>x</strong> тип <strong>number</strong>.</p>
<p>Этот механизм так же работает с пользовательскими assert функциями, а так же с операторами <strong>typeof</strong> и <strong>instanceof</strong> и не зависят от флага компилятора <em>strictNullChecks</em>.</p>
<p>Типы <strong>null</strong> и <strong>undefined</strong> не могут быть расширены типом <strong>any</strong> в режиме строгой проверки. Допустим у нас есть такая переменная:</p>
<pre><strong>let</strong> x = null;</pre>
<p>В обычном режиме допустимым типом <strong>x </strong>является <strong>any</strong>, но в строгом режиме подразумеваемым типом <strong>x</strong> является <strong>null</strong> и, как следствие, <strong>null</strong> является единственным возможным значением в данном примере.</p>
<h4>Not null operator</h4>
<p>Добавлен новый оператор “<strong>!</strong>”, который следует после выражения. Оператор подсказывает компилятору, что тип операнда не-null и не-undefined, когда компилятор сам не может определить тип. К примеру, результатом операции x! будет значение типа с исключенными null и undefined. Так же, как и в случае приведения типов через синтаксис “&lt;T&gt;x” и “x as T”, оператор не-null утверждения просто удаляется из скомпилированного JavaScript кода.</p>
<pre><strong>function</strong> <strong>validateEntity</strong>(e: Entity?) {<br><em>// Бросить исключение, если у e значение null или недопустимый Entity</em><br>}</pre>
<pre><strong>function</strong> <strong>processEntity</strong>(e: Entity?) {<br>  validateEntity(e);<br><strong>let</strong> s = e!.name;<br>}</pre>
<p>Утверждаем, что на данном этапе у <strong>e</strong> не-null значение и есть доступ к свойству name иначе будет брошено исключение.</p>
<p>Новые возможности могут быть использованы в обычном и строгом режимах проверки типов. В частности, типы null и undefined автоматически вырезаются из объединения типов в обычном режиме проверки типов, а оператор не-null утверждения разрешен, но не оказывает никакого влияния на принятия решения компилятором.</p>
<p>Таким образом обновленные для использования в строгом режиме файлы объявлений (declaration files) все еще могут быть использованы в обычном режиме проверки типов для обратной совместимости.</p>
<h3>More Literal Types</h3>
<p>Строковые типы литералов появились в версии 1.8. Разработчики хотели, чтобы типы отличные от string так же получили эту возможность. Поэтому в новой версии каждый уникальный тип boolean, number и enum получит свой тип. Используя составные типы можно выражать некоторые сущности более натурально.</p>
<pre>type Digit = 0 | 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9;<br><strong>let</strong> nums: Digit[] = [2, 4, 8];</pre>
<pre><em>// Ошибка! 32 не входит в тип 'Digit'!</em><br>nums.push(32);</pre>
<h3>Never type</h3>
<p>В TS 2.0 вводится новый примитивный тип never. Этот тип представляет тип значений, которые никогда не произойдут. В частности тип never представляет функции, чей возвращаемый тип данных не определен, а так же переменные, для которых type guards никогда не выполнятся.</p>
<p>Тип never имеет следующие характеристики:</p>
<ul>
<li>Отсутствие типа является подтипом для never, а так же может быть присвоено к never (за исключением самого never).</li>
<li>Это подтип, который может быть присвоен любому типу.</li>
<li>Если для функционального выражения или стрелочной функции явно не указан тип возвращаемого значения и отсутствуют выражения return или все return возвращают тип never и если точка выхода из функции не доступна (так определил контроль усправления потока), то прогнозируемый тип возвращаемого значения функции будет never.</li>
<li>В функциональном выражении, для которого явно указан never в качестве типа возвращаемого значения все return-ы (если они есть) должны возвращать выражения типа never, а так же точка выхода из функции не должна быть достижима.</li>
</ul>
<p>Т.к. never является подтипом любого типа, он всегд опущен в составных типах и всегда игнорируется в объявлении типа возвращаемого значения функции, если для этой функции указаны другие типы возвращаемого значения.</p>
<pre>function error(message: string): never {<br>    throw new Error(message);<br>}</pre>
<pre>function fail() { // :never<br>    return error("Something failed");<br>}</pre>
<pre>function infiniteLoop(): never {<br>    while (true) {<br>    }<br>}</pre>
<h3>Read-only properties and index signatures</h3>
<p>Для свойств и индексов теперь можно указывать модификатор доступа readonly, что позволяет только читать данное свойство или индекс.</p>
<p>Помеченные флагом readonly свойства могут быть проинициализированы при объявлении или же внутри конструктора класса, где эти свойства были определены, в других местах переопределение readonly свойств запрещено.</p>
<p>Кроме того, в некоторых ситуациях readonly подразумевается контекстом:</p>
<ul>
<li>Для свойства определен только метод доступа get, но не set.</li>
<li>Свойства объекта типа enum считаются readonly свойствами.</li>
<li>Свойства экспортируемых из модуля объектов, объявленных через constсчитаются readonly свойствами.</li>
<li>Импортируемые (через import) из модулей сущности считаются readonly.</li>
<li>Обращение к сущностям импортируемым из модулей, спроектированных в стиле ES2015 считаются readonly (например foo.x доступен только для чтения, если foo объявлен как import * as foo from “foo”).</li>
</ul>
<p>Примеры:</p>
<pre>interface Point {<br>    readonly x: number;<br>    readonly y: number;<br>}</pre>
<pre>var p1: Point = { x: 10, y: 20 };<br>p1.x = 5; // Error!</pre>
<pre>class Foo {<br>    readonly a = 1;<br>    readonly b: string;</pre>
<pre>constructor() {<br>        this.b = "hello"; // Ok<br>    }<br>}</pre>
<h3>Control flow based type analysis</h3>
<p>Ранее анализ типа произведенный на основании механизма type guardings был ограничен условными выражениями if и ?: и не брал во внимание последствия присвоения значений, а так же такие контролирующие поток конструкции, как return и break.</p>
<p>Теперь механизм проверки типов анализирует все возможные потоки, проходящие через утверждения и выражения для того, чтобы сделать более точные выводы о вероятном типе переменной или аргумента функции, который является составным типом, в любом месте кода.</p>
<p>Кроме того в режиме строгой проверки типов анализ типа на основании контроля потока так же предупреждает о необходимости явного определения значения у переменных, чей тип не разрешает undefined значений.</p>
<h3>Specifying the type of this for functions</h3>
<p>Теперь в функциях и методах можно указывать, какой тип this они ожидают.</p>
<p>По умолчанию тип this в функции — any. Начиная с версии 2.0, вы можете явно указать this в качестве аргумента, где this является ложным аргументом, который идет первым в списке аргументов функции:</p>
<pre><strong>function</strong> <strong>foo</strong>(this: void) {<br><em>// </em>Использование <em>this в теле функции приведет к ошибке<br></em>}</pre>
<p>Добавлен новый флаг noImplicitThis, который позволяет сообщать об использовании функций, где тип this не указан.</p>
<h3>Необязательные свойства и методы класса</h3>
<p>Необязательные свойства и методы теперь можно определить внутри класса таким же образом, как это делается в интерфейсах. Пример:</p>
<pre><strong>class</strong> Foo{<br>  a: number;<br>  b?: number;</pre>
<pre>  c() { <strong>return</strong> 1 }<br>  d?() { <strong>return</strong> 2 }<br>  f?(): number; <em>// Тело может быть опущено</em><br>}</pre>
<h3>Private and Protected Constructors</h3>
<p>Конструктор класса может теперь можно объявить как private или protected.</p>
<p>Класс с private конструктором не может быть инициализирован за пределами класса, а так же не может быть расширен.</p>
<p>Класс с protected конструктором тоже не может быть инициализирован, однако может быть расширен.</p>
<pre>class Singleton {<br>    private static instance: Singleton;<br>    private constructor() { }</pre>
<pre>    static getInstance() {<br>      if (!Singleton.instance)<br>          Singleton.instance = new Singleton;<br>      return Singleton.instance;<br>    } <br>}</pre>
<pre>let Obj1 = new Singleton(); // Error!<br>let Obj2 = Singleton.getInstance(); // Ok</pre>
<h3>Abstract properties and accessors</h3>
<p>Внутри абстрактного класса могут быть объявлены абстрактные свойства и/или методы доступа. Любой наследуемый класс обязан реализовать абстрактные свойства или тоже должен быть абстрактным. Абстрактные свойства не могут быть инициализированы. Абстрактные методы доступа не могут иметь тело. Пример:</p>
<pre>abstract class Base {<br>  abstract name: string;<br>  abstract get value();<br>  abstract set value(v: number);<br>}</pre>
<pre>class Derived extends Base {<br>  name = "derived";<br>  value = 1;<br>}</pre>
<h3>Implicit index signatures</h3>
<p>Литерал объекта теперь может быть присвоен типу с сигнатурой индекса в том случае, если все известные свойства этого объекта сопоставимы с сигнатурой индекса. Это позволяет передать переменную в качестве аргумента функции, которая ожидает словарь или массив:</p>
<pre><strong>function</strong> <strong>httpService</strong>(path: string, headers: { [x: string]: string }) { }<br><br><strong>const</strong> headers = {<br>    "Content-Type": "application/x-www-form-urlencoded"<br>};<br><br>httpService("", { "Content-Type": "application/x-www-form-urlencoded" });  <em>// Ок</em></pre>
<pre>httpService("", headers);  <em>// Раньше это вызвало бы ошибку компилятора, но сейчас - нет</em></pre>
<h3>Allow duplicate identifiers across declarations</h3>
<p>Разрешены дублирующие объявления между файлами деклараций. Подобные ситуации были основным источником появления ошибок при работе с TS: несколько файлов деклараций объявляли одни и те же cвойства в интерфейсах.</p>
<p>Это ограничение ослабили и теперь компилятор позволяет иметь дублирующие определения между файлами, если они имеют одинаковый тип. Но внутри одного файла дублирования по-прежнему запрещены.</p>
<p>Пример:</p>
<pre>// file1.d.ts<br>interface Foo { a?: string; }</pre>
<pre>// file2.d.ts<br>interface Foo {<br>    b?: string;<br>    c?: string;<br>    a?: string;  // Ок<br>}</pre>
<h3>Trailing commas in function parameter and argument lists</h3>
<p>Завершающая запятая в аргументах и параметрах функции теперь разрешена. Эта возможность является реализацией предложения Stage-4 (утверждено и будет реализовано в будущей версии ES) ECMAScript, которое совместимо с предыдущими версиями: ES3/ES5/ES6.</p>
<h3>Файлы деклараций внешних модулей</h3>
<p>Файлы деклараций это основной способ использования API внешних библиотек в TypeScript, но их получение и расположение не идеально.</p>
<p>Теперь файлы внешних деклараций можно подключать не выходя из npm. В качестве примера, чтобы установить файлы деклараций для библиотеки lodash достаточно всего лишь выполнить npm команду:</p>
<pre>npm install --save @types/lodash</pre>
<h3>Прочие нововведения</h3>
<h4>Including built-in type declarations with — lib</h4>
<p>Подключение встроенных деклараций опцией — lib</p>
<h3>Flag unused declarations with — noUnusedParameters and — noUnusedLocals</h3>
<p>Появились опции — noUnusedParameters и — noUnusedLocals для уведомления о неиспользуемых объявлениях.</p>
<h3>Module identifiers allow for .js extension</h3>
<p>Поиск модулей с расширением .js</p>
<h3>Support “target: es5” with “module: es6”</h3>
<h3>Ссылки по теме</h3>
<p><a href="https://github.com/Microsoft/TypeScript/wiki/What%27s-new-in-TypeScript">https://github.com/Microsoft/TypeScript/wiki/What%27s-new-in-TypeScript</a><br />
<a href="https://github.com/Microsoft/TypeScript/wiki/What%27s-new-in-TypeScript">https://github.com/Microsoft/TypeScript/wiki/What%27s-new-in-TypeScript</a><br />
<a href="https://github.com/Microsoft/TypeScript/wiki/What%27s-new-in-TypeScript">https://github.com/Microsoft/TypeScript/wiki/What%27s-new-in-TypeScript</a><br />
<a href="https://github.com/Microsoft/TypeScript/wiki/What%27s-new-in-TypeScript">https://github.com/Microsoft/TypeScript/wiki/What%27s-new-in-TypeScript</a><br />
<a href="https://github.com/Microsoft/TypeScript/wiki/What%27s-new-in-TypeScript">https://github.com/Microsoft/TypeScript/wiki/What%27s-new-in-TypeScript</a></p>



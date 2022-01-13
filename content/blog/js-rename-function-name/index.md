---
title: "JS: Rename function name"
date: "2020-07-07T11:18:18.00Z"
description: "Мутируем иммутабельное, переписываем имена Многие, кто работает с JS, знают, что все есть объект в JS, а что не объект, то с эти"
---

<h2 id="-">Мутируем иммутабельное, переписываем имена</h2><p>Многие, кто работает с JS, знают, что все есть объект в JS, а что не объект, то с этим можно работать как с объектом. Поэтому мы можем в JS вытворять такие штуки:</p><pre><code class="language-javascript">30..toString(16) // = 1e
"abc".length // = 3</code></pre><p>и так далее. Но при этом надо понимать, что не все такие свойства можно изменять. Некоторые из них readonly. У кого что и как работает — надо знать (изучая документацию или опытным путем). Поэтому может быть непонятно, как так выходит, что:</p><pre><code class="language-javascript">let a = [1,2,3];
let s = "123";

a.length = 2;
a; // [1,2]

s.length = 2;
s; // TypeError: Cannot assign to read only property 'length' of string '123'</code></pre><p>Хотя было бы логично же сделать поведение как и в массивах, да?</p><p>И вот одна из интересных задач, которую можно встретить не только на собеседовании, но и в жизни:</p><pre><code class="language-javascript">function foo(){}
var foo = function (){};
var foo = function bar(){};</code></pre><p>Очень интересный, но уже стар как мир, вопрос: в чем различия?</p><p>Надо ли рассказывать в чем? Если надо раскрыть задачи такого плана— напишите в комментариях. Сейчас в 2х словах для тех, кто только изучает JS или пришел из других языков:</p><pre><code class="language-javascript">function foo(){}
// всплывет, доступна перед объявлением по foo(),
// function.name = 'foo',
// внутри тела доступна по foo() для рекурсии

var foo = function (){};
// всплывет var foo, доступна только после присвоения по foo(), 
// function.name = 'foo',
// внутри тела доступна по foo() для рекурсии

var foo = function bar(){};
// всплывет var foo, доступна только после присвоения по foo(), 
// function.name = 'bar',
// внутри тела функции доступна как по bar()
// так и по foo() для рекурсивного вызова</code></pre><p>Очень кратко. Надо будет подробнее — распишу или ищите в документации. Так вот, к чему этот вопрос? Видите вот этот загадочный <code>function.name</code> ?</p><p>Для тех, кто не в курсе, имя функции можно получить через свойство <code>name</code>:</p><pre><code class="language-javascript">function foo(){}
console.log( foo.name ) // 'foo'

var foo = function(){}
console.log( foo.name ) // 'foo'

var foo = function bar(){}
console.log( foo.name ) // 'bar'</code></pre><p>Ну и что? Зачем это нам и где это используется?</p><p>А это используется в том же <code>console.log()</code> , вы можете просто написать:</p><pre><code class="language-javascript">function foo(){}
console.log( foo ) // '[Function: foo]'

var foo = function(){}
console.log( foo ) // '[Function: foo]'

var foo = function bar(){}
console.log( foo ) // '[Function: bar]'</code></pre><p>Вы обратили внимание что в нашем случае вроде бы анонимная функция всеравно имеет имя? Но что если:</p><pre><code class="language-javascript">function some(fn) {
  console.log(fn) // '[Function]'
  console.log(fn.name) // ''
}

some(function(){
  // some callback
});</code></pre><p>И вот у вас весь стек трейс из таких вот анонимных <code>[Function]</code>. Что это? Откуда? И приходится гадать и распутывать. Что можно сделать, чтобы добавить имя? Все верно, присвоить в переменную или дать имя:</p><pre><code class="language-javascript">function some(fn) {
  console.log(fn) // '[Function: foo]'
  console.log(fn.name) // 'foo'
}

var foo;
some(foo = function(){
  // some callback
});</code></pre><p>Это экзотика какая-то, кто так пишет, скажете вы. Ну да, лучше писать так:</p><pre><code class="language-javascript">some(function foo(){
  // some callback
});</code></pre><p>И я полностью согласен. Подписывать (давать имена) функции — это полезно для отладки.</p><h4 id="--1">Задачка</h4><p>Как-то, не помню уже как и из какой задачи, возникла идея, в результате которой родился вопрос (возможно даже встретить его на собеседованиях):</p><pre><code class="language-javascript">const foo = function bar() {}
console.log(foo.name)

foo.name = 'lol';
console.log(foo.name) // ???</code></pre><p>Что будет? Можем переименовать функцию?</p><p>Ответ:</p><ol><li><code>foo.name = 'bar'</code></li><li><code>foo.name = 'lol'</code> — <code>TypeError: Cannot assign to read only property ‘name’ of function ‘function bar() {}’</code></li></ol><p>Выходит что нельзя? А если прям ну очень надо?</p><p>Ну если “ну очень надо”, то можно. В мире нет ничего невозможного :)</p><pre><code class="language-javascript">const foo = function bar() {}
console.log(foo.name)

Reflect.defineProperty(foo,'name',{value:'lol'});

console.log(foo.name) // 'lol'
console.log(foo) // [Function: lol]</code></pre><p>Вот таким вот нехитрым способом можно переименовать функцию. Доступна ли она по имени <code>lol()</code> ? Нет, недоступна. Но в логах вы будете видеть это имя. Таким образом можно генерить программно имена колбэков и подписывать их.</p><p>Если недоступен Reflect, то используйте Object:</p><pre><code class="language-javascript">Object.defineProperty(foo,'name',{value:'lol'});</code></pre><p>Смысл тот же.</p><h3 id="p-s-">P.S.:</h3><p>Я удивлен, как люди засирают NPM пакетами из 2–3 строк. Какие же это, матьево, пакеты? Я понимаю прелесть переиспользования логики, но если бы они хотя бы были сгруппированы в пакеты. Тот же leftpad, который вызвал пару лет назад бурю негодования сообщества и все кричали что мы разучились программировать, имеет хотя бы 47 строк кода. Но когда я наткнулся на этот “пакет”: <a href="https://github.com/sindresorhus/rename-fn" rel="nofollow noopener">https://github.com/sindresorhus/rename-fn</a></p><p>Я был в шоке… А какой следующий шаг? Экспортироватьть нативные функции? Этот модуль для переименования функции состоит из 1 строчки:</p><pre><code class="language-javascript">module.exports = (fn, name) =&gt; Object.defineProperty(fn, 'name', {value: name, configurable: true});</code></pre><p>Друзья!.. Коллеги!.. Ребята! Не делайте так! Если хочется поделиться с миром — напишите статью, пост в твиттере, но не пульте в NPM такие вещи. Не надо вам в зависимости такой пакет. Вообще не нужна функция, используйте сразу вызов <code>Reflect.defineProperty()</code> с нужными параметрами на нужном объекте и не заворачивайте это все в функции. Зачем?</p>


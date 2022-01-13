---
title: "Реализация Одиночки в JS"
date: "2016-08-25T11:54:49.00Z"
description: "Как не облажаться на интервью Тема, вроде бы, изъезженная. Кто-то реально на практике применяет понимая что это и зачем. Кто-то "
---

<!--kg-card-begin: html--><h4>Как не облажаться на интервью</h4>
<p>Тема, вроде бы, изъезженная. Кто-то реально на практике применяет понимая что это и зачем. Кто-то применяет, но не знает что это известный шаблон проектирования и он так называется. У кого-то спрашивают про это на собеседованиях.</p>
<p>С учетом особенностей JS различные варианты из ООП в нем могут быть очень даже нестандартными. Я сам иногда на собеседовании прошу написать Singleton у кандидата, только в случае если он совершил следующие действия:</p>
<ol>
<li>сказал что знает ООП и шаблоны проектирования</li>
<li>сказал, что из всех паттернов знает Singleton</li>
</ol>
<p>Не хочу поднимать сейчас вопрос о необходимости такого паттерна в JavaScript. Но как это не удивительно, Singleton’ом в JavaScript мы оперируем повседневно.</p>
<p>Обычно я спрашиваю вопрос таким образом:</p>
<blockquote><p>Какие есть способы получать один и тот же экземпляр объекта?</p></blockquote>
<p>И тут я жду рассуждений. Каждый из нас пользовался и не раз Singleton объектами в JS даже не думая ни о каких шаблонах объектно ориентированного программирования. Как ни странно, но задача для многих оказывается нетривиальной. Даже если человек до этого писал на PHP или C#, к примеру. Даже если человек давно знаком с JS, почему-то мало кто отвечает, что самый простой способ создать Singleton объект в JS — это создать глобальную переменную с присвоением объекта, ведь в JS для создания экземпляра объекта не обязательно создавать класс. В JS все есть объект…</p>
<p>В результате решил агрегировать все свои знания и оформить в виде сборника решений одной задачи на все случаи жизни. Причем покажу варианты на ES5, ES6+ и TypeScript. TypeScript в данном случае выступает в роли правильного ООП языка. И так, поехали…</p>
<h4>Singleton — одиночка</h4>
<p>Немного занудства, можно пропустить, если все это знаете.</p>
<blockquote><p>
<strong>Одиночка</strong> (англ. <em>Singleton</em>) — порождающий шаблон проектирования, гарантирующий что в однопоточном приложении будет <strong>единственный экземпляр класса с глобальной точкой доступа</strong>.</p></blockquote>
<p>Порождающие шаблоны (англ. <em>Creational patterns</em>) — шаблоны проектирования, которые абстрагируют процесс инстанцирования. Они позволяют сделать систему независимой от способа создания, композиции и представления объектов.</p>
<p>Шаблон, порождающий классы, использует наследование, чтобы изменять инстанцируемый класс, а шаблон, порождающий объекты, делегирует инстанцирование другому объекту.</p>
<p><strong>Цель</strong></p>
<p>Гарантирует, что у класса есть только один экземпляр, и предоставляет к нему глобальную точку доступа. Существенно то, что можно пользоваться именно <em>экземпляром</em> класса, так как при этом во многих случаях становится доступной более широкая функциональность. Например, к описанным компонентам класса можно обращаться через интерфейс, если такая возможность поддерживается языком.</p>
<p><strong>Плюсы</strong></p>
<ol>
<li>Контролируемый доступ к единственному экземпляру.</li>
</ol>
<p><strong>Минусы</strong></p>
<ol>
<li>Глобальные объекты могут быть вредны для объектного программирования, в некоторых случаях приводя к созданию немасштабируемого проекта;</li>
<li>Усложняет написание модульных тестов и следование TDD.</li>
</ol>
<p><strong>Примеры использования</strong></p>
<ul>
<li>Объект-дебаггер для отладки web-приложения</li>
<li>Объект сбора ошибок</li>
<li>Класс доступа к браузерным хранилищам и cookies</li>
<li>Реализация шаблона Реестр (Registry). Например реестр объектов, для контроля за используемыми объектами на странице</li>
<li>Реализация паттерна Медиатор или Application controller</li>
</ul>
<hr>
<h4>Условия выполнения</h4>
<p>Мы воспользуемся подходом TDD и прежде чем писать реализации запишем минимальные тесты, которые должны быть выполнены. Так как это JS и этот язык сильно отличается от более “правильных” языков типа Java, C++ и прочих, в которых создание объекта реализуется через класс, а конструктор не может ничего возвращать, то мы будем так же рассматривать варианты реализации без конструктора и классического определения класса. Ведь в JS это можно делать.</p>
<p>И так, минимальные условия:</p>
<pre>var <strong>errorMessage</strong> = 'Instantiation failed: use Singleton.getInstance() instead of new.';</pre>
<pre>// Test constructor<br>try { var <strong>obj0</strong> = new <strong>Singleton</strong> } catch(<strong>c</strong>) { console.log(<strong>c</strong> == <strong>errorMessage</strong>) }</pre>
<pre>// Create and get object<br>let <strong>obj1</strong> = <strong>Singleton</strong>.getInstance();<br>let <strong>obj2</strong> = <strong>Singleton</strong>.getInstance();</pre>
<pre><strong>obj1</strong>.foo = 456;<br>console.log( <strong>obj1</strong> === <strong>obj2</strong> );</pre>
<pre>try { var <strong>obj3</strong> = new <strong>Singleton</strong> } catch(<strong>c</strong>) { console.log(<strong>c</strong> == <strong>errorMessage</strong>) }</pre>
<pre>console.log(<strong>obj0</strong> === void 0);<br>console.log(<strong>obj3</strong> === void 0);</pre>
<p>Но эти тесты будут модифицированы в процессе разбора решений, так как у нас будут реализации, возвращающие ссылку на объект из конструктора.</p>
<h3>Реализации Singleton в TypeScript</h3>
<h4>Классическая реализация на TypeScript</h4>
<pre>
class Singleton {

  protected static _instance :Singleton;
  
  protected foo :number = 123;
  
  constructor() {
    if (Singleton._instance) {
        throw new Error("Instantiation failed: "+
                        "use Singleton.getInstance() instead of new.");
    }
    Singleton._instance = this;
  }

  public static getInstance() :Singleton {
    if (Singleton._instance) {
      return Singleton._instance;
    }
    return Singleton._instance = new Singleton;
  }
}
</pre>
<p>Все бы хорошо, но в TypeScript 1.8 нет возможности задать приватный конструктор, что приводит к добавлению логики в него. Минусы такой реализации — при первом вызове <em>new Singleton</em> конструктор вернет объект. Да им можно пользоваться, но это нарушает классическую реализацию. Мы можем модифицировать код и получить вот такую версию:</p>
<pre>
class Singleton {

  protected static _instance :Singleton = new Singleton;
  
  protected foo :number = 123;
	
  constructor() {
    if (Singleton._instance) {
        throw new Error("Instantiation failed: "+
                        "use Singleton.getInstance() instead of new.");
    }
  }

  public static getInstance() :Singleton {
    return Singleton._instance;
  }
}
</pre>
<p>В такой реализации и кода меньше, и нельзя получить экземпляр объекта через new, так как первая иницализация происходит “автоматически” при объявлении класса.</p>
<p>Снова повторюсь: так как у нас необычный язык, то реализовать задачу можно совершенно необычными способами. Например мы можем реализовать одиночку через пространство имен (namespace):</p>
<pre>
namespace Singleton {
	
  interface Instance {
    foo: number;
  }
  
  const instance :Instance = {
    foo: 123
  };
  
  export function getInstance() :Instance {
    return instance;
  }
}
</pre>
<p>Продолжая развивать тему, мы можем реализовать паттерн через модуль. Я покажу вариант модуля:</p>
<pre>
module Singleton {
	
  class Instance {
	  constructor(public foo: number = 123) {}
  }
  
  let instance = new Instance;
  
  export function getInstance() :Instance {
     return instance;
  }
}
</pre>
<p>Вы так же можете реализовать модуль в отдельном файле:</p>
<pre>
class Instance {
  constructor(public foo: number = 123) {}
}

let instance = new Instance;

export function getInstance() :Instance {
  return instance;
}

// ...

import * as Singleton from "singleton.ts";

let obj1 = Singleton.getInstance();
let obj2 = Singleton.getInstance();

obj1.foo = 456;

console.log( obj1 === obj2 );
</pre>
<p>В такой реализации у нас не то чтобы нет доступа к объекту через вызов new Singleton. У нас вообще нет возможности достучаться до конструктора (ну мы сейчас не рассматриваем цепочку прототипов и прочие возможности JS).</p>
<h4>Анонимный класс</h4>
<p>Так можНо, если нужно ?</p>
<pre><strong>const</strong> Singleton = <strong>new</strong> (<strong>class</strong> {<br><strong>public</strong> foo :number = 123;<br>   getInstance() :this { <strong>return</strong> this }<br>})();</pre>
<h3>Реализации Singleton в JavaScript</h3>
<p>А теперь вернемся к нашему любимому JavaScript со всеми его возможностями. И так, помните я говорил, что мы каждый день пользуемся объектами одиночками? Так как у нас JS , то нам вовсе не нужно создавать класс для получения объекта. Мы можем создать объект, который будет проходить наши тесты:</p>
<pre>const <strong>Singleton</strong> = {<br><strong>foo</strong>: 123,<br>   getInstance() { return <strong>this</strong> }<br>};</pre>
<pre>let <strong>obj1</strong> = <strong>Singleton</strong>.getInstance();<br>let <strong>obj2</strong> = <strong>Singleton</strong>.getInstance();</pre>
<pre><strong>obj1</strong>.foo = 456;<br>console.log( <strong>obj1</strong> === <strong>obj2</strong> );</pre>
<p>В данном примере метод getInstance создан только для того, чтобы не менять наши тесты. Ведь у нас есть полный доступ ко всему объекту и мы можем делать с ним что угодно. Но если вспоминать классическое определение шаблона, то там сказано что Одиночка порождающий шаблон, гарантирующий единственный экземпляр класса с глобальной точкой доступа. Пример выше выполняет эти условия, разве что у нас не реализован механизм порождения. Хотя можно считать что он встроен в язык программирования.</p>
<p>А теперь рассмотрим более сложные примеры на ES5+, позволяющие создавать именно классы, которые будут порождать Singleton.</p>
<p>И да, мы можем возвращать из конструктора любой объект, что дает простор воображению. Поехали!</p>
<h4>Используем arguments</h4>
<pre>function <strong>Singleton</strong>() {<br>   if (arguments.callee.instance) return arguments.callee.instance;<br>   this.foo = 123;<br>   return arguments.callee.instance = this;<br>}</pre>
<pre>let <strong>obj1</strong> = new <strong>Singleton</strong>;<br>let <strong>obj2</strong> = new <strong>Singleton</strong>;</pre>
<pre>obj1 === obj2 // true</pre>
<p>Метод лаконичен и просто в реализации, но у него есть недостаток. В режиме <em>“use strict”</em> этот код не будет работать, а JSLint/JSHint в (Php|Web)Storm будет показывать ошибку.</p>
<p>Тогда этот же пример можно переписать так:</p>
<pre>function <strong>Singleton</strong>() {<br>    if (<strong>Singleton</strong>.instance) return <strong>Singleton</strong>.instance;<br><strong>this</strong>.foo = 123;<br>    return <strong>Singleton</strong>.instance = <strong>this</strong>;<br>}</pre>
<h4>Скрываем доступ к instance</h4>
<p>Пример на ES5 c приватными (локальными) переменными:</p>
<pre>
(function(g){
    /** @type {SingletonConstructor} */
    var instance;
    g.Singleton = function() {
        if (instance !== void 0) return instance;
        return instance = this;
    };
    g.Singleton.prototype.foo = 123;
})(window||global);

var obj1 = new Singleton;
var obj2 = new Singleton;

console.log(obj2.foo === 123);
obj1.foo = 456;
console.log(obj2.foo === 456);
console.log(obj1 === obj2 );
</pre>
<p>В этом примере используем замыкание для реализации.</p>
<p><strong>Краткая запись</strong></p>
<pre>var <strong>Singleton</strong> = new function(){<br>    var <strong>instance</strong> = <strong>this</strong>;<br><em>// Код конструктора<br></em><strong>    </strong>return function(){ return <strong>instance</strong> }<br>}</pre>
<pre>console.log( new <strong>Singleton</strong> === new <strong>Singleton</strong> ); // true</pre>
<h4>ECMAScript 2015</h4>
<pre>
let singleton = Symbol();
let singletonEnforcer = Symbol();

class Singleton {

  constructor(enforcer) {
    if (enforcer !== singletonEnforcer)
       throw "Instantiation failed: use Singleton.getInstance() instead of new.";
    // код конструктора
  }

  static get instance() {
    if (!this[singleton])
        this[singleton] = new Singleton(singletonEnforcer);
    return this[singleton];
  }
  
  static set instance(v) { throw "Can't change constant property!" }
}

export default Singleton;
    
// ...

import Singleton from 'singleton';

// Test constructor
try { var obj0 = new Singleton() } catch(c) { console.log(c) }
console.log('obj0', obj0 );


// Create and get object
let obj1 = Singleton.instance;
let obj2 = Singleton.instance;



console.log(obj2.foo === 123 );
obj1.foo = 456;
console.log('obj2', obj2 );
console.log('obj1 === obj2',  obj1 === obj2 );

try { var obj3 = new Singleton() } catch(c) { console.log(c) }
console.log('obj3', obj3);
</pre>
<h4>Эпилог</h4>
<p>Как видите способов и разнообразия для реализации логики порождающей единственный экземпляр объекта хватает в нашем любимом JavaScript.</p>
<!--kg-card-end: html-->


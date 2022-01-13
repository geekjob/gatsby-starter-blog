---
title: "Управление потоком выполнения в PHP"
date: "2020-05-26T13:06:14.000Z"
description: "В этой заметке мы не будем рассуждать на тему правильного и чистого кода, что он должен быть коротким, и тд и тп...  Суть вопрос"
---

<p>В этой заметке мы не будем рассуждать на тему правильного и чистого кода, что он должен быть коротким, и тд и тп...</p><p>Суть вопроса вот в чем. Есть линейное выполнение нескольких IF блоков, SWITCH блоков и все это в рамках одной функции или скрипта. По дефолту мы не можем вызвать блоки break в IF блоках, а в блоках SWITCH порой есть необходимость сгруппировать по смыслу несколько ветвей без брейка, но как управлять исключениями в таком случае? Поясню примерами.</p><p>Может быть такая ситуация</p><pre><code class="language-php">// ...

if(condition) {

    // ... may be continue true

    if(condition_a) {

         // ... may be continue true

         if(condition_b) {

			// ... may be continue true

         }
         else {

              // ... may be continue true
			  // ... some logic
         }

    }
    else {

         // ... may be continue true
	     // ... some logic
    }

	// ... may be continue true
    // ... some logic
}

// contunue code thread
</code></pre><p>И тогда приходит в голову завести переменную $continue, которую выставляем в истину, если нужно перейти дальше, а в каждом блоке нужно делать проверку.</p><pre><code class="language-php">// ...

if(condition) {
    $continue = false;
    // ... may be continue true

    if(condition_a &amp;&amp; !$continue) {

         // ... may be continue true

	  if (!$continue) {
         if(condition_b) {

			// ... may be continue true

         }
         else {

              // ... may be continue true
			  // ... some logic
         }
       }
    }
    elseif (!$continue) {

         // ... may be continue true
	     // ... some logic
    }

	// ... may be continue true
    // ... some logic
}

// contunue code thread</code></pre><p>Ну как-то так.</p><p>Что касается switch, то могут быть такие логические развязки:</p><pre><code class="language-php">
switch ($route) {
    case '/a':
    	// some do and continue
    
    case '/b':
    case '/c':
    	call_abc($route);
        break;

    case '/a1':
    case '/b1':
    case '/c1':
    	call_abc1($route);
		break;
    default:
     // ...
}

// contunue code thread</code></pre><h2 id="-">Решение</h2><p>Блок IF мы можем завернуть в блок do - while, тогда нам будут доступны break'и:</p><pre><code class="language-php">
do {


   if (a) { somedo(); break; }

   if (b) { somedo(); break; }

   if (c) { somedo(); break; }


} while(0);</code></pre><p>Другой вариант - это использовать лейблы и блок goto. Да, много было сломано копий про ужасность этого оператора, но в PHP он имеет ограничения, так что наколбасить прям ужас ужас не получится.</p><pre><code class="language-php">
if (a) { somedo(); goto mainthread; }

if (b) { somedo(); goto mainthread; }

if (c) { somedo(); goto mainthread; }


mainthread:
// contunue code thread</code></pre><p>Ну и еще вариант, если вы можете использовать внешний скрипт как один большой switch-case, то вы просто можете делать return прямо из кода (не только из функции):</p><pre><code class="language-php">
// ...

require __DIR__ . '/switch.php';

// contunue code thread</code></pre><p><strong>switch.php</strong> :</p><pre><code class="language-php">&lt;?php declare(strict_types=1);

if (a) { somedo(); return; }

if (b) { somedo(); return; }

if (c) { somedo(); return; }
</code></pre><p>Я не вижу проблем в использовании таких подходов, особенно если это небольшие системные скрипты и утилиты.</p>


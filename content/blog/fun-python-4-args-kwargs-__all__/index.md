---
title: "Fun Python #4: про args, kwargs и __all__"
date: "2020-01-22T14:58:06.00Z"
description: "Вот что я узнал… И так, продолжаю изучать Python и узнавать что-то новое. Дабы закрепить свои знания, делаю пометки в виде посто"
---

<!--kg-card-begin: html--><h4>Вот что я узнал…</h4>
<p>И так, продолжаю изучать Python и узнавать что-то новое. Дабы закрепить свои знания, делаю пометки в виде постов. Что сегодня я узнал…</p>
<p>Когда начал изучать Python, все курсы и уроки, рассказывающие про модули умалчивали про то, что можно управлять тем, что импортируется из модулей. И только недавно узнал про ключевое слово __all__.</p>
<pre>$ cat foo.py<br>def a(): print("function a()")<br>def b(): print("function b()")</pre>
<pre>$ cat app.py<br>from foo import *<br>a()<br>b()</pre>
<p>Все отработает, но если мы сделаем так:</p>
<pre>$ cat foo.py<br>def a(): print("function a()")<br>def b(): print("function b()")</pre>
<pre>__all__ = ["a"]</pre>
<p>то</p>
<pre>from foo import *<br><br>b()</pre>
<pre>NameError: name 'b' is not defined</pre>
<p>Если задать None, то вообще не импортируется ничего:</p>
<pre>__all__ = None</pre>
<p>И вроде бы круто, можно управлять. Но, как оказалось, поведение его не совсем то, какое я ожидал. Оказывается что этот механизм не защищает от прямых обращений вида:</p>
<pre>from foo import a, b</pre>
<p>Такой импорт игнорирует __all__ и это было для меня не очевидно, но это описано в документации и так задумано, так что все ок.</p>
<figure>
<p><img data-width="74" data-height="90" src="https://cdn-images-1.medium.com/max/600/1*jaqHGQeOhOdDX_lJAH4ntg.jpeg"><br />
</figure>
<p>Собственно вот что сегодня я узнал…</p>
<!--kg-card-end: html-->


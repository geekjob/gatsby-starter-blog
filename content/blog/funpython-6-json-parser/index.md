---
title: "FunPython #6: Простой JSON парсер без библиотек"
date: "2020-01-28T14:32:58.000Z"
description: "Eval JSON string in Python Допустим есть некий JSON:  json_str = '{"someInt":42,"someTrue":true,"someNull": null,"someFalse":fal"
---

<h4>Eval JSON string in Python</h4>
<p>Допустим есть некий JSON:</p>
<pre>json_str = '{"someInt":42,"someTrue":true,"someNull": null,"someFalse":false,"someString":"Hello!","someFloat":3.14}'</pre>
<p>Для работы с JSON в Python есть пакет json. Чтобы получить словарь из JSON строки мы можем поступить так:</p>
<pre><strong>import</strong> json<br><strong>from</strong> pprint <strong>import</strong> pprint<br><strong>pprint</strong>(json.loads(json_str))</pre>
<p>Получаем:</p>
<pre><em>{u'someFalse': False,<br> u'someFloat': 3.14,<br> u'someInt': 42,<br> u'someNull': None,<br> u'someString': u'Hello!',<br> u'someTrue': True}</em></pre>
<p>Все просто. А что если можно получить словарь из JSON без вспомогательных библиотек? Вам не кажется что JSON по синтаксису очень похож на словарь в Python? А что если сделать eval строки?</p>
<pre>pprint(<strong>eval</strong>(json_str))</pre>
<p>И тут мы получаем ошибку:</p>
<pre>NameError: name 'true' is not defined</pre>
<p>Хм. А что если…</p>
<pre>null = <strong>None<br></strong>true = <strong>True<br></strong>false = <strong>False</strong></pre>
<pre>json_dict = <strong>eval</strong>(json_str)<br>pprint(json_dict)</pre>
<p>Получаем:</p>
<pre><em>{'someFalse': False,<br> 'someFloat': 3.14,<br> 'someInt': 42,<br> 'someNull': None,<br> 'someString': 'Hello!',<br> 'someTrue': True}</em></pre>
<p>И вуаля, у нас получился JSON. Конечно такой метод использовать в веб приложении и, тем более, в продакшене опасно, но вот для личных скриптов вполне может быть пригодится. Как минимум про это можно просто знать, мало ли что…</p>



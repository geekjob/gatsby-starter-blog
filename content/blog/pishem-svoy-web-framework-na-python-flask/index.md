---
title: "Как написать свой web-framework на Python"
date: "2020-01-04T23:49:51.00Z"
description: "Пишем свой Flask И так, это продолжение темы про то, как изучить Python за выходные (новогодние выходные, если что).  Выучить Py"
---

<h2 id="-flask">Пишем свой Flask</h2><p>И так, это продолжение темы про то, как изучить Python за выходные (новогодние выходные, если что).</p><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="/viuchit-python-za-vihodnie/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">Выучить Python за выходные</div><div class="kg-bookmark-description">Мой путь от нуля до адекватного Junior Python DeveloperВсем привет! С новым 2020 годом и вот это все… Новогодние каникулы хороши тем,что есть легальная индульгенция на то, что можно делать то что нравится вопрекиприоритетам, разрешить себе забыть про работу и заняться чем-то интересным. Я решил …</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://tech.geekjob.ru/favicon.png"><span class="kg-bookmark-author">Geekjob Tech</span><span class="kg-bookmark-publisher">Александр Майоров</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://tech.geekjob.ruhttps://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/images/2020/04/1_esKzN_-aJy4N1hpXfNgasA.png"></div></a></figure><!--kg-card-begin: html--><style>
    pre {
        background: white !important;
        color: #402d8b !important;
    }
    pre strong {
        color: red !important;
    }
</style>
<p>В отличие от PHP, в Python сервер нужно реализовывать самому. Но, фреймворки все это делают за вас, а для продакшена используются готовые решения, такие как gunicorn.</p>
<p>Gunicorn это вариация WSGI HTTP сервера. Что такое WSGI — оставлю на самостоятельное обучение. Чтобы добиться совместимости с WSGI, нам нужен вызываемый объект (функция или класс), который принимает два параметра (environ и start_response), и возвращает совместимый с WSGI ответ.</p>
<p>Предполагается что вы уже знаете про виртуальное окружение, у вас стоит последняя версия питона и вы умеете пользоваться пакетным менеджером pip. Я не учу питону, я делюсь своим опытом как написать что-то похожее на фреймворк Flask.</p>
<p>И так, чтобы сделать простейший вебсервер на Python достаточно создать простейший файл main.py со следующим кодом:</p>
<pre><strong>def</strong> app(environ, start_response):<br>     response_body = <strong>b</strong><em>"Hello, World!"</em><br>     status = "200 OK"<br>     start_response(status, headers=[])<br><strong>return</strong> <strong>iter</strong>([response_body])</pre>
<p>И далее самый простой способ запустить это приложение:</p>
<pre>gunicorn -w 1 main:app</pre>
<p>В данном случае мы запускаем сервер с 1м воркером и указываем файл и вызываемую функцию. Все.</p>
<p>Но для отладки лучше использовать вебсервер из пакета wsgiref:</p>
<pre><strong>from</strong> wsgiref.simple_server <strong>import</strong> make_server<br>    server = make_server('127.0.0.1', 8080, app)<br>    server.serve_forever()</pre>
<p>и для старта такого сервера не нужен gunicorn, достаточно просто вызвать наш main.py</p>
<p>Ну что же, с сервером вроде бы разобрались. Давайте создадим myflask.py и начнем разработку. Вообще схема моего проекта будет выглядеть так:</p>
<pre>app.py<br>config.py<br>main.py<br>myflask.py</pre>
<p>Редактируем app.py</p>
<pre><strong>from</strong> config <strong>import</strong> Config<br><strong>from</strong> app <strong>import</strong> app<br><br><br><strong>if</strong> <strong>__name__</strong> == "__main__":<br>    app.run(debug=<strong>True</strong>)</pre>
<p>Это самый простой файл, пока у нас нет реализаций других файлов.</p>
<p>В данном файле мы говорим что импортируем некоторый app из файла app.py. Если этот файл вызван напрямую, а не импортирован, то мы вызываем наше приложение <code>app.run()</code></p>
<h4>Config.py</h4>
<p>Простой файл:</p>
<pre><strong>class</strong> Config:<br>    HOST = "127.0.0.1"<br>    PORT = 8080<br><br></pre>
<h4>Создаем app.py</h4>
<p>Я буду краток на слова и сразу показывать код. Вроде бы все так просто, что нет смысла комментировать:</p>
<pre><strong>from</strong> config <strong>import</strong> Config<br><strong>from</strong> myflask <strong>import</strong> MyFlask<br><br>app = MyFlask()<br>app.config.from_object(Config)</pre>
<pre><strong>@app</strong>.route("/")<br><strong>def</strong> home():<br>   return "Home page"</pre>
<pre><strong>@app</strong>.route("/about")<br><strong>def</strong> about():<br>    return "This is page about MyFlask framework :)"</pre>
<pre><strong>@app</strong>.route("/foo/{slug}")<br><strong>def</strong> foo(slug):<br><strong>return</strong> "Route with dinamyc {slug}"</pre>
<p>Здесь мы создаем объект app и описываем маршрутизацию, использую классную фичу языка — декораторы.</p>
<h4>Создаем MyFlask</h4>
<p>Ну и теперь создаем наш фреймворк:</p>
<pre><strong>from</strong> webob <strong>import</strong> Request, Response<br><strong>from</strong> parse <strong>import</strong> parse<br><strong>import</strong> os<br><strong>import</strong> re</pre>
<pre><strong>class</strong> MyFlask:<br><strong>def</strong> <strong>__init__</strong>(<strong>self</strong>):<br><strong>self</strong>.__routes = {}<br><strong>self</strong>.config = <strong>MyFlaskConfig</strong>()<br><br><strong>def</strong> <strong>__call__</strong>(<strong>self</strong>, environ, start_response=None):<br>        request = Request(environ)<br>        response = <strong>self</strong>.handle_request(request)<br><strong>return</strong> response(environ, start_response)<br><br><strong>def</strong> run(<strong>self</strong>, debug=False):<br><strong>from</strong> wsgiref.simple_server <strong>import</strong> make_server<br>        port = int(<strong>self</strong>.config['PORT']) or 5000<br>        host = <strong>self</strong>.config['HOST'] or "127.0.0.1"<br>        server = make_server(host, port, self)<br>        print(f'http://{host}:{port}')<br>        server.serve_forever()<br><br><strong>def</strong> route(<strong>self</strong>, path):<br><strong>def</strong> wrapper(handler):<br><strong>self</strong>.__routes[path] = handler<br><strong>return</strong> handler<br><strong>return</strong> wrapper<br><br><strong>def</strong> handle_request(<strong>self</strong>, request):<br>        response = Response()<br>        handler, kwargs = self.find_handler(request_path=request.path)<br><strong>if</strong> handler <strong>is</strong> <strong>not</strong> <strong>None</strong>:<br>            response.text = handler(**kwargs)<br><strong>else</strong>:<br><strong>self</strong>.default_response(response)<br><strong>return</strong> response<br><br><strong>def</strong> default_response(self, response):<br>        response.status_code = 404<br>        response.text = "&lt;center&gt;&lt;h1&gt;Not found 404&lt;/h1&gt;&lt;hr&gt;&lt;/center&gt;"<br><br><strong>def</strong> find_handler(self, request_path):<br><strong>for</strong> path, handler <strong>in</strong> <strong>self</strong>.__routes.items():<br>            parse_result = parse(path, request_path)<br><strong>if</strong> parse_result <strong>is</strong> <strong>not</strong> <strong>None</strong>:<br>                return handler, parse_result.named<br><strong>return</strong> <strong>None</strong>, <strong>None</strong></pre>
<p>Я не знаю надо ли расписывать весь этот код. Чего в этом коде не хватает — это реализации MyFlaskConfig, который описывается так:</p>
<pre><strong>class</strong> MyFlaskConfig:<br><strong>def</strong> <strong>__init__</strong>(<strong>self</strong>):<br><strong>self</strong>.__config = {<br>            "DEBUG": False,<br>            "HOST": "127.0.0.1",<br>            "PORT": 5000,<br>        }<br><br><strong>def</strong> <strong>__getitem__</strong>(<strong>self</strong>, item):<br><strong>return</strong> <strong>self</strong>.get(item)<br><br><strong>def</strong> <strong>__setitem__</strong>(<strong>self</strong>, key, value):<br><strong>self</strong>.__config[key] = value<br><br><strong>def</strong> get(<strong>self</strong>, item, defval=None):<br><strong>if</strong> item <strong>in</strong> self.__config:<br><strong>return</strong> <strong>self</strong>.__config[item]<br><strong>return</strong> defval<br><br><strong>def</strong> from_object(<strong>self</strong>, obj):<br><strong>for</strong> key <strong>in</strong> <strong>dir</strong>(obj):<br><strong>if</strong> key.isupper():<br><strong>self</strong>[key] = <strong>getattr</strong>(obj, key)</pre>
<p>Кстати, код функции from_object подсмотрел в исходниках Flask.</p>
<p>И так, это минимум, который позволяет реализовать простейший фреймворк похожий по API на Flask.</p>
<p>Чтобы не возвращать просто текст, давайте создадим простое подобие шаблонизатора:</p>
<pre><strong>def</strong> render_template(tpl_file: str, **kwargs):<br>    template_dir = os.path.dirname(<strong>__file__</strong>) + '/templates'<br>    tpl_path = template_dir + tpl_file<br><strong>with</strong> <strong>open</strong>(tpl_path) <strong>as</strong> f:<br>        s = f.read()<br><strong>for</strong> k <strong>in</strong> kwargs:<br>            s = re.sub(r'{' + k + '}', kwargs[k], s)<br><strong>return</strong> s</pre>
<p>Теперь создадим простой html шаблон templates/index.html:</p>
<pre>&lt;!doctype html&gt;<br>&lt;html lang="en"&gt;<br>&lt;head&gt;<br>    &lt;title&gt;<strong>{title}</strong>&lt;/title&gt;<br>&lt;/head&gt;<br>&lt;body&gt;<br><strong>{content}</strong><br>&lt;/body&gt;<br>&lt;/html&gt;</pre>
<p>Теперь наш app.py можно переписать так:</p>
<pre><strong>from</strong> config <strong>import</strong> Config<br><strong>from</strong> myflask <strong>import</strong> MyFlask, render_template<br><br>app = MyFlask()<br>app.config.from_object(Config)<br><br><br><strong>@app</strong>.route("/")<br><strong>def</strong> home():<br>    list_str = "&lt;ul&gt;"<br>    list_str += list_str.join(<em>[</em><strong><em>f</em></strong><em>'&lt;li&gt;&lt;a href="/hello/Item_{i}"&gt;Item {i}&lt;/a&gt;&lt;/li&gt;' </em><strong><em>for</em></strong><em> i </em><strong><em>in</em></strong><em> </em><strong><em>range</em></strong><em>(4)]</em>) + "&lt;/ul&gt;"</pre>
<pre>    <strong>return</strong> render_template('/index.html',<br>          title="Index",<br>          content=f"&lt;h1&gt;Main content&lt;/h1&gt;&lt;hr&gt;{list}",<br>          )<br><br><br><strong>@app</strong>.route("/about")<br>def about():<br><strong>return</strong> "This is page about MyFlask framework :)"<br><br><br><strong>@app</strong>.route("/foo/{slug}")<br><strong>def</strong> foo(slug):<br><strong>return</strong> render_template('/index.html',<br>                           title="Hello",<br>                           content=f"&lt;h1&gt;Hello, {slug}!&lt;/h1&gt;",<br>                           )</pre>
<p>Тут показан пример как сделать наипростейший шаблонизатор. И вот когда что-то такое я написал для себя, мне стало как-то проще. Еще я до кучи почитал исходники Flask и теперь готов написать что-то в продакшн. Как вариант, для начала начну с административной панели GeekJob.ru — тем более архитектура SOA, так что могу смело добавлять сервисы в текущий проект без боли.</p>
<h4>Запуск в production</h4>
<p>Если хочется запустить это в продакшен, то создаем файл конфигурации для gunicorn:</p>
<pre># gunicorn_config.py</pre>
<pre>command = "/Users/mayorov/workspace/pyprojects/myflask/main.py"<br>pythonpath = "/Users/mayorov/workspace/pyprojects/myflask/.venv/bin/python"<br>bind = '127.0.0.1:8000'<br>workers = 17 # количество ядер * 2 + 1<br>worker_class = 'sync'<br>worker_connections = 1000<br>timeout = 30<br>keepalive = 2<br>user = "www"<br># raw_env = "тут переменные окружения"</pre>
<p>Создаем скрипт запуска bin/start_gunicorn.sh:</p>
<pre><strong>#!/usr/bin/env bash<br><br>source</strong>  /Users/mayorov/workspace/pyprojects/myflask/.venv/bin/activate<br>exec gunicorn -c "/Users/mayorov/workspace/pyprojects/myflask/gunicorn_config.py" main:app</pre>
<p>Ну и теперь запускаем наш проект через:</p>
<pre>/Users/mayorov/workspace/pyprojects/myflask/bin/start_gunicorn.sh</pre>
<p>Ну вот примерно как-то так работает Flask. Конечно его возможности сильно богаче, я только показал утрированный пример. В качестве шаблонизатора надо бы прикрутить Jinja2. Реализовать логику блюпринтов… Ну и много чего еще сделать, на самом деле. Но у меня нет сил и желания все разжевывать досконально. Для обучения в самый раз. Если было полезно — ставьте лайк.</p>
<h4>Итого</h4>
<p>Мне понравился Python как язык, особенно возможность перегрузки операторов. Много математических функций из коробки, ну и сам язык имеет свои приятные черты. Далее по плану чисто ради фана пройти где-нибудь собеседование, понять на что я тяну ?</p>
<!--kg-card-end: html-->


---
title: "Share sessions between Node.js and PHP services"
date: "2019-02-27T12:16:28.000Z"
description: "PHP session handler compatible with Node express-session  Compatible PHP session handler  В современном мире никого не удивить с"
---

<h4>PHP s<em>ession handler compatible with Node express-session</em><br />
</h4>

<p>В современном мире никого не удивить сервис ориентированной архитектурой. Можно сказать что сейчас это уже не менйстрим, а формат разработки. Это не модно, это реально удобно, когда монолит разбит на разные составляющие и каждая задача решается тем инструментом, который лучше для этого подходит. И это справедливо уже не только для энтерпрайза, но и пет проджекты могут состоять из готовых докер контейнеров, реализующих небольшие сервисы.</p>
<p>Например, Node.js отлично справляется с I/O и отлично решает паттерн BFF (Backend for Frontend). Об этом подробнее говорили в недавнем выпуске RadioJS:</p>
<p><iframe title="Выпуск 55: Node.js на бэкенде - настоящий бэкенд? by RadioJSPodcast" width="580" height="400" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?visual=true&#038;url=https%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F569384229&#038;show_artwork=true&#038;maxwidth=580&#038;maxheight=870&#038;dnt=1"></iframe></p>
<p>Но есть вещи, которые лучше (удобнее/быстрее) писать на других языках. Сейчас я переписываю наш проект <a href="https://geekjob.ru/" target="_blank" rel="noopener noreferrer">GeekJOB.ru</a> и у меня в одной из частей проекта есть воркфлоу, где фронтенд отдается через Node.js, при этом нода хранит сесси в Redis (мне кажется один из приемлемых способов для распределенного хранения сессий). Есть части сервиса, реализованные на PHP (в основном это различный процессинг загружаемых файлов, конвертации, сборка-разборка, вычленение текстов, передача данных на NLP обработку в NER модуль на Python, извлечение смыслов, обработка, etc…).</p>
<p>И вот встал вопрос шеринга сессий. Сессии в PHP и в Node.js формируются по разному и это вообще интересная тема. Сначала я поискал готовые модули, но я не нашел ничего адекватного(по моим меркам) что я мог бы взять в продакшен. Скажем так, во всех них был <a href="http://lurkmore.to/%D0%A4%D0%B0%D1%82%D0%B0%D0%BB%D1%8C%D0%BD%D1%8B%D0%B9_%D0%BD%D0%B5%D0%B4%D0%BE%D1%81%D1%82%D0%B0%D1%82%D0%BE%D0%BA" target="_blank" rel="noopener noreferrer">фатальный недостаток</a>.</p>
<p>Одно из решений, что предлагают разные разработчики: просто брать на стороне PHP айдишник Node.js сессии и модулем Redis ходить в базу и получать данные. Это даже не про работу сессий, это чисто про прочитать данные по ID из базы. Изи? Вери изи. Но, это не механизм сессий, работает только в одностороннем порядке (имеется в виду не запись в базу, а генерация сессии на стороне PHP с последующим принятием ее в Node.js).</p>
<p>Смотрел в сторону готовых решений, но как выяснилось, они требуют допиливания. Кто как смог решить свою задачу — так и сделал. Некоторые библиотеки отпугнули своими реализациями.</p>
<p>Я же захотел разобраться как устроены эти сессии и привести их к единому формату, в итоге у меня получился <a href="https://packagist.org/packages/geekjob/expressjs-php-session-handler" target="_blank" rel="noopener noreferrer">PHP Session Handler</a>, который регистрируется в PHP, после чего он умеет работать с Node.js express-session сессиями без каких-то костылей. Все очень прозрачно.</p>
<p>Причем PHP умеет не просто работать с готовой сессией от Node.js, но и генерить и выставлять правильную сессию, которую примет Node.js. И это очень важный шаг, потому, что если сессия будет неправильной, вы можете уронить Node.js приложение, так как express-session считает что данные нельзя испортить.</p>
<p>О чем я говорю, давайте поясню. Express кладет в базу сессию с блоком cookie:</p>
<pre>Key: <strong>session:4-70cG5MqBHH49KRKu6Ae_OqcK9LtKMd<br></strong>TTL: <strong>1552991427<br></strong>Type: <strong>String<br></strong>{<br>   "<strong>cookie</strong>": {<br>     "originalMaxAge": 1553369596120,<br>     "expires": "2068-05-14T08:56:47.279Z",<br>     "httpOnly": true,<br>     "domain": ".geekjob.ru",<br>     "path": "/"<br>   },<br><em>{ ... session data objects }</em>,<br>}</pre>
<p>Если этого блока или какого-то поля в объекте не будет, то все (матьевосукабля) приложение на Node.js упадет! И пока будет такая битая сессия в базе и на клиенте, приложение будет рестартовать в бесконечном цикле. Таким образом можно вывести из строя целую ноду (мы же деплоим на продакшен не 1 экземпляр сервиса).</p>
<p>А в логах вы увидите:</p>
<pre>node_modules/express-session/session/store.js:87<br>var expires = sess.cookie.expires<br>                         ^<br><em>TypeError: Cannot read property 'expires' of undefined at RedisStore.Store.createSession (node_modules/express-session/session/store.js:87:29) at node_modules/express-session/index.js:478:15</em></pre>
<p>Это жесть. Для своего приложения я сделал фикс и заодно запулил PR:</p>
<p><a href="https://github.com/expressjs/session/pull/634">https://github.com/expressjs/session/pull/634</a></p>
<p>Но не факт что примут. Поэтому в экосистеме Node.js крайне рекомендуется держать свой приватный NPM со своими форками, но это уже другая история.</p>
<h3>Express-session</h3>
<p>И так, что из себя представляет сессия из модуля express-session. Выглядит Session ID так:</p>
<pre>s%3AFPzoe-5J7jiYa_KjcqOIujWKSE1aGyit.4YtSPd765T1Z7zATngt6D84%2BsjUOKEsM5BIim51f2k4</pre>
<p>Что это?</p>
<p>Сессия состоит из префикса, идентификатора и подписи.</p>
<pre>s<strong>:</strong>session_id<strong>.</strong>signature</pre>
<p>Префикс простой “s:” тут ни отнять, ни добавить. Есть и есть, всегда один и тот же.</p>
<h4>Подпись</h4>
<p>Подпись гарантирует что нам пришла валидная сессия и ее никто не подделал по дороге к серверу. При настройке сессий есть поле secret key, которое как раз из себя представляет соль, добавляемую при хешировании:</p>
<pre><strong>const</strong> app = express()<br><br>app.use(session({<br>  secret: 'some secret salt',<br>}))</pre>
<p>В модуле express-session можно найти формирование куки:</p>
<pre><strong>function</strong> setcookie(res, name, val, secret, options) {<br><strong>var</strong> signed = 's:' + signature.sign(val, secret);</pre>
<p>В свою очередь модуль использует модуль cookie-signature:</p>
<pre><strong>var</strong> <strong>signature</strong> = <strong>require</strong>('cookie-signature')</pre>
<p>В котором находим код подписи:</p>
<pre>exports.sign = <strong>function</strong>(val, secret){<br><strong>return</strong> val + '.' +<br><strong>crypto</strong><br>          .<strong>createHmac</strong>('sha256',secret)<br>          .<strong>update</strong>(val)<br>          .<strong>digest</strong>('base64')<br>          .<strong>replace</strong>(/<strong>=</strong>+$/, '')<br>};</pre>
<p>Отлично. Значит, чтобы разобрать эту куку в PHP, нам достаточно выцепить Session ID, и даже можем не реализовывать проверку подписи. Но если хочется прям все по красоте, то реализуем и проверку на подделку.</p>
<h4>PHP Session Handler</h4>
<p>Раньше для регистрации обработчиков сессий приходилось писать отдельные функции. Но сейчас есть интерфейс и даже класс, от которого можно унаследоваться:</p>
<pre><strong>class</strong> ExpressjsSessionHandler <strong>extends</strong> SessionHandler {</pre>
<p>В нем мы реализуем только необходимые методы, все остальное будет работать по дефолту.</p>
<h4>PHP генерация Session ID like as Node.js Express</h4>
<pre> <strong>public</strong> <strong>function</strong> create_sid(): <strong>string</strong> {<br>  $sid = parent::create_sid();<br>  $hmac =<br>   str_replace('=', '',<br>    base64_encode(<br>     hash_hmac('sha256', $sid, $this-&gt;secret, true)<br>    )<br>   )<br>  ;<br><strong>return</strong> "s:$sid.$hmac";<br> }</pre>
<p>По сути это все тот же код генерации сессии как на Node.js, только на PHP, да. Полный код можно найти в репозитории:</p>
<p><a href="https://github.com/expressjs/session/pull/634">https://github.com/expressjs/session/pull/634</a></p>
<p>Для работы с Redis использую модуль из PECL, который из коробки умеет работать с сессиями. Ставится очень просто:</p>
<pre><strong>pecl</strong> install redis</pre>
<p>В Docker на базе официальной репы php:fpm ставится так же просто:</p>
<pre><strong>FROM</strong> php:fpm<br>...<br><strong>RUN</strong> pecl install redis &amp;&amp; docker-php-ext-enable redis</pre>
<h3>Как пользоваться</h3>
<p>Настраиваем Node.js приложение:</p>
<pre><strong>app</strong>.use(session({<br>  name: 'sid',<br>  secret: 'secret key',<br>  cookie: {<br>    // Share cookie through sub domains<br>    // if you use many domains for service architecture<br>    domain : '.your.domain',<br>    maxAge : <strong>Date</strong>.now() + 60000<br>  },<br>  store: <strong>new</strong> RedisStore({<br>    host  : 'redis',<br>    port  : 6379,<br>    client: redis,<br>    prefix: 'session:',<br>  })<br>}));</pre>
<h4>Настраиваем PHP сервис</h4>
<p>Ставим модуль через composer:</p>
<pre><strong>composer</strong> require geekjob/expressjs-session-handler</pre>
<p>Настраиваем модуль в рантайме:</p>
<pre><strong>require_once</strong> 'vendor/autoload.php';</pre>
<pre><strong>GeekJOBExpressjsSessionHandler</strong>::register([<br>  'name'   =&gt; 'sid',<br>  'secret' =&gt; 'secret key',<br>  'cookie' =&gt; [<br>    // Share cookie through sub domains<br>    'domain'  =&gt; '.your.domain',<br>    'path'    =&gt; '/',<br>       'maxage'  =&gt; <strong>strtotime</strong>('+1hour'), // Set maxage<br>     ],<br>    'store' =&gt; [<br>       'handler' =&gt; 'redis',<br>          'path'    =&gt; 'tcp://127.0.0.1:6379',<br>	  'prefix'  =&gt; 'session:',<br>    ],<br>   // Set to true if signature verification is needed.<br>   'secure' =&gt; false <br>]);</pre>
<p>У меня управляемая проверка подписи. Если хотите верифицировать подпись — то выставьте флаг <em>secure=true</em>. Тогда каждая сессионная кука будет проверяться на валидность и регенерироваться, если будет подделана.</p>
<p>Для продакшена рекомендую сконфигурировать часть через php.ini (с учетом что это сервис и он поставляется в Docker, то это логично). В частности мы конфигурируем Redis и немного сессионных параметров:</p>
<pre><strong>session.session_name</strong> = sid<br><strong>session.save_handler</strong> = redis<br><strong>session.save_path</strong> = "tcp://127.0.0.1/?prefix=session:"<br><strong>session.serialize_handler</strong> = php_serialize</pre>
<pre>; After this number of seconds, stored data will be seen as 'garbage' and<br>; cleaned up by the garbage collection process.<br>; <a href="http://php.net/session.gc-maxlifetime" target="_blank" rel="noopener noreferrer">http://php.net/session.gc-maxlifetime</a><br>; default: session.gc_maxlifetime = 1440 <br>; Redis Sessions use this value for setting TTL<br><strong>session.gc_maxlifetime</strong> = maxage - time()</pre>
<pre>; Lifetime in seconds of cookie or, if 0, until browser is restarted.<br>; <a href="http://php.net/session.cookie-lifetime" target="_blank" rel="noopener noreferrer">http://php.net/session.cookie-lifetime</a><br><strong>session.cookie_lifetime</strong> = maxage - time()</pre>
<p>Тогда в самом PHP достаточно будет написать:</p>
<pre><strong>require_once</strong> 'vendor/autoload.php';</pre>
<pre><strong>GeekJOBExpressjsSessionHandler</strong>::register([<br>    'secret' =&gt; 'secret key',<br>    'cookie' =&gt; [<br>       'domain'  =&gt; '.your.domain',<br>       'path'    =&gt; '/',<br>    ],<br>    'secure' =&gt; false<br>]);</pre>
<p>Ну а с учетом того, что это микросервис, можно эту логику и вовсе вынести в auto_prepend файл.</p>
<h3>PS</h3>
<p>Если где-то есть ошибки — пришлите PR, пожалуйста.</p>
<p>Ссылка на <a href="https://packagist.org/packages/geekjob/expressjs-php-session-handler" target="_blank" rel="noopener noreferrer">packagist.org</a>:</p>
<p><a href="https://github.com/expressjs/session/pull/634">https://github.com/expressjs/session/pull/634</a></p>



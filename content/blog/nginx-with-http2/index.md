---
title: "Поднять Nginx с HTTP2"
date: "2016-08-16T14:31:40.00Z"
description: "Попутно решаем проблемы с OpenSSL Решил перевести один свой проект на HTTPS. Но хотелось не только HTTP, но еще и HTTP2 в придач"
---

<!--kg-card-begin: html--><h4>Попутно решаем проблемы с OpenSSL</h4>
<p>Решил перевести один свой проект на HTTPS. Но хотелось не только HTTP, но еще и HTTP2 в придачу. В итоге, как всегда это водится в Linux мире, столкнулся с проблемами. Проблемы благополучно решил, но хочется записать для себя и поделиться с вами этими решениями. И так, поехали…</p>
<h4>Зачем переводить на HTTPS</h4>
<p>Собственно вопрос, а зачем вообще может понадобиться этот HTTPS или даже HTTP2? Ну кроме того, что это новый модный протокол, а модный проект (aka startup) обязан работать на модных технологиях. На самом деле для бизнеса есть польза от HTTPS.</p>
<h4>Зачем HTTPS?</h4>
<p><strong>Повышаем конверсию</strong></p>
<p>Мы живем во времена продвинутого поколения, знакомого с гаджетами и понимающими, хотя бы на базовом уровне, принципы работы интернета. И это поколение знает, что данные кредитной карты или пароли лучше вводить на сайте с зелененьким “значочком” в адресной строке и с префиксом <strong>HTTPS. </strong>И я серьезен сейчас. Я уже видел отзывы реальных клиентов, которые говорили что не стали вводить данные своей карты и ушли на другой сайт только потому, что страница с вводом таких данных не была защищена.</p>
<p><strong>SEO. Повышаем посещаемость</strong></p>
<p>Но это мелочи. Копаем глубже — SEO. Мало того, что Google и Яндекс индексируют сайты под HTTPS охотнее, так Google еще и поднимает их в выдаче. Т.е. это легкий способ поднять свои позиции в серпе (выдаче) поисковика.</p>
<p><strong>Аналитика</strong></p>
<p>Но и это еще не все. Вы ведете активные рекламные кампании, да и просто следите за переходами в том же Google analitics. И проблема заключается в том, что сами поисковики находятся под HTTPS, а вот ваш сайт — нет! И это значит что? Правильно! Это значит то, что п<strong>ри переходе с HTTPS на HTTP теряется Referer</strong>. А это ведет к ухудшению аналитики. Откуда и почему приходят люди — загадка, покрытая правилами секурности.</p>
<p>Это несколько пунктов, ради которых стоит перевести ваш сайт с HTTP на HTTPS.</p>
<h4>Почему HTTP/2?</h4>
<p>Добрались и до нового модного протокола. Ну ок, получили сертификат, подняли Nginx, открыли 443 порт, настроили хост с прописанными сертификатами… А новый протокол-то зачем? И без него жить можно.</p>
<p>Да, можно, но за SSL надо платить. Секурность безопасность дается не просто так иначе бы давно все сайты были сразу под HTTPS. <br />В HTTP/2 используется только одно мультиплексирующее соединение до хоста, вместо множества соединений передающих по одному файлу. И производится всего один handshake вместо множества, как у HTTPS/1.1 . Таким образом мы снижаем нагрузку на сервер и количество передаваемого трафика.</p>
<p>Ну и да, протокол 2й версии обещает повышение скорости загрузки ресурсов, но об этом мы поговорим в отдельной статье.</p>
<h4>Получаем SSL сертификат</h4>
<p>Как получить — решать вам. Можете купить, можете получить бесплатно, к примеру, на <a href="https://letsencrypt.org/" target="_blank" rel="noopener noreferrer">https://letsencrypt.org</a> или <a href="https://www.startssl.com/" target="_blank" rel="noopener noreferrer">https://www.startssl.com</a></p>
<h4>Настраиваем Nginx</h4>
<p>Вся суть настройки Nginx сводится к следующему:</p>
<ul>
<li>Он должен быть правильно собран</li>
<li>Нужно прописать сертфикаты в host</li>
</ul>
<p>Nginx правильно собран для работы с HTTP/2 если он конфигурировался со следующими опциями:</p>
<pre> ./configure --with-http_ssl_module <br>             --with-http_v2_module</pre>
<p>Минимальная конфигурация хоста для запуска HTTS с поддержкой HTTP/2:</p>
<pre>server {<br><strong>listen      443 ssl http2;</strong><br>    server_name new.hr;<br><br><strong>    ssl                 on;</strong><br>    include             ssl_base.conf;<br><strong>    ssl_certificate     /etc/nginx/ssl/new.hr/1_new.hr_bundle.crt;<br>    ssl_certificate_key /etc/nginx/ssl/ssl.key;<br><br></strong>    set $sname new.hr;<br>    set $subdomain "www";<br>    set $root "/www/sites/$sname/$subdomain/public";<br><br>    root $root;<br>    index index.html index.htm;<br>}</pre>
<p>SSL в данном случае перед HTTP ставится для обратной совместимости с браузерами, которые не поддерживают новый протокол.</p>
<p>После чего говорим серверу перечитать конфиги или перезапускаем сервер удобным вам способом</p>
<pre>killall -HUP nginx<br># or<br>/etc/init.d/nginx reload<br># or<br>/etc/init.d/nginx restart<br># or <br>service nginx restart</pre>
<p>В общем это на ваше усмотрение.</p>
<h4>Проверяем работу</h4>
<p>Если все собралось, то вы сможете постучаться по вашему адресу (в моем случае это <a href="https://new.hr%29" target="_blank" rel="noopener noreferrer">https://new.hr)</a> и увидеть ваш сайт. Но я не увидел. Причем сервер не ругался на конфигурацию. Проверка конфигов говорила что все ок. Кстати, проверить работу конфига можно командой</p>
<pre>nginx -t</pre>
<p>Лучше взять за правило перезапускать сервер только после проверки конфига:</p>
<pre>nginx -t &amp;&amp; /etc/init.d/nginx restart</pre>
<p>Сначала думал что с сертификатми что-то не так. Но оказалось что проблема в другом.</p>
<h4>Дебажим Nginx</h4>
<p>В любой непонятной ситуации надо дебажить. Включить в Nginx дебаг лог просто, главное чтобы сервер был собран с флагом:</p>
<pre>--with-debug</pre>
<p>В глобальный nginx.conf добавляем строчку с логом:</p>
<pre>...</pre>
<pre><strong><em>error_log /var/log/nginx/debug.log debug;</em></strong><em><br><br></em>http {<br>...<br>}</pre>
<p>Перезапускаем сервер и читаем логи</p>
<pre>nginxt -t &amp;&amp; /etc/init.d/nginx restart &amp;&amp; tail -f <em>/var/log/nginx/debug.log</em></pre>
<p>Запрашиваем наш сайт и смотрим в лог, а там видим</p>
<pre>no ssl_certificate is defined in server listening on SSL port while SSL handshaking</pre>
<p>Оказалось что у меня были хосты для тестов с SSL, в которых уже давно истекли сертификаты или вовсе были удалены. После того, как я вычистил все такие хосты все заработало. Вроде бы Ура!</p>
<h4>SSL заработал но без HTTP/2</h4>
<p>Когда я проверил протокол соединения, оказалось что это все еще старый добрый HTTP/1.1</p>
<p>Странно подумал я, снова полез в отладочный лог и оказалось что у меня не происходит переключения на новый протокол. Покопавшись в документации выяснилось что HTTP2 включается только если Nginx собран с OpenSSL версии 1.0.2 и выше.</p>
<blockquote><p>Чтобы принимать HTTP/2-соединения по TLS, необходимо наличие поддержки расширения “Application-Layer Protocol Negotiation” (ALPN) протокола TLS, появившейся лишь в <a href="http://www.openssl.org/" target="_blank" rel="noopener noreferrer">OpenSSL</a> версии 1.0.2. Работа расширения “Next Protocol Negotiation” (NPN) протокола TLS (поддерживаемого начиная с OpenSSL версии 1.0.1) в данном случае не гарантируется.</p></blockquote>
<p>Проверив свою версию в системе</p>
<pre>openssl version</pre>
<p>У меня оказалась она, естественно, ниже.</p>
<h4>Собираем Nginx с SSL 1.0.2</h4>
<p>Тут все не так уж сложно. Качаем, распаковываем и пересобираем:</p>
<pre>wget <a href="https://www.openssl.org/source/openssl-1.0.2g.tar.gz" target="_blank" rel="noopener noreferrer">https://www.openssl.org/source/openssl-1.0.2g.tar.gz</a><br>tar -zxf openssl-1.0.2g.tar.gz<br>cd nginx<br>./configure --with-http_ssl_module <br>            --with-openssl=`realpath ../openssl-1.0.2g` <br>            --with-http_v2_module <br>            #другие ваши настройки </pre>
<p>Перезапускаем сервер и вуаля. Для контроля можно воспользоваться сервисом</p>
<ul>
<li><a href="https://www.ssllabs.com/ssltest/analyze.html?d=new.hr" target="_blank" rel="noopener noreferrer">https://www.ssllabs.com/ssltest/analyze.html?d=new.hr</a></li>
<li><a href="https://www.sslshopper.com/ssl-checker.html?#hostname=new.hr" target="_blank" rel="noopener noreferrer">https://www.sslshopper.com/ssl-checker.html?#hostname=new.hr</a></li>
</ul>
<p>и насладиться результатом анализа</p>
<figure>
<p><img data-width="1992" data-height="978" src="https://cdn-images-1.medium.com/max/800/1*SHzXvXZ-hLWD-XMUMXuqbg.png"><br />
</figure>
<!--kg-card-end: html-->


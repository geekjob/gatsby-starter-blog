---
title: "Chrome Headless"
date: "2017-11-01T21:19:28.00Z"
description: "Запускаем на удаленном сервере с режимом отладки В этой статье будет речь о том как подключиться к безбашенному хрому на удаленн"
---

<!--kg-card-begin: html--><h4>Запускаем на удаленном сервере с режимом отладки</h4>
<p>В этой статье будет речь о том как подключиться к безбашенному хрому на удаленном сервере с помощью DevTools.</p>

<p>Чтобы запустить хедлес хром с возможностью подключиться отладчиком достаточно написать строку:</p>
<pre><strong>google-chrome</strong><em> </em>--headless --disable-gpu <br>    --remote-debugging-port=9222 <br>    https://нужныйвамсайт</pre>
<p>Что значат параметры не трудно догадаться. Не буду перепечатывать документацию и посоветую прочесть статью от девшахты за авторством <a href="https://medium.com/u/d36721421183" target="_blank" rel="noopener noreferrer">Roman Ponomarev</a>:</p>
<p><a href="https://medium.com/@frontman/chrome-headless-%D1%81%D1%82%D0%B0%D0%B2%D0%B8%D0%BC-%D0%BD%D0%B0-centos-24011c71d4bd">https://medium.com/@frontman/24011c71d4bd</a></p>
<p>Когда запустите, вам дадут ссылку вида:</p>
<pre>DevTools listening on ws://127.0.0.1:9222/devtools/browser/2dbd53d7-e0b4-4c3d-bfe0-4db0221b877a</pre>
<p>И тут встает вопрос. Как узнать что происходит с браузером? Чем подключиться и как? Для чего эта ссылка?</p>
<p>Можно ручками открыть страницу:</p>
<pre><a href="https://chrome-devtools-frontend.appspot.com/serve_file/@67b212ffb03c4401235f8961e2d15371b96cde27/inspector.html?ws=77.244.215.79:9222/devtools/page/c4cd94aa-bb62-4707-861e-cf6fa2394814&amp;remoteFrontend=true" target="_blank" rel="noopener noreferrer">https://chrome-devtools-frontend.appspot.com/serve_file/<strong>@67b...hash...e27</strong>/inspector.html?</a><a href="https://chrome-devtools-frontend.appspot.com/serve_file/@67b212ffb03c4401235f8961e2d15371b96cde27/inspector.html?ws=77.244.215.79:9222/devtools/page/c4cd94aa-bb62-4707-861e-cf6fa2394814&amp;remoteFrontend=true" target="_blank" rel="noopener noreferrer">remoteFrontend=true</a>&amp;<a href="https://chrome-devtools-frontend.appspot.com/serve_file/@67b212ffb03c4401235f8961e2d15371b96cde27/inspector.html?ws=77.244.215.79:9222/devtools/page/c4cd94aa-bb62-4707-861e-cf6fa2394814&amp;remoteFrontend=true" target="_blank" rel="noopener noreferrer">ws=</a></pre>
<p>и вписать эту ссылку в параметр ws. Получится как-то так:</p>
<pre><a href="https://chrome-devtools-frontend.appspot.com/serve_file/@67b212ffb03c4401235f8961e2d15371b96cde27/inspector.html?ws=77.244.215.79:9222/devtools/page/c4cd94aa-bb62-4707-861e-cf6fa2394814&amp;remoteFrontend=true" target="_blank" rel="noopener noreferrer">https://chrome-devtools-frontend.appspot.com/serve_file/<strong>@67...hash...27</strong>/inspector.html?</a><a href="https://chrome-devtools-frontend.appspot.com/serve_file/@67b212ffb03c4401235f8961e2d15371b96cde27/inspector.html?ws=77.244.215.79:9222/devtools/page/c4cd94aa-bb62-4707-861e-cf6fa2394814&amp;remoteFrontend=true" target="_blank" rel="noopener noreferrer">remoteFrontend=true</a>&amp;<a href="https://chrome-devtools-frontend.appspot.com/serve_file/@67b212ffb03c4401235f8961e2d15371b96cde27/inspector.html?ws=77.244.215.79:9222/devtools/page/c4cd94aa-bb62-4707-861e-cf6fa2394814&amp;remoteFrontend=true" target="_blank" rel="noopener noreferrer">ws=</a><strong>127.0.0.1:9222/devtools/browser/2dbd53d7-e0b4-4c3d-bfe0-4db0221b877a</strong></pre>
<p>Но что за hash? Откуда его взять? Его генерит браузер, так что в ручную лучше не подставлять, не зная деталей. Разбираемся дальше. Если постучимся к нашему серверу через порт 9222 ничего не произойдет. Да и адрес нашего хрома не 127.0.0.1. Как с этим быть?</p>
<h3>Доступ по IP</h3>
<p>Вы стучитесь по IP через браузер к своему серверу и вводите номер порта:</p>
<pre>http://yourserver:9222</pre>
<p>И получаете режект. Если пойдете на StackOverflow — найдете там рекомендацию запустить локально SSH тунель:</p>
<pre><em>ssh </em>-L 0.0.0.0:9222:localhost:9222 username@localhost -N<br># или<br><em>ssh </em>-L 9222:localhost:9222 username@localhost -N<br># или<br><em>ssh </em>-L [ваш ip]:9223:localhost:9222 username@localhost -N</pre>
<p>Для отладки ставьте флаг -v, если возникли трудности. Все эти команды надо вводить на сервере.</p>
<p>И это будет “работать”. Но зачем так делать? Ведь у хрома есть специальная опция:</p>
<pre><strong>--remote-debugging-address</strong></pre>
<p>Достаточно указать там IP вашего сервера и никакой туннель не нужен выходит. И так, строка для запуска на сервере должна выглядеть так:</p>
<pre><strong>google-chrome</strong><em> </em>--headless --disable-gpu <br><strong>    --remote-debugging-port=9222 <br>    --remote-debugging-address=[your ip adres] <br></strong>    https://vacancy.new.hr</pre>
<p>Теперь вы можете обратиться по 9222 порту к вашему серверу через браузер и получите ссылку на DevTools для отладки вашего хрома на вашем удаленном сервере.</p>
<p>И вроде бы работает, НО! Но вы видите пустую DevTools. А должны видеть отладчик с загруженной страницей. Я пока не понял почему при таком методе не получается нормально подключиться к браузеру на сервере и пришел к решению через туннелирование, но только теперь я туннелирую порт с локальной машины на свой удаленный сервер:</p>
<pre><strong>ssh</strong><em> </em>-L 9222:localhost:9222 username@[your ip] -N</pre>
<p>Эту строку запускать уже на своей машине, а не на сервере. И вот теперь вы можете делать отладку. И первое что я увидел — это проблемы с русскими шрифтами:</p>
<figure>
<p><img data-width="2880" data-height="1488" src="https://cdn-images-1.medium.com/max/800/1*2MnierK1X1eZ6Uj2vJNTCA.png"><br />
</figure>
<p>Так что отладка очень даже нужна, чтобы понять, что же происходит с безголовым хромом на сервере. Далее надо разобраться с шрифтами, но это уже другая история…</p>
<p><strong>UPD</strong></p>
<p>Для пользователей vscale.io порты нужно открывать ручками:</p>
<pre><strong>firewall-cmd</strong> --zone=public --permanent --add-port=9222/tcp<br><strong>firewall-cmd</strong> --reload</pre>
<p>Кстати, если кто-то ответит в комментариях как без туннелирования запустить отладчик — буду рад услышать. Пишите, делитесь комментариями. Заранее спасибо!</p>
<!--kg-card-end: html-->


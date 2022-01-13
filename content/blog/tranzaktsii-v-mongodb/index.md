---
title: "Транзакции в MongoDB"
date: "2020-05-24T22:09:30.000Z"
description: "Особенности работы на примере PHP В MongoDB еще в версии 4.2 добавили честные ACID транзакции [https://ru.wikipedia.org/wiki/ACI"
---

<h2 id="-php">Особенности работы на примере PHP</h2><p>В MongoDB еще в версии 4.2 добавили честные <a href="https://ru.wikipedia.org/wiki/ACID">ACID транзакции</a>. MongoDB - это уже не просто key-value хранилище наподобие Redis (как некоторые используют), а все же более серьезная база данных.</p><p>Многие разработчики до сих пор скептически относятся к NoSQL базам в качестве основной базы. Если рассматривать монгу, то да, сехмы все еще приходится контролировать на стороне клиента и описывать в приложении через разные  ORM, Data Mappers и Active Records библиотеки.</p><p>У нас на проекте MongoDB используется как основная база данных и пока с ней не было проблем. Я уже привык к агрегатам вместо сложных SQL запросов, а так же привык описывать схемы в коде и контролировать целостность базы через приложение.</p><p>Одно из интересных преимуществ монги для стартапа - не нужно заморачиваться с миграциями. Только миграции на инициализацию индексов. Вы выкатываете код и новый код уже работает с новой схемой. Правда в коде нужно дополнительно создавать проверки на наличие того или иного поля. Но может это и не так уж и плохо.</p><p>Возвращаясь к транзакциям...</p><p>В PHP на данный момент офицальный драйвер - это <a href="https://www.php.net/manual/ru/set.mongodb.php">MongoDB Driver</a>. Не всегда очевидно как с ним работать, поэтому для своих проектов написал обертку для более удобного манипулирования.</p><p>Когда вы почитаете документацию и начнете работать с транзакциями, вдруг выяснится что они не работают, но при этом никаких ошибок не выдается... Первая ошибка, которая встречается - это то, что транзакционную сессию нужно передавать во все запросы, которые должны попасть в транзакцию:</p><pre><code class="language-php">&lt;?php declare(strict_types=1);

// ...

try
{
	$session = $client-&gt;startSession();
	$session-&gt;startTransaction();

	$db-&gt;vacancies-&gt;delete(
		['_creator' =&gt; $user_id,
		['session' =&gt; $session]
	);
	$db-&gt;users-&gt;deleteOne(
		['_id' =&gt; $user_id,
		['session' =&gt; $session]
	);

	$session-&gt;commitTransaction();
}
catch(Exception $e)
{
	$session-&gt;abortTransaction();
}

// ...</code></pre><p>Но когда вы напишите правильно запросы, может оказаться что ваша база данных не поддерживает транзакции, если база запущена в single mode, по сути по дефолту, не в режиме replica set и будет выдавать что-то типа:</p><blockquote>transactions are available for replica sets only</blockquote><p>Если вы используете Docker с официального репозитория, то инициализировать MongoDB в докер контейнере через docker-compose можно следующим образом:</p><pre><code class="language-bash">version : '3'
services:

#
# MongoDB
#
    mongo:
        image: mongo:4.2.3-bionic
        hostname: mongo
        container_name: mongo
        command: --auth --replSet rs0
        restart: always
        environment:
            TZ: "Europe/Moscow"
            MONGO_INITDB_ROOT_USERNAME: "${MONGO_USER}"
            MONGO_INITDB_ROOT_PASSWORD: "${MONGO_PASS}"
        ports:
            - 127.0.0.1:27017:27017

#EOF#</code></pre><p>Собственно через команду</p><p>command: --replSet rs0</p><p>по сути мы устанавливаем имя нашего сервера rs0.</p><p>После этого запускаем контейнер:</p><pre><code class="language-bash">docker-compose up -d</code></pre><p>Проверить настройки сервера можно командой:</p><pre><code class="language-javascript">// in mongo shell:

db.runCommand({getCmdLineOpts:1});</code></pre><p>Затем нужно всего один раз зайти в базу (можно через консоль, можно через GUI - как вы привыкли) и выполнить команду:</p><pre><code class="language-javascript">// in mongo shell

rs.initiate()</code></pre><p>Вам должна показаться статистика, где будет показана конфигурация. В итоге вы получили кластер из одного сервера MongoDB.</p><pre><code class="language-javascript">{
 "info2" : "no configuration specified. Using a default configuration for the set",
 "me" : "mongo:27017",
 "ok" : 1
}</code></pre><p>Теперь можно проверить, что всё работает прямо в базе через запросы или в нашем PHP коде.</p><p>По идее после этого все должно заработать и у вас появится возможность использовать транзакции. Я так же рекомендую заглянуть в <a href="https://docs.mongodb.com/master/core/transactions/">документацию</a> и прочитать об ограничениях и возможностях транзакций.</p><h2 id="cannot-create-namespace-in-multi-document-transaction">Cannot create namespace in multi-document transaction</h2><p>MongoDB славен тем, как я уже упоминал, что вы можете не создавать заранее коллекцию (таблицу в терминах реляционных СУБД), и она автоматически создастся при первой вставке.</p><p>НО! Если вы используете транзакции с несуществующими коллекциями, то вы получите сообщение об ошибке. В документации есть про это следующее:</p><blockquote>Operations that affect the database catalog, such as creating or dropping a collection or an index, are not allowed in multi-document transactions. For example, a multi-document transaction <strong>cannot include an insert operation that would result in the creation of a new collection.</strong> See Restricted Operations.</blockquote><p>Вам нужно заранее создать коллекцию.</p><pre><code class="language-javascript">db.createCollection('collection_name');</code></pre>


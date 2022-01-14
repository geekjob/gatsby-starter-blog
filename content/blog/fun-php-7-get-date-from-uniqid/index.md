---
title: "FunPHP#7: ID'шники в которых зашита дата"
date: "2022-01-14T10:33:29.00Z"
description: "Экономим на данных - 1 стобец с уникальным айди, в котором хранится дата"
---

Те кто работает с MongoDB знают что там в качестве уникального автоинкремента используется поле _id,
которое обязательно для всех по дефолту и оно отличается от числовых автоинкрементов, как в других SQL базах.

Не все знают, что мало того, что по таким полям можно сортировать, но в самом этом ID зашита дата (которая по сути является датой создания этого ID - тобиш записи).


```js
function generateObjectId(date) {
    return Math.floor((new Date(date)).getTime()/1e3).toString(16) +
              (('x'.repeat(16).replace(/x/g,
                  _=>(Math.random()*16|0).toString(16))
              ))
}

let date = new Date('2022/01/13 22:22:22')
let id = generateObjectId(date)


console.log(id) // 61e07beea8d49039c3de64b6

```

Чтобы вернуть все это обратно в дату можно использовать такую функцию:

```js
function objectIdToDateTime(objectId) {
  return new Date(parseInt(objectId.substring(0,8),16)*1e3)
}

objectIdToDateTime('5e1b270142dcae0010186f02')
// Sun Jan 12 2020 17:02:41 GMT+0300

// В самой монге есть возможность получить время от ObjectId:
ObjectId("5e1b270142dcae0010186f02").getTimestamp()
// ISODate("2020-01-12T17:02:41.000+03:00")
```

Подробнее про это я писал в этой статье: https://geekjob.tech/fun-mongo-1-objectid/


Так к чему все это я и причем тут PHP?

В PHP есть функция `uniqid`:

```php
uniqid(string $prefix = "", bool $more_entropy = false): string
```

Получает уникальный идентификатор с префиксом, основанный на текущем времени в микросекундах.

Если бы нас попросили написать похожую функцию снуля, мы могли бы написать ее так, например:

```php
<?php

var_dump(uniqid());
var_dump(uniq_d());

// string(13) "61e12c4400e9d"
// string(13) "61e12c44eb02c"


function uniq_d(): string
{
    ['sec'=>$sec, 'usec'=>$usec] = gettimeofday();
    return sprintf('%x%x%x', $sec, $usec, date('s'));
}
```


Результат почти совпадает.

Ну и собственно теперь к теме, как получить дату из такого ID:

```php

$d1 = uniqid();
$d2 = uniq_d();

var_dump($d1); // string(13) "61e12dbe01013"
var_dump($d2); // string(13) "61e12dbe101a2"

$d = date('r',uiqid2date($d1));
var_dump($d); // string(31) "Fri, 14 Jan 2022 09:01:02 +0100"

$d = date('r',uiqid2date($d2));
var_dump($d); // string(31) "Fri, 14 Jan 2022 09:01:02 +0100"


function uiqid2date(string $uniqid): int
{
    return hexdec(substr($uniqid,0,8));
}
```

Таким образом можно хранить 1 поле в базе вместо 2х, сохраняя дату создлания в самом ID.

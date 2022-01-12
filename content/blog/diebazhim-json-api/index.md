---
title: "Дебажим JSON API"
date: "2021-08-14T12:12:12.00Z"
description: "Делаем Быстрый дамп в DevTools"
---

## Быстрый дамп в DevTools

Это пост из серии лайфхаков. Не знал, но вспомнил. Если вам нужно посмотреть вывод данных, отдаваемых каким-то JSON API сервисом, то используя fetch и console.table это делается так просто и быстро, как два байта переслать.

В качестве сервера данных для примера будем использовать специальный сервис, который генерит JSON ответ:

```js
const jsonApiUri = "http://www.filltext.com/?rows=32&id={number|1000}&firstName={firstName}&lastName={lastName}&email={email}&phone={phone|(xxx)xxx-xx-xx}&description={lorem|16}"
```

И всего одной строчкой кода мы можем вывести все эти данные в табличном виде:

```js
fetch(jsonApiUri).then(r=>r.json()).then(console.table)
```

На выходе получим такую вот красивую таблицу:


Вы можете определять какие столбцы (поля) объекта вы хотите увидеть. Например, вывод всех ссылок на странице:

```js
console.table(document.querySelectorAll('a'), ['href','text'])
```

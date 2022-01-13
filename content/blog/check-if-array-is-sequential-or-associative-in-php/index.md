---
title: "Check if array is sequential or associative in PHP"
date: "2021-09-07T12:12:12.00Z"
description: "Now we have a simple way in PHP 8.1"
---

Ну наконец-то в PHP 8.1 добавили встроенную функцию, которая освобождает от необходимости различного рода велосипедов, для того, чтобы определить, данный массив ассоциативный или нет. В терминологии других языков правильнее было бы говорить что есть списки и есть массивы.
Теперь есть волшебная функция

```php
array_is_list(array $array): bool
```

которая говорит нам, мы работаем со списком или с массивом.

```php
array_is_list([]); // true
array_is_list(['apple', 2, 3]); // true
array_is_list([0 => 'apple', 'orange']); // true

// Массив начинается не с 0
array_is_list([1 => 'apple', 'orange']); // false

// Ключи массива не по порядку
array_is_list([1 => 'apple', 0 => 'orange']); // false

// Ключи массива не являются целыми числами
array_is_list([0 => 'apple', 'foo' => 'bar']); // false

// Непоследовательные ключи
array_is_list([0 => 'apple', 2 => 'bar']); // false
```

Вжух и все

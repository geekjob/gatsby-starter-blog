---
title: "Convert HEIC Images to JPG on MacOS"
date: "2022-01-13T23:33:29.00Z"
description: "Добавлем меню в Finder"
---

Я частенько делаю фотографии на iPhone, а затем отправляю эти фото на Macbook, где их далее использую в интернете.
И часто сервисы принимают все привычные форматы, кроме HEIC.

Мне надоело каждый раз открывать фото стандартным просмотрщиком и сохранять в новом формате.

Я добавил специальное меню в Finder и расскажу как это сделать.

![geekjob](https://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/blog/Convert-HEIC-Images-to-JPG-MacOS/img1.png)

Для конвертации HEIC в JPG нам нужен Imagemagick. Ставим через homebrew:

```bash
brew install imagemagick
```

Сам процесс конвертации:

```bash
mogrify -format jpg *.heic
```

Далее создаем скрипт через Automator

## Finder Extension через Automator
Открываем Automator и создаем новое приложение. Нам нужен раздел Фйалы и папки.
Выбираем "Получить выбранные объекты Finder"
А далее вставляем блок shell-script

В итоге эти все действия можно уместить на 1м скриншоте:
![geekjob](https://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/blog/Convert-HEIC-Images-to-JPG-MacOS/img2.png)

Теперь у вас появился новый пункт меню в Finder, в разделе "Быстрые действия"

<iframe width="560" height="315" src="https://www.youtube.com/embed/QNzGi-BLz-w" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

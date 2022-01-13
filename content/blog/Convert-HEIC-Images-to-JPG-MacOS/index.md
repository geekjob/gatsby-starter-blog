---
title: "Convert HEIC Images to JPG on MacOS"
date: "2022-01-13T23:33:29.00Z"
description: "Добавлем меню в Finder"
---

### Status: DRAFT


Я частенько делаю фотографии на iPhone, а затем отправляю эти фото на Macbook, где их далее использую в интернете.
И часто сервисы принимают все привычные форматы, кроме HEIC.

Мне надоело каждый раз открывать фото стандартным просмотрщиком и созранять в новом формате.

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
...
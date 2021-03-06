---
title: "ImageMagick: emulate the effect of a scanned document"
date: "2022-02-01T02:02:02.00Z"
description: "Автоматизируем работу фотошопера. Эмулируем эффект отсканированного PDF документа"
---

Суть задачи: иногда просят прислать скан документа, причем по сути принципиально он не будет отличаться от документа, на который наложил фото подписи и печати.
Порой бюррократия у некоторых зашкаливает. Я за то, чтобы экономить бумагу и вообще переходить на ЭДО (электронный документоборот).
Но все же, некоторым очень важно чтобы документ был именно отсканирован.

Я делал такие документы через Photoshop, до тех пор пока не заколебался. В итоге я наваял для себя простой bash скрипт, который берет цветной оригинал в PDF и на выходе генерирует PDF с эффектом буд-то бы это факс или ксерокопия.

Выглядит очень даже натурально.


Файл scan.sh

```bash
#!/usr/bin/env bash

f=$1

# конвертируем PDF в JPG и делаем черно-белым
convert -verbose -density 300 -trim "$f" -background white -flatten -quality 100 -type Grayscale step-1.jpg

# Накладываем прозрачную картинку - эффект шумов и помех от ксерокса
convert -verbose step-1.jpg fg.png -composite step-2.png

# Рандомно поворачиваем на небольшой угол, буд-то бы документ криво лежал в сканере
angle=$[ RANDOM % 4 + 1 ]
echo "ANGLE=$angle"
convert -verbose step-2.png -background '#000000' -rotate 0.$angle step-2.jpg


# Обратно превращаем картинку в PDF
newfile="${f%%.pdf}-scan.pdf"
convert -verbose step-2.jpg "$newfile"

# эта строчка для MacOS, позволяет сразу увидеть результат
open "$newfile"

# чистим за собой от временных файлов
rm -v step-1.jpg step-2.jpg step-2.png
```


<iframe width="560" height="315" src="https://www.youtube.com/embed/eRowSRtjQls" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>


### Продолжение тут

https://tech.geekjob.ru/ImageMagick-emulate-effect-scanned-document-multipage/



---
title: "ImageMagick: emulate the effect of a scanned document. Part 2"
date: "2022-02-02T02:02:02.00Z"
description: "Автоматизируем работу фотошопера. Эмулируем эффект отсканированного PDF документа"
---

В прошлой статье я показал как сделать скрипт для одностраничных документов.
В случае с мультидокументами скрипт нужно немного переписать:

Файл scan.sh

```bash
#!/usr/bin/env bash

f=$1


convert -verbose -density 300 "$f" -background white -alpha remove -alpha off  -quality 100 -type Grayscale s1-%01d.jpg
# convert -verbose -density 300 -trim "$f" -background white -flatten -quality 100 -type Grayscale s1.jpg

i=0
for p in $(ls s1-*.jpg)
do
    convert -verbose "s1-$i.jpg" fg.png -composite "s2-$i.jpg"
    rm "s1-$i.jpg"

    angle=$[ RANDOM % 5 + 1 ]
    negative=$[ RNADOM %2 ]
    numsign=""
    [[ $negative > 0  ]] && numsign="-"
    echo "ANGLE=$angle"

    convert -verbose s2-$i.jpg -background '#000000' -rotate "${numsign}0.${angle}" "s2-$i.jpg"

    ((i=i+1))
done


newfile="${f%%.pdf}-scan.pdf"
convert "s2-*.jpg" -quality 100 "$newfile"

open "$newfile"

rm -v s2-*.jpg
```

Теперь можно конвертировать мультидокументы.


<iframe width="560" height="315" src="https://www.youtube.com/embed/eRowSRtjQls" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>




---
title: "JS: Download data as file"
date: "2020-07-18T21:29:04.000Z"
description: "Загрузка данных со страницы в виде файла
Если есть задача сформировать на лету данные в файл и загрузить их, например,
трансформ"
---

<h2 id="-">Загрузка данных со страницы в виде файла</h2><p>Если есть задача сформировать на лету данные в файл и загрузить их, например, трансформировать таблицу в CSV файл, то есть простой способ как загрузить такие данные:</p><pre><code class="language-javascript">
const downloadAsCSVFile = function(csv, fname) {
    let csvfile = new Blob([csv], {type: 'text/csv'})
    let downlink = document.createElement('a')

    downlink.download = fname
    downlink.href = window.URL.createObjectURL(csvfile)
    downlink.style.display = 'none'

    document.body.appendChild(downlink)
    downlink.click()
    document.body.removeChild(downlink)
}


downloadAsCSVFile(anyDataString, 'filename.csv')</code></pre>


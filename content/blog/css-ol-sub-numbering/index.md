---
title: "CSS ol sub numbering"
date: "2021-08-20T12:12:42.00Z"
description: "Делаем списки для документов на CSS Юридические документы, как правило, имеют  пронумерованные пункты. При этом пункты могут сод"
---

<h2 id="-css">Делаем списки для документов на CSS</h2><p>Юридические документы, как правило, имеют  пронумерованные пункты. При этом пункты могут содержать вложенные пункты. Можно, конечно, такие вещи сделать в ручную, но через CSS это может быть удобнее.</p><p>Собственно сам код очень прост:</p><pre><code class="language-css">ol { counter-reset: item }
ol &gt; li { display: block }
ol &gt; li:before {
    content: counters(item, ".") ". ";
    counter-increment: item
}</code></pre><p>В итоге получаем такой вот документ:</p><figure class="kg-card kg-image-card"><img src="https://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/images/2021/08/--------------2021-08-20---15.12.06.png" class="kg-image" alt srcset="https://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/images/size/w600/2021/08/--------------2021-08-20---15.12.06.png 600w, https://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/images/size/w1000/2021/08/--------------2021-08-20---15.12.06.png 1000w, https://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/images/size/w1600/2021/08/--------------2021-08-20---15.12.06.png 1600w, https://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/images/2021/08/--------------2021-08-20---15.12.06.png 2034w" sizes="(min-width: 720px) 720px"></figure>


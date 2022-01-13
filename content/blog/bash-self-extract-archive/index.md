---
title: "Самораспаковывающийся архив BASH"
date: "2016-01-09T18:51:31.00Z"
description: "BZip вариант #!/bin/bash sed -e '1,/^DATA_SECTION$/d' $0 | base64 -d | tar -jx exit DATA_SECTION    Упаковка tar-bzip архива cat"
---

<h4>BZip вариант</h4>
<pre>#!/bin/bash<br>sed -e '1,/^DATA_SECTION$/d' $0 | base64 -d | tar -jx<br>exit<br>DATA_SECTION<br><br></pre>
<h4>Упаковка tar-bzip архива</h4>
<pre>cat archive.tbz | base64 &gt;&gt; my_tbz_dist.sh</pre>
<h4>GZip вариант</h4>
<pre>#!/bin/bash<br>sed -e '1,/^DATA_SECTION$/d' $0 | base64 -d | tar -zx<br>exit<br>DATA_SECTION<br><br></pre>
<h4>Упаковка tgz архива</h4>
<pre>cat archive.tgz | base64 &gt;&gt; my_tgz_dist.sh</pre>



---
title: "Using Curl as Wget"
date: "2016-08-17T12:47:27.00Z"
description: "Use curl instead wget in Dockerfile Often I see in some Dockerfile installation wget in order to download any files. See that fo"
---

<h4>Use <strong>curl</strong> instead wget in Dockerfile</h4>
<p>Often I see in some Dockerfile installation <strong>wget</strong> in order to download any files. See that for example:</p>
<pre>RUN yum -y update &amp;&amp;<br>    yum install -y <strong>wget</strong> &amp;&amp;<br><strong>wget</strong> "http://rpms.famillecollet.com/enterprise/remi-release-7.rpm" &amp;&amp;<br>    ...</pre>
<p>The question why? You can download something using <strong>сurl</strong>. You can run curl as wget by this command:</p>
<pre>curl -O</pre>
<p>And you can to create an alias of ‘wget’ that will simply run the command <strong>curl -O</strong>:</p>
<pre>$ echo 'alias wget="curl -O"' &gt;&gt; ~/.bash_profile<br>$<br>$ wget "http://rpms.famillecollet.com/enterprise/remi-release-7.rpm"</pre>



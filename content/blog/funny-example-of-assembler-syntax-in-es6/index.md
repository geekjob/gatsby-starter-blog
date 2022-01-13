---
title: "Funny example of Assembler syntax in ES6"
date: "2016-02-09T03:26:29.000Z"
description: "It’s joke, but it show power of tagged template strings mov   `ax` `2` mov   `dx` `3` add   `ax` `dx` print `ax`  //// var mem ="
---

<h4>It’s joke, but it show power of tagged template strings</h4>
<pre>mov   `ax` `2`<br>mov   `dx` `3`<br>add   `ax` `dx`<br>print `ax`</pre>
<pre>////<br>var mem = {};<br>function mov(s1) { return s2 =&gt; mem[s1[0]] = s2[0] }<br>function add(s1) { return s2 =&gt; mem[s1[0]] + mem[s2[0]] }<br>function print(s1) { console.log(mem[s1[0]]) }</pre>



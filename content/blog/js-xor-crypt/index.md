---
title: "Простой XOR криптор"
date: "2017-04-19T14:42:31.00Z"
description: "В функциональном стиле Классический пример простейшей функции шифрования текстовой информации с использованием алгоритма XOR мож"
---

<h4>В функциональном стиле</h4>
<p>Классический пример простейшей функции шифрования текстовой информации с использованием алгоритма XOR может выглядеть так:</p>
<pre><strong>function</strong> crypt(str, key){<br><strong>var</strong> newstr = '';</pre>
<pre>  <strong>for</strong>(<strong>let</strong> i=0; i &lt; str.length; i++) {<br><strong>let</strong> char = str.charCodeAt(i) ^ key;<br>    newstr += String.fromCharCode(char);<br>  }</pre>
<pre>  <strong>return</strong> newstr;<br>}</pre>
<p>По перфомансу код быстр, простой и читаемый. Но если вы хотите ту же функцию в функциональном стиле, то она может быть записана в 1 строку:</p>
<pre><strong>const</strong> crypt <strong>= </strong>(str, key) <strong>=&gt;</strong> str.split('').map((s,i) <strong>=&gt;</strong> <strong>String</strong>.fromCharCode(s.charCodeAt()<strong>^</strong>key)).join('');</pre>
<p>Кода, как видите, реально меньше. Но и читаемость, как и перфоманс данного кода, сильно ниже.</p>
<h3>Пример</h3>
<pre><strong>var</strong> text = 'Текст для шифрования',<br>    key = 376000,<br>    hash;</pre>
<pre>hash = crypt(text, key);<br>console.log(hash); <em>// 룢룵룺뢁뢂볠룴룻뢏볠뢈룸뢄뢀룾룲룰룽룸뢏</em></pre>
<pre>text = crypt(hash, key);<br>console.log(text); <em>// Текст для шифрования</em></pre>
<h4>Улучшенный пример</h4>
<pre><strong>const</strong> encrypt = (str, key) =&gt; str<br>  .<strong>split</strong>('')<br>  .<strong>map</strong>(s=&gt;(s.charCodeAt()^key).toString(16))<br>  .<strong>join</strong>('g')<br>;</pre>
<pre><strong>const</strong> decrypt = (str, key) =&gt; str<br>  .<strong>split</strong>('g')<br>  .<strong>filter</strong>(Boolean)<br>  .<strong>map</strong>(s=&gt; <strong>String</strong>.fromCharCode(<strong>parseInt</strong>(s,16)^key) )<br>  .<strong>join</strong>('')<br>;</pre>
<pre><strong>let</strong> text = '<em>Текст для шифрования with english symbols</em>',<br>    key = <em>889360895</em>;</pre>
<pre><strong>let</strong> hash = encrypt(text, key);<br><em>//350295ddg350295cag350295c5g350295beg350295bdg350291dfg350295cbg350295c4g350295b0g350291dfg350295b7g350295c7g350295bbg350295bfg350295c1g350295cdg350295cfg350295c2g350295c7g350295b0g350291dfg35029188g35029196g3502918bg35029197g350291dfg3502919ag35029191g35029198g35029193g35029196g3502918cg35029197g350291dfg3502918cg35029186g35029192g3502919dg35029190g35029193g3502918c</em></pre>
<pre><strong>decrypt</strong>(hash, key);<br>//</pre>



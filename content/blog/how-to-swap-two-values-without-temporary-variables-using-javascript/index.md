---
title: "How To Swap Two Values Without Temporary Variables Using JavaScript"
date: "2016-07-18T14:45:39.00Z"
description: "A complete guide with answers for the interview Photo by Artem Sapegin [https://unsplash.com/@sapegin?utm_source=unsplash&utm_me"
---

<h4>A complete guide with answers for the interview</h4>
- <a href="https://unsplash.com/@sapegin?utm_source=unsplash&amp;utm_medium=referral&amp;utm_content=creditCopyText" target="_blank" rel="noopener noreferrer">Artem Sapegin</a> <br/>
- <a href="https://unsplash.com/search/photos/javascript?utm_source=unsplash&amp;utm_medium=referral&amp;utm_content=creditCopyText" target="_blank" rel="noopener noreferrer">Unsplash</a> <br/>

<p>Swapping the value of two variables normally takes three lines and a temporary variable. What if I told you there was an easier way to do this with JavaScript?</p>
<p>There are two types of conditions for such a task. There is the classical condition, where we change two numbers. Then there is the more difficult task — change two of any type (string, float, object, other…).</p>
<hr>
<h3>Traditional Method</h3>
<p>The goal is to swap the values of <code>a</code> and <code>b</code> (all types).</p>
<pre>let a = 1,<br>    b = 2,<br>    c = 0;</pre>
<pre>c = a;<br>a = b;<br>b = c;</pre>
<p>Of course, we’ve introduced another variable, called <code>c</code>, to temporarily store the original value of <code>a</code> during the swap. But can we do it without <code>c</code>? Yes, we can!</p>
<hr>
<h3>Solution for Integers Only</h3>
<p>Let’s start with the first task — to change the two integers.</p>
<h4>With mathematical operations</h4>
<pre>a = a + b<br>b = a - b<br>a = a - b</pre>
<p>or</p>
<pre>a += b<br>b  = a — b<br>a -= b</pre>
<h4>XOR</h4>
<p>Since these are integers, you can also use any number of clever tricks to swap without using a third variable. For instance, you can use the bitwise XOR operator:</p>
<pre>a = a ^ b<br>b = a ^ b<br>a = a ^ b</pre>
<p>or</p>
<pre>a ^= b;<br>b ^= a;<br>a ^= b;</pre>
<p>This is called the XOR swap algorithm. Its theory of operation is described in <a href="http://en.wikipedia.org/wiki/XOR_swap_algorithm" target="_blank" rel="noopener noreferrer">this Wikipedia article</a>. I forgot to mention that this works reliably only with integers. I assumed the integer variables from question’s thread.</p>
<h4>Hacks and tricks</h4>
<p><strong>Single line swapping with addition</strong></p>
<pre>a = b + (b=a, 0)</pre>
<p>This solution uses no temporary variables, no arrays, only one addition, and it’s fast. In fact, it is sometimes<em> </em>faster than a temporary variable on several platforms. It works for all numbers, never overflows, and handles edge-cases such as Infinity and NaN.</p>
<p>It works in two steps:</p>
<pre>1. (b=a, 0) sets b to the old value of a and yields 0</pre>
<pre>2. a = b + 0 sets a to the old value of b</pre>
<p><strong>Another single line swapping:</strong></p>
<pre>b=a+(a=b)-b</pre>
<p><strong>Single line swapping with XOR</strong></p>
<pre>a = a^b^(b^=(a^b))</pre>
<hr>
<h3>Solutions for All Types</h3>
<p>And now on to the second task — to change the two variables with any types.</p>
<h4>Classic one-line method</h4>
<p>This trick uses an array to perform the swap. Take a second to wrap your head around it:</p>
<pre>a = [b, b=a][0];</pre>
<p>There are a few things happening here. If you’re having trouble understanding how or why this works, consider this explanation:</p>
<ol>
<li>We’re utilizing an array where the first index is the value of <code>a</code> and the second index is the value of <code>b</code>.</li>
<li>
<code>a</code> is set to the value of <code>b</code> when the array is created.</li>
<li>
<code>b</code> is set to the first index of the array, which is <code>a</code>
</li>
</ol>
<h4>Another tricky one-line solution</h4>
<p>Using ES6 self executing arrow functions:</p>
<pre>b = (a=&gt;a)(a,a=b);</pre>
<p>or ES5+ immediately invoked function:</p>
<pre>b = (function(a){ return a })(a, a=b);</pre>
<h4>ES6+ method</h4>
<p>Since ES6, you can also swap variables more elegantly. You can use destructuring assignment array matching. It’s simply:</p>
<pre>[a, b] = [b, a]</pre>



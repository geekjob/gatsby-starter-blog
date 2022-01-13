---
title: "FunPHP#6: Еще немного магии в PHP7"
date: "2019-05-20T17:41:26.00Z"
description: "UPD базы знаний Люблю я всякую магию. Люблю фокусы, умею их показывать. И в программировании мне так же нравятся фокусы. Не раз "
---

<h4>UPD базы знаний</h4>

<p>Люблю я всякую магию. Люблю фокусы, умею их показывать. И в программировании мне так же нравятся фокусы. Не раз уже писал про фокусы в JS, реже в PHP. А ведь PHP это язык с которого началась моя любовь к фокусам еще в далеком 2009 году, когда я еще тусил на <a href="https://phpclub.ru/talk/" target="_blank" rel="noopener noreferrer">PHPClub</a> ?</p>
<p>Еще в далеком 2015 году на хабре я писал статью <a href="https://habr.com/ru/post/259865/" title="https://habr.com/ru/post/259865/" target="_blank" rel="noopener noreferrer">Безумный PHP. Фьюри код</a><strong>. </strong>Захотелось немного обновить пост, показать новые (может быть для кого-то уже не новые) трюки, поправить старые…</p>
<h4>Как в PHP переопределить TRUE?</h4>
<p>Этот вопрос частично был отвечен в статье на Хабре еще в 2015 году и там я приводил примеры, которые пришли в голову — определение через неймспейсы:</p>
<pre><em>// Так сделать не получится в глобальной области, а внеймспейсе<br>// Notice:  Constant true already defined in ...<br></em><strong>namespace</strong> {<br><strong>define</strong>('true', false);<br>}</pre>
<pre>//или</pre>
<pre><strong>namespace</strong> Hack {<br><strong>define</strong>('Hack\true', false);<br>   var_dump(true === false); <em>// true<br></em>}</pre>
<p>Но сейчас эти способы не работают в PHP 7.3. Позже, я узнал метод лучше, как сделать такую шутку в глобальном скопе. Метод был описан на <a href="https://www.reddit.com/r/PHP/comments/5te0cw/use_const_true_as_false/" target="_blank" rel="noopener noreferrer">Reddit</a> еще очень очень давно:</p>
<pre><strong>use</strong> <strong>const</strong> <strong>true</strong> <strong>as</strong> <strong>false</strong>;</pre>
<pre>var_dump(<strong>true</strong> );          // true<br>var_dump(<strong>false</strong>);          // true<br>var_dump(<strong>true</strong> === <strong>false</strong>); // true</pre>
<p>Парам пам пам! Пруф: <a href="https://3v4l.org/3ZbNW" target="_blank" rel="noopener noreferrer">https://3v4l.org/3ZbNW</a></p>
<p>Играя этим можно делать разные первоапрельские трюки:</p>
<pre><strong>use const false as null;<br>use const null as false;</strong></pre>
<p>Но если хочется сорвать башню, то можно сделать так:</p>
<pre><strong>use</strong> <strong>const</strong> <strong>NAN</strong> <strong>as</strong> <strong>true</strong>;</pre>
<pre>var_dump(<strong>true</strong> === <strong>true</strong>); // false<br>var_dump(<strong>true</strong> == <strong>true</strong>);  // false<br>var_dump(<strong>true</strong> == <strong>false</strong>); // false<br>var_dump(<strong>true</strong> == <strong>NAN</strong>);   // false</pre>
<p>Вот это будет реально отрыв башки, так как NAN != NAN.</p>



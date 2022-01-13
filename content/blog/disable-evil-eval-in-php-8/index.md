---
title: "Evil eval in PHP 8"
date: "2021-08-04T19:21:11.00Z"
description: "Запрещаем конструкцию eval или как я написал расширение из 2х строк кода на С (ну почти 2х строк :))  Собственно задача - запрет"
---

<p>Запрещаем конструкцию eval или как я написал расширение из 2х строк кода на С (ну почти 2х строк :))</p><p>Собственно задача - запретить "функцию" eval. Да да, все верно, я взял в кавычки, так как eval - это не функция, а языковая конструкция.</p><p>Все опасные функции можно выключить используя специальную директиву в файле php.ini, но не инструкции. Eval выключить через php.ini нельзя, увы.</p><p>Про особенности директивы можно прочитать в короткой заметке:</p><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="/overload-php-functions/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">Override internal PHP functions</div><div class="kg-bookmark-description">Переписать функцию PHP без специальных расширений и отладочных инструментов.Возможно ли? Спйолер: Да. Но есть нюанс. Сначала нужно функцию, которую хочется переопределить стереть. Асделать это можно через php.ini файл, вписав функцию в директиву: disable_functions &#x3D; Для примера возьмем функцию …</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://tech.geekjob.ru/favicon.png"><span class="kg-bookmark-author">Geekjob Tech</span><span class="kg-bookmark-publisher">FullStack CTO</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://tech.geekjob.ru/content/images/2021/07/--------------2021-07-28---23.54.32.png"></div></a></figure><h3 id="-">Зачем?</h3><p>Все просто. На одном из своих второстепенных серверов под всякие вордпресы я нашел залитый шел, который выглядел просто и содержал в себе вызов eval.</p><p>В общем озадачился такой идеей - выключить нахрен этот евал. Раньше существовал такой проект как Suhosin. Возможно он и сейчас существует, но вот под версию PHP 8 я его не нашел.</p><p>Вообще способов вызвать eval в PHP много, но с приходом версии 8, в этом плане многое стало лучше и старые способы уже не работают, такие как:</p><pre><code class="language-php">preg_replace('/a/e', $_REQUEST['shell'], 'a');
// Warning: preg_replace(): The /e modifier is no longer supported, use preg_replace_callback instead


mb_ereg_replace('a', $_REQUEST['shell'], 'a', 'e');
// Fatal error: Uncaught ValueError: Option "e" is not supported


create_function("fn() =&gt; 1");
// Fatal error: Uncaught Error: Call to undefined function create_function()</code></pre><p>В общем, давно я не трогал С, и не писал расширений под PHP. Так что я пошел в документацию</p><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="https://www.zend.com/resources/writing-php-extensions"><div class="kg-bookmark-content"><div class="kg-bookmark-title">Writing PHP Extensions | Zend by Perforce</div><div class="kg-bookmark-description"></div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://www.zend.com/sites/zend/themes/custom/zend/images/favicons/favicon.ico"><span class="kg-bookmark-author">Zend</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://www.zend.com/sites/zend/themes/custom/zend/logo.svg"></div></a></figure><p>Скачал исходники PHP:</p><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="https://github.com/php/php-src"><div class="kg-bookmark-content"><div class="kg-bookmark-title">GitHub - php/php-src: The PHP Interpreter</div><div class="kg-bookmark-description">The PHP Interpreter. Contribute to php/php-src development by creating an account on GitHub.</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://github.githubassets.com/favicons/favicon.svg"><span class="kg-bookmark-author">GitHub</span><span class="kg-bookmark-publisher">php</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://opengraph.githubassets.com/709742784644eb2a971f116c4b8fa4c67b5de5922e05177aab811a0a7931e30f/php/php-src"></div></a></figure><p>Создал скелет проекта, согласно документации и пошел изучать как устроено выполнение кода. Находим в исходниках вот такой вот файлик:</p><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="https://github.com/php/php-src/blob/master/Zend/zend_execute.h"><div class="kg-bookmark-content"><div class="kg-bookmark-title">php-src/zend_execute.h at master · php/php-src</div><div class="kg-bookmark-description">The PHP Interpreter. Contribute to php/php-src development by creating an account on GitHub.</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://github.githubassets.com/favicons/favicon.svg"><span class="kg-bookmark-author">GitHub</span><span class="kg-bookmark-publisher">php</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://opengraph.githubassets.com/709742784644eb2a971f116c4b8fa4c67b5de5922e05177aab811a0a7931e30f/php/php-src"></div></a></figure><p>и к нему же</p><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="https://github.com/php/php-src/blob/master/Zend/zend_execute.c"><div class="kg-bookmark-content"><div class="kg-bookmark-title">php-src/zend_execute.c at master · php/php-src</div><div class="kg-bookmark-description">The PHP Interpreter. Contribute to php/php-src development by creating an account on GitHub.</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://github.githubassets.com/favicons/favicon.svg"><span class="kg-bookmark-author">GitHub</span><span class="kg-bookmark-publisher">php</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://opengraph.githubassets.com/709742784644eb2a971f116c4b8fa4c67b5de5922e05177aab811a0a7931e30f/php/php-src"></div></a></figure><p>изучаем и прикидываем, что по сути задача наша сломать. Ломать не строить, но ломать тоже надо аккуратно.</p><p>Итого что выходит:</p><pre><code class="language-c">
void evil_execute_ex(zend_execute_data *execute_data)
{
    if (execute_data-&gt;opline &amp;&amp; (execute_data-&gt;opline-&gt;opcode == ZEND_INCLUDE_OR_EVAL) &amp;&amp; (execute_data-&gt;opline-&gt;extended_value == ZEND_EVAL))
    {
    	zend_error(E_ERROR, "Eval disabled!");
		return;
    }

    zend_old_execute_ex(execute_data);
}


PHP_MINIT_FUNCTION(evil)
{
    zend_old_execute_ex = zend_execute_ex;
    zend_execute_ex = evil_execute_ex;
    return SUCCESS;
}</code></pre><p>Это если кратко. Полную версию расширения можно увидеть в репозитории на гитхабе: <a href="https://github.com/frontdevops/php-evil">https://github.com/frontdevops/php-evil</a></p><p>Ну или все проще, можно сразу воспользоваться результатом:</p><pre><code class="language-bash"># 1
git clone https://github.com/frontdevops/php-evil
# 2
cd php-evil
# 3
phpize
# 4
./configure
# or ./configure --enable-hide-presence (whether to hide presence this extension)
# 5
make &amp;&amp; make install
# 6
# Add to php.ini extension=evil.so</code></pre><figure class="kg-card kg-image-card kg-card-hascaption"><img src="/content/images/2021/08/img1.png" class="kg-image" alt srcset="/content/images/size/w600/2021/08/img1.png 600w, /content/images/size/w1000/2021/08/img1.png 1000w, /content/images/size/w1600/2021/08/img1.png 1600w, /content/images/2021/08/img1.png 1920w" sizes="(min-width: 720px) 720px"><figcaption>disabled eval in PHP8</figcaption></figure><p>Я предусмотрел опцию: скрыть присутствие. По сути это просто другой вывод сообщения, который говорит что есть некая ошибка, вместо явного сообщения о том, что eval выключен.</p><figure class="kg-card kg-image-card kg-card-hascaption"><img src="/content/images/2021/08/img2.png" class="kg-image" alt srcset="/content/images/size/w600/2021/08/img2.png 600w, /content/images/size/w1000/2021/08/img2.png 1000w, /content/images/size/w1600/2021/08/img2.png 1600w, /content/images/2021/08/img2.png 1954w" sizes="(min-width: 720px) 720px"><figcaption>php 8 - disabled eval</figcaption></figure><h2 id="github">Github</h2><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="https://github.com/frontdevops/php-evil"><div class="kg-bookmark-content"><div class="kg-bookmark-title">GitHub - frontdevops/php-evil: Disable eval instruction in PHP8</div><div class="kg-bookmark-description">Disable eval instruction in PHP8. Contribute to frontdevops/php-evil development by creating an account on GitHub.</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://github.githubassets.com/favicons/favicon.svg"><span class="kg-bookmark-author">GitHub</span><span class="kg-bookmark-publisher">frontdevops</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://opengraph.githubassets.com/9c637936eccd2ae6dc7f95a5642a3a2bdc733cf2bc431fd2286076431a20ce81/frontdevops/php-evil"></div></a></figure>

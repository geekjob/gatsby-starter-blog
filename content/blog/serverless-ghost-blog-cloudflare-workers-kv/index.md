---
title: "Serverless статистика для Ghost блога на примере Cloudflare workers + KV за 5 минут"
date: "2020-06-13T11:32:37.00Z"
description: "Делаем простую статистику и лайки за 5 минут, используя воркеры Cloudflare с применеием Key Value хранилища от них же.  Задача: "
---

<p>Делаем простую статистику и лайки за 5 минут, используя воркеры Cloudflare с применеием Key Value хранилища от них же.</p><p><strong>Задача:</strong></p><p>После перезда с medium.com на свой собственный блог (в качестве движка которого я использую Ghos 3й версии, так как он мне очень нравится) я не смог найти чего-то удобного для статистики и лайков. Все же хорошей мотивацией является то, что мои статьи кому-то приносят пользу и интересны, так что если не сложно - ставьте лайк :)</p><p>И так, готового плагина не нашел, но и писать свой бэкенд как-то не очень-то и хотелось. И тут я подумал, а почему бы не заюзать воркеры для этой задачи + KV от моего любимого Cloudflare?</p><p>Первое что нам нужно - завести два неймпсейса - по сути две таблицы:</p><figure class="kg-card kg-image-card"><img src="/content/images/2020/06/--------------2020-06-13---14.08.00--1-.png" class="kg-image"></figure><p>Тут вроде бы все просто. Далее создаем два воркера. Один воркер считает статистику просмотров, второй воркер обрабатывает "хлопки" (в терминах medium.com :))</p><p>На вкладке воркеров создаем два воркера. Код воркеров показан ниже.</p><figure class="kg-card kg-image-card"><img src="/content/images/2020/06/--------------2020-06-13---14.10.58.png" class="kg-image"></figure><p>Код воркера для обработки лайков. Заходим в редактор:</p><figure class="kg-card kg-image-card"><img src="/content/images/2020/06/--------------2020-06-13---14.19.44.png" class="kg-image"></figure><p>и пишем код:</p><pre><code class="language-javascript">
addEventListener('fetch',e=&gt;{e.respondWith(handleRequest(e.request))});

const res = json =&gt;
    new Response(
        JSON.stringify(json),
        {
            status: 200,
            headers: [
                ['Content-Type', 'application/json'],
                [
                   'Access-Control-Allow-Origin',
                   'https://tech.geekjob.ru'
                ]
            ]
        }
    )
;


async function handleRequest(req) {
    let url = new URL(req.url);
    let key = url.searchParams.get('k');

    if (!key)
        return res({ error: true, message: 'Bad key' });

    let likes = parseInt(await GJ_BLOG_LIKES.get(key)) || 0;
    await GJ_BLOG_LIKES.put(key, ++likes);

    return res({ likes })
}</code></pre><p>Для удобства я описал функцию res, чтобы было удобно возвращать ответ. </p><p>Код простой - обращаемся к нашему хранилищу, читаем данные, приводим к числу, увеличиваем счетчик и возвращаем ответ.</p><p>KV поддерживает всего 3 типа:</p><ul><li><code>string</code></li><li><code>ReadableStream</code></li><li><code>ArrayBuffer</code></li></ul><p>При этом при чтении вы можете указать какой тип возвращается и там есть возможность сразу преобразовать JSON строку в объект:</p><p><code>NAMESPACE.get(key, type)</code></p><p>The <code>type</code> parameter can be any of:</p><ul><li><code>"text"</code>: (default) a string</li><li><code>"json"</code>: an object decoded from a JSON string</li><li><code>"arrayBuffer"</code>: An <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/ArrayBuffer">ArrayBuffer</a> instance.</li><li><code>"stream"</code>: A <a href="https://developer.mozilla.org/en-US/docs/Web/API/ReadableStream">ReadableStream</a>.</li></ul><p>Собственно поэтому мы используем <code>parseInt()</code> для преобразования числа в Number.</p><p>Если вы попытаетесь запустить ваш воркер - он выдаст ошибку, так как не знает ничего про ваше хранилище еще.</p><h2 id="-kv-">Подключаем KV хранилище</h2><p>Для этого нужно сохранить ваш воркер, при желании задать ему адекватное имя и выйти их редактора.</p><figure class="kg-card kg-image-card"><img src="/content/images/2020/06/--------------2020-06-13---14.20.14.png" class="kg-image"></figure><p>Вы должны пробросить внутрь воркера переменную, которую свяжете с вашим KV неймспейсом.</p><p>Вот теперь ваш воркер будет работать.</p><h3 id="-">Пишем код воркера для подсчета просмотров и возврата статистики</h3><p>Код данного воркера я совместил сразу с отображением статистики по просмотрам и лайкам, чтобы можно было показать на странице.</p><pre><code class="language-javascript">
addEventListener('fetch',e=&gt;{e.respondWith(handleRequest(e.request))});

const res = json =&gt;
    new Response(
        JSON.stringify(json),
        {
            status: 200,
            headers: [
                ['Content-Type', 'application/json'],
                [
                    'Access-Control-Allow-Origin',
                    'https://tech.geekjob.ru'
                ]
            ]
        }
    )
;


async function handleRequest(req) {
    let url = new URL(req.url);
    let key = url.searchParams.get('k');

    if (!key)
        return res({ error: true, message: 'Bad key' });

    let views = parseInt(await GJ_BLOG_STAT.get(key)) || 0;
    await GJ_BLOG_STAT.put(key, ++views);
    let likes = parseInt(await GJ_BLOG_LIKES.get(key)) || 0;

    return res({
        views,
        likes
    })
}</code></pre><p>Так же не забываем пробросить KV внутрь воркера через настройки.</p><p>Теперь в админке Ghost, через блок Code Injections я добавил стили и небольшой JS код.</p><blockquote>Site Header. Code here will be injected into the <code>{{ghost_head}}</code> tag on every page of the site</blockquote><pre><code class="language-html">&lt;style&gt;
#statinfo {
    cursor: pointer;
    z-index: 99999;
    background: #fff;
    position: absolute;
    width: 70px;
    top: 69px;
    right: 2%;
    color: #000;
    font-size: 12px;
    text-align:center;
    padding: 4px;
    border-radius: 2px;
    opacity: .7;
    font-weight: bold;
}
#statinfo hr {
    height: 1px;
    line-height: 1px;
    font-size: 1px;
    padding: 0;
    margin: 2px 0;
    border-top: 1px solid #000;
}
&lt;/style&gt;</code></pre><blockquote>Site Footer. <em>Code here will be injected into the <code>{{ghost_foot}}</code> tag on every page of the site</em></blockquote><pre><code class="language-html">&lt;!-- Код визуального блока кнопки Like со статистикуой --&gt;
&lt;div id="statinfo" onclick="likePost()"&gt;
    ? &lt;span class="silikes"&gt;?&lt;/span&gt;
    &lt;hr&gt;
    ? &lt;span class="siviews"&gt;?&lt;/span&gt;
&lt;/div&gt;
&lt;script&gt;
// Создаем имя страницы - по сути только путь без крайних слешей
var pageid = location.pathname.replace('/','').replace(/\/$/,'') || 'main';

document.addEventListener('DOMContentLoaded', function(){
    var $statinfo = document.querySelector('#statinfo'),
        $views = $statinfo.querySelector('.siviews'),
        $likes = $statinfo.querySelector('.silikes')
    ;

    // Обрабатываем Like
    window.likePost = function() {
        fetch('https://like-blog.geekjob.workers.dev/?k='+pageid)
            .then(d=&gt;d.json())
            .then(data =&gt; {
                if (data.error) return;
                $likes.innerText = data.likes || 0;
            })
            .catch(console.error);        
    };

    // Засчитываем просмотр страницы и загружаем статистику
    fetch('https://stat-blog.geekjob.workers.dev/?k='+pageid)
        .then(d=&gt;d.json())
        .then(data =&gt; {
            if (data.error) return;
            $views.innerText = data.views || 0;
            $likes.innerText = data.likes || 0;
	    })
        .catch(console.error);
})
&lt;/script&gt;</code></pre><p>Собственно что получилось:</p><figure class="kg-card kg-image-card"><img src="/content/images/2020/06/--------------2020-06-13---14.29.07--1-.png" class="kg-image"></figure><p>Результат вы можете видеть на этой странице если все отработало штатно, без ошибок.</p><p>Поставьте лайк, если не сложно :)</p><!--kg-card-begin: html--><div onclick="likePost();this.innerHTML='Спасибо!'" class="likeButton">
     ? Однознано лайк, понравилось ?
</div><!--kg-card-end: html--><p>Спасибо!</p><p>Больше информации в документации:</p><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="https://developers.cloudflare.com/workers/reference/apis/kv/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">KV</div><div class="kg-bookmark-description">Use Cloudflare’s APIs and edge network to build secure, ultra-fast applications.</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://www.cloudflare.com/img/favicon/apple-touch-icon.png"><span class="kg-bookmark-publisher">Cloudflare Workers logo (horizontal)The horizontal wordmark logo for the Cloudflare Workers brand.</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://developers.cloudflare.com/workers/svg/github.svg"></div></a></figure><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="https://developers.cloudflare.com/workers/quickstart"><div class="kg-bookmark-content"><div class="kg-bookmark-title">Quick Start</div><div class="kg-bookmark-description">Use Cloudflare’s APIs and edge network to build secure, ultra-fast applications.</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://www.cloudflare.com/img/favicon/apple-touch-icon.png"><span class="kg-bookmark-publisher">Cloudflare Workers logo (horizontal)The horizontal wordmark logo for the Cloudflare Workers brand.</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://developers.cloudflare.com/workers/svg/github.svg"></div></a></figure>


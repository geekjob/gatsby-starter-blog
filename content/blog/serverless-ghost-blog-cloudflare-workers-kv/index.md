---
title: "Serverless статистика для Ghost блога на примере Cloudflare workers + KV за 5 минут"
date: "2020-06-13T11:32:37.00Z"
description: "Делаем простую статистику и лайки за 5 минут, используя воркеры Cloudflare с применеием Key Value хранилища от них же.  Задача: "
---

Делаем простую статистику и лайки за 5 минут, используя воркеры Cloudflare с применеием Key Value хранилища от них же.

**Задача:**

После перезда с medium.com на свой собственный блог (в качестве движка которого я использую Ghos 3й версии, так как он мне очень нравится) я не смог найти чего-то удобного для статистики и лайков. Все же хорошей мотивацией является то, что мои статьи кому-то приносят пользу и интересны, так что если не сложно - ставьте лайк :)

И так, готового плагина не нашел, но и писать свой бэкенд как-то не очень-то и хотелось. И тут я подумал, а почему бы не заюзать воркеры для этой задачи + KV от моего любимого Cloudflare?

Первое что нам нужно - завести два неймпсейса - по сути две таблицы:

[IMG]

Тут вроде бы все просто. Далее создаем два воркера. Один воркер считает статистику просмотров, второй воркер обрабатывает "хлопки" (в терминах medium.com :))

На вкладке воркеров создаем два воркера. Код воркеров показан ниже.

Код воркера для обработки лайков. Заходим в редактор:

[IMG]

и пишем код:

```js
addEventListener('fetch',e=>{e.respondWith(handleRequest(e.request))});

const res = json => new Response(JSON.stringify(json), {
	status: 200,
	headers: [
		['Content-Type', 'application/json'],
		[
			'Access-Control-Allow-Origin',
			'https://tech.geekjob.ru'
		]
	]
});

async function handleRequest(req) {
let url = new URL(req.url);
let key = url.searchParams.get('k');

if (!key)
	return res({ error: true, message: 'Bad key' });

	let likes = parseInt(await GJ_BLOG_LIKES.get(key)) || 0;
	await GJ_BLOG_LIKES.put(key, ++likes);

	return res({ likes })
}
```

Для удобства я описал функцию res, чтобы было удобно возвращать ответ.

Код простой - обращаемся к нашему хранилищу, читаем данные, приводим к числу, увеличиваем счетчик и возвращаем ответ.

KV поддерживает всего 3 типа:

- string
- ReadableStream
- ArrayBuffer

При этом при чтении вы можете указать какой тип возвращается и там есть возможность сразу преобразовать JSON строку в объект:

`NAMESPACE.get(key, type)`

The type parameter can be any of:

- "text": (default) a string
- "json": an object decoded from a JSON string
- "arrayBuffer": An ArrayBuffer instance.
- "stream": A ReadableStream.

Собственно поэтому мы используем parseInt() для преобразования числа в Number.

Если вы попытаетесь запустить ваш воркер - он выдаст ошибку, так как не знает ничего про ваше хранилище еще.

### Подключаем KV хранилище
Для этого нужно сохранить ваш воркер, при желании задать ему адекватное имя и выйти их редактора.


Вы должны пробросить внутрь воркера переменную, которую свяжете с вашим KV неймспейсом.

Вот теперь ваш воркер будет работать.

Пишем код воркера для подсчета просмотров и возврата статистики
Код данного воркера я совместил сразу с отображением статистики по просмотрам и лайкам, чтобы можно было показать на странице.

```js
addEventListener('fetch',e=>{e.respondWith(handleRequest(e.request))});

const res = json =>
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

}
```

Так же не забываем пробросить KV внутрь воркера через настройки.

Теперь в админке Ghost, через блок Code Injections я добавил стили и небольшой JS код.

```html
Site Header. Code here will be injected into the {{ghost_head}} tag on every page of the site
<style>
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
</style>
Site Footer. Code here will be injected into the {{ghost_foot}} tag on every page of the site
<!-- Код визуального блока кнопки Like со статистикуой -->
<div id="statinfo" onclick="likePost()">
	? <span class="silikes">?</span>
	<hr>
	? <span class="siviews">?</span>
</div>
<script>
// Создаем имя страницы - по сути только путь без крайних слешей
var pageid = location.pathname.replace('/','').replace(//$/,'') || 'main';

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
</script>
```

Собственно что получилось:

[IMG]

Результат вы можете видеть на этой странице если все отработало штатно, без ошибок.

Больше информации в документации:

<figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="https://developers.cloudflare.com/workers/reference/apis/kv/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">KV</div><div class="kg-bookmark-description">Use Cloudflare’s APIs and edge network to build secure, ultra-fast applications.</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://www.cloudflare.com/img/favicon/apple-touch-icon.png"><span class="kg-bookmark-publisher">Cloudflare Workers logo (horizontal)The horizontal wordmark logo for the Cloudflare Workers brand.</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://developers.cloudflare.com/workers/svg/github.svg"></div></a></figure><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="https://developers.cloudflare.com/workers/quickstart"><div class="kg-bookmark-content"><div class="kg-bookmark-title">Quick Start</div><div class="kg-bookmark-description">Use Cloudflare’s APIs and edge network to build secure, ultra-fast applications.</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://www.cloudflare.com/img/favicon/apple-touch-icon.png"><span class="kg-bookmark-publisher">Cloudflare Workers logo (horizontal)The horizontal wordmark logo for the Cloudflare Workers brand.</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://developers.cloudflare.com/workers/svg/github.svg"></div></a></figure>

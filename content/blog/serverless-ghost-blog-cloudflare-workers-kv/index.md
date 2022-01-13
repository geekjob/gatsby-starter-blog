---
title: "Serverless статистика для Ghost блога на примере Cloudflare workers + KV за 5 минут"
date: "2020-06-13T11:32:37.000Z"
description: "Делаем простую статистику и лайки за 5 минут, используя воркеры Cloudflare с
применеием Key Value хранилища от них же.

Задача:
"
---

<p>Делаем простую статистику и лайки за 5 минут, используя воркеры Cloudflare с применеием Key Value хранилища от них же.</p><p><strong>Задача:</strong></p><p>После перезда с medium.com на свой собственный блог (в качестве движка которого я использую Ghos 3й версии, так как он мне очень нравится) я не смог найти чего-то удобного для статистики и лайков. Все же хорошей мотивацией является то, что мои статьи кому-то приносят пользу и интересны, так что если не сложно - ставьте лайк :)</p><p>И так, готового плагина не нашел, но и писать свой бэкенд как-то не очень-то и хотелось. И тут я подумал, а почему бы не заюзать воркеры для этой задачи + KV от моего любимого Cloudflare?</p><p>Первое что нам нужно - завести два неймпсейса - по сути две таблицы:</p>- <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/ArrayBuffer">ArrayBuffer</a> <br/>
- <a href="https://developer.mozilla.org/en-US/docs/Web/API/ReadableStream">ReadableStream</a> <br/>
- <a class="kg-bookmark-container" href="https://developers.cloudflare.com/workers/reference/apis/kv/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">KV</div><div class="kg-bookmark-description">Use Cloudflare’s APIs and edge network to build secure, ultra-fast applications.</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://www.cloudflare.com/img/favicon/apple-touch-icon.png"><span class="kg-bookmark-publisher">Cloudflare Workers logo (horizontal)The horizontal wordmark logo for the Cloudflare Workers brand.</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://developers.cloudflare.com/workers/svg/github.svg"></div></a> <br/>
- <a class="kg-bookmark-container" href="https://developers.cloudflare.com/workers/quickstart"><div class="kg-bookmark-content"><div class="kg-bookmark-title">Quick Start</div><div class="kg-bookmark-description">Use Cloudflare’s APIs and edge network to build secure, ultra-fast applications.</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://www.cloudflare.com/img/favicon/apple-touch-icon.png"><span class="kg-bookmark-publisher">Cloudflare Workers logo (horizontal)The horizontal wordmark logo for the Cloudflare Workers brand.</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://developers.cloudflare.com/workers/svg/github.svg"></div></a> <br/>



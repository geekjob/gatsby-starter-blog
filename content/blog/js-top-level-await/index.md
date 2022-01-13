---
title: "JS/ES: Top-Level await"
date: "2020-05-24T14:55:52.000Z"
description: "Experimental support for 'Top-Level Await' just landed in Node.js core and
Chrome Dev Tools, and Safari Web Inspector!
Да да, в "
---

<h2 id="experimental-support-for-top-level-await-just-landed-in-node-js-core-and-chrome-dev-tools-and-safari-web-inspector-">Experimental support for 'Top-Level Await' just landed in Node.js core and Chrome Dev Tools, and Safari Web Inspector!</h2><p>Да да, в Node.js 14.3 уже есть возможность писать верхнеуровневые await , пока, правда, в экспериментальном режиме. А так же еще одна особенность: они доступны только в ESM модулях иначе не сработают. Если вы пользуетесь Babel, то вы можете уже использовать в продакшене эту фичу. Так же top level await были добавлены в TypeScript 3.8 еще в Феврале 2020 года. Так же эта возможность давно доступна в проекте <a href="https://deno.land/">Deno</a>.</p><p>Помимо Node.js эта фича языка доступан в <a href="https://developers.google.com/web/updates/2017/08/devtools-release-notes#await">Chrome Dev Tools</a> и Safari Web Inspector.</p><pre><code class="language-javascript">let data = (await fetch('https://geekjob.ru/vacancies?format=json')).data;

console.log(data);</code></pre><p>Но все же, если хочется использовать эту фичу в ноде нативно без транспайлеров, то вам нужно будет запуститься с флагами. Без флагов получится такой вариант - old way.</p><pre><code class="language-javascript">// index.msj

await Promise.resolve(console.log('?'));
// → SyntaxError: await is only valid in async function


void async function() {
    await Promise.resolve(console.log('?'));
    // → ?
}();
</code></pre><p>И если вы запустите проект с включенными опциями, то результат будет ок в обоих случаях.</p><pre><code class="language-bash">node --experimental-top-level-await --harmony-top-level-await index.mjs</code></pre><h3 id="-">В чем собственно суть проблемы?</h3><p>В JS много асинхронного кода, особенно если мы работаем с библиотеками баз данных. Node.js это не только среда для серверных веб-приложений, но так же можно писать разные вспомогательные скрипты, где асинхронность избыточна.</p><p>Типичный кейс работы с базой данных в Express:</p><pre><code>async routeFunction(req, res, next) {

   let db = await dbConnect();
   let result = await db.query('...');

   if (result.some) {
     ...
   }
   else {
     ...
   }

   next();
}</code></pre><p>Если же этот участок переписывать через промисы или еще хуже через колбэки, то код станет менее читаемым и более сложным.</p><p>С новым подходом в данном случае просто уйдет слово async и функции можно будет делать более универсальными.</p><p>Второй кейс - это необходимая синхронность, когда происходит подключение разных библиотек, но эта фича будет полезна в браузерах, когда туда завезут top level await'ы. Например:</p><pre><code class="language-javascript">var jQuery;
try {
  jQuery = await import('https://ajax.googleapis.com/libs/jquery.js');
} catch {
  jQuery = await import('/local/jquery.js');
}
</code></pre><p>С учетом разных блокировок, связанных с политикой, теперь такой код все более актуальнее, правда сейчас он реализуется все еще таким образом:</p><pre><code class="language-html">&lt;script src="//ajax.googleapis.com/libs/jquery/jquery.js"&gt;&lt;/script&gt;
&lt;script&gt;window.jQuery || document.write('&lt;script src="/local/jquery.js"&gt;\x3C/script&gt;')&lt;/script&gt;
</code></pre><p>Если интересна тема, больше подробностей на странице предложения:</p>- <a class="kg-bookmark-container" href="https://github.com/tc39/proposal-top-level-await"><div class="kg-bookmark-content"><div class="kg-bookmark-title">tc39/proposal-top-level-await</div><div class="kg-bookmark-description">top-level `await` proposal for ECMAScript (stage 3) - tc39/proposal-top-level-await</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://github.githubassets.com/favicons/favicon.svg"><span class="kg-bookmark-author">tc39</span><span class="kg-bookmark-publisher">GitHub</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://avatars3.githubusercontent.com/u/1725583?s=400&amp;v=4"></div></a> <br/>



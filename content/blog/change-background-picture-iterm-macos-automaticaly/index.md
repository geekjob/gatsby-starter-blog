---
title: "Как поменять фоновую картинку в терминале командой?"
date: "2021-08-12T10:02:55.00Z"
description: "Рецепт только для маководов. Основное приложение для работы в терминале у меня iTerm, так что и менять картинку буду в нем. Сам "
---

<p>Рецепт только для маководов. Основное приложение для работы в терминале у меня iTerm, так что и менять картинку буду в нем. Сам терминал у меня настроен под себя, полный конфиг всегда можете найти на гитхабе:</p><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="https://github.com/frontdevops/my-bash-config"><div class="kg-bookmark-content"><div class="kg-bookmark-title">GitHub - frontdevops/my-bash-config: My Shell configurations</div><div class="kg-bookmark-description">My Shell configurations. Contribute to frontdevops/my-bash-config development by creating an account on GitHub.</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://github.githubassets.com/favicons/favicon.svg"><span class="kg-bookmark-author">GitHub</span><span class="kg-bookmark-publisher">frontdevops</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://opengraph.githubassets.com/e83b5ee13a8424622733d99e914cf6f381a2d6fd0f8a9ea033c6a6d21d4a3860/frontdevops/my-bash-config"></div></a></figure><p>Зачем? Я захотел сделать так, чтобы при переходе в root режим, у меня фоновое изоюражение менялось. А еще чтобы оно менялось если я зашел по SSH куда-то. Чтобы я точно знал где я и когда. Ну и просто это очень красиво, модно, молодежно,... Хипстерня одним словом.</p><p>Чтобы поменять фоновое изображение из терминала в MacOS я заюзал AppleScript:</p><pre><code class="language-bash">--Change the background picture in iTerm by arguments--
on run argv
	tell application "iTerm"
		tell current session of current window
			set background image to "/Users/mayorov/Pictures/iTerm/" &amp; (argv as text)
		end tell
	end tell
end run</code></pre><p>По дефолту все скрипты сохраняются в директории:</p><p>~/<code>Library/Mobile\ Documents/com~apple~ScriptEditor2/Documents</code></p><p>Сами картинки я положил в стандартную директорию для картинок, в подпапку iTerm</p><p>Далее пишем shell фнукцию:</p><pre><code class="language-bash">function chbg()
{
    osascript /Users/mayorov/Library/Mobile\ Documents/com~apple~ScriptEditor2/Documents/bgImgIterm.scpt $@
}</code></pre><p>После чего в профайл скриптах добавляем:</p><pre><code class="language-bash">if [ $(id -u) = 0 ]
then
    chbg "root.jpg"
else
    chbg "user.jpg"
fi


function logout()
{
    chbg "user.jpg"
}


trap logout EXIT</code></pre><p>На выходе получаем вот такую красоту:</p><figure class="kg-card kg-embed-card"><iframe width="200" height="150" src="https://www.youtube.com/embed/ygwv_FkHt9Y?feature=oembed" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></figure>


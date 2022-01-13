---
title: "Как поменять фоновую картинку в терминале командой?"
date: "2021-09-07T12:12:12.00Z"
description: "Зачем? Я захотел сделать так, чтобы при переходе в root режим, у меня фоновое изоюражение менялось. А еще чтобы оно менялось если я зашел по SSH куда-то. Чтобы я точно знал где я и когда. Ну и просто это очень красиво, модно, молодежно,... Хипстерня одним словом."
---

Рецепт только для маководов. Основное приложение для работы в терминале у меня iTerm, так что и менять картинку буду в нем.
Сам терминал у меня настроен под себя, полный конфиг всегда можете найти на гитхабе:

https://github.com/frontdevops/my-bash-config

Зачем? Я захотел сделать так, чтобы при переходе в root режим, у меня фоновое изоюражение менялось. А еще чтобы оно менялось если я зашел по SSH куда-то. Чтобы я точно знал где я и когда. Ну и просто это очень красиво, модно, молодежно,... Хипстерня одним словом.

Чтобы поменять фоновое изображение из терминала в MacOS я заюзал AppleScript:

```bash
--Change the background picture in iTerm by arguments--
on run argv
	tell application "iTerm"
		tell current session of current window
			set background image to "/Users/mayorov/Pictures/iTerm/" & (argv as text)
		end tell
	end tell
end run
```

По дефолту все скрипты сохраняются в директории:

`~/Library/Mobile\ Documents/com~apple~ScriptEditor2/Documents`

Сами картинки я положил в стандартную директорию для картинок, в подпапку iTerm

Далее пишем shell фнукцию:

```bash
function chbg()
{
    osascript /Users/mayorov/Library/Mobile\ Documents/com~apple~ScriptEditor2/Documents/bgImgIterm.scpt $@
}
```

После чего в профайл скриптах добавляем:

```bash
if [ $(id -u) = 0 ]
then
    chbg "root.jpg"
else
    chbg "user.jpg"
fi

function logout()
{
    chbg "user.jpg"
}

trap logout EXIT
```

На выходе получаем вот такую красоту:

<iframe width="560" height="315" src="https://www.youtube.com/embed/ygwv_FkHt9Y" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>


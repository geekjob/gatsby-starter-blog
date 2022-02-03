---
title: "Что нового в Python 3.9"
date: "2020-06-11T11:17:52.00Z"
description: "Релиз нового пайтона уже не за горами и случится в октябре 2020. В этом посте я расскажу свои мысли про новые фичи.  Обсуждаем ф"
---

<p>Релиз нового пайтона уже не за горами и случится в октябре 2020. В этом посте я расскажу свои мысли про новые фичи.</p><h2 id="-">Обсуждаем фишки нового пайтона</h2><h3 id="pep-616-string-methods-to-remove-prefixes-and-suffixes">PEP 616 - String methods to remove prefixes and suffixes</h3><p>В <strong>Python 3.9</strong>, <a href="https://www.python.org/dev/peps/pep-0616/">PEP-616</a> добавили два новых метода для работы со строками:</p><ul><li>str.removeprefix</li><li>str.removesuffix</li></ul><p>Теперь вы можете реализовать функцию по тримингу кавычек в пару строк, ну ничоси:</p><pre><code class="language-python">def strip_quotes(text):
    return text.removeprefix('"').removesuffix('"')
</code></pre><p>А как раньше решалась такая задача?</p><pre><code class="language-python">def strip_quotes(text):
    return text.lstrip('"').rstrip('"')</code></pre><p>Эммм... Да, тут есть небольшие нюансы, но все же, никто не отменял регулярные выражения:</p><pre><code class="language-python">import re

def strip_quotes(text):
    text = re.sub(r'^"', '', text)
    return re.sub(r'"$', '', text)
</code></pre><p>Возможно выглядит не так коротко, но все же, решает задачу. Возможно встанут вопросы про производительность и необходимость использовать модуль... Но это же пара строк и тут больше гибкости в настройке, имхо.</p><p>Но даже если бы не было этих методов, честно говоря, не знаю на сколько это оправдано вообще, так как засоряет стандартный API кучей мелких готовых функций (которые отчасти еще и дублируются), которые и так легко реализовать и подключать по требованию. Как бы мы могли реализовать эти функции (без lstrip, rstrip и регулярок)?</p><pre><code class="language-python">def removeprefix(s: str, prefix: str) -&gt; str:
    if s.startswith(prefix):
        return s[len(prefix):]
    return s

def removesuffix(s: str, suffix: str, /) -&gt; str:
    if suffix and s.endswith(suffix):
        return s[:-len(suffix)]
    else:
        return s[:]
</code></pre><p>Так что эти фичи явно не big deal. Но... Объясните мне реальную нужду в таких вещах на уровне языка?</p><p>Пруф:</p><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="https://www.python.org/dev/peps/pep-0616/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">PEP 616 -- String methods to remove prefixes and suffixes</div><div class="kg-bookmark-description">The official home of the Python Programming Language</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://www.python.org/static/apple-touch-icon-144x144-precomposed.png"><span class="kg-bookmark-author">Python.org</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://www.python.org/static/opengraph-icon-200x200.png"></div></a></figure><h3 id="pep585-type-hinting-generics-in-standard-collections">PEP585: Type Hinting Generics In Standard Collections</h3><p>Это полезное улучшение. Любители типизаций должны оценить и мое личное мнение - в правильном направлении движется питон в плане тайп хинтингов. Если сейчас приходится писать так:</p><pre><code class="language-python">from typing import List, Type

lst: List[int] = [1, 2, 3]

t: Type[int] = float
</code></pre><p>То с версии 3.9 эти типы доступны в глобальном пространстве:</p><pre><code class="language-python"># From python 3.9

lst: list[int] = [1, 2, 3]
t: type[int] = float
</code></pre><p>Приятная и полезная фича.</p><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="https://www.python.org/dev/peps/pep-0585/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">PEP 585 -- Type Hinting Generics In Standard Collections</div><div class="kg-bookmark-description">The official home of the Python Programming Language</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://www.python.org/static/apple-touch-icon-144x144-precomposed.png"><span class="kg-bookmark-author">Python.org</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://www.python.org/static/opengraph-icon-200x200.png"></div></a></figure><h3 id="pep-584-add-union-operators-to-dict">PEP 584 - Add Union Operators To dict</h3><p>В python на сегодня известно, по крайней мере, не менее 4х основных способа смерджить два словаря:</p><pre><code class="language-python"># 1. Simple merge:
merged = d1.copy()
merged.update(d2)

# 2. Unpacking merge:
merged = {**d1, **d2}

# 3. Unpacking again (keys must be strings):
merged = dict(d1, **d2)

# 4. collections.ChainMap. Result is not dict but so.
from collections import ChainMap
merged: ChainMap = collections.ChainMap(d1, d2)
</code></pre><p>Теперь у нас будет пятый вариант для склеивания двух словарей:</p><pre><code class="language-python">merged = d1 | d2
</code></pre><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="https://www.python.org/dev/peps/pep-0584/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">PEP 584 -- Add Union Operators To dict</div><div class="kg-bookmark-description">The official home of the Python Programming Language</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://www.python.org/static/apple-touch-icon-144x144-precomposed.png"><span class="kg-bookmark-author">Python.org</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://www.python.org/static/opengraph-icon-200x200.png"></div></a></figure><p>Мое отношение к этой фиче? Полезно, не сказать что это биг дил, но полезно.</p><p>В следующе статье попробую реализовать эту фичу на Python 3.8, заодно поглубже узнать возможности питона...</p><figure class="kg-card kg-bookmark-card"><a class="kg-bookmark-container" href="/merge-dict-like-python39/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">Используем фичи Python 3.9 в Python 3.8 - пишем полифил</div><div class="kg-bookmark-description">Разбираемся как расширить built-in классыВ Python 3.9 заявлена новая фича: новый синтаксис мерджа двух и более словарей.Если раньше мы писали: # 1. Basic merge:merged &#x3D; d1.copy()merged.update(d2) # 2. Unpacking merge:merged &#x3D; {**d1, **d2} То в Python 3.9 можно будет писать так: merged &#x3D; d1 …</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://tech.geekjob.ru/favicon.png"><span class="kg-bookmark-author">Geekjob Tech</span><span class="kg-bookmark-publisher">Александр Майоров</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://tech.geekjob.ruhttps://raw.githubusercontent.com/geekjob/gatsby-starter-blog/main/content/images/2020/06/--------------2020-06-13---21.27.32.png"></div></a></figure><!--kg-card-begin: html--><hr>
<div onclick="likePost();this.innerHTML='Вам спасибо! ?'" class="likeButton">
     ? Лайк, спасибо
</div><!--kg-card-end: html-->


---
title: "Используем фичи Python 3.9 в Python 3.8 - пишем полифил"
date: "2020-06-13T18:27:47.000Z"
description: "Разбираемся как расширить built-in классы В Python 3.9 заявлена новая фича: новый синтаксис мерджа двух и более словарей. Если р"
---

<h2 id="-built-in-">Разбираемся как расширить built-in классы</h2><p>В Python 3.9 заявлена новая фича: новый синтаксис мерджа двух и более словарей. Если раньше мы писали:</p><pre><code class="language-python"># 1. Basic merge:
merged = d1.copy()
merged.update(d2)

# 2. Unpacking merge:
merged = {**d1, **d2}</code></pre><p>То в Python 3.9 можно будет писать так:</p><pre><code class="language-python">merged = d1 | d2

# or

d1 |= d2 # d1 - merged result</code></pre>- <a class="kg-bookmark-container" href="https://www.python.org/dev/peps/pep-0584/"><div class="kg-bookmark-content"><div class="kg-bookmark-title">PEP 584 -- Add Union Operators To dict</div><div class="kg-bookmark-description">The official home of the Python Programming Language</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://www.python.org/static/apple-touch-icon-144x144-precomposed.png"><span class="kg-bookmark-publisher">Python.org</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://www.python.org/static/opengraph-icon-200x200.png"></div></a> <br/>
<p>Вроде круто, вау. Но если задуматься, тут нет рокет сайнаса. Более того, вы можете использовать этот синтаксис уже сегодня, сделав свой полифил и начинать использовать такой синтаксис прямо сейчас в Python 3.8</p><p>Как? Сейчас разберемся.</p><h3 id="-">Перегрузка операторов</h3><p>В Python есть крутая фича - перегрузка операторов, благодаря чему можно творить чудеса с языком и создавать свои DSL. Собственно как реализовать поведение для вышеописанных фич? Берем код из самого пепа:</p><pre><code class="language-python">def __or__(self, other):
    if not isinstance(other, dict):
        return NotImplemented
    new = dict(self)
    new.update(other)
    return new

def __ror__(self, other):
    if not isinstance(other, dict):
        return NotImplemented
    new = dict(other)
    new.update(self)
    return new

def __ior__(self, other):
    dict.update(self, other)
    return self</code></pre><h3 id="-python39dict">Пишем свой вариант словаря Python39Dict</h3><pre><code class="language-python"> class Python39Dict(dict):
    def __or__(self, other):
        if not isinstance(other, dict):
            return NotImplemented
        new = dict(self)
        new.update(other)
        return new

    def __ror__(self, other):
        if not isinstance(other, dict):
            return NotImplemented
        new = dict(other)
        new.update(self)
        return new

    def __ior__(self, other):
        dict.update(self, other)
        return self

    # end MyDict #


def main():
    d1 = Python39Dict({
        "f1": 123,
        "f2": "abc"
    })
    d2 = Python39Dict({
        "b1": 456,
        "b2": "def"
    })

    d3 = d1 | d2
    print(d3)
    d1 |= d2
    print(d1)
    # end main #


if __name__ == "__main__":
    main()
</code></pre><p>Супер! Все работает, мы получили на выходе:</p><pre><code class="language-python">{'f1': 123, 'f2': 'abc', 'b1': 456, 'b2': 'def'}
{'f1': 123, 'f2': 'abc', 'b1': 456, 'b2': 'def'}
</code></pre><p>Но как-то не комильфо же писать каждый раз <code>Python39Dict({})</code> да? А можем мы добавить эти методы в существующий класс словаря?</p><h3 id="--1">Как добавить метод к существующему классу?</h3><p>Наченм разбираться с базовых вещей, добавим метод к существующему классу:</p><pre><code class="language-python">class A:
    pass

a = A()

def foo(self):
    print('hello world!')

setattr(A, 'foo', foo)
a.foo() # hello world!</code></pre><p>Так, значит мы умеем добавлять методы к существующим классам. Супер, пробуем:</p><pre><code class="language-python">
setattr(dict, '__or__', '__or__')

</code></pre><p>И тут нас ждет неудача, мы получим ошибку:</p><pre><code>
TypeError: can't set attributes of built-in/extension type 'dict'
</code></pre><p>Хм, а что же делать?</p><h2 id="builtins">Builtins</h2><p>Находим, что существует встроенный модуль <code>builtins</code>. Он позволяет модифицировать встроенные объекты.</p><pre><code class="language-python">import builtins


class Python39Dict(dict):
    def __or__(self, other):
        if not isinstance(other, dict):
            return NotImplemented
        new = dict(self)
        new.update(other)
        return new

    def __ror__(self, other):
        if not isinstance(other, dict):
            return NotImplemented
        new = dict(other)
        new.update(self)
        return new

    def __ior__(self, other):
        dict.update(self, other)
        return self

    # end MyDict #


__builtins__.dict = Python39Dict


def main():
    d1 = dict({
        "f1": 123,
        "f2": "abc"
    })
    d2 = dict({
        "b1": 456,
        "b2": "def"
    })

    d3 = d1 | d2
    print(d3)
    d1 |= d2
    print(d1)
    # end main #


if __name__ == "__main__":
    main()
</code></pre><p>Уже лучше, но есть но! Мы должны явно указывать при создании что мы используем словарь и приходится писать слово <code>dict</code>. А можем ли мы и это улучшить? Чтобы словари выглядели нативно?</p><h3 id="-forbiddenfruit">Запретный плод - forbiddenfruit</h3><p>Да, запретный плод сладок и его не следует трогать и злоупотреблять, но если очень надо...</p><p>Устанавливаем модуль <code>forbiddenfruit</code> и пишем следующий код:</p><pre><code class="language-python">from forbiddenfruit import curse


def dict_or(self, other):
    if not isinstance(other, dict):
        return NotImplemented
    new = dict(self)
    new.update(other)
    return new


def dict_ior(self, other):
    dict.update(self, other)
    return self


curse(dict, "__or__", dict_or)
curse(dict, "__ior__", dict_ior)


def main():
    d1 = {
        "f1": 123,
        "f2": "abc"
    }
    d2 = {
        "b1": 456,
        "b2": "def"
    }

    d3 = d1 | d2
    print(d3)
    d1 |= d2
    print(d1)
    # end main #


if __name__ == "__main__":
    main()
</code></pre><p>Воу воу! Работает! Оформляем как модуль, выносим код в файл <code>python39dict</code> и теперь можем подключить новый синтаксис слияния словарей к проекту:</p><pre><code class="language-python">import python39dict

d1 = {
    "f1": 123,
    "f2": "abc"
}
d2 = {
    "b1": 456,
    "b2": "def"
}

d3 = d1 | d2
print(d3)
d1 |= d2
print(d1)
</code></pre><p>Ну вот и все. Как видите, вы можете пробовать расширять язык, даже если в нем нет каких-то готовых фич и некоторые фичи даже предлагать сообществу, которые могут в итоге попасть в спецификацию и в язык. Конечно слияние объектов в Python 3.9 будет реализовано на уровне языка в коде на С, а не через питон, и работать будет явно быстрее и безопаснее. Но вы можете пробовать добавлять новые фичи таким вот образом, пока ждете выхода новой версии языка.</p><p>Каждый ваш лайк - это мотивация мне продолжать писать статьи и рассказывать вам интересные вещи из мира программирования. Если статья была полезна, нажмите кнопочку, пожалуйста :)</p><hr>
<div onclick="likePost();this.innerHTML='Спасибо!'" class="likeButton">
     ? Лайк, было полезно ?
</div>


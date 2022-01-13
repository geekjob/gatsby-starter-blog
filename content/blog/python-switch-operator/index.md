---
title: "Python Switch operator"
date: "2020-07-07T09:51:18.00Z"
description: "Полный гайд по реализации switch-case в питоне В Python нет привычного оператора Switch как в других языках и после Java, JavaSc"
---

<h2 id="-switch-case-">Полный гайд по реализации switch-case в питоне</h2><p>В Python нет привычного оператора Switch как в других языках и после Java, JavaScript или PHP переходя на Python бывает непривычно писать логику без switch-case инструкций. Даже в Bash есть case оператор. Но выход есть и не один! Рассмотрим все варианты реализации логики switch-case на Python.</p><p>А еще этот вопрос встречал на собеседованиях. Так что велком под кат, будем разбираться...</p><h2 id="-1-">Вариант 1: Словари</h2><p>Самый простой и распространенный вариант - это использовать словари в качестве switch конструкции:</p><pre><code class="language-python">
x = 'bar'

switch = {
    'foo': 123,
    'bar': 456,
    'buz': 789,
}[x]

print(switch)</code></pre><p>Логика проста: мы обращаемся к нужному нам значению через ключ словаря. Такой же подход можно использовать и в других языках, например в JavaScript:</p><pre><code class="language-javascript">
let x = 'bar'

let switch = {
    'foo': 123,
    'bar': 456,
    'buz': 789,
}[x] ?? null

console.log(switch)</code></pre><p>Заметили разницу? Её почти нет. Обратили внимание что мы использовали Nullish Coalescing оператор? Это на случай если обратимся к несуществующему ключу. А в Python как быть?</p><p>Да, в Python есть что-то похожее:</p><pre><code class="language-python">
x = 'wtf'

switch = {
    'foo': 123,
    'bar': 456,
    'buz': 789,
}[x] or Null

# Traceback (most recent call last):
#   File "switch.py", line 3, in &lt;module&gt;
#     switch = {
# KeyError: 'wtf'</code></pre><p>Но, к сожалению, в таком варианте условие не успеет отработать и будет ошибка. Но у словаря уже есть метод <code>get</code> который вернет None в случае отсутствия ключа:</p><pre><code class="language-python">
x = 'wtf'

switch = {
     'foo': 123,
     'bar': 456,
     'buz': 789,
 }.get(x)</code></pre><p>Мы так же можем использовать условия и писать такие конструкции:</p><pre><code class="language-python">
def get_size_text(x: int):
    return {
        x &lt; 10: 'Small',
        10 &lt;= x &lt; 20: 'Medium',
        20 &lt;= x: 'Big'
    }[True]


print(get_size_text(13))
</code></pre><p>Но это еще не все.</p><h2 id="-">Классы</h2><p>Тут уже на что хватит фантазии, но по сути все варианты сводятся к следующим нескольким идеям.</p><h3 id="-chaining-">Идея с цепочками (chaining)</h3><p>Мы можем написать такой простенький класс:</p><pre><code class="language-python">class Switch:
    def __init__(self, val):
        self.val = val

    def case(self, val, f):
        if self.val == val:
            f()
        return self


def switch_foo():
    print('Foo')


def switch_bar():
    print('Bar')


def switch_buz():
    print('Buz')


x = 'bar'

Switch(x) \
    .case('foo', switch_foo) \
    .case('bar', switch_bar) \
    .case('buz', switch_buz)
</code></pre><p>Громоздко, конечно, но можно делать более сложную логику.</p><p>Другой вариант:</p><pre><code class="language-python">
class switch(object):
    def __init__(self, val):
        self.emp = False
        self.val = val

    def __iter__(self):
        yield self.match
        raise StopIteration

    def match(self, *args):
        if self.emp or not args:
            return True
        elif self.val in args:
            self.emp = True
            return True
        return False


x = 2

for case in switch(x):
    if case(1):
        print('Foo')
    if case(2):
        print('Bar')
        break
    if case(3):
        print('Buz')
    # default
    if case():
        print('Default')
</code></pre><p>Честно говоря уже too much. Но если хочется чего-то эдакого...</p><h2 id="--1">Тернарный оператор</h2><p>Конечно привычного тернарного оператора в Python так же нет, но есть возможность писать короткие условные конструкции. Так что мы могли бы написать такой блок, выполняющий роль switch-case:</p><pre><code class="language-python">
x = 5

switch = (
	(1 == x and 'Foo') or
	(2 == x and 'Bar') or
	(3 == x and 'Buz') or
	None
)

print(switch)</code></pre><p>Минусы такого подхода: легко запутаться и допустить ошибку. Читать такой код даже самому через какое-то время будет сложно. Ну и надо сразу предупредить, что данный способ будет работать только в том случае, если второй аргумент оператора <code>and</code> всегда будет содержать <code>True</code>-выражение, иначе этот блок будет пропускаться.</p><p>Кстати, в PHP можно использовать подобный подход:</p><pre><code class="language-php">&lt;?php

$x = 2;

(
    (1 == $x and $switch = 'Foo') or
    (2 == $x and $switch = 'Bar') or
    (3 == $x and $switch = 'Buz') or
    ($switch = null )
);

print($switch);</code></pre><p>Но это так, оффтоп, да и нецелесообразно. Но ведь можем? Могём!</p><p>Еще бывают варианты на исключениях и другая экзотика. Но это все уже персонально, может быть логика где такие варианты могут быть оправданны.</p><p>Ну и в конце-то концов, никто не отменял просто цепочку <code>if-elif-else</code> . Такая конструкция может оказаться сильно выгоднее как по скорости, так и по читаемости.</p><p><strong>Материалы по теме</strong></p><p><a href="https://docs.python.org/3/faq/design.html#why-isn-t-there-a-switch-or-case-statement-in-python">https://docs.python.org/3/faq/design.html#why-isn-t-there-a-switch-or-case-statement-in-python</a></p>


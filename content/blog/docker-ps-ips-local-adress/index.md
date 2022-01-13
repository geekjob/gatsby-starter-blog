---
title: "Выводим IP адреса в docker ps"
date: "2021-07-27T15:31:36.000Z"
description: "Мне нужно иногда получать локальные адреса докер контейнеров. Да, есть команда,
для получения такового:

$ docker inspect -f '{{"
---

<p>Мне нужно иногда получать локальные адреса докер контейнеров. Да, есть команда, для получения такового:</p><pre><code class="language-bash">$ docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' $container_id</code></pre><p>Но каждый раз такое набирать, да еще и помнить...</p><p>Да, можно сделать алиас или функцию:</p><pre><code class="language-bash">#!/usr/bin/env bash

function dockerip() {
    docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' "$@"
}


dockerip container_name
dockerip container_id</code></pre><p>Но мне хочется сразу чтобы в выводе команды docker ps был локальный IP</p><p>Собственно я для себя написал простейшую обертку <strong>dockerps</strong>, которой пользуюсь вместо docker ps:</p><pre><code class="language-bash">#!/usr/bin/env bash

function dockerip {
    docker inspect -f \
       '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' "$@"
}


printf '%*s\n' "${COLUMNS:-$(tput cols)}" '' | tr ' ' =
#seq -s- $COLUMNS|tr -d '[:digit:]'

i=0
docker ps | while read s
do
  if [ 0 = $i ]
  then
    echo -e "| $s\tLocal IP"
    printf '%*s\n' "${COLUMNS:-$(tput cols)}" '' | tr ' ' -
    ((i=i+1))
  else
    uid=$(echo $s | awk '{print $1}')
    localip=`dockerip $uid`
    if [ ! -z "$localip" ]
    then
      echo -e  "| $s\t$localip"
    else
      echo -e "| $s\tlocalhost"
    fi
  fi
done

printf '%*s\n' "${COLUMNS:-$(tput cols)}" '' | tr ' ' _

#EOF#</code></pre><p>Вывод такой функции выглядит точно так же как оригнал, но в конце дописываются локальные IP адреса:</p><p>Далее все это можно зарядить в алиас или еще куда и пользоваться кастомной командой <strong>dockerps</strong></p>


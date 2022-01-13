---
title: "Простой интерактивный текстовый редактор на Bash"
date: "2020-07-02T14:15:15.00Z"
description: "На случай если даже нет Vim'а Бывало ли у вас такое, что заходите на сервер, а там вообще нет ничего для редактирования текстов?"
---

<h2 id="-vim-">На случай если даже нет Vim'а</h2><p>Бывало ли у вас такое, что заходите на сервер, а там вообще нет ничего для редактирования текстов? От слова совсем, кроме дефолтных команд. На такой случай накатал небольшой текстовый редактор, который поддерживает интерактивный режим.</p><pre><code class="language-bash">#!/usr/bin/env bash

${1:?"Set file for editing or type --help for help"}

if [ "$1" = "--help" ]
then
  cat &lt;&lt;EOF
Usage:
  edit file.name

Commands:
  e      - edit line, type new line for replace current
  r      - remove line
  i      - insert new line
  x/q    - save changes and exit
  ^c     - abort and exit without saving
  Eneter - skip line and go to next
EOF
  exit
fi

if [ ! -f "$1" ]
then
  echo "File $1 not exists!"
  exit 1
fi



echo -n &gt; tmp.file

cmd="s"
starteditline=${2:-1}
line=$starteditline
i=0

mapfile -t rows &lt; "$1"

for row in "${rows[@]}"
do
  if (( 0 &lt; starteditline ))
  then
    ((i++))
    if (( i &lt; starteditline ))
    then
      echo "$row" &gt;&gt; tmp.file
      continue
    fi
  fi

  echo -ne "\e[91m"; printf "%03d" $line; echo -e "\e[95m $row \e[39m"

  if [[ $cmd = [xq] ]]
  then
    echo "$row" &gt;&gt; tmp.file
  else
    read -n 1 -s cmd
    case $cmd in
      "e")
        echo -ne "\e[33m" ; read -r -p "  : " replace ; echo -ne "\e[39m"
        echo "${row//*/$replace}" &gt;&gt; tmp.file
        ;;
      "r")
        echo -ne "\e[91m" ; printf "%03d" $line ; echo -e " line removed \e[39m"
        ;;
      "i")
        echo "$row" &gt;&gt; tmp.file
        echo -ne "\e[95m" ; read -r -p "new line: " newline ; echo -ne "\e[39m"
        echo "$newline" &gt;&gt; tmp.file
        ;;
      *)
        echo "$row" &gt;&gt; tmp.file
        ;;
    esac
  fi

  ((line++))
done

sed -i 's/^\\ / /g' tmp.file
cat tmp.file &gt; "$1" &amp;&amp; rm tmp.file

#EOF#</code></pre><p>Исходники</p>- <a class="kg-bookmark-container" href="https://github.com/geekjobru/xed"><div class="kg-bookmark-content"><div class="kg-bookmark-title">geekjobru/xed</div><div class="kg-bookmark-description">Simple Bash Interactive Text Editor Vim like. Contribute to geekjobru/xed development by creating an account on GitHub.</div><div class="kg-bookmark-metadata"><img class="kg-bookmark-icon" src="https://github.githubassets.com/favicons/favicon.svg"><span class="kg-bookmark-author">geekjobru</span><span class="kg-bookmark-publisher">GitHub</span></div></div><div class="kg-bookmark-thumbnail"><img src="https://avatars0.githubusercontent.com/u/47718589?s=400&amp;v=4"></div></a> <br/>
<p></p>


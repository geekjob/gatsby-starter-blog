---
title: "How to parse YAML string via Bash"
date: "2016-07-18T15:24:49.000Z"
description: "If you like parse YAML via command line (bash or other), you can write script on JS for Nodejs, Ruby, PHP or other… Or you can u"
---

<p>If you like parse YAML via command line (bash or other), you can write script on JS for Nodejs, Ruby, PHP or other… Or you can use ready command line tools. It’s simply.</p><p>Of course you can search the finished tool, or even write your own parser, such as this:</p><pre><code class="language-bash">#!/bin/sh

local prefix=$2
local s='[[:space:]]*' w='[a-zA-Z0-9_]*' fs=$(echo @|tr @ '\034')

sed -ne "s|^\($s\)\($w\)$s:$s\"\(.*\)\"$s\$|\1$fs\2$fs\3|p" \
     -e "s|^\($s\)\($w\)$s:$s\(.*\)$s\$|\1$fs\2$fs\3|p"  $1 |

awk -F$fs '{
   indent = length($1)/2;
   vname[indent] = $2;
   for (i in vname) {if (i &gt; indent) {delete vname[i]}}
   if (length($3) &gt; 0) {
      vn=""; for (i=0; i&lt;indent; i++) {vn=(vn)(vname[i])("_")}
      printf("%s%s%s=\"%s\"\n", "'$prefix'",vn, $2, $3);
   }
}'

# Usage
# yaml_bash_parser.sh any_config.yml "config_"</code></pre><p>This is great, but is it intended to work only with indentations made of two spaces. It’s not problem, you can change this script. But you can do all this even easier and better.</p>
<h4>First step: convert YAML to JSON</h4>
<p>Install Ruby and add to <em>.bashrc</em> code:</p>
<pre>alias yaml2json="ruby -ryaml -rjson -e 'puts JSON.pretty_generate(YAML.load(ARGF))'"</pre>
<p>or write function</p>
<pre>function yaml2json()<br>{<br>    ruby -ryaml -rjson -e <br>         'puts JSON.pretty_generate(YAML.load(ARGF))' $*<br>}</pre>
<p>or write bash script <em>yaml2json</em> and put it into <em>/usr/local/bin</em> directory.</p>
<h4>Second step: parse JSON</h4>
<p>On Linux, there is a command-line JSON processor called <a href="http://list.xmodulo.com/jq.html" target="_blank" rel="noopener noreferrer">jq</a> which does exactly that. Using jq, you can parse, filter, map, and transform JSON-structured data effortlessly.</p>
<h4><strong>Install JQ</strong></h4>
<p><strong>For Debian and Ubuntu</strong></p>
<pre>$ sudo apt-get install jq</pre>
<p><strong>For Centos</strong></p>
<pre>$ sudo yum install jq</pre>
<p>For others see <a href="https://stedolan.github.io/jq/download/" target="_blank" rel="noopener noreferrer">https://stedolan.github.io/jq/download/</a></p>
<h4>How use JQ</h4>
<p>An example JSON Schema:</p>
<pre>$ cat anyfile.json</pre>
<pre>{<br>   "name": "NewHR",<br>   "location": {<br>      "street": "Tverskaya",<br>      "city": "Moscow",<br>      "country": "Russian Federation"<br>   },<br>   "employees": [<br>     {<br>        "name": "Alexander Majorov",<br>        "division": "Engineering"<br>     }<br>   ]<br>}</pre>
<p>To parse a JSON object:</p>
<pre>$ cat anyfile.json | jq ‘.name’</pre>
<pre>"NewHR"</pre>
<p>To parse a nested JSON object:</p>
<pre>$ cat anyfile.json | jq ‘.location.city’</pre>
<pre>"Moscow"</pre>
<p>To parse a JSON array:</p>
<pre>$ cat anyfile.json | jq ‘.employees[0].name’</pre>
<pre>"Alexander Majorov"</pre>
<p>To extract specific fields from a JSON object:</p>
<pre>$ cat anyfile.json | jq ‘.location | {street, city}’</pre>
<pre>{<br>  "street": "Tverskaya",<br>  "city": "Moscow"<br>}</pre>
<h4>Parse YAML</h4>
<p>Write pipe line:</p>
<pre>cat anyfile.yaml | yaml2json | jq 'your query'</pre>
<p>or write bash script and call it with arguments.</p>



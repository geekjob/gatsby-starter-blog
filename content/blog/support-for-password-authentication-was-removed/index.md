---
title: "Support for password authentication was removed"
date: "2021-08-15T17:28:41.000Z"
description: "Если вы работаете с Github и вдруг увидели такое сообщение:  > Support for password authentication was removed on August 13, 202"
---

<p>Если вы работаете с Github и вдруг увидели такое сообщение:</p><blockquote>Support for password authentication was removed on August 13, 2021. Please use a personal access token instead.<br>Please see <a href="https://github.blog/2020-12-15-token-authentication-requirements-for-git-operations/">https://github.blog/2020-12-15-token-authentication-requirements-for-git-operations/</a> for more information.</blockquote><p>То вот мой рецепт как решить эту проблему.</p><p>Согласно сообщению создаете свой персональный токен, но этого может быть недостаточно. В моем случае была проблема с тем, что нужно было сбросить сначала креденшелы:</p><pre><code class="language-bash">echo url=https://[login]@github.com | git credential reject</code></pre><p>После этого будет заново запрошен логин и пароль, где в качестве пароля вы укажите свой токен. </p><p>Как сгенерить токен? Об этом есть много информации в сети и даже на ютубе.</p><p>А еще вы можете указать каким способом сохранять пароли:</p><pre><code class="language-bash"># on Windows
git config --global credential.helper manager

# on macOS
git config --global credential.helper osxkeychain

# on Linux (if available)
git config --global credential.helper libsecret
# oron Linux if libsecret isn't available
git config --global credential.helper store

# or use cache
git config --global credential.helper cache</code></pre>


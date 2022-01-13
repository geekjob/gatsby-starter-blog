<?php declare(strict_types=1);

$data = json_decode(file_get_contents(__DIR__ . '/dump.json'), true);




foreach ($data['db'][0]['data']['posts'] as $post)
{
    if ($post['status'] != 'published') continue;
    if ($post['slug'] == 'js-emoji') continue;
    if ($post['slug'] == 'untitled-2') continue;

    $record = [
        'text' => $post['html'],
        'description' => mb_substr(
            str_replace('"', '',
                str_replace(
                    "\n", ' ',
                    $post['plaintext']
                )
            ),
            0, 128
        ),
        'date' => preg_replace('~\.000Z$~i', '.00Z', $post['published_at']),
        'title' => mb_substr(
            str_replace('"', '',
                str_replace(
                    "\n", ' ',
                    $post['title']
                )
            ),
            0, 128
        ),
        'slug' => $post['slug']
    ];

    unset($post);

    $dir = __DIR__ . '/blog/' . $record['slug'];
    if (!file_exists($dir)) mkdir($dir);

/*
    $record['text'] = preg_replace_callback(
        '~<figure.*</figure>~is',
        function(array $matches): string
        {
            $s = '';
            if (preg_match_all('~<a.*?</a>~is', $matches[0], $a))
            {
                foreach ($a[0] as $link)
                {
                    $s .= "- $link <br/>\n";
                }
            }
            return $s;
        },
        $record['text']
    );
//*/

//    $record['text'] = preg_replace('~<!--.*?-->~is', '', $record['text']);

    $post_data = <<<MARKDOWN
---
title: "{$record['title']}"
date: "{$record['date']}"
description: "{$record['description']}"
---

{$record['text']}


MARKDOWN;


    $indexmd = $dir . '/index.md';
    file_put_contents($indexmd, $post_data);
}



//EOF//
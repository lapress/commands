<?php

use App\Post;

// You can replace this requiring each file separately
/** @var Illuminate\Filesystem\Filesystem $files */
$files = app('files')->files(__DIR__.'/metaboxes');

foreach ($files as $file) {
    require_once __DIR__.'/metaboxes/'.$file->filename;
}

if (!function_exists('save_metabox_data')) {
    function save_metabox_data($id)
    {
        $post = Post::withoutGlobalScopes()->find($id);
        $data = app('request')->get($post->post_type);

        if (!empty($data)) {
            $post->update();
            $post->saveMeta($data);
        }


    }

    add_action('save_post', 'save_metabox_data');
}

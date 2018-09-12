<?php

use LaPress\Support\WordPress\CustomPostTypeFormatter;
use LaPress\Support\WordPress\CustomPostTypeTaxonomyFormatter;

foreach (config('wordpress.posts.types', []) as $name => $postType) {

    if (!empty($postType)) {
        $options = [];
        if (is_array($postType)) {
            $options = !empty($postType['options']) ? $postType['options'] : [];
            $postType = $postType['model'];
        }

        ${$name} = new CPT(
            CustomPostTypeFormatter::get($postType),
            array_merge(CustomPostTypeFormatter::getOptions($postType), $options)
        );
    }
}

foreach (config('wordpress.posts.taxonomies', []) as $postType => $taxonomies) {
    foreach ($taxonomies as $taxonomy => $options) {
        ${$postType}->register_taxonomy(
            CustomPostTypeTaxonomyFormatter::get($taxonomy, $options)
        );
    }
}

<?php

namespace LaPress\Commands\Services;

/**
 * @author Sebastian Szczepański
 * @copyright Ably
 */
class Theme
{
    /**
     * @param string $directoryName
     */
    public function link(string $directoryName)
    {
        app('files')->link(
            resource_path('themes/'.$directoryName.'/public'),
            storage_path('wordpress/wp-content/themes/'.$directoryName)
        );
    }

    /**
     * @param string $directoryName
     */
    public function linkPublic(string $directoryName)
    {
        app('files')->link(
            resource_path('themes/'.$directoryName.'/public'),
            public_path($directoryName)
        );
    }
}

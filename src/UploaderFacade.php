<?php

namespace IBekzod\Uploader;

use Illuminate\Support\Facades\Facade;

/**
 * @see \IBekzod\Uploader\Skeleton\SkeletonClass
 */
class UploaderFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'uploader';
    }
}

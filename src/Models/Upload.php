<?php

namespace IBekzod\Uploader\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
    protected $guarded = ['id'];

    protected $connection = config('uploader.connection');
    public function getFilePathAttribute(){
        return Storage::temporaryUrl($this->path, now()->addMinutes(10));
    }
}

<?php

namespace IBekzod\Uploader\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
    protected $guarded = ['id'];

    public function getFilePathAttribute(){
        return Storage::temporaryUrl($this->path, now()->addMinutes(10));
    }
}

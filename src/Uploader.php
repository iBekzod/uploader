<?php

namespace IBekzod\Uploader;

use IBekzod\Uploader\Models\Upload;
use IBekzod\Uploader\Exceptions\UploadNotFoundException;

class Uploader
{
    protected Upload $upload;
    public function getUpload()
    {
        if (!isset($this->upload)) {
            throw new UploadNotFoundException('Upload has not been set yet');
        }
        return $this->upload;
    }
    public function setUpload(Upload $upload)
    {
        if (isset($upload)) {
            $this->upload = $upload;
        } else {
            throw new UploadNotFoundException('Upload not found');
        }
        return $this;
    }

    public function setUploadById($upload_id)
    {
        if ($upload = Upload::where('id', $upload_id)->first()) {
            $this->setUpload($upload);
        } else {
            throw new UploadNotFoundException('Upload not found');
        }
        return $this;
    }

    public function uploadAttachment($attachment, $type = 'file')
    {
        // $public_path = public_path() . DIRECTORY_SEPARATOR;
        $file_path = 'uploads' . DIRECTORY_SEPARATOR . $type;
        // if (!is_dir($public_path . $file_path)) {
        //     mkdir($public_path . $file_path, 0777, true);
        // }
        $upload = new Upload;
        $upload->type = $type;
        $upload->path = $attachment->store($file_path);
        $upload->name = $attachment->getClientOriginalName();
        $upload->size = $attachment->getSize();
        $upload->extension = strtolower($attachment->getClientOriginalExtension());
        if ($upload->save()) {
            $this->setUpload($upload);
        }
        return $this;
    }

    public function removeUpload()
    {
        $upload = self::getUpload();
        if (@unlink(public_path() . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $upload->path))) {
            $upload->delete();
        } else {
            throw new UploadNotFoundException('Uploaded file path not found');
        }
        return $this;
    }
}

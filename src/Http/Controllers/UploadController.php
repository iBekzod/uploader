<?php

namespace IBekzod\Uploader\Http\Controllers;

use IBekzod\Uploader\Exceptions\UploadNotFoundException;
use IBekzod\Uploader\Http\Requests\PaginationRequest;
use IBekzod\Uploader\Http\Requests\UploadDestroyRequest;
use IBekzod\Uploader\Http\Requests\UploadShowRequest;
use IBekzod\Uploader\Http\Requests\UploadStoreRequest;
use IBekzod\Uploader\Http\Requests\UploadUpdateRequest;
use IBekzod\Uploader\Http\Responses\UploadResource;
use IBekzod\Uploader\Models\Upload;
use IBekzod\Uploader\Uploader;


class UploadController extends Controller
{
    private Uploader $uploader;

    public function __construct()
    {
        $this->uploader = new Uploader;
    }
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request  $request
     *
     */
    public function index(PaginationRequest $request)
    {
        return $this->paginated(UploadResource::class, Upload::query()->paginate($request->post('limit')));
    }

    public function show(UploadShowRequest $request)
    {
        try {
            $upload = $this->uploader->setUploadById($request->post('id'))->getUpload();
        } catch (UploadNotFoundException $th) {
            return $this->error($th->getMessage(), 404);
        } catch (\Exception $th) {
            return $this->error($th->getMessage(), 400);
        }
        return $this->singleItem(UploadResource::class, $upload);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(UploadStoreRequest $request)
    {
        try {
            $request->validated();
            $upload = $this->uploader->uploadAttachment($request->file('attachment'), $request->type)->getUpload();
        } catch (UploadNotFoundException $th) {
            return $this->error($th->getMessage(), 404);
        } catch (\Exception $th) {
            return $this->error($th->getMessage(), 400);
        }
        return $this->singleItem(UploadResource::class, $upload, 201);
    }

    /**
     * Update resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function update(UploadUpdateRequest $request)
    {
        try {
            $data = $request->validated();
            $upload = $this->uploader->setUploadById($request->post('id'))->removeUpload()->uploadAttachment($data->attachment, $request->type)->getUpload();
        } catch (UploadNotFoundException $th) {
            return $this->error($th->getMessage(), 404);
        } catch (\Exception $th) {
            return $this->error($th->getMessage(), 400);
        }
        return $this->singleItem(UploadResource::class, $upload, 202);
    }

    /**
     * Delete resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function destroy(UploadDestroyRequest $request)
    {
        try {
            $this->uploader->setUploadById($request->post('id'))->removeUpload();
        } catch (UploadNotFoundException $th) {
            return $this->error($th->getMessage(), 404);
        } catch (\Exception $th) {
            return $this->error($th->getMessage(), 400);
        }
        return abort(204);
    }
}

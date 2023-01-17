<?php

namespace App\Domains\Photo\Controllers;

use App\Domains\Photo\Actions\GetAllPhotoAction;
use App\Domains\Photo\Actions\GetPhotoByIdAction;
use App\Domains\Photo\Actions\UploadNewPhotoAction;
use App\Domains\Photo\Jobs\RemoveFilePhotoJob;
use App\Domains\Photo\Requests\StorePhotoRequest;
use App\Domains\Photo\Resources\PhotoCollection;
use App\Domains\Photo\Resources\PhotoResource;
use App\Domains\Utils\Response;
use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ApiPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = request('page');
        $photos = new GetAllPhotoAction;

        $photos = ! empty($page) ?
            $photos(Photo::CACHE_KEY.'_page_'.$page) :
            $photos();

        return new PhotoCollection($photos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhotoRequest $request)
    {
        $data = (new UploadNewPhotoAction)($request);

        return new PhotoResource($data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $photo = (new GetPhotoByIdAction)($id);

        return new PhotoResource($photo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        $photo = (new GetPhotoByIdAction)($id);

        if(!empty($photo->id)){
            dispatch(new RemoveFilePhotoJob($photo));
        }

        return new PhotoResource($photo);
    }
}

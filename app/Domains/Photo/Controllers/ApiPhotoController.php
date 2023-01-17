<?php

namespace App\Domains\Photo\Controllers;

use App\Domains\Photo\Actions\GetAllPhotoAction;
use App\Domains\Photo\Actions\UploadNewPhotoAction;
use App\Domains\Photo\Actions\UploadPhotoAction;
use App\Domains\Photo\Resources\PhotoCollection;
use App\Domains\Photo\Resources\PhotoResource;
use App\Domains\Utils\Response;
use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ApiPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $page = request('page');
        $photos = new GetAllPhotoAction;

        $photos = !empty($page) ?
            $photos(Photo::CACHE_KEY . '_page_' . $page) :
            $photos();

        return new PhotoCollection($photos);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'photo' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ]);

        $user = Auth::user();

        $path = $request->file('photo')->store($user->id);
        $photo_id = Str::uuid();

        $request = $request->only(['title', 'description']);
        dispatch(new UploadNewPhotoAction($user, $request, $path, $photo_id));

        $data = (object) [
            'photo_id' => $photo_id,
            'title' => $request['title'],
            'path' => $path,
            'description' => $request['description'] ?? null,
            'user' => $user
        ];
        return new PhotoResource($data);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

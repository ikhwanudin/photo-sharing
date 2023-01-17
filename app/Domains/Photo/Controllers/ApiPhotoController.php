<?php

namespace App\Domains\Photo\Controllers;

use App\Domains\Photo\Actions\UploadPhotoAction;
use App\Domains\Utils\Response;
use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

//        dispatch(new UploadPhotoAction($request, $user->id));
        $path = $request->file('photo')->store($user->id);

        $photo = new Photo([
            'title' => $request->title,
            'description' => $request->description ?? null,
            'path' => $path
        ]);

        $user->photos()->save($photo);

        return response()->json(Response::success($photo->toArray()));

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
     * @param \Illuminate\Http\Request $request
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

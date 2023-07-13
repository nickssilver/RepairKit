<?php

namespace App\Http\Controllers\Api\Media;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Media\StoreImageRequest;
use App\Http\Resources\Media\FileResource;
use App\Models\Media;
use Auth;
use Illuminate\Http\JsonResponse;
use Str;

class MediaController extends ApiController
{

    /**
     * Media saving process
     *
     * @param StoreImageRequest $request request
     *
     * @return JsonResponse
     */
    public function store(StoreImageRequest $request): JsonResponse
    {
        $image = $request->file('file');
        $extension = Str::lower($image->getClientOriginalExtension());
        $file = Media::create(
            [
                'uuid' => Str::uuid(),
                'name' => $image->getClientOriginalName(),
                'size' => $image->getSize(),
                'mime' => $image->getMimeType(),
                'extension' => $extension,
                'disk' => 'public',
                'path' => date('Y') . '/' . date('m'),
                'server_name' => bcrypt($image->getRealPath()) . '.' . $extension,
                'user_id' => Auth::id(),
            ]
        );
        if ($file && $image->storeAs($file->path, $file->server_name, $file->disk)) {
            return response()->json(new FileResource($file));
        }
        return response()->json(
            ['message' => __('Something went wrong try again !')],
            500
        );
    }

    /**
     * Display specific media file
     *
     * @param Media $media file
     *
     * @return JsonResponse
     */
    public function show(Media $media): JsonResponse
    {
        return response()->json(new FileResource($media));
    }
}

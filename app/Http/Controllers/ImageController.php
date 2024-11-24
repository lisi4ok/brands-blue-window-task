<?php

namespace App\Http\Controllers;

use App\Interfaces\HasImageInterface;
use App\Interfaces\ImageInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ImageController extends Controller
{
    /**
     * Delete the current model's images.
     */
    public function destroy(Request $request, int $id): RedirectResponse
    {
        if ($request->model instanceof HasImageInterface) {
            $request->model->findOrFail($id)->deleteImage();

            return back(303)->with('status', 'image-deleted');
        }

        if ($request->model instanceof ImageInterface) {
            $request->model->findOrFail($id)->deleteImages();

            return back(303)->with('status', 'images-deleted');
        }

        return back(404)->with('status', 'image-not-found');
    }
}

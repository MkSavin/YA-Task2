<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotesController extends Controller
{
    /*
     *
        Route::get('/notes', 'NotesController@list');
        Route::post('/notes', 'NotesController@insert');
        Route::get('/notes/{id}', 'NotesController@first');
        Route::put('/notes/{id}', 'NotesController@update');
        Route::delete('/notes/{id}', 'NotesController@delete');
     * */

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request)
    {
        if (!isset($request->query)) {
            return $this->success(Note::all());
        } else {
            return $this->success(Note::where('title', $request->query)->orWhere('content', $request->query)->get());
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function first(Request $request, $id)
    {
        return $this->success(Note::findOrFail($id));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function insert(Request $request)
    {
        if ($note = (new Note())->store($request)) {
            return $this->success($note);
        } else {
            return $this->error('Can not insert new note');
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        if ($note = (new Note())->put($request)) {
            return $this->success($note);
        } else {
            return $this->error('Can not update note');
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request)
    {
        if ($request->id && $note = Note::findOrFail($request->id)->delete()) {
            return $this->success([
                'result' => true,
            ]);
        } else {
            return $this->error('Can not delete note');
        }
    }
}

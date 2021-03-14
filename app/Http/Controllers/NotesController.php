<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class NotesController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request)
    {
        if (empty($request->get('query'))) {
            $notes = Note::all();

            // file: /config/task.php
            $n = Config::get('task.n');

            $notes->transform(function ($item) use ($n) {
                $item->content = mb_substr($item->content, 0, $n);
                return $item;
            });

            return $this->success($notes);
        } else {
            return $this->success(Note::where('title', $request->get('query'))->orWhere('content', $request->get('query'))->get());
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

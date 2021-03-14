<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class Note extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'id',
        'content',
    ];

    public function store(Request $request)
    {
        $fields = $request->only($this->fillable);

        if ($created = self::create($fields))
        {
            return $created;
        }

        return false;
    }

    public function put(Request $request)
    {
        if (!isset($request->id))
        {
            return false;
        }

        if ($updated = Note::findOrFail($request->id)->update($request->only($this->fillable)))
        {
            return Note::findOrFail($request->id);
        }

        return false;
    }

}

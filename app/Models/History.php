<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    public $table = 'history';

/*    protected $appends = [
        'history',
    ];*/

    protected $guarded = array();

    protected $fillable = [
        'type',
        'notes',
        'user_id',
        'updated_at'
    ];

    public function users()
    {
        return $this->hasMany('App\Model\User');
    }

    // just records something
    public static function insertEvent($user = null, $type = null, $description = null)
    {
        $history = new History();
        $history->type = $type;
        $history->user_id = $user;
        $history->notes = $description;
        $history->updated_at = \Carbon\Carbon::now()->toDateTimeString();;
        $history->created_at = \Carbon\Carbon::now()->toDateTimeString();;
        $history->save();
    }
}
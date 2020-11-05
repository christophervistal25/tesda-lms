<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StudentActivityLog extends Model
{
    protected $fillable = ['user_id', 'perform'];

    public static function view(int $id, string $perform)
    {
    	$record = self::where(['user_id' => $id, 'perform' => strtolower($perform)])->first();
    	if ($record) {
    		$isPastOneDay = Carbon::now()->diffInDays($record->created_at) >= 1;
    		if ($isPastOneDay) {
    			return self::create(['user_id' => $id, 'perform' => $perform]);
    		}
    	} else
    		return self::create(['user_id' => $id, 'perform' => $perform]);
    }
}

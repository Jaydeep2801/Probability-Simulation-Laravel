<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Prize extends Model
{

    protected $guarded = ['id'];

    protected $fillable = ['title','probability', 'alloted'];

    /**
     * Allots the prizes
     * 
     * @return App\Models\Prize
     * */
    public static function nextPrize()
    {
        $randomNumber = rand(0, 100);

        $allocatedProbability = 0;
        foreach (Prize::orderBy('probability', 'asc')->get() as $prize) {
            $allocatedProbability += $prize->probability;
            if ($allocatedProbability >= $randomNumber) {
                $prize->alloted++;
                $prize->save();
                return $prize;
            }
        }

        $lastPrize = Prize::orderBy('probability', 'desc')->first();
        $lastPrize->alloted++;
        $lastPrize->save();
        return $lastPrize;
    }
}

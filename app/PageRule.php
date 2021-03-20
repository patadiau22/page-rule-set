<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PageRule extends Model
{
    //
    public $table = "page_rule";
    public $fillable = ['show_on', 'rule', 'rule_text','created_by'];

    public static $showOnArr = ['1'=> 'Show On','2'=>'Dont\'t show on'];
    public static $ruleArr = ['1'=> 'pages that contain','2'=>'a specific page','3'=>'pages starting with','4'=>'pages ending with'];


    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
        });

        
    }
}

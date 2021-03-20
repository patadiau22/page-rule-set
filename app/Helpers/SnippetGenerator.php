<?php


namespace App\Helpers;


use App\PageRule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SnippetGenerator
{

    public function __construct()
    {

    }

    private static function createJsFile($content){
        $filename = Str::random().".js";
        Storage::disk('public')->put($filename,$content);
        return $filename;
    }

    public static function generateJs($data){
        $jsString = "(function(){";
        $jsString .= "var url_path = window.location.pathname.substring(1);";
        $orConditionShow = '';
        $orConditionNotShow = '';
        foreach($data as $key => $val){
            
            if($val['show_on'] == 1 && in_array($val['rule'],[1,2])){
                if($orConditionShow == '')
                    $orConditionShow .= '( new String(url_path).valueOf() == new String("'.$val['rule_text'].'").valueOf() ) ';
                else 
                    $orConditionShow .= '|| ( new String(url_path).valueOf() == new String("'.$val['rule_text'].'").valueOf() ) ';
            }
            
            if($val['show_on'] == 2 && in_array($val['rule'],[1,2])){
                if($orConditionNotShow == '')
                    $orConditionNotShow .= '( new String(url_path).valueOf() == new String("'.$val['rule_text'].'").valueOf() ) ';
                else
                    $orConditionNotShow .= '|| ( new String(url_path).valueOf() == new String("'.$val['rule_text'].'").valueOf() ) '; 
            }

            if($val['show_on'] == 1 && $val['rule'] == 3){
                if($orConditionShow == '')
                    $orConditionShow .= '( url_path.substring(0, ("'.$val['rule_text'].'").length) == "'.$val['rule_text'].'" ) ';
                else 
                    $orConditionShow .= '|| ( url_path.substring(0, ("'.$val['rule_text'].'").length) == "'.$val['rule_text'].'" ) ';
            }
            if($val['show_on'] == 2 && $val['rule'] == 3){
                if($orConditionNotShow == '')
                    $orConditionNotShow .= '( url_path.substring(0, ("'.$val['rule_text'].'").length) == "'.$val['rule_text'].'" ) ';
                else 
                    $orConditionNotShow .= '|| ( url_path.substring(0, ("'.$val['rule_text'].'").length) == "'.$val['rule_text'].'" ) ';
            }


            if($val['show_on'] == 1 && $val['rule'] == 4){
                if($orConditionShow == '')
                    $orConditionShow .= '( url_path.substring(url_path.length - ("'.$val['rule_text'].'").length) == "'.$val['rule_text'].'" ) ';
                else 
                    $orConditionShow .= '|| ( url_path.substring(url_path.length - ("'.$val['rule_text'].'").length) == "'.$val['rule_text'].'" ) ';
            }
            if($val['show_on'] == 2 && $val['rule'] == 4){
                if($orConditionNotShow == '')
                    $orConditionNotShow .= '( url_path.substring(url_path.length - ("'.$val['rule_text'].'").length) == "'.$val['rule_text'].'" ) ';
                else 
                    $orConditionNotShow .= '|| ( url_path.substring(url_path.length - ("'.$val['rule_text'].'").length) == "'.$val['rule_text'].'" ) ';
            }
        }
        
        if($orConditionShow != ''){
            $jsString .= 'if( '.$orConditionShow.' ){';
            $jsString .=  'alert("hello world!");';
            $jsString .= '}';
        }
        if($orConditionNotShow != ''){
            $jsString .= 'if( '.$orConditionNotShow.' ){';
            $jsString .=  'console.log("Nothing to show");';
            $jsString .= '}';
        }
        $jsString .= "})();";    
        return $jsString;
    }

    public static function getSnippet($data){
        $jsContent = self::generateJs($data);
        if($jsContent != ''){
            $filename = self::createJsFile($jsContent);
            return '<script src="'.url(Storage::url($filename)).'"></script>';
        } 
    }



}

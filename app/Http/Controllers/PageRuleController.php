<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\PageRule;
use App\Helpers\SnippetGenerator;

class PageRuleController extends Controller
{
    //

    /**
     * Save 
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'addmore.*.show_on' => 'required',
            'addmore.*.rule' => 'required',
            'addmore.*.rule_text' => 'required',
        ]);
        
        $codeSnippet = SnippetGenerator::getSnippet($request->addmore);
        if($codeSnippet != ''){
            PageRule::where("created_by", Auth::user()->id)->delete();
            foreach ($request->addmore as $key => $value) {
                PageRule::create($value);
            }
            return view('copy_snippet',['codeSnippet'=>$codeSnippet])->with('success', 'Code Snippet Generated Successfully.');
        } else {
            return back()->with('error', 'Something went wrong. Please try after sometime !!!');
        }

        
        
        
    }
}

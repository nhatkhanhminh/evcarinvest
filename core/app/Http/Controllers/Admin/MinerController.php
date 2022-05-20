<?php

namespace App\Http\Controllers\Admin;

use App\Feature;
use App\Http\Controllers\Controller;
use App\Miner;
use App\Plan;
use Illuminate\Http\Request;

class MinerController extends Controller
{
    public function index()
    {
        if(request()->has('search') && request()->search ){
            $key            = trim(strtolower(request()->search));
            $miners         = Miner::where('name', 'LIKE', "%$key%")->orWhere('coin_code', 'LIKE',"%$key%")->with('plans')->latest()->paginate(getPaginate());
        }else{
            $miners         = Miner::with('plans')->latest()->paginate(getPaginate());
        }

        $page_title     = "All Miners";
        $empty_message  = "No Miner Yet";
        return view('admin.miner.index', compact('page_title', 'empty_message', 'miners'));
    }

    public function plans($id)
    {
        $plans          = Plan::where('miner_id', $id)->paginate(getPaginate());
        $this_miner     = Miner::find($id);
        $miners         = Miner::orderBy('name')->paginate(getPaginate());
        $features       = Feature::orderBy('name')->paginate(getPaginate());

        $page_title     = "All Plans For ". $this_miner->name;
        $empty_message  = "No Plan Yet";
        return view('admin.miner.plans', compact('page_title', 'empty_message', 'plans', 'features', 'miners', 'this_miner'));
    }

    public function store(Request $request)
    {
        $validation_rule = [
            'name'                      => 'required|string|max:100|unique:miners,name',
            'coin_code'                 => 'required|string|max:20|unique:miners,coin_code',
            'minimum_withdrawal_limit'  => 'required|numeric',
            'maximum_withdrawal_limit'  => 'required|numeric|gt:minimum_withdrawal_limit'
        ];

        $miner = new Miner();

        $request->validate($validation_rule);


        $miner->name                = $request->name;
        $miner->coin_code           = $request->coin_code;
        $miner->min_withdraw_limit  = $request->minimum_withdrawal_limit;
        $miner->max_withdraw_limit  = $request->maximum_withdrawal_limit;
        $miner->save();
        $notify[] = ['success', 'Miner Created Successfully'];

        return redirect()->back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $validation_rule = [
            'name'            => 'required|string|max:100|unique:miners,name,'.$id,
            'coin_code'       => 'required|string|max:20|unique:miners,coin_code,'.$id,
            'minimum_withdrawal_limit'  => 'required|numeric',
            'maximum_withdrawal_limit'  => 'required|numeric|gt:minimum_withdrawal_limit'
        ];

        $miner = Miner::findOrFail($id);
        $notify[] = ['success', 'Miner Updated Successfully'];

        $request->validate($validation_rule);

        $miner->name                = $request->name;
        $miner->coin_code           = $request->coin_code;
        $miner->min_withdraw_limit  = $request->minimum_withdrawal_limit;
        $miner->max_withdraw_limit  = $request->maximum_withdrawal_limit;
        $miner->save();

        return redirect()->back()->withNotify($notify);
    }

}

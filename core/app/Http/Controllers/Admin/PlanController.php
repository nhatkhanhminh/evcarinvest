<?php

namespace App\Http\Controllers\Admin;

use App\Feature;
use App\Http\Controllers\Controller;
use App\Miner;
use App\Order;
use App\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        if(request()->has('search') && request()->search){
            $key            = trim(strtolower(request()->search));
            $plans          = Plan::where('title', 'LIKE', "%$key%")
            ->orWhereHas('miner', function ($product) use ($key) {
                $product->where('name', 'like', "%$key%");
            })
            ->with('miner')->latest()->paginate(getPaginate());
        }else{
            $plans          = Plan::with('miner')->latest()->paginate(getPaginate());
        }

        $miners         = Miner::orderBy('name')->paginate(getPaginate());
        $features       = Feature::orderBy('name')->paginate(getPaginate());

        $page_title     = "All Plans";
        $empty_message  = "No Plan Yet";
        return view('admin.plan.index', compact('page_title', 'empty_message', 'plans', 'features', 'miners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'miner'             => 'required|exists:miners,id',
            'title'             => 'required|string|max:80',
            'price'             => 'required|numeric',
            'return_per_day'    => 'required_if:return_type,1|numeric',
            'min_return_per_day'=> 'required_if:return_type,2|numeric',
            'max_return_per_day'=> 'required_if:return_type,2|numeric',
            'speed'             => 'required|numeric',
            'speed_unit'        => 'required|integer|between:0,8',
            'period'            => 'required|numeric',
            'period_unit'       => 'required|integer|between:0,2',
            'description'       => 'nullable|string',
            'features'          => 'nullable|array',
            'features.*'        => 'string',
            'status'            => 'nullable|regex:(on)'
        ]);

        $plan                       = new Plan();
        $plan->miner_id             = $request->miner;
        $plan->title                = $request->title;
        $plan->price                = $request->price;
        $plan->min_return_per_day   = $request->return_per_day??$request->min_return_per_day;
        $plan->max_return_per_day   = $request->max_return_per_day??null;
        $plan->speed                = $request->speed;
        $plan->speed_unit           = $request->speed_unit;
        $plan->period               = $request->period;
        $plan->period_unit          = $request->period_unit;
        $plan->description          = $request->description;
        $plan->features             = json_encode($request->features);
        $plan->status               = isset($request->status)?1:0;
        $plan->save();

        $notify[] = ['success', 'Plan Created Successfully'];
        return redirect()->back()->withNotify($notify);
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'miner'             => 'required|exists:miners,id',
            'title'             => 'required|string|max:80',
            'price'             => 'required|numeric',
            'return_per_day'    => 'required_if:return_type,1|numeric',
            'min_return_per_day'=> 'required_if:return_type,2|numeric',
            'max_return_per_day'=> 'required_if:return_type,2|numeric',
            'speed'             => 'required|numeric',
            'speed_unit'        => 'required|integer|between:0,8',
            'period'            => 'required|numeric',
            'period_unit'       => 'required|integer|between:0,2',
            'description'       => 'nullable|string',
            'status'            => 'nullable|regex:(on)',
            'features'          => 'nullable|array',
            'features.*'        => 'string'
        ]);

        $plan                       = Plan::findOrFail($id);
        $plan->miner_id             = $request->miner;
        $plan->title                = $request->title;
        $plan->price                = $request->price;
        $plan->min_return_per_day   = $request->return_per_day??$request->min_return_per_day;
        $plan->max_return_per_day   = $request->max_return_per_day??null;
        $plan->speed                = $request->speed;
        $plan->speed_unit           = $request->speed_unit;
        $plan->period               = $request->period;
        $plan->period_unit          = $request->period_unit;
        $plan->description          = $request->description;
        $plan->features             = json_encode($request->features);
        $plan->status               = isset($request->status)?1:0;
        $plan->save();

        $notify[] = ['success', 'Plan Updated Successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function sales()
    {
        if(request()->has('search') && request()->search ){
            $key            = trim(request()->search);
            $sales          = Order::where('trx', $key)->with('user')->latest()->paginate(getPaginate());
        }else{
            $sales          = Order::with('user')->latest()->paginate(getPaginate());

        }

        $page_title     = "All Plans";
        $empty_message  = "No Plan Yet";
        return view('admin.sale.index', compact('page_title', 'empty_message', 'sales'));
    }

}

<?php

namespace App\Http\Controllers;

use App\Mail\EmailConfirmation;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\User;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Subscription;
use Illuminate\Support\Facades\DB;



class PlanController extends Controller
{
    protected $stripe;

    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }

    public function index()
    {
        //$plans = Plan::all();
        //$plans = Plan::whereIn('cycle_type', array('Monthly'))->get();
        ///$subscription = Subscription::orderBy('id')->get();
        $plans = DB::table('plans')
            ->select('plans.id', 'plans.name', 'plans.slug', 'plans.description', 'plans.cost', 'subscriptions.stripe_plan')
            ->leftJoin('subscriptions', 'plans.stripe_plan', '=', 'subscriptions.stripe_plan')
            ->orderBy('plans.id')
            ->get();


        return view('plans.index', compact('plans'));
        //dd($plans);
    }


    public function createPlan()
    {

        return view('plans.create');
    }

    public function storePlan(Request $request)
    {
        $data = $request->except('_token');

        $data['slug'] = strtolower($data['name']);
        $price = $data['cost'] * 100;

        $cycle_interval = $data['plan_type'];

        //create stripe product
        $stripeProduct = $this->stripe->products->create([
            'name' => $data['name'],
        ]);

        //Stripe Plan Creation
        $stripePlanCreation = $this->stripe->plans->create([
            'amount' => $price,
            'currency' => 'usd',
            'interval' => $cycle_interval, //  it can be day,week,month or year
            'product' => $stripeProduct->id,
        ]);

        $data['stripe_plan'] = $stripePlanCreation->id;
        $data['cycle_type'] = $data['plan_type'];



        Plan::create($data);

        return redirect()->route('plans.index');
    }

    public function allplans()
    {

        $plan = $this->stripe->plans->retrieve('plan_IQNZnrTl7VZ8Z7');
        //$update_plan = $this->stripe->plans->update('plan_IUwIrXjYlXIWXx');
        //$price = $this->stripe->prices->retrieve('price_1HrPafLilNYNrshAOV1MmXsh');
        //$product = $this->stripe->products->retrieve('prod_ISKEyrAUsLMKYU');
        //$invoice = $this->stripe->invoices->retrieve('in_1Hw228LilNYNrshALcVx6v2z');

        // return response()->json([
        //     'invoices' => $invoice,
        //     'prices' => $price
        //     'products' => $product,
        // ]);
        dd($plan);
    }

    public function editPlan($id)
    {

        $plan = Plan::findOrFail($id);
        return view('plans.edit', compact('plan'));
    }


    public function updateUpdate(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);
        //$post->update($request->all());
        //$request->all();
        $data = $request->except('_token');
        $update_product = $this->stripe->products->update(
            'prod_IUwIYWKEYh6y2P',
            ['name' => $data['name']]
        );

        //dd($request->all());
        return response()->json($update_product);
    }


    public function sendEmail(Request $request)
    {
        $user = $request->user();

        Mail::to($user->email)->send(new EmailConfirmation);
    }
}

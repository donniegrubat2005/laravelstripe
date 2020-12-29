<?php

namespace App\Http\Controllers;


use App\Mail\EmailConfirmation;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Subscription;

class SubscriptionController extends Controller
{
    protected $stripe;
    protected $childController;

    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }

    public function index()
    {
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $plan = Plan::findOrFail($request->get('plan'));

        $request->user()->newSubscription('default', $plan->stripe_plan)->create($request->token);

        return back();
    }

    public function show(Plan $plan, Request $request)
    {

        $paymentMethods = $request->user()->paymentMethods();

        $intent = $request->user()->createSetupIntent();

        return view('plans.paynow', compact('plan', 'intent'));
        //return view('plans.payment', compact('plan', 'intent'));
    }

    public function subscribe(Request $request)
    {



        $plan = Plan::findOrFail($request->get('plan'));

        $user = User::find(Auth::user()->id);
        $subscription = Subscription::where('user_id', '=', Auth::user()->id);

        $testStripeId = $subscription->count();

        if ($testStripeId != 1) {

            $user = $request->user();
            $paymentMethod = $request->paymentMethod;

            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            $user->newSubscription('default', $plan->stripe_plan)
                ->withCoupon(isset($coupon['name']))
                ->create($paymentMethod, [
                    'email' => $user->email,
                ]);
        } else {
            $couponCode = "Hgew9EYe";
            $user = User::find(Auth::user()->id);
            //$user->subscription('default')->updateStripeSubscription(['coupon' => $couponCode]);
            $user->subscription('default')->swapAndInvoice($plan->stripe_plan)
                ->updateStripeSubscription(['coupon' => $couponCode]);
            //$this->updateCoupon();

        }
        return back();
    }


    public function sendInvoiceReceipt()
    {
        // $invoice = $this->stripe->invoices->retrieve(
        //     'in_1HviQHLilNYNrshApZayaILj',
        //     []
        // );
        $user = User::find(Auth::user()->id);
        //$invoices = $user->invoicesIncludingPending(array('limit' => 1));
        $invoices = $this->stripe->invoices->retrieve('in_1HxComLilNYNrshAskgP5btM');
        //$subscriptionid = $invoices[0]->subscription;
        $subscriptionid = $invoices->subscription;
        $subscription = $this->stripe->subscriptions->retrieve($subscriptionid);
        //return redirect($invoice->hosted_invoice_url);
        // return response()->json($invoice);
        //dd($subscription);
        //dd($invoices);
        //dd($invoices[0]->subscription);
        $test = $this->TransactionContoller->transaction();

        dd($test);
    }

    public function updateCoupon()
    {

        $couponCode = "Hgew9EYe";
        $user = User::find(Auth::user()->id);
        $user->subscription('default')->updateStripeSubscription(['coupon' => $couponCode]);
    }

    public function viewInvoiceReceipt()
    {
        $user = User::find(1);
        //$user = User::where('id', 1)->first();

        //$settings = array('limit' => 1);
        $invoices = $user->invoicesIncludingPending(array('limit' => 1));

        return view('plans.invoices', compact('invoices'));
    }


    public function sendEmail(Request $request)
    {
        $user = $request->user();

        Mail::to($user->email)->send(new EmailConfirmation);

        return new EmailConfirmation();
    }


    public function transaction(Request $request)
    {
        // //$data = $request->except('_token');
        // $user = User::find(1);
        // $invoice = $user->invoicesIncludingPending(array('limit' => 1));
        // //$invoice = $this->stripe->invoiceItems->all(array('limit' => 1));
        // //$invoice_data = $invoice[0]->id;
        // $description = isset($invoice[0]->lines->data[0]->description);
        // $description1 = isset($invoice[0]->lines->data[1]->description) ? $invoice[0]->lines->data[1]->description : '';
        // $price1 = isset($invoice[0]->lines->data[1]->price->unit_amount) ? $invoice[0]->lines->data[1]->price->unit_amount / 100 : 0;
        // $amount1 = isset($invoice[0]->lines->data[1]->amount) ? $invoice[0]->lines->data[1]->amount / 100 : 0;


        // if ($description == true) {
        //     $data = [
        //         'customer'        =>  $invoice[0]->customer,
        //         'customer_email'  =>  $invoice[0]->customer_email,
        //         'description1'    =>  $description1,
        //         'description'     =>  $invoice[0]->lines->data[0]->description,
        //         'currency'        =>  $invoice[0]->currency,
        //         'invoice_number'  =>  $invoice[0]->number,
        //         'discount'        =>  isset($invoice[0]->total_discount_amounts[0]->amount) ? $invoice[0]->total_discount_amounts[0]->amount / 100 : 0,
        //         'price1'          =>  $price1,
        //         'price'           =>  $invoice[0]->lines->data[0]->price->unit_amount / 100,
        //         'amount1'         =>  $amount1,
        //         'amount'          =>  $invoice[0]->lines->data[0]->amount / 100,
        //         'subtotal'        =>  $invoice[0]->subtotal / 100,
        //         'total'           =>  $invoice[0]->total / 100,
        //         'amount_due'      =>  $invoice[0]->amount_due / 100,
        //         'paid'            =>  $invoice[0]->paid,
        //         'url_link'        =>  $invoice[0]->invoice_pdf,
        //     ];
        //     //Transaction::create($data);
        //     dd($invoice);
        //     // } else {
        //     //     return redirect()->route('plans.index');
        //     // }



        return view('plans.invoice');
    }
}

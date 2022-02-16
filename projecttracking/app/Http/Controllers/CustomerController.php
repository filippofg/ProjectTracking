<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class CustomerController extends Controller
{
    /* Costruttore del controller:
     * viene specificato qui il middleware
     * per l'autenticazione, anziché
     * specificarlo nelle routes.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Auth::user()->is_admin, 403, 'Utente non autorizzato');

        $customers = Customer::all();

        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Auth::user()->is_admin, 403, 'Utente non autorizzato');

        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'vat_number'        => 'required|numeric|digits:11',
            'business_name'     => 'required|max:255',
            'referent_name'     => 'required|max:255',
            'referent_surname'  => 'required|max:255',
            'referent_email'    => 'required|email|max:255',
            'ssid'              => 'required|numeric|digits:7|unique:customers,ssid',
            'pec'               => 'required|email|max:255|unique:customers,pec'
        ]);

        if($validator->fails()) {
            return redirect('customer/create')
                ->withErrors($validator)
                ->withInput();
        }

        $customer = Customer::create($input);

        // return redirect('/customer');

        $projects = Project::where('customer_vat_number', $input['vat_number'])->get();

        return view('customer.show', compact('customer', 'projects'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $vat_number
     * @return \Illuminate\Http\Response
     */
    public function show($vat_number)
    {
        //$all = Customer::all();
        //$customer = $all->find($vat_number);
        $customer = Customer::find($vat_number);
        $projects = Project::where('customer_vat_number', $vat_number)->get();

        return view('customer.show', compact('customer', 'projects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $vat_number
     * @return \Illuminate\Http\Response
     */
    public function edit($vat_number)
    {
        abort_unless(Auth::user()->is_admin, 403, 'Utente non autorizzato');

        $customer = Customer::find($vat_number);

        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $vat_number
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vat_number)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'vat_number'        => 'numeric|digits:11',            /* required */
            'business_name'     => 'max:255',           /* required */
            'referent_name'     => 'max:255',           /* required */
            'referent_surname'  => 'max:255',           /* required */
            'referent_email'    => 'email|max:255',     /* required */
            'ssid'              => 'numeric|digits:7',             /* required|unique:customers,ssid */
            'pec'               => 'email|max:255'            /* required|nique:customers,pec */
        ]);

        if($validator->fails()) {
            return redirect("customer/{$vat_number}/edit")
            ->withErrors($validator)
            ->withInput();
        }

        $customer = Customer::find($vat_number);

        if(!$customer)
            return redirect('/customer');

        $customer->update($input);

        return redirect("/customer/{$vat_number}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $vat_number
     * @return \Illuminate\Http\Response
     */
    public function destroy($vat_number)
    {
        $row = Customer::find($vat_number)->delete();

        return json_encode( ['message' => 'ok']);
        //return redirect('/customer');
    }

    public function search(Request $request) {
        $customers = Customer::where('business_name', 'LIKE', '%'.$request->business_name.'%')->get();

        return view('customer.index', compact('customers'));
    }
}

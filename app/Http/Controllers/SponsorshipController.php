<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Sponsorship;
use Braintree\Gateway;
use Braintree\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SponsorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Apartment $apartment)
    {
        $gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'tqcvwgvx389yj3m8',
            'publicKey' => 'sh2nkfvtt3pzfsp6',
            'privateKey' => '22857b34c162952e9161b76d2809ab4f'
        ]);

        // pass $clientToken to your front-end
        $clientToken = $gateway->clientToken()->generate();
        $sponsorships = Sponsorship::all();

        return view('admin.apartments.payments', compact('clientToken', 'sponsorships', 'apartment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Apartment $apartment)
    {
        $data = $request->all();
        $sponsorship = Sponsorship::whereLabel($data['sponsorship'])->first();
        $nonceFromTheClient = $request->payment_method_nonce;
        //$deviceDataFromTheClient = $request->device_data;
        $gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'tqcvwgvx389yj3m8',
            'publicKey' => 'sh2nkfvtt3pzfsp6',
            'privateKey' => '22857b34c162952e9161b76d2809ab4f'
        ]);
        //$result = $gateway->transaction()->sale([
        $result = $gateway->transaction()->sale([
            'amount' => '10',
            'paymentMethodNonce' => $nonceFromTheClient,
            //'deviceData' => $deviceDataFromTheClient,
            'options' => [
                'submitForSettlement' => True
            ]
        ]);

        if ($result->success) {
            if (count($apartment->sponsorships) && Apartment::find($apartment->id)->sponsorships()->max('expire_date') > Carbon::now('Europe/Rome')) {
                $latest_expiration = Apartment::find($apartment->id)->sponsorships()->max('expire_date');
                $start_date = $latest_expiration;
                $expire_date = Carbon::parse($start_date)->addHours($sponsorship->duration);
            } else {
                $start_date = Carbon::now('Europe/Rome');
                $expire_date = Carbon::parse($start_date)->addHours($sponsorship->duration);
            }
            $apartment->sponsorships()->attach($sponsorship, ['start_date' => $start_date, 'expire_date' => $expire_date]);

            // Il pagamento è stato elaborato con successo
            $transactionId = $result->transaction->id;
            return to_route('apartments.show', $apartment->id)->with('message', 'Sponsorizzazione attivata')->with('type', 'success');
        } else {

            // Il pagamento non è riuscito
            $errorMessage = $result->message;
            return back()->with('message', 'pagamento rifiutato')->with('type', 'danger');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sponsorship $sponsorship)
    {
        //
    }
}

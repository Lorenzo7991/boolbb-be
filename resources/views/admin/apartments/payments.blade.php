@extends('layouts.app')
@section('title', 'Sponsorship')
@section('content')
    <form id="payment-form" action="{{ route('sponsorship.store', $apartment->id) }}" method="post">
        @csrf
        <div x-data="{ currentActive: 'Gold' }">
            <h1 class="text-center" x-text="currentActive"> </h1>
            <div class=" row row-cols-3">
              @foreach ($sponsorships as $sponsorship)
              <!--card sponsorizzazione-->
              <div class="col">
                <div class="card text-center">
                  <div class="card-header">
                    {{ $sponsorship->label }}
                  </div>
                  <div class="card-body">
                    <p class="card-text">Durata sponsorizzazione : {{ $sponsorship->duration }}</p>
                    <input x-model="currentActive" x-on:click="currentActive = '{{$sponsorship->label}}'" class="form-check-input border border-danger" type="radio" value="{{$sponsorship->label}}"  name="sponsorship" id="sponsorship-{{$sponsorship->id}}">
                  </div>
                  <div class="card-footer text-body-secondary">
                    Prezzo:{{ $sponsorship->price }}€
                  </div>
                </div>
              </div>
              @endforeach
            </div>
        </div>



        <!--card pagamento-->
        <div id="dropin-container"></div>
        <input type="submit" />
        <input type="hidden" id="nonce" name="payment_method_nonce" />
        <input type="hidden" id="device_data" name="device_data">
    </form>


@endsection

@section('script')

    <script type="text/javascript">
        const form = document.getElementById('payment-form');
        const deviceDataInput = form['device_data'];
        const nonceInput = form['payment_method_nonce'];
        // call 'braintree.dropin.create' code here

        // Step two: create a dropin instance using that container (or a string
        //   that functions as a query selector such as '#dropin-container')
        braintree.dropin.create({
            authorization: '{{ $clientToken }}',
            container: document.getElementById('dropin-container')
            // ...plus remaining configuration
        }, (error, instance) => {
            // if (deviceDataInput == null ){
            //   deviceDataInput = document.createElement('input');
            //   deviceDataInput.name = 'device_data';
            //   deviceDataInput.type = 'hidden';
            //   form.appendChild(deviceDataInput)
            // }
            if (error) {
                console.error(error)
                return
            }
            form.addEventListener('submit', event => {
                event.preventDefault();
                instance.requestPaymentMethod((error, payload) => {
                    if (error) {
                        console.error(error)
                        return
                    }

                    document.getElementById('nonce').value = payload.nonce;
                    //   braintree.dataCollector.create({
                    //     client:braintree.client,
                    //     paypal:braintree.paypal,
                    //     dataCollector:braintree.dataCollector
                    //   },function(dataCollectorErr, dataCollectorInstance){
                    //     if(dataCollectorErr){
                    //       //gestisci l'errore del dataCollector
                    //       return;
                    //     }
                    //      dataCollectorInstance.collectDeviceData(function(collectErr, deviceData ){
                    //      deviceDataInput.value = deviceData;
                    //     })
                    //   }
                    // )
                    form.submit();
                });
            });
        });
    </script>
@endsection

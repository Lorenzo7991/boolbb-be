@extends('layouts.app')
@section('title', 'Sponsorship')
@section('content')
    <form id="payment-form" action="{{ route('sponsorship.store', $apartment->id) }}" method="post">
        @csrf
        <div x-data="{ currentActive: 'gold' }">
            <h1 class="text-center mb-5">Piani di sponsorizzazione</h1>
            <div class=" row row-cols-3" id="sponsorship-cards">
                @foreach ($sponsorships as $sponsorship)
                    <!--card sponsorizzazione-->
                    <div class="col">
                        <div x-on:click="currentActive= '{{ $sponsorship->label }}'"
                            class="card text-center card-{{ $sponsorship->label }} rounded-4 overflow-hidden shadow-lg"
                            :class="currentActive == '{{ $sponsorship->label }}' ? 'active-card' : ''">
                            <div class="card-header text-capitalize fw-bold">
                                <h4>
                                    {{ $sponsorship->label }}
                                </h4>
                            </div>
                            <div class="card-body">
                                <p class="card-text">Metti in evidenza il tuo appartamento per: {{ $sponsorship->duration }}
                                    ore</p>
                                <input x-model="currentActive" class="form-check-input card-radio" type="radio"
                                    value="{{ $sponsorship->label }}" name="sponsorship"
                                    id="sponsorship-{{ $sponsorship->id }}">
                            </div>
                            <div class="card-footer fw-bold">
                                Prezzo: {{ $sponsorship->price }} €
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

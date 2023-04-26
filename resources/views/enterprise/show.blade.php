@extends('master')

@section('content')
    <div class="fs-s"></div>
<div class="container">
    <div class="row m-0">
        <div class="col-md-7 col-12">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="row box-right">
                        <div class="col-md-8 ps-0 ">
                            <div class="fs-s"></div>
                            <p class="ps-3 textmuted fw-bold h6 mb-0">TOTAL TO PAY</p>
                            <p class="h1 fw-bold d-flex"> <span class=" fas fa-dollar-sign textmuted pe-1 h6 align-text-top mt-1">
                                @if($type == 0)
                                    </span>34 <span class="textmuted">.99</span> </p>
                                @elseif($type == 1)
                                    </span>39 <span class="textmuted">.99</span> </p>
                                @else
                                    </span>44 <span class="textmuted">.99</span> </p>
                                @endif
                            <p class="ms-3 px-2 bg-green">Nearly completing order of this subscription.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 px-0 mb-4">
                    <div class="box-right">
                        <div class="d-flex pb-2">
                            <div class="fs-s"></div>
                        </div>
                        <div class="bg-blue p-1">
                            <P class="h8 textmuted ml-3 p-2">Retry payment method if you believe you're seeing this billing issue by mistake.
                                <p class="p-blue bg btn btn-info h8">LEARN MORE</p>
                            </P>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-12 ps-md-5 p-0 ">
            <div class="box-left">
                <p class="textmuted h8">Invoice</p>
                <p class="fw-bold h7">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                <p class="textmuted h8">{{ Auth::user()->zipcode }}, {{ Auth::user()->address }} {{ Auth::user()->street_nr }}</p>
                <p class="textmuted h8 mb-2">{{ Auth::user()->city }}, {{ Auth::user()->country }}</p>
                <div class="h8">
                    <div class="row m-0 border mb-3">
                        <div class="col-6 h8 pe-0 ps-2">
                            <p class="textmuted py-2">Items</p>
                            @if($type == 0)
                            <span class="d-block py-2">DigiDate Enterprise (basic)</span>
                            @elseif($type == 1)
                            <span class="d-block py-2">DigiDate Enterprise (Premium)</span>
                            @else
                            <span class="d-block py-2">Digidate Enterprise (Diamond)</span>
                            @endif
                        </div>
                        <div class="col-2 text-center p-0">
                            <p class="textmuted p-2">Qty</p>
                            <span class="d-block p-2">1</span>
                        </div>
                        <div class="col-4 p-0 text-center h8 border-end">
                            <p class="textmuted p-2">Price</p>
                            @if($type == 0)
                            <span class="d-block py-2"><span class="fas fa-euro-sign"></span>34,99</span>
                            @elseif($type == 1)
                            <span class="d-block py-2 "><span class="fas fa-euro-sign"></span>39,99</span>
                            @else
                            <span class="d-block py-2 "><span class="fas fa-euro-sign"></span>44,99</span>
                            @endif
                        </div>
                    </div>
                    <div class="h8 mb-5">
                        <p class="textmuted">All prices in EUR. Payments accepted with Credit Cards and PayPal. VAT may apply.</p>
                    </div>
                </div>
                <div class="">
                    <p class="h7 fw-bold mb-1">Pay this Invoice</p>
                    <p class="textmuted h8 mb-2">Make payment for this invoice by filling in the details</p>
                    <form class="form" action="{{ route('enterprise.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-12">
                                <div class="card border-0"> <input class="form-control ps-5" type="text" placeholder="Card number"></div>
                            </div>
                            <div class="col-6"> <input class="form-control my-3" type="text" placeholder="MM/YY"></div>
                            <div class="col-6"> <input class="form-control my-3" type="text" placeholder="cvv"></div>
                            <p class="p-blue h8 fw-bold mb-3 ml-3">MORE PAYMENT METHODS</p>
                        </div>
                        <button class="btn btn-primary d-block h8 btn-block" type="submit"><b>COMPLETE ORDER</b></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="fs-s"></div>
@endsection

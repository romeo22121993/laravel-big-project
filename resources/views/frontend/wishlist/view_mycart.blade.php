@extends('frontend.main_master')
@section('content')

    @section('title')
        My Cart Page
    @endsection

    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class='active'>MyCart</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="body-content">
        <div class="container">
            <div class="row ">
                <div class="shopping-cart">
                    <div class="shopping-cart-table ">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="cart-romove item">Image</th>
                                        <th class="cart-description item">Name</th>
                                        <th class="cart-product-name item">Color</th>
                                        <th class="cart-edit item">Size</th>
                                        <th class="cart-qty item">Quantity</th>
                                        <th class="cart-sub-total item">Subtotal</th>
                                        <th class="cart-total last-item">Remove</th>
                                    </tr>
                                </thead><!-- /thead -->
                                <tbody id="cartPage">
                                    @foreach( $carts as $row)
                                        <tr>
                                            <td class="col-md-2">
                                                <img src="{{ asset($row->options->image) }}" alt="imga" style="width:60px; height:60px;">
                                            </td>

                                            <td class="col-md-2">
                                                <div class="product-name">
                                                    <a href="{{ route('productdetail', $row->id) }}">{{ $row->name }}</a>
                                                </div>
                                                <div class="price">
                                                    {{ $row->price }}
                                                </div>
                                            </td>

                                            <td class="col-md-2">
                                                <strong> {{ $row->options->color }}</strong>
                                            </td>

                                            <td class="col-md-2">
                                                @if ( $row->options->size == null )
                                                    <span> .... </span>
                                                @else
                                                    <strong>{{ $row->options->size }} </strong>
                                                @endif
                                            </td>

                                            <td class="col-md-2">
                                                @if ( $row->qty > 1 )
                                                    <button type="submit" class="btn btn-danger btn-sm cartDecrementBtm" id="{{ $row->rowId }}" >-</button>
                                                @else
                                                    <button type="submit" class="btn btn-danger btn-sm" disabled >-</button>
                                                @endif

                                                <input type="text" value="{{ $row->qty }}" min="1" max="100" disabled="" style="width:25px;" >

                                                <button type="submit" class="btn btn-success btn-sm cartIncrementBtn" id="{{ $row->rowId }}" >+</button>

                                            </td>

                                            <td class="col-md-2">
                                                <strong>{{ $row->subtotal }}$</strong>
                                            </td>

                                            <td class="col-md-1 close-btn">
                                                <button type="submit" class="cartRemoveBtn" id="{{ $row->rowId }}"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><h5>Total Quantity: <b class="cartQtyTd">{{ $cartQty }}</b></h5></td>
                                        <td><h5>Total Price: <b class="cartTotalTd">{{ $cartTotal }}$</b></h5></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-12 estimate-ship-tax">

                    </div>

                    <div class="col-md-4 col-sm-12 estimate-ship-tax">
                        @if(Session::has('coupon'))
                        @else
                            <table class="table" id="couponField">
                                <thead>
                                    <tr>
                                        <th>
                                            <span class="estimate-title">Discount Code</span>
                                            <p>Enter your coupon code if you have one..</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control unicase-form-control text-input" placeholder="You Coupon.." id="coupon_name">
                                            </div>
                                            <div class="clearfix pull-right">
                                                <button type="submit" class="btn-upper btn btn-primary applyCouponBtn">APPLY COUPON</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>

                    <div class="col-md-4 col-sm-12 cart-shopping-total">
                        <table class="table">
                            <thead id="couponCalField">

                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="cart-checkout-btn pull-right">
                                            <a href="{{ route('checkout') }}" type="submit" class="btn btn-primary checkout-btn">PROCCED TO CHEKOUT</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <br>
            @include('frontend.body.brands')
        </div>
    </div>

@endsection

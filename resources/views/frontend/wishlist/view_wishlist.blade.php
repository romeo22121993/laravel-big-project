@extends('frontend.main_master')

@section('content')

    @section('title')
        Wish List Page
    @endsection

    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class='active'>Wishlist</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="body-content">
        <div class="container">
            <div class="my-wishlist-page">
                <div class="row">
                    <div class="col-md-12 my-wishlist">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="4" class="heading-title">My Wishlist</th>
                                    </tr>
                                </thead>
                                <tbody id="wishlist">
                                    @foreach( $wishlist as $row)
                                        <tr>
                                            <td class="col-md-2"><img src="{{ asset($row->product->product_thambnail) }}" alt="imga"></td>
                                            <td class="col-md-7">
                                                <div class="product-name">
                                                    <a href="{{ route('productdetail', $row->product->id) }}">{{ $row->product->product_name_en }}</a>
                                                </div>
                                                <div class="price"
                                                    @if ( $row->product->discount_price == null )
                                                        {{  $row->product->selling_price }}
                                                    @else
                                                        {{ $row->product->discount_price }}
                                                        <span>{{ $row->product->selling_price }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="col-md-2">
                                                <button class="btn btn-primary icon productViewBtn" type="button" title="Add Cart" data-toggle="modal" data-target="#exampleModal" id="{{ $row->product->id }}" >Add to Cart</button>
                                            </td>
                                            <td class="col-md-1 close-btn">
                                                <button type="submit" class="wishlistRemoveBtn" id="{{ $row->id }}"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            @include('frontend.body.brands')
        </div>
    </div>
@endsection

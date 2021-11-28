<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

use App\Models\Coupon;
use Illuminate\Support\Facades\Session;

class CartPageController extends Controller
{

    /**
     * Function showing cart page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function MyCart(){

        $carts     = Cart::content();
        $cartQty   = Cart::count();
        $cartTotal = Cart::total();

        $cartTotal = str_replace( ',', '', $cartTotal);
        $cartQty   = str_replace( ',', '', $cartQty);

    	return view('frontend.wishlist.view_mycart', compact( 'carts', 'cartTotal', 'cartQty'));
    }


    /**
     * Function getting cart product by ajax
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function GetCartProduct(){
        $carts     = Cart::content();
    	$cartQty   = Cart::count();
    	$cartTotal = Cart::total();

        $cartTotal = str_replace( ',', '', $cartTotal);
        $cartQty   = str_replace( ',', '', $cartQty);

    	return response()->json(array(
    		'carts'     => $carts,
    		'cartQty'   => $cartQty,
    		'cartTotal' => round($cartTotal),
    	));

    }

    /**
     * Function removing cart product
     *
     * @param $rowId
     * @return \Illuminate\Http\JsonResponse
     */
    public function RemoveCartProduct($rowId){
        Cart::remove($rowId);

//        if (Session::has('coupon')) {
//           Session::forget('coupon');
//        }

        return response()->json(['success' => 'Successfully Remove From Cart']);
    }

    /**
     * Function cart incrementing on backend side
     *
     * @param $rowId
     * @return \Illuminate\Http\JsonResponse
     */
    public function CartIncrement( $rowId ){
        $row = Cart::get( $rowId );
        Cart::update( $rowId, $row->qty + 1);

        /*
        if ( Session::has('coupon') ) {

            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon      = Coupon::where('coupon_name',$coupon_name)->first();

            Session::put('coupon',[
                'coupon_name'     => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(Cart::total() * $coupon->coupon_discount/100),
                'total_amount'    => round(Cart::total() - Cart::total() * $coupon->coupon_discount/100)
            ]);
        }
        */

        return response()->json('increment');

    }


    /**
     * Function Cart Decrementing
     *
     * @param $rowId
     * @return \Illuminate\Http\JsonResponse
     */
    public function CartDecrement($rowId){

        $row = Cart::get( $rowId );
        Cart::update( $rowId, $row->qty - 1 );

        /*
        if ( Session::has('coupon') ) {

            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon      = Coupon::where('coupon_name',$coupon_name)->first();

            Session::put('coupon',[
                'coupon_name'     => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(Cart::total() * $coupon->coupon_discount/100),
                'total_amount'    => round(Cart::total() - Cart::total() * $coupon->coupon_discount/100)
            ]);
        }
        */

        return response()->json('Decrement');

    }

}


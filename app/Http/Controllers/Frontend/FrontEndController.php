<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MultiImg;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Slider;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class FrontEndController extends Controller
{

    public $index_controller;

    public function __construct( )
    {
        $this->index_controller = new IndexController();
    }


    /**
     * Function showing products by tags
     *
     * @param $tag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function TagWiseProduct($chosen_tag){

        if ( ( session()->get('language') == 'hindi' ) ) {
            $products = Product::where('status', 1)->where('product_tags_hin', 'LIKE' , '%' .$chosen_tag .'%')->orderBy('id', 'DESC')->paginate(1);
        }
        else {
            $products = Product::where('status',1)->where('product_tags_en', 'LIKE' , '%' .$chosen_tag .'%')->orderBy('id','DESC')->paginate(1);
        }

        $categories = Category::where('category_id', 0)->orderBy('category_name_en', 'ASC')->get();

        $tags_en  = Product::groupBy('product_tags_en')->select('product_tags_en')->get();
        $tags_hin = Product::groupBy('product_tags_hin')->select('product_tags_hin')->get();

        $tags_hin =  $this->index_controller->getDistinctTags( $tags_hin, 'hin' );
        $tags_en  =  $this->index_controller->getDistinctTags( $tags_en, 'en' );


        return view('frontend.product.tags_view',compact('products','categories', 'tags_en', 'tags_hin', 'chosen_tag'));
    }

    /**
     * Function for product detail page
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function ProductDetails($id){
        $product = Product::findOrFail($id);

        $color_en         = $product->product_color_en;
        $product_color_en = explode(',', $color_en);

        $color_hin         = $product->product_color_hin;
        $product_color_hin = explode(',', $color_hin);

        $size_en         = $product->product_size_en;
        $product_size_en = explode(',', $size_en);

        $size_hin         = $product->product_size_hin;
        $product_size_hin = explode(',', $size_hin);

        $multiImag      = MultiImg::where('product_id',$id)->get();

        $cat_id         = $product->category_id;
        $relatedProduct = Product::where('category_id',$cat_id)->where('id','!=',$id)->orderBy('id','DESC')->get();

        $featured      = Product::where('featured', 1)->orderBy('id', 'DESC')->limit(6)->get();
        $hot_deals     = Product::where('hot_deals', 1)->where('discount_price', '!=', NULL)->orderBy('id', 'DESC')->limit(3)->get();
        $special_offer = Product::where('special_offer', 1)->orderBy('id', 'DESC')->limit(6)->get();
        $special_deals = Product::where('special_deals', 1)->orderBy('id', 'DESC')->limit(3)->get();

        $tags_en  = Product::groupBy('product_tags_en')->select('product_tags_en')->get();
        $tags_hin = Product::groupBy('product_tags_hin')->select('product_tags_hin')->get();

        $tags_hin = $this->index_controller->getDistinctTags( $tags_hin, 'hin' );
        $tags_en  = $this->index_controller->getDistinctTags( $tags_en, 'en' );

        return view('frontend.product.product_details',
            compact('product','multiImag','product_color_en','product_color_hin','product_size_en','product_size_hin',
                'relatedProduct',  'featured', 'hot_deals', 'special_offer', 'special_deals', 'tags_en', 'tags_hin' )
        );
    }

}

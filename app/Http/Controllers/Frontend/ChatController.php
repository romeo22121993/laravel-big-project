<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MultiImg;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Blog\BlogPost;
use App\Models\Category;
use App\Models\Slider;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class ChatController extends Controller
{

    public function __construct()
    {
    }

    /**
     * Main home page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function ChatVue()
    {
        $sliders        = Slider::where('status', 1)->limit(5)->get();
        $products       = Product::where('status', 1)->get();
        $categories     = Category::where('category_id', 0)->orderBy('category_name_en', 'ASC')->get();
        $subcategory    = Category::where('category_id', '>', 0)->orderBy('category_name_en', 'ASC')->get();
        $subsubcategory = Category::where('category_id', '>', 0)->where('subcategory_id', '>', 0)->orderBy('category_name_en', 'ASC')->get();

        $featured      = Product::where('featured', 1)->orderBy('id', 'DESC')->limit(6)->get();
        $hot_deals     = Product::where('hot_deals', 1)->where('discount_price', '!=', NULL)->orderBy('id', 'DESC')->limit(3)->get();
        $special_offer = Product::where('special_offer', 1)->orderBy('id', 'DESC')->limit(6)->get();
        $special_deals = Product::where('special_deals', 1)->orderBy('id', 'DESC')->limit(3)->get();

        $tags_en  = Product::groupBy('product_tags_en')->select('product_tags_en')->get();
        $chosen_tag  = '';
        $tags_hin = Product::groupBy('product_tags_hin')->select('product_tags_hin')->get();

        $tags_hin = [];
        $tags_en  = [];

        $blogposts = BlogPost::latest()->take(5)->get();
        $settings  = SiteSetting::find(1);
        $chat = 'chat';

        return view('frontend.chat.chat', compact( 'chat','blogposts', 'settings', 'categories', 'subcategory', 'subsubcategory', 'sliders', 'products', 'featured', 'hot_deals', 'special_offer', 'special_deals', 'tags_en','chosen_tag' , 'tags_hin' ));
    }


    /**
     * Main home page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function Chat1()
    {
        $sliders        = Slider::where('status', 1)->limit(5)->get();
        $products       = Product::where('status', 1)->get();
        $categories     = Category::where('category_id', 0)->orderBy('category_name_en', 'ASC')->get();
        $subcategory    = Category::where('category_id', '>', 0)->orderBy('category_name_en', 'ASC')->get();
        $subsubcategory = Category::where('category_id', '>', 0)->where('subcategory_id', '>', 0)->orderBy('category_name_en', 'ASC')->get();

        $featured      = Product::where('featured', 1)->orderBy('id', 'DESC')->limit(6)->get();
        $hot_deals     = Product::where('hot_deals', 1)->where('discount_price', '!=', NULL)->orderBy('id', 'DESC')->limit(3)->get();
        $special_offer = Product::where('special_offer', 1)->orderBy('id', 'DESC')->limit(6)->get();
        $special_deals = Product::where('special_deals', 1)->orderBy('id', 'DESC')->limit(3)->get();

        $tags_en  = Product::groupBy('product_tags_en')->select('product_tags_en')->get();
        $chosen_tag  = '';
        $tags_hin = Product::groupBy('product_tags_hin')->select('product_tags_hin')->get();

        $tags_hin = [];
        $tags_en  = [];

        $blogposts = BlogPost::latest()->take(5)->get();
        $settings  = SiteSetting::find(1);

        $chat = 'chat1';

        return view('frontend.chat.chat', compact( 'chat','blogposts', 'settings', 'categories', 'subcategory', 'subsubcategory', 'sliders', 'products', 'featured', 'hot_deals', 'special_offer', 'special_deals', 'tags_en','chosen_tag' , 'tags_hin' ));
    }

}

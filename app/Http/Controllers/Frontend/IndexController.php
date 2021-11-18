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


class IndexController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Main home page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function Index()
    {
        $sliders = Slider::where('status', 1)->limit(5)->get();
        $products = Product::where('status', 1)->get();
        $categories = Category::where('category_id', 0)->orderBy('category_name_en', 'ASC')->get();
        $subcategory = Category::where('category_id', '>', 0)->orderBy('category_name_en', 'ASC')->get();
        $subsubcategory = Category::where('category_id', '>', 0)->where('subcategory_id', '>', 0)->orderBy('category_name_en', 'ASC')->get();

        $featured = Product::where('featured', 1)->orderBy('id', 'DESC')->limit(6)->get();
        $hot_deals = Product::where('hot_deals', 1)->where('discount_price', '!=', NULL)->orderBy('id', 'DESC')->limit(3)->get();
        $special_offer = Product::where('special_offer', 1)->orderBy('id', 'DESC')->limit(6)->get();
        $special_deals = Product::where('special_deals', 1)->orderBy('id', 'DESC')->limit(3)->get();

        $tags_en  = Product::groupBy('product_tags_en')->select('product_tags_en')->get();
        $tags_hin = Product::groupBy('product_tags_hin')->select('product_tags_hin')->get();

        $tags_hin = $this->getDistinctTags( $tags_hin, 'hin' );
        $tags_en  = $this->getDistinctTags( $tags_en, 'en' );

        return view('frontend.index', compact( 'categories', 'subcategory', 'subsubcategory', 'sliders', 'products', 'featured', 'hot_deals', 'special_offer', 'special_deals', 'tags_en', 'tags_hin' ));
    }

    private function getDistinctTags( $array, $type ) {
        $arr = array();

        foreach ($array as $tag) {

            $variable =  ( $type == 'hin' ) ? explode(',', $tag->product_tags_hin) : explode(',', $tag->product_tags_en);
            foreach ( $variable as $tag ) {
                if (!in_array($tag, $arr)) {
                    $arr[] = $tag;
                }
            }
        }

        return $arr;
    }

    /**
     * Function for user log out
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function UserLogout(){
        Auth::logout();
        return Redirect()->route('login');
    }

    /**
     * Function for log in
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function loginForm(){

        $sliders        = Slider::where('status', 1)->limit(5)->get();
        $categories     = Category::where('category_id', 0)->orderBy('category_name_en','ASC')->get();
        $subcategory    = Category::where('category_id','>', 0)->orderBy('category_name_en','ASC')->get();
        $subsubcategory = Category::where('category_id','>', 0)->where('subcategory_id','>', 0)->orderBy('category_name_en','ASC')->get();

        return view('auth.admin_login', compact( 'categories', 'subcategory', 'subsubcategory', 'sliders' ), ['guard' => 'admin']);
    }

    /**
     * Custom login form function
     *
     * @param Request $request
     * @return mixed
     */
    public function CustomLogin( Request $request ) {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if ( Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }
        else {
            return redirect()->route("admin.login")->withErrors(['msg' => 'Login details are not valid']);
        }

    }

    /**
     * Custom login form function
     *
     * @param Request $request
     * @return mixed
     */
    public function TestEmail( Request $request ) {
        $request->validate([
            'email'    => 'required'
        ]);

        $email = $request->email;
        $to_name = 'fff';
        $to_email = $email;
        $data = array('name'=> "Ogbonna Vitalis(sender_name)", "body" => "A test mail");
        Mail::send( 'emails.mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject( 'Laravel Test Mail');
            $message->from( 'roman.b.upqode@gmail.com', 'Test Mail');
        });

        return redirect()->route('dashboard')->withErrors(['msg' => 'Login details are not valid']);

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

        $multiImag        = MultiImg::where('product_id',$id)->get();

        $cat_id         = $product->category_id;
        $relatedProduct = Product::where('category_id',$cat_id)->where('id','!=',$id)->orderBy('id','DESC')->get();

        return view('frontend.product.product_details',compact('product','multiImag','product_color_en','product_color_hin','product_size_en','product_size_hin','relatedProduct'));

    }


}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function CategoryView(){

    	$category = Category::latest()->get();
    	return view('backend.category.category_view',compact('category'));
    }

    public function CategoryStore(Request $request){

        $request->validate([
            'category_name_en' => 'required',
            'category_name_hin' => 'required',
            'category_icon' => 'required',
        ],[
            'category_name_en.required' => 'Input Category English Name',
            'category_name_hin.required' => 'Input Category Hindi Name',
        ]);

        Category::insert([
            'category_name_en' => $request->category_name_en,
            'category_name_hin' => $request->category_name_hin,
            'category_slug_en' => strtolower(str_replace(' ', '-',$request->category_name_en)),
            'category_slug_hin' => str_replace(' ', '-',$request->category_name_hin),
            'category_icon' => $request->category_icon,
        ]);

        $notification = array(
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // end method


    public function CategoryEdit($id){
    	$category = Category::findOrFail($id);
    	return view('backend.category.category_edit',compact('category'));
    }


    public function CategoryUpdate(Request $request ,$id){

        Category::findOrFail($id)->update([
            'category_name_en' => $request->category_name_en,
            'category_name_hin' => $request->category_name_hin,
            'category_slug_en' => strtolower(str_replace(' ', '-',$request->category_name_en)),
            'category_slug_hin' => str_replace(' ', '-',$request->category_name_hin),
            'category_icon' => $request->category_icon,
        ]);

        $notification = array(
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.category')->with($notification);

    } // end method


    public function CategoryDelete($id){

    	Category::findOrFail($id)->delete();

    	$notification = array(
			'message' => 'Category Deleted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    } // end method

    public static function get_name_by_id( $id = 0 ) {
        $categories  = Category::where('id', $id)->first();
        return $categories->category_name_en;
    }

    public function SubCategoryView(){

        $categories  = Category::where('category_id', 0)->get();
        $subcategory = Category::where('category_id', '>', 0)->get();
        return view('backend.category.subcategory_view',compact('subcategory','categories'));

    }


    public function SubCategoryStore(Request $request){

        $request->validate([
            'category_id' => 'required',
            'category_name_en' => 'required',
            'category_name_hin' => 'required',
        ],[
            'category_id.required' => 'Please select Any option',
            'category_name_en.required' => 'Input SubCategory English Name',
        ]);

        Category::insert([
            'category_id' => $request->category_id,
            'category_name_en' => $request->category_name_en,
            'category_name_hin' => $request->category_name_hin,
            'category_slug_en' => strtolower(str_replace(' ', '-',$request->category_name_en)),
            'category_slug_hin' => str_replace(' ', '-',$request->category_name_hin),
        ]);

        $notification = array(
            'message' => 'SubCategory Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // end method



    public function SubCategoryEdit($id){
        $categories  = Category::where('category_id', 0)->orderBy('category_name_en','ASC')->get();
        $subcategory = Category::findOrFail($id);
        return view('backend.category.subcategory_edit',compact('subcategory','categories'));

    }


    public function SubCategoryUpdate(Request $request){

        $subcat_id = $request->id;

        Category::findOrFail($subcat_id)->update([
            'category_id' => $request->category_id,
            'category_name_en' => $request->category_name_en,
            'category_name_hin' => $request->category_name_hin,
            'category_slug_en' => strtolower(str_replace(' ', '-',$request->category_name_en)),
            'category_slug_hin' => str_replace(' ', '-',$request->category_name_hin),
        ]);

        $notification = array(
            'message' => 'SubCategory Updated Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('subcategory.all')->with($notification);

    }  // end method



    public function SubCategoryDelete($id){

        Category::findOrFail($id)->delete();

        $notification = array(
            'message' => 'SubCategory Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->back()->with($notification);

    }


    /////////////// That for SUB->SUBCATEGORY ////////////////

    public function SubSubCategoryView(){

        $categories = Category::where('category_id', 0)->orderBy('category_name_en','ASC')->get();
        $subsubcategory = Category::where('category_id','>', 0)->where('subcategory_id','>', 0)->orderBy('category_name_en','ASC')->get();
        return view('backend.category.sub_subcategory_view',compact('subsubcategory','categories'));

    }


    public function GetSubCategory($category_id){

        $subcat = Category::where('category_id',$category_id)->orderBy('category_name_en','ASC')->get();
        return json_encode($subcat);
    }


    public function GetSubSubCategory($subcategory_id){

        $subsubcat = Category::where('subcategory_id',$subcategory_id)->orderBy('category_name_en','ASC')->get();
        return json_encode($subsubcat);
    }



    public function SubSubCategoryStore(Request $request){

        $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'category_name_en' => 'required',
            'category_name_hin' => 'required',
        ],[
            'category_id.required' => 'Please select Any option',
            'category_name_en.required' => 'Input SubSubCategory English Name',
        ]);



        Category::insert([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'category_name_en' => $request->category_name_en,
            'category_name_hin' => $request->category_name_hin,
            'category_slug_en' => strtolower(str_replace(' ', '-',$request->category_name_en)),
            'category_slug_hin' => str_replace(' ', '-',$request->category_name_hin),
        ]);

        $notification = array(
            'message' => 'Sub-SubCategory Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // end method



    public function SubSubCategoryEdit($id){
        $subsubcategories = Category::findOrFail($id);

        $categories       = Category::where('category_id', 0)->orderBy('category_name_en','ASC')->get();
        $subcategories    = Category::where('category_id',  $subsubcategories->category_id)->orderBy('category_name_en','ASC')->get();
        return view('backend.category.sub_subcategory_edit',compact('categories','subcategories','subsubcategories'));
    }

    public function SubSubCategoryUpdate(Request $request){

        $subsubcat_id = $request->id;

        Category::findOrFail($subsubcat_id)->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'category_name_en' => $request->category_name_en,
            'category_name_hin' => $request->category_name_hin,
            'category_slug_en' => strtolower(str_replace(' ', '-',$request->category_name_en)),
            'category_slug_hin' => str_replace(' ', '-',$request->category_name_hin),
        ]);

        $notification = array(
            'message' => 'Sub-SubCategory Update Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('subsubcategory.all')->with($notification);

    } // end method


    public function SubSubCategoryDelete($id){

        Category::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Sub-SubCategory Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->back()->with($notification);

    }

}

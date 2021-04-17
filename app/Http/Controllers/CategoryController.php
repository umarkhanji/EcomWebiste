<?php

namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function addCategory(Request $request)
    {
         if($request->isMethod('post'))
         {
         	$data = $request->all();
            if(empty($data['status']))
            {
                $status =0;
            }else{
                $status=1;
            }
         	$category = new Category();
         	$category->name = $data['category_name'];
            $category->parent_id = $data['parent_id'];
         	$category->description = $data['description'];
         	$category->url = $data['url'];
            $category->status = $status;
         	$category->save();
            return redirect('/admin/view-categories')->with('flash_message_success','Category Added  Successfully');;
         }

         $levels = Category::where(['parent_id'=>0])->get();

    	return view('admin.category.add_category')->with(compact('levels'));
    }

    public function viewCategories()
    {
        $categories = new Category();
        $data = $categories->all();


        return view('admin.category.view_categories')->with(compact('data'));
    }

    public function editCotegory(Request $request,$id)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            // dd($data);

            $data = $request->all();
            if(empty($data['status']))
            {
                $status =0;
            }else{
                $status=1;
            }
            Category::where(['id'=>$id])->update(['name'=>$data['name'],'description'=>$data['description'],'url'=>$data['url'],'status'=>$status]);
            return redirect('admin/view-categories')->with('flash_message_success','Category updated Successfully');
        }
       
        $categoryDetail = Category::where(['id'=>$id])->first();
        $levels = Category::where(['parent_id'=>0])->get();
        // dd($categoryDetail);
        return view('admin.category.edit_category')->with(compact('categoryDetail','levels'));
    }

    public function deleteCotegory($id)
    {
        Category::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Category Deleted Successfully');
       // dd($id);
    }


}

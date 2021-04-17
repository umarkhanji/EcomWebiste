<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Banner;
use Image;
class BannersController extends Controller
{
	public function addBanner(Request $request)
	{
		if($request->isMethod('post')){
		$data =$request->all();
	    
	    $banner = new Banner();
	    $banner->title = $data['title'];
	    $banner->link  = $data['link'];
	    if(empty ($data['status'] ) ){
              $status = 0;
          }else{
              $status =1;
         }

          //Upload image
            if($request->hasFile('image'))
            {
               $image_tmp = Input::file('image');
               //upload image
               if($image_tmp->isValid())
               {
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = rand(111,99999).'.'.$extension;
                $banner_path = 'images/frontend_images/banners/'.$filename;
                //Resize Images
                Image::make($image_tmp)->resize(1140,340)->save($banner_path);   
                  $banner->image=$filename;
               }
            }

            $banner->status = $status;
            $banner->save();
            return redirect()->back()->with('flash_message_success','Banner has been Added Succefully');


	        }
           return view('admin.banners.add_banner');
	}

	public function editBanner(Request $request,$id=null)
	{
       $bannerDetails = Banner::where('id',$id)->first();
       if($request->isMethod('post')){
		$data =$request->all();
		//Upload image

		   if(empty ($data['status'] ) ){
              $status = 0;
          }else{
              $status =1;
         }

         if(empty($data['title']))
         {
         	$title = '';
         }


         if(empty($data['link']))
         {
         	$link = '';
         }
            if($request->hasFile('image'))
            {
               $image_tmp = Input::file('image');
               //upload image
               if($image_tmp->isValid())
               {
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = rand(111,99999).'.'.$extension;
                $banner_path = 'images/frontend_images/banners/'.$filename;
                //Resize Images
                Image::make($image_tmp)->resize(1140,340)->save($banner_path);   
                  $banner->image=$filename;
               }
            }else
            {
                $filename = $data['current_image'];
            }

       Banner::where('id',$id)->update(['status'=>$status,'title'=>$data['title'],'link'=>$data['link'],'image'=>$filename]);
       return redirect()->back()->with('flash_message_success','Banner has been Edited Successfully');
  
	}
       // dd($bannerDetails);
       return view('admin.banners.edit_banner')->with(compact('bannerDetails'));
	}
    public function viewBanners()
    {
    	$banners =Banner::get();
    	return view('admin.banners.view_banners')->with(compact('banners'));
    }

    public function deleteBanners($id=null)
    {
       Banner::where(['id'=>$id])->delete();
       return redirect()->back()->with('flash_message_success','Banner has been deleted Successfully');
    }
}

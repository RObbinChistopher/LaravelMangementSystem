<?php 
namespace App\Traits;
use Illuminate\Http\Request;
use File;

trait ImageUploadTrait
{
    public function Uploadimage(Request $request, $input_name, $path)
    {
        if($request->hasFile($input_name))
        {
            $image = $request->{$input_name};
            $ext = $image->getClientOriginalExtension();
            $image_name = 'media_'.uniqid(). '.' . $ext;
            $image->move(public_path($path), $image_name);

            return $path . '/' .$image_name;
        }
    }
    public function UploadMulitpleimage(Request $request, $input_name, $path)
    {

        $ImagesPath = [];
        if($request->hasFile($input_name))
        {
            $images = $request->{$input_name};

            foreach ($images  as $image) {
                $ext = $image->getClientOriginalExtension();
                $image_name = 'media_'.uniqid(). '.' . $ext;
                $image->move(public_path($path), $image_name);
    
               $ImagesPath[] = $path . '/' .$image_name;
            }

            return $ImagesPath;
        }
    }
    public function Updateimage(Request $request, $input_name, $path, $oldpath=null)
    {
        if($request->hasFile($input_name))
        {
            if(File::exists(public_path($oldpath))){
                File::delete(public_path($oldpath));
            }
            $image = $request->{$input_name};
            $ext = $image->getClientOriginalExtension();
            $image_name = 'media_'.uniqid(). '.' . $ext;
            $image->move(public_path($path), $image_name);

            return $path . '/' .$image_name;
        }
    }

    // delete exists file 

    public function deleteupload($path)
    {
        if(File::exists(public_path($path))){
            File::delete(public_path($path));
        }
    }
}




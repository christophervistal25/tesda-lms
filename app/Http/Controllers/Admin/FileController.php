<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class FileController extends Controller
{
    public function store(Request $request)
    {

    	$destination =  public_path() . '/' .$request->file('file')->getClientOriginalName();
        move_uploaded_file($request->file('file'), $destination);

    	$result = \Cloudinary::config(array( 
              'cloud_name' => config('cloudder.cloudName'), 
              'api_key'    => config('cloudder.apiKey'), 
              'api_secret' => config('cloudder.apiSecret'), 
              'secure'     => true
        ));

        $uploaded = \Cloudinary\Uploader::upload($destination, [
            'use_filename'    => true,
            'unique_filename' => false,
            'resource_type'   => 'auto'
        ]);

        \File::delete($destination);
        
        $path = $request->file('file')->getClientOriginalName();
		    $ext = pathinfo($path, PATHINFO_EXTENSION);

        return response()->json([ 'link' => $uploaded['url'] , 'extension' => $ext]);
    
    }
}

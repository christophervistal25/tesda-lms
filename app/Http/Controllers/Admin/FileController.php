<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FileController extends Controller
{

    private function isFilePDF(string $extension) :bool
    {
        return $extension === 'pdf';
    }

    public function store(Request $request)
    {

    	

        $path = $request->file('file')->getClientOriginalName();
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        
        // if ( !$this->isFilePDF($ext) ) {
            $destination =  public_path() . '/files/' .$request->file('file')->getClientOriginalName();
            move_uploaded_file($request->file('file'), $destination);

            // $result = \Cloudinary::config(array( 
            //       'cloud_name' => config('cloudder.cloudName'), 
            //       'api_key'    => config('cloudder.apiKey'), 
            //       'api_secret' => config('cloudder.apiSecret'), 
            //       'secure'     => true
            // ));

            // $uploaded = \Cloudinary\Uploader::upload($destination, [
            //     'use_filename'    => true,
            //     'unique_filename' => false,
            //     'resource_type'   => 'auto',
            //     'pages'            => true
            // ]);

            // \File::delete($destination);
            // return response()->json(['link' => $uploaded['url'] , 'extension' => $ext]);
        // } else {
            // $destination =  public_path() . '/certificates/' . $request->file('file')->getClientOriginalName();
            // move_uploaded_file($request->file('file'), $destination);
            return response()->json(['link' => Str::after($destination, 'public'), 'extension' => $ext]);
        // }


        
    
    }
}

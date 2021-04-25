<?php


namespace ZhyuVueCurd\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use function GuzzleHttp\json_encode;

class UploadController extends Controller
{
    public function store(string $dir, string $column, Request $request){
//        $file_name = $request->$column->getClientOriginalName();
//        Log::info('upload........', [$dir, $request->all('file')]);
//        Log::info('upload........ file_name', [$file_name, $request->file, $request->allFiles()]);
        $path = Storage::putFile('public/'.$dir, $request->{$column});
        $path = str_replace('public', '', $path);
        Log::info('upload in .............'.$path);

        return $path;
    }

    public function ckeditor(string $table, Request $request){

        Log::info('upload in .............', [$request->all()]);
        $path = Storage::putFile('public/'.$table, $request->upload);
        $path = str_replace('public', '', $path);

        Log::info('upload in .............'.$path, [$request->all()]);

        return response()->json([
            'uploaded' => true,
            'url' => '/storage/'.$path,
        ]);
    }
}

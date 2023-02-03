<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ToolController extends Controller
{
    public function backup_index()
    {
        $files =  Storage::allFiles(config('app.name'));
        $files =collect($files)->sortDesc()->map(function ($item){
            $strs1 = explode('/', $item);
            $strs2 = explode('-',$strs1[1]);
            return [
                'datetime' =>Carbon::create(...$strs2)->format('Y-m-d H:i:s'),
                'name' => $strs1[1],
            ];
        });
        return view('admin.tool.backup', compact('files'));
    }

    public function backup_download($file)
    {
        return Storage::download(config('app.name') .'/'. $file);
    }

    public function backup_delete(Request $request)
    {
        Storage::delete(config('app.name') .'/'. $request->input('file'));

        return redirect()->route('admin.tools.backup_index');
    }

    public function backup_run()
    {
        Artisan::call('backup:run');

        return redirect()->route('admin.tools.backup_index');
    }
}

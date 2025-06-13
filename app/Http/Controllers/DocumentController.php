<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use Storage;
use File;

class DocumentController extends Controller
{
    public function upload_file()
    {
        $fileName = 'Dai Viet Su Ky';
        $filePath = public_path('upload/document/Dai-viet-su-ki-toan-thu59.pdf');

        $fileData = File::get($filePath);
        Storage::cloud()->put($fileName, $fileData);
        return 'File PDF Uploaded';
    }

    public function upload_image()
    {
        $fileName = 'Van Dijk 1';
        $filePath = public_path('frontend/images/vandijk1.webp');

        $fileData = File::get($filePath);
        Storage::cloud()->put($fileName, $fileData);
        return 'Image Uploaded';
    }

    public function create_document()
    {
        Storage::disk('google')->put('test.txt', 'Heisenberg');
        dd('created');
    }

    public function list_document()
    {
        $dir = '/';
        $recursive = false;
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));
        return $contents;
    }

    public function create_folder()
    {
        Storage::cloud()->makeDirectory('document_new');
        dd('created folder');
    }
    // End Page

    public function AuthLogin()
    {
        $admin_id = Auth::id();

        if($admin_id)
        {
            return redirect()->to('dashboard');
        }
        else
        {
            return redirect()->to('admin')->send();
        }
    }

    public function read_data()
    {
        $this->AuthLogin();
        $dir = '/';
        $recursive = false; // Co lay file trong thu muc con ko
        $contents = collect(Storage::cloud()->listContents($dir, $recursive))->where('type', '!=', 'dir');
        return view('admin.document.read')->with(compact('contents'));
    }

    public function download_document($virtual_path, $name)
    {
        $dir = '/';
        $recursive = false;

        // Tìm file theo virtual_path
        $fileinfo = collect(Storage::cloud()->listContents($dir, $recursive))
            ->where('type', 'file')
            ->where('extra_metadata.virtual_path', $virtual_path)
            ->first();

        if (!$fileinfo) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $fileId = $fileinfo['path']; // đây là Google Drive file ID
        $mime = $fileinfo['mime_type'];
        $rawData = Storage::cloud()->get($fileId);

        return response($rawData, 200)
        ->header('Content-Type', $mime)
        ->header('Content-Disposition', 'attachment; filename="' . $name . '"');
    }

    public function delete_document($virtual_path)
    {
        $fileinfo = collect(Storage::cloud()->listContents('/', false))->where('type', 'file')->where('extra_metadata.virtual_path', $virtual_path)->first();

        Storage::cloud()->delete($fileinfo['path']);
        return redirect()->back();
    }
}

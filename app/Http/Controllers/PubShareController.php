<?php

namespace App\Http\Controllers;

use App\Data\Alert;
use App\Models\PubShare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PubShareController extends Controller
{
    public function pubShare()
    {
        $files = PubShare::query()
            ->where('nik', Auth::user()->nik)
            ->orderBy('created_at', 'DESC')
            ->get(['id', 'title', 'attachment']);

        return view(
            'maintenance.pub_share.pub_share',
            [
                'title' => 'PubShare',
                'files' => $files,
            ],
        );
    }

    public function newFile(Request $request)
    {
        $nik = Auth::user()->nik;

        $validated = $request->validate([
            'file' => ['required'],
            'title' => ['nullable', 'min:3', 'max:30'],
        ]);

        $attachment = $request->file('file');

        if (!is_null($attachment) && $attachment->isValid()) {

            $name = explode('.', $attachment->getClientOriginalName())[0];
            $extension = strtolower($attachment->getClientOriginalExtension());
            $title = $name . '.' . $extension;

            if ($validated['title'] != null) {
                $title = $validated['title'] . '.' . $extension;
            }

            $file = new PubShare();
            $file->id = uniqid();
            $file->title = $title;
            $file->nik = Auth::user()->nik;
            $file->attachment = $title;
            $result = $file->save();

            if ($result) {
                $attachment->storePubliclyAs("pub_share/$nik", $title, 'public');
            }
        }

        return back()->with('alert', new Alert('Successfully uploaded.', 'alert-success'));
    }

    public function deleteFile(string $id)
    {
        $nik = Auth::user()->nik;
        $file = PubShare::query()->find($id);

        if ($file != null) {
            Storage::disk('public')->delete("pub_share/$nik/$file->attachment");
            $file->delete();
            return back()->with('alert', new Alert('Successfully deleted.', 'alert-success'));
        } else {
            return back()->with('alert', new Alert('File not found.', 'alert-info'));
        }
    }

    public function downloadFile(string $id)
    {
        $nik = Auth::user()->nik;
        $file = PubShare::query()->find($id);

        if ($file != null) {

            $path = Storage::disk('public')->path("pub_share/$nik/$file->attachment");
            return response()->download($path);
        } else {
            return back()->with('alert', new Alert('File not found.', 'alert-info'));
        }
    }
}

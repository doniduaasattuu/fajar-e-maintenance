<?php

namespace App\Http\Controllers;

use App\Data\Alert;
use App\Data\Modal;
use App\Models\Document;
use App\Models\User;
use App\Services\DocumentService;
use App\Traits\Utility;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class DocumentController extends Controller
{
    private DocumentService $documentService;
    private $allowed_attachment = ['png', 'jpeg', 'jpg', 'xlsx', 'xls', 'ods', 'doc', 'docx', 'pdf'];

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    // public function documents()
    // {
    //     return response()->view('maintenance.documents.documents', [
    //         'title' => 'Documents',
    //         'documentService' => $this->documentService,
    //     ]);
    // }

    public function documents(Request $request)
    {
        $search = $request->query('search');
        $dept = $request->query('dept');

        $paginator = Document::query()
            ->when($search, function ($query, $search) {
                $query
                    ->where('title', 'LIKE', "%{$search}%");
            })
            ->when($dept, function ($query, $dept) {
                $query
                    ->where('department', '=', $dept);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10)
            ->withQueryString();

        return view('maintenance.documents.documents', [
            'title' => 'Documents',
            'paginator' => $paginator,
        ]);
    }

    public function documentDelete(string $id)
    {
        $document = Document::query()->find($id);

        if (!is_null($document)) {
            // DO DELETE

            if (!is_null($document->attachment)) {
                Storage::disk('public')->delete("documents/$document->attachment");
            }

            $document->delete();

            Log::info('document with title "' . $document->title . '" was deleted', ['admin' => session('user')]);
            return back()->with('modal', new Modal('[200] Success', 'Document successfully deleted.'));
        } else {
            return back()->with('modal', new Modal('[404] Not found', 'Document not found.'));
        }
    }

    public function documentRegistration()
    {
        return response()->view('maintenance.documents.form', [
            'title' => 'New document',
            'documentService' => $this->documentService,
            'action' => 'document-register'
        ]);
    }

    public function documentRegister(Request $request)
    {
        $request->mergeIfMissing(['id' => uniqid(), 'uploaded_by' => Auth::user()->fullname]);

        return response()->json($request->all());

        $rules = [
            'id' => ['required', 'size:13'],
            'title' => ['required', 'min:15', 'max:50'],
            'area' => ['required', Rule::in(array_merge($this->areas(), ['All']))],
            'equipment' => ['nullable', 'size:9'],
            'funcloc' => ['nullable', 'max:50'],
            'uploaded_by' => ['required', 'max:50'],
            'attachment' => ['required', 'max:25000', File::types($this->allowed_attachment)],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            try {

                $attachment = $request->file('attachment');
                $validated = $validator->safe()->except(['attachment']);

                if (!is_null($attachment) && $attachment->isValid()) {
                    $validated['attachment'] = $validated['id'] . '.' . $attachment->getClientOriginalExtension();
                    $this->documentService->insertWithAttachment($attachment, $validated);
                } else {
                    $this->documentService->insert($validated);
                }
            } catch (Exception $error) {
                Log::error('document inserted error', ['user' => session('user'), 'message' => $error->getMessage()]);
                return back()->with('modal', new Modal('[500] Internal Server Error', $error->getMessage()));
            }


            Log::info('document inserted with title "' . $validated['title'] . '" success', ['user' => session('user')]);
            return back()->with('alert', new Alert('The document successfully saved.', 'alert-success'));
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    // EDIT & UPDATE
    public function documentEdit(string $id)
    {
        $document = Document::query()->find($id);

        if (!is_null($document)) {

            return response()->view('maintenance.documents.form', [
                'title' => 'Edit document',
                'documentService' => $this->documentService,
                'action' => 'document-update',
                'document' => $document,
            ]);
        } else {
            return back()->with('modal', new Modal('[404] Not found', 'Document not found'));
        }
    }

    public function documentUpdate(Request $request)
    {
        $rules = [
            'id' => ['required', 'size:13', 'exists:App\Models\Document,id'],
            'title' => ['required', 'min:15', 'max:50'],
            'area' => ['required', Rule::in(array_merge($this->areas(), ['All']))],
            'equipment' => ['nullable', 'size:9'],
            'funcloc' => ['nullable', 'max:50'],
            'uploaded_by' => ['required', 'max:50'],
            'attachment' => ['nullable', 'max:25000', File::types($this->allowed_attachment)],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $validated = $validator->validated();
            $attachment = $request->file('attachment');

            try {

                if (!is_null($attachment) && $attachment->isValid()) {
                    $validated['attachment'] = $validated['id'] . '.' . strtolower($attachment->getClientOriginalExtension());
                    $this->documentService->updateWithAttachment($attachment, $validated);
                } else {
                    $this->documentService->update($validated);
                }

                Log::info('document with title "' . $validated['title'] . '" was updated', ['user' => session('user')]);
                return back()->with('alert', new Alert('The document successfully updated.', 'alert-success'));
            } catch (Exception $error) {
                Log::error('document updated error', ['user' => session('user'), 'message' => $error->getMessage()]);
                return back()->with('modal', new Modal('[500] Internal Server Error', $error->getMessage()));
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
}

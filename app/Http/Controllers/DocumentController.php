<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use App\Services\DocumentService;
use App\Traits\Utility;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class DocumentController extends Controller
{
    use Utility;
    private DocumentService $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function documents()
    {
        return response()->view('documents.documents', [
            'title' => 'Documents',
            'documentService' => $this->documentService,
        ]);
    }

    public function renderDocument(string $attachment)
    {
        return response()->file('/storage/documents/' . $attachment);
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

            return redirect()->back()->with('message', ['header' => '[204] Success!', 'message' => 'Document successfully deleted!.']);
        } else {
            return redirect()->back()->with('message', ['header' => '[404] Not found!', 'message' => 'Document not found!.']);
        }
    }

    public function documentRegistration()
    {
        return response()->view('documents.form', [
            'title' => 'New document',
            'documentService' => $this->documentService,
            'action' => 'document-register'
        ]);
    }

    public function documentRegister(Request $request)
    {
        $request->mergeIfMissing(['id' => uniqid(), 'uploaded_by' => User::query()->find(session('nik'))->fullname]);

        $rules = [
            'id' => ['required', 'size:13'],
            'title' => ['required', 'min:15', 'max:50'],
            'area' => ['required', Rule::in($this->areas())],
            'equipment' => ['nullable', 'size:9'],
            'funcloc' => ['nullable', 'max:50'],
            'uploaded_by' => ['required', 'max:50'],
            'attachment' => ['required', 'max:25000', File::types(['png', 'jpeg', 'jpg', 'xlsx', 'xls', 'ods', 'doc', 'docx', 'pdf'])],
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
                return redirect()->back()->withErrors($error->getMessage())->withInput();
            }

            return redirect()->back()->with('alert', ['message' => 'The document successfully saved.', 'variant' => 'alert-success']);
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    // EDIT & UPDATE
    public function documentEdit(string $id)
    {
        $document = Document::query()->find($id);

        if (!is_null($document)) {

            return response()->view('documents.form', [
                'title' => 'Edit document',
                'documentService' => $this->documentService,
                'action' => 'document-update',
                'document' => $document,
            ]);
        } else {
            return redirect()->back()->with('message', ['header' => '[404] Not found!', 'message' => 'Document not found!.']);
        }
    }

    public function documentUpdate(Request $request)
    {
        $rules = [
            'id' => ['required', 'size:13', 'exists:App\Models\Document,id'],
            'title' => ['required', 'min:15', 'max:50'],
            'area' => ['required', Rule::in($this->areas())],
            'equipment' => ['nullable', 'size:9'],
            'funcloc' => ['nullable', 'max:50'],
            'uploaded_by' => ['required', 'max:50'],
            'attachment' => ['nullable', 'max:25000', File::types(['png', 'jpeg', 'jpg', 'xlsx', 'xls', 'ods', 'doc', 'docx', 'pdf'])],
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
                return redirect()->back()->with('alert', ['message' => 'The document successfully updated.', 'variant' => 'alert-success'])->withInput();
            } catch (Exception $error) {
                return redirect()->back()->withErrors($error->getMessage())->withInput();
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
}

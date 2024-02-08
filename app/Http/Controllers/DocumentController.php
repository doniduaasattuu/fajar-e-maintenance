<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Services\DocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
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

    public function documentRegistration()
    {
        return response()->view('documents.form', [
            'title' => 'New document',
            'documentService' => $this->documentService,
            'action' => 'document-register'
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\User;
use App\Services\DocumentService;
use App\Services\Impl\DocumentServiceImpl;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\DocumentSeeder;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TrafoSeeder;
use Database\Seeders\UserRoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentControllerTest extends TestCase
{
    // DOCUMENTS
    public function testGetDocumentsGuest()
    {
        $this->seed(DocumentSeeder::class);
        $this->get('/documents')
            ->assertRedirectToRoute('login');
    }

    public function testGetDocumentsEmployee()
    {
        $this->seed([UserRoleSeeder::class, DocumentSeeder::class]);

        Auth::attempt(['nik' => '55000135', 'password' => 'rahasia']);

        $this
            ->get('/documents')
            ->assertSeeText('Documents')
            ->assertSeeText('New document')
            ->assertSeeText('Search')
            ->assertSee('Title')
            ->assertSeeText('Dept')
            ->assertSee('EI1')
            ->assertSee('EI2')
            ->assertSee('EI3')
            ->assertSee('EI4')
            ->assertSee('EI5')
            ->assertSee('EI6')
            ->assertSee('EI7')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('Title')
            ->assertSeeText('Area')
            ->assertSeeText('Dept')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Uploaded by')
            ->assertSeeText('Attach')
            ->assertDontSeeText('Edit')
            ->assertDontSeeText('Delete');
    }

    public function testGetDocumentsAdmin()
    {
        $this->seed([UserRoleSeeder::class, DocumentSeeder::class]);

        Auth::attempt(['nik' => '55000153', 'password' => 'rahasia']);

        $this
            ->get('/documents')
            ->assertSeeText('Documents')
            ->assertSeeText('New document')
            ->assertSeeText('Search')
            ->assertSee('Title')
            ->assertSeeText('Dept')
            ->assertSee('EI1')
            ->assertSee('EI2')
            ->assertSee('EI3')
            ->assertSee('EI4')
            ->assertSee('EI5')
            ->assertSee('EI6')
            ->assertSee('EI7')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('Title')
            ->assertSeeText('Area')
            ->assertSeeText('Dept')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Uploaded by')
            ->assertSeeText('Attach')
            ->assertSeeText('Edit')
            ->assertDontSeeText('Delete');
    }

    public function testGetDocumentsSuperAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);

        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/documents')
            ->assertSeeText('Documents')
            ->assertSeeText('New document')
            ->assertSeeText('Search')
            ->assertSee('Title')
            ->assertSeeText('Dept')
            ->assertSee('EI1')
            ->assertSee('EI2')
            ->assertSee('EI3')
            ->assertSee('EI4')
            ->assertSee('EI5')
            ->assertSee('EI6')
            ->assertSee('EI7')
            ->assertSeeText('Displays')
            ->assertSeeText('entries')
            ->assertSeeText('Title')
            ->assertSeeText('Area')
            ->assertSeeText('Dept')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Uploaded by')
            ->assertSeeText('Attach')
            ->assertSeeText('Edit')
            ->assertSeeText('Delete');
    }

    // NEW DOCUMENT
    public function testGetNewDocumentGuest()
    {

        $this->get('/document-registration')
            ->assertRedirectToRoute('login');
    }

    public function testGetNewDocumentEmployee()
    {
        $this->seed([UserRoleSeeder::class, DocumentSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class,]);

        Auth::attempt(['nik' => '55000153', 'password' => 'rahasia']);

        $this
            ->get('/document-registration')
            ->assertSeeText('New document')
            ->assertSeeText('Table')
            ->assertSeeText('Title')
            ->assertSeeText('Area')
            ->assertSee('BO3')
            ->assertSee('CH3')
            ->assertSee('SP3')
            ->assertSee('SP5')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Attachment')
            ->assertSeeText('Maximum upload file size: 25 MB.')
            ->assertSeeText('Submit');
    }

    public function testGetNewDocumentSuperAdmin()
    {
        $this->seed([UserRoleSeeder::class, DocumentSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class,]);

        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-registration')
            ->assertSeeText('New document')
            ->assertSeeText('Table')
            ->assertSeeText('Title')
            ->assertSeeText('Area')
            ->assertSee('BO3')
            ->assertSee('CH3')
            ->assertSee('SP3')
            ->assertSee('SP5')
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Attachment')
            ->assertSeeText('Maximum upload file size: 25 MB.')
            ->assertSeeText('Submit');
    }

    // DOCUMENT REGISTER
    public function testPostDocumentRegisterGuest()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $attachment = UploadedFile::fake()->image('attachment.png');

        $this->post('/document-register', [
            'id' => uniqid(),
            'title' => 'Schematic diagram panel turbo vacuum PM3',
            'area' => 'PM3',
            'department' => 'EI2',
            'equipment' => null,
            'funcloc' => null,
            'uploaded_by' => 'Doni Darmawan',
            'attachment' => $attachment,
        ])
            ->assertRedirectToRoute('login');

        $saved_attachment = Storage::disk('documents')->get('attachment.png');
        self::assertNull($saved_attachment);
    }

    public function testPostDocumentRegisterSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $id = uniqid();
        $attachment = UploadedFile::fake()->image($id . '.png');


        Auth::attempt(['nik' => '55000153', 'password' => 'rahasia']);

        $this->get('/document-registration');

        $this
            ->followingRedirects()
            ->post('/document-register', [
                'id' => $id,
                'title' => 'Schematic diagram panel turbo vacuum PM3',
                'area' => 'PM3',
                'department' => 'EI2',
                'equipment' => null,
                'funcloc' => null,
                'uploaded_by' => 'Doni Darmawan',
                'attachment' => $attachment,
            ])
            ->assertSeeText('The document successfully saved.');

        $saved_attachment = Storage::disk('documents')->get($id . '.png');
        self::assertNotNull($saved_attachment);
    }

    // ID
    public function testPostDocumentRegisterSuccessIdNotSet()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $id = uniqid();
        $attachment = UploadedFile::fake()->image($id . '.jpeg');


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this->get('/document-registration');

        $this
            ->followingRedirects()
            ->post('/document-register', [
                'title' => 'Schematic diagram panel turbo vacuum PM3',
                'area' => 'PM3',
                'department' => 'EI2',
                'equipment' => null,
                'funcloc' => null,
                'uploaded_by' => 'Doni Darmawan',
                'attachment' => $attachment,
            ])
            ->assertSeeText('The document successfully saved.');
    }

    // TITLE
    public function testPostDocumentRegisterFailedTitleNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $id = uniqid();
        $attachment = UploadedFile::fake()->image($id . '.jpeg');


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this->get('/document-registration');

        $this
            ->followingRedirects()
            ->post('/document-register', [
                'id' => $id,
                'title' => null,
                'area' => 'PM3',
                'department' => 'EI2',
                'equipment' => null,
                'funcloc' => null,
                'uploaded_by' => 'Doni Darmawan',
                'attachment' => $attachment,
            ])
            ->assertSeeText('The title field is required.')
            ->assertDontSeeText('The document successfully saved.');
    }

    public function testPostDocumentRegisterFailedTitleInvalidLengthMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $id = uniqid();
        $attachment = UploadedFile::fake()->image($id . '.jpeg');


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this->get('/document-registration');

        $this
            ->followingRedirects()
            ->post('/document-register', [
                'id' => $id,
                'title' => 'Invalid title',
                'area' => 'PM3',
                'department' => 'EI2',
                'equipment' => null,
                'funcloc' => null,
                'uploaded_by' => 'Doni Darmawan',
                'attachment' => $attachment,
            ])
            ->assertSeeText('The title field must be at least 15 characters.')
            ->assertDontSeeText('The document successfully saved.');
    }

    public function testPostDocumentRegisterFailedTitleInvalidLengthMax()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $id = uniqid();
        $attachment = UploadedFile::fake()->image($id . '.jpeg');


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this->get('/document-registration');

        $this
            ->followingRedirects()
            ->post('/document-register', [
                'id' => $id,
                'title' => 'This is invalid title because maximum allowed title length is 50 characters.',
                'area' => 'PM3',
                'department' => 'EI2',
                'equipment' => null,
                'funcloc' => null,
                'uploaded_by' => 'Doni Darmawan',
                'attachment' => $attachment,
            ])
            ->assertSeeText('The title field must not be greater than 50 characters.')
            ->assertDontSeeText('The document successfully saved.');
    }

    // AREA
    public function testPostDocumentRegisterFailedAreaNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $id = uniqid();
        $attachment = UploadedFile::fake()->image($id . '.jpeg');


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this->get('/document-registration');

        $this
            ->followingRedirects()
            ->post('/document-register', [
                'id' => $id,
                'title' => 'Schematic diagram panel turbo vacuum PM3',
                'area' => null,
                'equipment' => null,
                'funcloc' => null,
                'uploaded_by' => 'Doni Darmawan',
                'attachment' => $attachment,
            ])
            ->assertSeeText('The area field is required.')
            ->assertDontSeeText('The document successfully saved.');
    }

    public function testPostDocumentRegisterFailedAreaInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $id = uniqid();
        $attachment = UploadedFile::fake()->image($id . '.jpeg');


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this->get('/document-registration');

        $this
            ->followingRedirects()
            ->post('/document-register', [
                'id' => $id,
                'title' => 'Schematic diagram panel turbo vacuum PM3',
                'area' => 'GK5',
                'department' => 'EI2',
                'equipment' => null,
                'funcloc' => null,
                'uploaded_by' => 'Doni Darmawan',
                'attachment' => $attachment,
            ])
            ->assertSeeText('The selected area is invalid.')
            ->assertDontSeeText('The document successfully saved.');
    }

    public function testPostDocumentRegisterSuccessAreaAll()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $id = uniqid();
        $attachment = UploadedFile::fake()->image($id . '.jpeg');


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this->get('/document-registration');

        $this
            ->followingRedirects()
            ->post('/document-register', [
                'id' => $id,
                'title' => 'Schematic diagram panel turbo vacuum PM3',
                'area' => 'All',
                'department' => 'EI2',
                'equipment' => null,
                'funcloc' => null,
                'uploaded_by' => 'Doni Darmawan',
                'attachment' => $attachment,
            ])
            ->assertDontSeeText('The area field is required.')
            ->assertDontSeeText('The selected area is invalid.')
            ->assertSeeText('The document successfully saved.');
    }

    // EQUIPMENT
    public function testPostDocumentRegisterSuccessEquipmentNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $id = uniqid();
        $attachment = UploadedFile::fake()->image($id . '.jpeg');


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this->get('/document-registration');

        $this
            ->followingRedirects()
            ->post('/document-register', [
                'id' => $id,
                'title' => 'Schematic diagram panel turbo vacuum PM3',
                'area' => 'All',
                'department' => 'EI2',
                'equipment' => null,
                'funcloc' => null,
                'uploaded_by' => 'Doni Darmawan',
                'attachment' => $attachment,
            ])
            ->assertDontSeeText('The equipment field is required.')
            ->assertDontSeeText('The selected equipment is invalid.')
            ->assertSeeText('The document successfully saved.');
    }

    public function testPostDocumentRegisterFailedEquipmentInvalidLength()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $id = uniqid();
        $attachment = UploadedFile::fake()->image($id . '.jpeg');


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this->get('/document-registration');

        $this
            ->followingRedirects()
            ->post('/document-register', [
                'id' => $id,
                'title' => 'Schematic diagram panel turbo vacuum PM3',
                'area' => 'All',
                'department' => 'EI2',
                'equipment' => 'EMO0001234',
                'funcloc' => null,
                'uploaded_by' => 'Doni Darmawan',
                'attachment' => $attachment,
            ])
            ->assertSeeText('The equipment field must be 9 characters.')
            ->assertDontSeeText('The document successfully saved.');
    }

    // FUNCLOC
    public function testPostDocumentRegisterSuccessFunclocNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $id = uniqid();
        $attachment = UploadedFile::fake()->image($id . '.jpeg');


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this->get('/document-registration');

        $this
            ->followingRedirects()
            ->post('/document-register', [
                'id' => $id,
                'title' => 'Schematic diagram panel turbo vacuum PM3',
                'area' => 'All',
                'department' => 'EI2',
                'equipment' => 'EMO000123',
                'funcloc' => null,
                'uploaded_by' => 'Doni Darmawan',
                'attachment' => $attachment,
            ])
            ->assertDontSeeText('The funcloc field is required.')
            ->assertSeeText('The document successfully saved.');
    }

    public function testPostDocumentRegisterFailedFunclocInvalidLengthMax()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $id = uniqid();
        $attachment = UploadedFile::fake()->image($id . '.jpeg');


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this->get('/document-registration');

        $this
            ->followingRedirects()
            ->post('/document-register', [
                'id' => $id,
                'title' => 'Schematic diagram panel turbo vacuum PM3',
                'area' => 'All',
                'department' => 'EI2',
                'equipment' => 'EMO000123',
                'funcloc' => 'This is invalid funcloc because max allowed funcloc length is fifty characters.',
                'uploaded_by' => 'Doni Darmawan',
                'attachment' => $attachment,
            ])
            ->assertSeeText('The funcloc field must not be greater than 50 characters.')
            ->assertDontSeeText('The document successfully saved.');
    }

    // ATTACHMENT
    public function testPostDocumentRegisterFailedAttachmentNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $id = uniqid();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this->get('/document-registration');

        $this
            ->followingRedirects()
            ->post('/document-register', [
                'id' => $id,
                'title' => 'Schematic diagram panel turbo vacuum PM3',
                'area' => 'All',
                'department' => 'EI2',
                'equipment' => 'EMO000123',
                'funcloc' => 'FP-01-PM3',
                'uploaded_by' => 'Doni Darmawan',
                'attachment' => null,
            ])
            ->assertSeeText('The attachment field is required.')
            ->assertDontSeeText('The document successfully saved.');
    }

    public function testPostDocumentRegisterFailedAttachmentInvalidType()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $id = uniqid();

        $attachment = UploadedFile::fake()->create('attachment', 500, 'cdr');


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this->get('/document-registration');

        $this
            ->followingRedirects()
            ->post('/document-register', [
                'id' => $id,
                'title' => 'Schematic diagram panel turbo vacuum PM3',
                'area' => 'All',
                'department' => 'EI2',
                'equipment' => 'EMO000123',
                'funcloc' => 'FP-01-PM3',
                'uploaded_by' => 'Doni Darmawan',
                'attachment' => $attachment,
            ])
            ->assertSeeText('The attachment field must be a file of type: png, jpeg, jpg, xlsx, xls, ods, doc, docx, pdf.')
            ->assertDontSeeText('The document successfully updated.');
    }

    public function testPostDocumentRegisterFailedAttachmentInvalidMaxSize()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $id = uniqid();

        $attachment = UploadedFile::fake()->create('attachment', 26000, 'pdf');


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this->get('/document-registration');

        $this
            ->followingRedirects()
            ->post('/document-register', [
                'id' => $id,
                'title' => 'Schematic diagram panel turbo vacuum PM3',
                'area' => 'All',
                'department' => 'EI2',
                'equipment' => 'EMO000123',
                'funcloc' => 'FP-01-PM3',
                'uploaded_by' => 'Doni Darmawan',
                'attachment' => $attachment,
            ])
            ->assertSeeText('The attachment field must not be greater than 25000 kilobytes.')
            ->assertDontSeeText('The document successfully updated.');
    }

    // DOCUMENT EDIT 
    public function testGetDocumentEditGuest()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        self::assertNotNull($documents);
        self::assertTrue(count($documents) > 10);

        $this->get('/document-edit/' . $documents->first()->id)
            ->assertRedirectToRoute('login');
    }

    public function testGetDocumentEditEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        self::assertNotNull($documents);
        self::assertTrue(count($documents) > 10);


        Auth::attempt(['nik' => '55000153', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $documents->first()->id)
            ->assertSeeText('Edit document')
            ->assertSeeText('Table')
            ->assertSeeText($documents->first()->id)
            ->assertSeeText('Title')
            ->assertSee($documents->first()->title)
            ->assertSeeText('Area')
            ->assertSee($documents->first()->area)
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Attachment')
            ->assertSeeText('Existing')
            ->assertSeeText('Maximum upload file size: 25 MB.')
            ->assertSeeText('Save changes')
            ->assertDontSeeText('Submit');
    }

    public function testGetDocumentEditAhorized()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        self::assertNotNull($documents);
        self::assertTrue(count($documents) > 10);


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $documents->first()->id)
            ->assertSeeText('Edit document')
            ->assertSeeText('Table')
            ->assertSeeText($documents->first()->id)
            ->assertSeeText('Title')
            ->assertSee($documents->first()->title)
            ->assertSeeText('Area')
            ->assertSee($documents->first()->area)
            ->assertSeeText('Equipment')
            ->assertSeeText('Funcloc')
            ->assertSeeText('Attachment')
            ->assertSeeText('Existing')
            ->assertSeeText('Maximum upload file size: 25 MB.')
            ->assertSeeText('Save changes')
            ->assertDontSeeText('Submit');
    }

    // DOCUMENT UPDATE
    public function testPostDocumentUpdateSuccess()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $documents->first()->id);

        $attachment = UploadedFile::fake()->image('attachment.png');
        $documentService = $this->app->make(DocumentService::class);
        $documentService->saveAttachment($attachment, 'attachment');

        $this
            ->followingRedirects()
            ->post('/document-update', [
                'id' => $documents->first()->id,
                'title' => $documents->first()->title,
                'department' => 'EI2',
                'area' => $documents->first()->area,
                'equipment' => $documents->first()->equipment,
                'funcloc' => $documents->first()->funcloc,
                'uploaded_by' => $documents->first()->uploaded_by,
                'attachment' => $attachment,
            ])
            ->assertSeeText('The document successfully updated.');

        $saved_attachment = Storage::disk('documents')->get('attachment.png');
        self::assertNotNull($saved_attachment);
    }

    // ID
    public function testPostDocumentUpdateFailedIdNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $documents->first()->id);

        $attachment = UploadedFile::fake()->image('attachment.png');

        $this
            ->followingRedirects()
            ->post('/document-update', [
                'id' => null,
                'title' => $documents->first()->title,
                'area' => $documents->first()->area,
                'equipment' => $documents->first()->equipment,
                'funcloc' => $documents->first()->funcloc,
                'uploaded_by' => $documents->first()->uploaded_by,
                'attachment' => $attachment,
            ])
            ->assertSeeText('The id field is required.')
            ->assertDontSeeText('The document successfully updated.');
    }

    public function testPostDocumentUpdateFailedInvalidId()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $documents->first()->id);

        $attachment = UploadedFile::fake()->image('attachment.png');

        $this
            ->followingRedirects()
            ->post('/document-update', [
                'id' => uniqid(),
                'title' => $documents->first()->title,
                'area' => $documents->first()->area,
                'equipment' => $documents->first()->equipment,
                'funcloc' => $documents->first()->funcloc,
                'uploaded_by' => $documents->first()->uploaded_by,
                'attachment' => $attachment,
            ])
            ->assertSeeText('The selected id is invalid.')
            ->assertDontSeeText('The document successfully updated.');
    }

    public function testPostDocumentUpdateFailedInvalidIdLength()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $documents->first()->id);

        $attachment = UploadedFile::fake()->image('attachment.png');

        $this
            ->followingRedirects()
            ->post('/document-update', [
                'id' => uniqid() . 'a3f',
                'title' => $documents->first()->title,
                'area' => $documents->first()->area,
                'equipment' => $documents->first()->equipment,
                'funcloc' => $documents->first()->funcloc,
                'uploaded_by' => $documents->first()->uploaded_by,
                'attachment' => $attachment,
            ])
            ->assertSeeText('The id field must be 13 characters.')
            ->assertDontSeeText('The document successfully updated.');
    }

    // TITLE
    public function testPostDocumentUpdateFailedTitleNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        $document = $documents->first();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $document->id);

        $attachment = UploadedFile::fake()->image('attachment.png');

        $this
            ->followingRedirects()
            ->post('/document-update', [
                'id' => $document->title,
                'title' => null,
                'area' => $document->area,
                'equipment' => $document->equipment,
                'funcloc' => $document->funcloc,
                'uploaded_by' => $document->uploaded_by,
                'attachment' => $attachment,
            ])
            ->assertSeeText('The title field is required.')
            ->assertDontSeeText('The document successfully updated.');
    }

    public function testPostDocumentUpdateFailedInvalidTitleLengthMin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        $document = $documents->first();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $document->id);

        $attachment = UploadedFile::fake()->image('attachment.png');

        $this
            ->followingRedirects()
            ->post('/document-update', [
                'id' => $document->id,
                'title' => 'Invalid',
                'area' => $document->area,
                'equipment' => $document->equipment,
                'funcloc' => $document->funcloc,
                'uploaded_by' => $document->uploaded_by,
                'attachment' => $attachment,
            ])
            ->assertSeeText('The title field must be at least 15 characters.')
            ->assertDontSeeText('The document successfully updated.');
    }

    public function testPostDocumentUpdateFailedInvalidTitleLengthMax()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        $document = $documents->first();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $document->id);

        $attachment = UploadedFile::fake()->image('attachment.png');

        $this
            ->followingRedirects()
            ->post('/document-update', [
                'id' => $document->id,
                'title' => 'This is invalid title beacuse characters length is more than fifty',
                'area' => $document->area,
                'equipment' => $document->equipment,
                'funcloc' => $document->funcloc,
                'uploaded_by' => $document->uploaded_by,
                'attachment' => $attachment,
            ])
            ->assertSeeText('The title field must not be greater than 50 characters.')
            ->assertDontSeeText('The document successfully updated.');
    }

    // AREA
    public function testPostDocumentUpdateFailedAreaNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        $document = $documents->first();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $document->id);

        $attachment = UploadedFile::fake()->image('attachment.png');

        $this
            ->followingRedirects()
            ->post('/document-update', [
                'id' => $document->id,
                'title' => $document->title,
                'area' => null,
                'equipment' => $document->equipment,
                'funcloc' => $document->funcloc,
                'uploaded_by' => $document->uploaded_by,
                'attachment' => $attachment,
            ])
            ->assertSeeText('The area field is required.')
            ->assertDontSeeText('The document successfully updated.');
    }

    public function testPostDocumentUpdateFailedAreaInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        $document = $documents->first();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $document->id);

        $attachment = UploadedFile::fake()->image('attachment.png');

        $this
            ->followingRedirects()
            ->post('/document-update', [
                'id' => $document->id,
                'title' => $document->title,
                'area' => 'GK5',
                'equipment' => $document->equipment,
                'funcloc' => $document->funcloc,
                'uploaded_by' => $document->uploaded_by,
                'attachment' => $attachment,
            ])
            ->assertSeeText('The selected area is invalid.')
            ->assertDontSeeText('The document successfully updated.');
    }

    // EQUIPMENT
    public function testPostDocumentUpdateSuccessEquipmentNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        $document = $documents->first();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $document->id);

        $attachment = UploadedFile::fake()->image('attachment.png');

        $this
            ->followingRedirects()
            ->post('/document-update', [
                'id' => $document->id,
                'title' => $document->title,
                'area' => 'CH3',
                'department' => 'EI2',
                'equipment' => null,
                'funcloc' => $document->funcloc,
                'uploaded_by' => $document->uploaded_by,
                'attachment' => $attachment,
            ])
            ->assertDontSeeText('The equipment field is required.')
            ->assertDontSeeText('The equipment area is invalid.')
            ->assertSeeText('The document successfully updated.');
    }

    public function testPostDocumentUpdateFailedInvalidEquipmentLength()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        $document = $documents->first();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $document->id);

        $attachment = UploadedFile::fake()->image('attachment.png');

        $this
            ->followingRedirects()
            ->post('/document-update', [
                'id' => $document->id,
                'title' => $document->title,
                'area' => 'CH3',
                'department' => 'EI2',
                'equipment' => 'EMO0001234',
                'funcloc' => $document->funcloc,
                'uploaded_by' => $document->uploaded_by,
                'attachment' => $attachment,
            ])
            ->assertSeeText('The equipment field must be 9 characters')
            ->assertDontSeeText('The document successfully updated.');
    }

    public function testPostDocumentUpdateSuccessFunclocNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        $document = $documents->first();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $document->id);

        $attachment = UploadedFile::fake()->image('attachment.png');

        $this
            ->followingRedirects()
            ->post('/document-update', [
                'id' => $document->id,
                'title' => $document->title,
                'area' => 'CH3',
                'department' => 'EI2',
                'equipment' => 'EMO000234',
                'funcloc' => null,
                'uploaded_by' => $document->uploaded_by,
                'attachment' => $attachment,
            ])
            ->assertDontSeeText('The funcloc field is required.')
            ->assertSeeText('The document successfully updated.');
    }

    public function testPostDocumentUpdateFailedFunclocInvalidMaxLength()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        $document = $documents->first();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $document->id);

        $attachment = UploadedFile::fake()->image('attachment.png');

        $this
            ->followingRedirects()
            ->post('/document-update', [
                'id' => $document->id,
                'title' => $document->title,
                'area' => 'All',
                'equipment' => 'EMO000234',
                'funcloc' => 'This is invalid funcloc because maximal length is fifty characters',
                'uploaded_by' => $document->uploaded_by,
                'attachment' => $attachment,
            ])
            ->assertSeeText('The funcloc field must not be greater than 50 characters.')
            ->assertDontSeeText('The document successfully updated.');
    }

    // ATTACHMENT
    public function testPostDocumentUpdateSuccessAttachmentNull()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        $document = $documents->first();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $document->id);

        $this
            ->followingRedirects()
            ->post('/document-update', [
                'id' => $document->id,
                'title' => $document->title,
                'area' => 'CH3',
                'department' => 'EI2',
                'equipment' => $document->equipment,
                'funcloc' => $document->funcloc,
                'uploaded_by' => $document->uploaded_by,
                'attachment' => null,
            ])
            ->assertDontSeeText('The attachment field is required.')
            ->assertDontSeeText('The document successfully updated.');
    }

    public function testPostDocumentUpdateFailedAttachmentInvalidType()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        $document = $documents->first();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $document->id);

        $attachment = UploadedFile::fake()->image('attachment.gif');

        $this
            ->followingRedirects()
            ->post('/document-update', [
                'id' => $document->id,
                'title' => $document->title,
                'area' => 'CH3',
                'department' => 'EI2',
                'equipment' => $document->equipment,
                'funcloc' => $document->funcloc,
                'uploaded_by' => $document->uploaded_by,
                'attachment' => $attachment,
            ])
            ->assertSeeText('The attachment field must be a file of type: png, jpeg, jpg, xlsx, xls, ods, doc, docx, pdf.')
            ->assertDontSeeText('The document successfully updated.');
    }

    public function testPostDocumentUpdateFailedAttachmentInvalidMaxSize()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        $document = $documents->first();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->get('/document-edit/' . $document->id);

        $attachment = UploadedFile::fake()->create('attachment', 26000, 'pdf');

        $this
            ->followingRedirects()
            ->post('/document-update', [
                'id' => $document->id,
                'title' => $document->title,
                'area' => 'CH3',
                'department' => 'EI2',
                'equipment' => $document->equipment,
                'funcloc' => $document->funcloc,
                'uploaded_by' => $document->uploaded_by,
                'attachment' => $attachment,
            ])
            ->assertSeeText('The attachment field must not be greater than 25000 kilobytes.')
            ->assertDontSeeText('The document successfully updated.');
    }

    public function testDeleteDocumentGuest()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        $document = $documents->first();

        $this
            ->get('/document-delete/' . $document->id)
            ->assertRedirectToRoute('login');
    }

    public function testDeleteDocumentEmployee()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        $document = $documents->first();


        Auth::attempt(['nik' => '55000135', 'password' => 'rahasia']);

        $this
            ->followingRedirects()
            ->get('/document-delete/' . $document->id)
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testDeleteDocumentSuperAdmin()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);
        $documents = $this->app->make(DocumentServiceImpl::class)->getAll();
        $document = $documents->first();


        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this
            ->followingRedirects()
            ->get('/document-delete/' . $document->id)
            ->assertSeeText('Document successfully deleted.');

        $different_document = Document::query()->find($document->id);
        self::assertNull($different_document);
    }

    public function testDeleteDocumentAuthorizedInvalid()
    {
        $this->seed([UserRoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DocumentSeeder::class]);

        Auth::attempt(['nik' => '55000154', 'password' => 'rahasia']);

        $this->get('/documents');
        $this
            ->followingRedirects()
            ->get('/document-delete/' . uniqid())
            ->assertSeeText('Document not found.');
    }
}

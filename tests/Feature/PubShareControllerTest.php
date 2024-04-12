<?php

namespace Tests\Feature;

use App\Data\Modal;
use App\Models\PubShare;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserRoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PubShareControllerTest extends TestCase
{
    public function testGetPubShareEmployee()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->get('/pub-share')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testGetPubShareAdmin()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/pub-share')
            ->assertSeeText('Pub Share')
            ->assertSeeText('File *')
            ->assertSeeText('Title')
            ->assertSee('Rename')
            ->assertDontSeeText('You are not allowed to perform this operation!');
    }

    public function testGetPubShareSuperAdmin()
    {
        $this->seed([UserRoleSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/pub-share')
            ->assertSeeText('Pub Share')
            ->assertSeeText('File *')
            ->assertSeeText('Title')
            ->assertSee('Rename')
            ->assertDontSeeText('You are not allowed to perform this operation!');
    }

    // POST FILE
    public function testPostPubShareAdminSuccess()
    {
        $this->seed([UserRoleSeeder::class]);

        $this->get('/pub-share');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $image = UploadedFile::fake()->image("Old name" . '.jpg');

        $this
            ->followingRedirects()
            ->post('/pub-share', [
                'file' => $image,
                'title' => 'New name',
            ])
            ->assertSeeText('New name.jpg')
            ->assertDontSeeText('Old name')
            ->assertSeeText('Successfully uploaded.');

        $filesInPubShare = PubShare::all();
        self::assertCount(1, $filesInPubShare);
    }

    public function testPostPubShareAdminSuccessTitleNull()
    {
        $this->seed([UserRoleSeeder::class]);

        $this->get('/pub-share');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $image = UploadedFile::fake()->image("Old name" . '.jpg');

        $this
            ->followingRedirects()
            ->post('/pub-share', [
                'file' => $image,
                'title' => null,
            ])
            ->assertDontSeeText('New name.jpg')
            ->assertSeeText('Old name.jpg')
            ->assertSeeText('Successfully uploaded.');
    }

    public function testPostPubShareAdminFailedFileNull()
    {
        $this->seed([UserRoleSeeder::class]);

        $this->get('/pub-share');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->post('/pub-share', [
                'file' => null,
                'title' => null,
            ])
            ->assertDontSeeText('Successfully uploaded.')
            ->assertSeeText('The file field is required.');
    }

    public function testPostPubShareAdminFailedFileMaxSize()
    {
        $this->seed([UserRoleSeeder::class]);

        $this->get('/pub-share');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $image = UploadedFile::fake()->image("Old name" . '.jpg')->size(41000);

        $this
            ->followingRedirects()
            ->post('/pub-share', [
                'file' => $image,
                'title' => null,
            ])
            ->assertDontSeeText('Successfully uploaded.')
            ->assertSeeText('The file field must not be greater than 40000 kilobytes.');
    }

    public function testPostPubShareAdminFailedTitleMinLength()
    {
        $this->seed([UserRoleSeeder::class]);

        $this->get('/pub-share');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $image = UploadedFile::fake()->image("Old name" . '.jpg');

        $this
            ->followingRedirects()
            ->post('/pub-share', [
                'file' => $image,
                'title' => 'a',
            ])
            ->assertDontSeeText('a.jpg')
            ->assertDontSeeText('Successfully uploaded.')
            ->assertSeeText('The title field must be at least 3 characters.');
    }

    public function testPostPubShareAdminFailedTitleMaxLength()
    {
        $this->seed([UserRoleSeeder::class]);

        $this->get('/pub-share');

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $image = UploadedFile::fake()->image("Old name" . '.jpg');

        $this
            ->followingRedirects()
            ->post('/pub-share', [
                'file' => $image,
                'title' => 'This is invalid title because length is more than 50 character',
            ])
            ->assertDontSeeText('a.jpg')
            ->assertDontSeeText('Successfully uploaded.')
            ->assertSeeText('The title field must not be greater than 30 characters.');
    }

    // DOWNLOAD
    public function testDownloadFileSuccess()
    {
        $this->testPostPubShareAdminSuccess();

        $file = PubShare::query()->first();

        $this
            ->get("/pub-share/$file->id/download")
            ->assertDownload($file->attachment);
    }

    public function testDownloadFileFailedDifferenceAdmin()
    {
        $this->testPostPubShareAdminSuccess();

        $file = PubShare::query()->first();

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get("/pub-share/$file->id/download")
            ->assertStatus(403)
            ->assertSeeText('This action is unauthorized.');
    }

    public function testDownloadFileFailedEmployee()
    {
        $this->testPostPubShareAdminSuccess();

        $file = PubShare::query()->first();

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this
            ->get("/pub-share/$file->id/download")
            ->assertSessionHas([
                'modal' => new Modal('[403] Forbidden', 'You are not allowed to perform this operation!'),
            ]);
    }

    // DELETE
    public function testDeleteFileSameUser()
    {
        $this->testPostPubShareAdminSuccess();

        $filesInPubShare = PubShare::query()->first();
        $id = $filesInPubShare->id;

        $this
            ->followingRedirects()
            ->get("/pub-share/delete/$id")
            ->assertSeeText('Successfully deleted.');
    }

    public function testDeleteFileDifferenceUser()
    {
        $this->testPostPubShareAdminSuccess();

        $filesInPubShare = PubShare::query()->first();
        $id = $filesInPubShare->id;

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia'
        ]);

        $this
            ->followingRedirects()
            ->get("/pub-share/delete/$id")
            ->assertStatus(403)
            ->assertSeeText('This action is unauthorized.')
            ->assertDontSeeText('Successfully deleted.');
    }

    // AUTHORIZATION
    public function testAuthorizableEmployee()
    {
        $this->testPostPubShareAdminSuccess();
        $user = User::query()->find('55000135');
        $file = PubShare::query()->first();

        self::assertFalse($user->can('create', PubShare::class));
        self::assertTrue($user->cannot('create', PubShare::class));
        self::assertFalse($user->can('delete', $file));
        self::assertFalse($user->can('view', $file));
    }

    public function testAuthorizableAdmin()
    {
        $this->testPostPubShareAdminSuccess();

        $user = User::query()->find('55000153');
        $file = PubShare::query()->first();

        self::assertTrue($user->can('create', PubShare::class));
        self::assertFalse($user->cannot('create', PubShare::class));
        self::assertTrue($user->can('delete', $file));
        self::assertTrue($user->can('view', $file));
    }

    public function testAuthorizableOtherAdmin()
    {
        $this->testPostPubShareAdminSuccess();

        $user = User::query()->find('55000154');
        $file = PubShare::query()->first();

        self::assertTrue($user->can('create', PubShare::class));
        self::assertFalse($user->cannot('create', PubShare::class));
        self::assertFalse($user->can('delete', $file));
        self::assertFalse($user->can('view', $file));
    }
}

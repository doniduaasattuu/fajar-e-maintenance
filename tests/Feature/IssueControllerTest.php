<?php

namespace Tests\Feature;

use App\Models\Issue;
use Carbon\Carbon;
use Database\Seeders\IssueSeeder;
use Database\Seeders\UserRoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class IssueControllerTest extends TestCase
{
    public function testGetIssueGuest()
    {
        $this
            ->get('/issues')
            ->assertRedirectToRoute('login');
    }

    public function testGetIssueEmployee()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/issues')
            ->assertDontSeeText('Edit')
            ->assertDontSeeText('Delete')
            ->assertSeeText("What's going on EI2", false);
    }

    public function testGetIssueAdmin(): void
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/issues')
            ->assertSeeText("What's going on EI6", false);
    }

    public function testGetIssueSuperAdmin(): void
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/issues')
            ->assertSeeText("What's going on EI2", false);
    }

    // NEW ISSUE
    public function testNewIssueEmployee()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->get('/issue-registration')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testNewIssueAdmin()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->get('/issue-registration')
            ->assertDontSeeText('You are not allowed to perform this operation!')
            ->assertSeeText('New issue')
            ->assertSeeText('Status *')
            ->assertSeeText('Target date *')
            ->assertSeeText('Section *')
            ->assertSeeText('Area *')
            ->assertSeeText('Description *')
            ->assertSeeText('Corrective action')
            ->assertSeeText('Root cause')
            ->assertSeeText('Preventive action')
            ->assertSeeText('Remark')
            ->assertDontSeeText('Save changes')
            ->assertSeeText('Submit');
    }

    public function testNewIssueSuperAdmin()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->get('/issue-registration')
            ->assertDontSeeText('You are not allowed to perform this operation!')
            ->assertSeeText('New issue')
            ->assertSeeText('Status *')
            ->assertSeeText('Target date *')
            ->assertSeeText('Section *')
            ->assertSeeText('Area *')
            ->assertSeeText('Description *')
            ->assertSeeText('Corrective action')
            ->assertSeeText('Root cause')
            ->assertSeeText('Preventive action')
            ->assertSeeText('Remark')
            ->assertDontSeeText('Save changes')
            ->assertSeeText('Submit');
    }

    // CREATE ISSUE
    public function testCreateIssueEmployee()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->post('/issue-register', [
                'id' => uniqid(),
                'issued_date' => Carbon::now(),
                'target_date' => Carbon::now(),
                'remaining_days' => Carbon::now(),
                'section' => 'ELC',
                'area' => 'SP3',
                'description' => 'Incoming ACB TR.810 micrologic tidak baca phase S',
                'corrective_action' => 'Ganti micrologic dengan spare',
                'root_cause' => 'Lifetime',
                'preventive_action' => 'Ganti dengan ACB ABB dan buat change over power untuk outgoing MDP',
                'status' => 'DONE',
                'remark' => 'Chemical CH7 stop dan PM3 stop fresh water habis',
                'department' => 'EI2',
                'created_by' => 'Doni Darmawan',
                'updated_by' => 'Doni Darmawan',
            ])
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testCreateIssueAdmin()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->get('/issue-registration');

        $this
            ->followingRedirects()
            ->post('/issue-register', [
                'id' => uniqid(),
                'issued_date' => Carbon::now(),
                'target_date' => Carbon::now(),
                'remaining_days' => Carbon::now(),
                'section' => 'ELC',
                'area' => 'SP3',
                'description' => 'Incoming ACB TR.810 micrologic tidak baca phase S',
                'corrective_action' => 'Ganti micrologic dengan spare',
                'root_cause' => 'Lifetime',
                'preventive_action' => 'Ganti dengan ACB ABB dan buat change over power untuk outgoing MDP',
                'status' => 'DONE',
                'remark' => 'Chemical CH7 stop dan PM3 stop fresh water habis',
                'department' => 'EI2',
                'created_by' => 'Doni Darmawan',
                'updated_by' => 'Doni Darmawan',
            ])
            ->assertSeeText('Issue successfully saved.');
    }

    public function testCreateIssueSuperAdmin()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this->get('/issue-registration');

        $this
            ->followingRedirects()
            ->post('/issue-register', [
                'id' => uniqid(),
                'issued_date' => Carbon::now(),
                'target_date' => Carbon::now(),
                'remaining_days' => Carbon::now(),
                'section' => 'ELC',
                'area' => 'SP3',
                'description' => 'Incoming ACB TR.810 micrologic tidak baca phase S',
                'corrective_action' => 'Ganti micrologic dengan spare',
                'root_cause' => 'Lifetime',
                'preventive_action' => 'Ganti dengan ACB ABB dan buat change over power untuk outgoing MDP',
                'status' => 'DONE',
                'remark' => 'Chemical CH7 stop dan PM3 stop fresh water habis',
                'department' => 'EI2',
                'created_by' => 'Doni Darmawan',
                'updated_by' => 'Doni Darmawan',
            ])
            ->assertSeeText('Issue successfully saved.');
    }

    // ISSUE EDIT
    public function testEditIssueEmployee()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->get('/issue-edit/6641c5582fb8b')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testEditIssueAdmin()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->get('/issue-edit/6641c5582fb8b')
            ->assertDontSeeText('You are not allowed to perform this operation!');
    }

    public function testEditIssueAdminNotFound()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->get('/issue-edit/6641c5582ac65')
            ->assertSeeText('Issue not found.');
    }

    public function testEditIssueSuperAdmin()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->get('/issue-edit/6641c5582fb8b')
            ->assertDontSeeText('You are not allowed to perform this operation!')
            ->assertSeeText('NOT')
            ->assertSeeText('Drum thickener SP32 not rotating DT 98 Minute')
            ->assertSeeText('Checking inverter (inverter not trip, Load motor SP32 high = 30A). Info to production for cleaning drum thickener and running well')
            ->assertSeeText('Load motor SP32 high and drum cannot rotating')
            ->assertSeeText('Cleaning drum by production')
            ->assertSee('DT 98 MINUTES FROM PM3')
            ->assertSeeText('Save changes')
            ->assertDontSeeText('Submit');
    }

    // UPDATE ISSUE
    public function testUpdateIssueEmployee()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $issue = Issue::query()->find('6641c5582fb8b');

        $this
            ->followingRedirects()
            ->post('/issue-update', [
                'target_date' => $issue->target_date,
                'remaining_days' => $issue->remaining_days,
                'section' => $issue->section,
                'area' => $issue->area,
                'description' => $issue->description,
                'corrective_action' => $issue->corrective_action,
                'root_cause' => $issue->root_cause,
                'preventive_action' => $issue->preventive_action,
                'status' => $issue->status,
                'remark' => $issue->remark,
                'updated_by' => $issue->updated_by,
            ])
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testUpdateIssueAdmin()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $issue = Issue::query()->find('6641c5582fb8b');

        $this
            ->get('/issue-edit/6641c5582fb8b')
            ->assertSeeText('Drum thickener SP32 not rotating DT 98 Minute');

        $this
            ->followingRedirects()
            ->post('/issue-update', [
                'id' => $issue->id,
                'target_date' => $issue->target_date,
                'remaining_days' => $issue->remaining_days,
                'section' => $issue->section,
                'area' => $issue->area,
                'description' => 'Drum thickener SP32 not rotating DT 150 Minute',
                'corrective_action' => $issue->corrective_action,
                'root_cause' => $issue->root_cause,
                'preventive_action' => $issue->preventive_action,
                'status' => $issue->status,
                'remark' => $issue->remark,
                'updated_by' => $issue->updated_by,
            ])
            ->assertSeeText('Issue successfully updated.');

        $this
            ->get('/issue-edit/6641c5582fb8b')
            ->assertDontSeeText('Drum thickener SP32 not rotating DT 98 Minute')
            ->assertSeeText('Drum thickener SP32 not rotating DT 150 Minute');
    }

    public function testUpdateIssueSuperAdmin()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $issue = Issue::query()->find('6641c5582fb8b');

        $this
            ->get('/issue-edit/6641c5582fb8b')
            ->assertSeeText('Drum thickener SP32 not rotating DT 98 Minute');

        $this
            ->followingRedirects()
            ->post('/issue-update', [
                'id' => $issue->id,
                'target_date' => $issue->target_date,
                'remaining_days' => $issue->remaining_days,
                'section' => $issue->section,
                'area' => $issue->area,
                'description' => 'Drum thickener SP32 not rotating DT 150 Minute',
                'corrective_action' => $issue->corrective_action,
                'root_cause' => $issue->root_cause,
                'preventive_action' => $issue->preventive_action,
                'status' => $issue->status,
                'remark' => $issue->remark,
                'updated_by' => 'Doni Darmawan',
            ])
            ->assertSeeText('Issue successfully updated.');

        $this
            ->get('/issue-edit/6641c5582fb8b')
            ->assertDontSeeText('Drum thickener SP32 not rotating DT 98 Minute')
            ->assertSeeText('Drum thickener SP32 not rotating DT 150 Minute');

        $issue = $issue->refresh();
        $this->assertEquals($issue->updated_by, 'Doni Darmawan');
    }

    // ISSUE DELETE
    public function testDeleteIssueEmployee()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000135',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->get('/issue-delete/6641c5582fb8b')
            ->assertSeeText('You are not allowed to perform this operation!');
    }

    public function testDeleteIssueAdmin()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->get('/issue-delete/6641c5582fb8b')
            ->assertSeeText('Issue successfully deleted.');
    }

    public function testDeleteIssueAdminNotFound()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000153',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->get('/issue-delete/6641c5582ac8a')
            ->assertSeeText('Issue not found.');
    }

    public function testDeleteIssueSuperAdmin()
    {
        $this->seed([UserRoleSeeder::class, IssueSeeder::class]);

        Auth::attempt([
            'nik' => '55000154',
            'password' => 'rahasia',
        ]);

        $this
            ->followingRedirects()
            ->get('/issue-delete/6641c5582fb8b')
            ->assertSeeText('Issue successfully deleted.');
    }
}

<?php

use App\Models\Company;
use App\Models\URL;
use App\Models\User;

test('admin can create short urls', function () {
    $admin = User::factory()->admin()->create();

    $response = $this
        ->actingAs($admin)
        ->post('/urls', [
            'original_url' => 'https://example.com',
        ]);

    $response->assertRedirect(route('url.index'));
    $this->assertDatabaseHas('urls', [
        'original_url' => 'https://example.com',
        'user_id' => $admin->id,
        'company_id' => $admin->company_id,
    ]);
});

test('member can create short urls', function () {
    $member = User::factory()->member()->create();

    $response = $this
        ->actingAs($member)
        ->post('/urls', [
            'original_url' => 'https://example.com',
        ]);

    $response->assertRedirect(route('url.index'));
    $this->assertDatabaseHas('urls', [
        'original_url' => 'https://example.com',
        'user_id' => $member->id,
        'company_id' => $member->company_id,
    ]);
});

test('super admin cannot create short urls', function () {
    $superAdmin = User::factory()->superAdmin()->create();

    $response = $this
        ->actingAs($superAdmin)
        ->post('/urls', [
            'original_url' => 'https://example.com',
        ]);

    $response->assertStatus(403);
});

test('admin can only see urls from their company', function () {
    $company1 = Company::factory()->create();
    $company2 = Company::factory()->create();

    $admin1 = User::factory()->admin()->create(['company_id' => $company1->id]);
    $admin2 = User::factory()->admin()->create(['company_id' => $company2->id]);

    URL::factory()->create(['company_id' => $company1->id, 'user_id' => $admin1->id]);
    URL::factory()->create(['company_id' => $company2->id, 'user_id' => $admin2->id]);

    $response = $this
        ->actingAs($admin1)
        ->get('/');

    $response->assertOk();
    $response->assertSee($company1->name);
    $response->assertDontSee($company2->name);
});

test('member can only see their own urls', function () {
    $company = Company::factory()->create();
    $member1 = User::factory()->member()->create(['company_id' => $company->id]);
    $member2 = User::factory()->member()->create(['company_id' => $company->id]);

    URL::factory()->create(['company_id' => $company->id, 'user_id' => $member1->id]);
    URL::factory()->create(['company_id' => $company->id, 'user_id' => $member2->id]);

    $response = $this
        ->actingAs($member1)
        ->get('/');

    $response->assertOk();
    $response->assertSee($member1->name);
    $response->assertDontSee($member2->name);
});

test('short urls are publicly resolvable and redirect', function () {
    $url = URL::factory()->create(['original_url' => 'https://example.com', 'short_code' => 'abc123']);

    $response = $this->get('/s/abc123');

    $response->assertRedirect('https://example.com');
});
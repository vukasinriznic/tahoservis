<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Repair;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RepairController
 */
final class RepairControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $repairs = Repair::factory()->count(3)->create();

        $response = $this->get(route('repairs.index'));

        $response->assertOk();
        $response->assertViewIs('repairs.index');
        $response->assertViewHas('repairs', $repairs);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('repairs.create'));

        $response->assertOk();
        $response->assertViewIs('repairs.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RepairController::class,
            'store',
            \App\Http\Requests\RepairStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $work_done = fake()->text();
        $seal_number = fake()->word();

        $response = $this->post(route('repairs.store'), [
            'work_done' => $work_done,
            'seal_number' => $seal_number,
        ]);

        $repairs = Repair::query()
            ->where('work_done', $work_done)
            ->where('seal_number', $seal_number)
            ->get();
        $this->assertCount(1, $repairs);
        $repair = $repairs->first();

        $response->assertRedirect(route('repairs.index'));
    }
}

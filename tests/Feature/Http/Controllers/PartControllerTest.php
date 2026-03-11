<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Part;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PartController
 */
final class PartControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $parts = Part::factory()->count(3)->create();

        $response = $this->get(route('parts.index'));

        $response->assertOk();
        $response->assertViewIs('parts.index');
        $response->assertViewHas('parts', $parts);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('parts.create'));

        $response->assertOk();
        $response->assertViewIs('parts.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PartController::class,
            'store',
            \App\Http\Requests\PartStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = fake()->name();
        $code = fake()->word();
        $supplier = fake()->word();
        $quantity = fake()->numberBetween(-10000, 10000);

        $response = $this->post(route('parts.store'), [
            'name' => $name,
            'code' => $code,
            'supplier' => $supplier,
            'quantity' => $quantity,
        ]);

        $parts = Part::query()
            ->where('name', $name)
            ->where('code', $code)
            ->where('supplier', $supplier)
            ->where('quantity', $quantity)
            ->get();
        $this->assertCount(1, $parts);
        $part = $parts->first();

        $response->assertRedirect(route('parts.index'));
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $part = Part::factory()->create();

        $response = $this->get(route('parts.edit', $part));

        $response->assertOk();
        $response->assertViewIs('parts.edit');
        $response->assertViewHas('part', $part);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PartController::class,
            'update',
            \App\Http\Requests\PartUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $part = Part::factory()->create();
        $name = fake()->name();
        $code = fake()->word();
        $supplier = fake()->word();
        $quantity = fake()->numberBetween(-10000, 10000);

        $response = $this->put(route('parts.update', $part), [
            'name' => $name,
            'code' => $code,
            'supplier' => $supplier,
            'quantity' => $quantity,
        ]);

        $part->refresh();

        $response->assertRedirect(route('parts.index'));

        $this->assertEquals($name, $part->name);
        $this->assertEquals($code, $part->code);
        $this->assertEquals($supplier, $part->supplier);
        $this->assertEquals($quantity, $part->quantity);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $part = Part::factory()->create();

        $response = $this->delete(route('parts.destroy', $part));

        $response->assertRedirect(route('parts.index'));

        $this->assertModelMissing($part);
    }
}

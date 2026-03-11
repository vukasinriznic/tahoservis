<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Diagnostic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DiagnosticController
 */
final class DiagnosticControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $diagnostics = Diagnostic::factory()->count(3)->create();

        $response = $this->get(route('diagnostics.index'));

        $response->assertOk();
        $response->assertViewIs('diagnostics.index');
        $response->assertViewHas('diagnostics', $diagnostics);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('diagnostics.create'));

        $response->assertOk();
        $response->assertViewIs('diagnostics.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DiagnosticController::class,
            'store',
            \App\Http\Requests\DiagnosticStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $problem_description = fake()->text();
        $diagnostic_results = fake()->text();

        $response = $this->post(route('diagnostics.store'), [
            'problem_description' => $problem_description,
            'diagnostic_results' => $diagnostic_results,
        ]);

        $diagnostics = Diagnostic::query()
            ->where('problem_description', $problem_description)
            ->where('diagnostic_results', $diagnostic_results)
            ->get();
        $this->assertCount(1, $diagnostics);
        $diagnostic = $diagnostics->first();

        $response->assertRedirect(route('diagnostics.index'));
    }
}

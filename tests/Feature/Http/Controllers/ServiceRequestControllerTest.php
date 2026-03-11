<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ServiceRequestController
 */
final class ServiceRequestControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $serviceRequests = ServiceRequest::factory()->count(3)->create();

        $response = $this->get(route('service-requests.index'));

        $response->assertOk();
        $response->assertViewIs('service_requests.index');
        $response->assertViewHas('serviceRequests', $serviceRequests);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('service-requests.create'));

        $response->assertOk();
        $response->assertViewIs('service_requests.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ServiceRequestController::class,
            'store',
            \App\Http\Requests\ServiceRequestStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $vehicle = Vehicle::factory()->create();
        $tachograph_type = fake()->randomElement(/** enum_attributes **/);
        $description = fake()->text();
        $desired_date = Carbon::parse(fake()->dateTime());
        $phone = fake()->phoneNumber();

        $response = $this->post(route('service-requests.store'), [
            'vehicle_id' => $vehicle->id,
            'tachograph_type' => $tachograph_type,
            'description' => $description,
            'desired_date' => $desired_date,
            'phone' => $phone,
        ]);

        $serviceRequests = ServiceRequest::query()
            ->where('vehicle_id', $vehicle->id)
            ->where('tachograph_type', $tachograph_type)
            ->where('description', $description)
            ->where('desired_date', $desired_date)
            ->where('phone', $phone)
            ->get();
        $this->assertCount(1, $serviceRequests);
        $serviceRequest = $serviceRequests->first();

        $response->assertRedirect(route('service-requests.index'));
    }


    #[Test]
    public function show_displays_view(): void
    {
        $serviceRequest = ServiceRequest::factory()->create();

        $response = $this->get(route('service-requests.show', $serviceRequest));

        $response->assertOk();
        $response->assertViewIs('service_requests.show');
        $response->assertViewHas('serviceRequest', $serviceRequest);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Shipment;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Tests Shipment API
 * Requires correct seeding data from @see DatabaseSeeder
 */
class ApiCreateShipmentTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testShipmentCreateValid()
    {
        $shipmentData = [
            "data" => [
                [
                    "weight" => "567.0",
                    "streetname" => "fsdfsdfsfs",
                    "housenumber" => "54",
                    "postalcode" => "2751av",
                    "city" => "Zoetermeer",
                    "country" => "Netherlands"
                ],
                [
                    "weight" => "567.0",
                    "streetname" => "fsdfsdfsfs",
                    "housenumber" => "50",
                    "postalcode" => "2751av",
                    "city" => "Zoetermeer",
                    "country" => "Netherlands"
                ]
            ]
        ];

        $token = "1:670511b9d8e2a87093c7f50d1a07bb75e0412f9f2ef406205acc66628498f231";

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('POST', '/api/shipment/create', $shipmentData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('shipments', [
            'weight' => '567.0',
        ]);
    }

    public function testShipmentCreateBearerInvalid()
    {
        $shipmentData = [
            "data" => [
                [
                    "weight" => "567.0",
                    "streetname" => "fsdfsdfsfs",
                    "housenumber" => "54",
                    "postalcode" => "2751av",
                    "city" => "Zoetermeer",
                    "country" => "Netherlands"
                ],
                [
                    "weight" => "567.0",
                    "streetname" => "fsdfsdfsfs",
                    "housenumber" => "50",
                    "postalcode" => "2751av",
                    "city" => "Zoetermeer",
                    "country" => "Netherlands"
                ]
            ]
        ];

        $token = "1:670511b9d8e2a87093c7f50d1a07bb75e0412f9f2ef406205acc66628498f231xx";

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('POST', '/api/shipment/create', $shipmentData);

        $response->assertStatus(401);
    }

    public function testShipmentCreateIncompleteShipmentData()
    {
        $shipmentData = [
            "data" => [
                [
                    "weight" => "567.0",
                ],
                [
                    "weight" => "567.0",
                    "streetname" => "fsdfsdfsfs",
                    "housenumber" => "50",
                    "postalcode" => "2751av",
                    "city" => "Zoetermeer",
                    "country" => "Netherlands"
                ]
            ]
        ];

        $token = "1:670511b9d8e2a87093c7f50d1a07bb75e0412f9f2ef406205acc66628498f231";

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('POST', '/api/shipment/create', $shipmentData);

        $response->assertStatus(422);
    }
}

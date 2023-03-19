<?php

namespace Tests\Feature;

use App\Enums\ShipmentStatusEnum;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ApiUpdateShipmentStatusTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /**
     * Make sure shipment status can be updated with correct data.
     * @return void
     */
    public function testShipmentUpdateStatusValid()
    {
        $statusData = [
            "shipmentId" => 1,
            "shipmentStatus" => ShipmentStatusEnum::Sorting
        ];

        $token = "1:670511b9d8e2a87093c7f50d1a07bb75e0412f9f2ef406205acc66628498f231";

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('POST', '/api/shipment/updateStatus', $statusData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('shipment_statuses', [
            'shipment_id' => 1,
            'status' => ShipmentStatusEnum::Sorting,
        ]);
    }

    /**
     * Make sure shipment statuses cannot be skipped.
     * I.e. shipment cannot go from registered directly to delivered.
     * @return void
     */
    public function testShipmentUpdateStatusSkipInValid()
    {
        $statusData = [
            "shipmentId" => 1,
            "shipmentStatus" => ShipmentStatusEnum::Delivered
        ];

        $token = "1:670511b9d8e2a87093c7f50d1a07bb75e0412f9f2ef406205acc66628498f231";

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('POST', '/api/shipment/updateStatus', $statusData);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('shipment_statuses', [
            'shipment_id' => 1,
            'status' => ShipmentStatusEnum::Delivered,
        ]);
    }

    /**
     * Make sure api request with invalid bearer token does not work.
     * @return void
     */
    public function testShipmentStatusUpdateBearerTokenInvalid()
    {
        $statusData = [
            "shipmentId" => 1,
            "shipmentStatus" => ShipmentStatusEnum::Sorting
        ];

        $token = "1:670511b9d8e2a87093c7f50d1a07bb75e0412f9f2ef406205acc66628498f231xx";

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('POST', '/api/shipment/updateStatus', $statusData);

        $response->assertStatus(401);

        $this->assertDatabaseMissing('shipment_statuses', [
            'shipment_id' => 1,
            'status' => ShipmentStatusEnum::Sorting,
        ]);
    }

    /**
     * Make sure api request with invalid bearer token store token does not work.
     * @return void
     */
    public function testShipmentStatusUpdateBearerStoreInvalid()
    {
        $statusData = [
            "shipmentId" => 1,
            "shipmentStatus" => ShipmentStatusEnum::Sorting
        ];

        $token = "2:670511b9d8e2a87093c7f50d1a07bb75e0412f9f2ef406205acc66628498f231xx";

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('POST', '/api/shipment/updateStatus', $statusData);

        $response->assertStatus(401);

        $this->assertDatabaseMissing('shipment_statuses', [
            'shipment_id' => 1,
            'status' => ShipmentStatusEnum::Sorting,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Store;

use App\Enums\ShipmentStatusEnum;
use App\Helpers\TrackingNumberGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\LabelCreateRequest;
use App\Models\Carrier;
use App\Models\Shipment;
use App\Models\ShipmentStatus;
use Illuminate\Http\Request;
use TCPDF;

class LabelController extends Controller
{
    public function createForm(Request $request) {
        $shipments = $this->getShipments($request->shipment_id);

        if ($request->input('action') == 'label') {
            $carriers = Carrier::all();
            $shipmentIds = $request->shipment_id;

            return view('store.labels.createForm', compact('shipments', 'carriers', 'shipmentIds'));
        } else if ($request->input('action') == 'print') {
            $this->printLabels($shipments);
        } else {
            return to_route('store.shipments.overview');
        }
    }

    private function printLabels($shipments) {
        $pdf = new TCPDF();

        foreach($shipments as $shipment) {
            $pdf->AddPage('L');

            // define barcode style
            $style = array(
                'position' => '',
                'align' => 'C',
                'stretch' => false,
                'fitwidth' => true,
                'cellfitalign' => '',
                'border' => false,
                'hpadding' => 'auto',
                'vpadding' => 'auto',
                'fgcolor' => array(0,0,0),
                'bgcolor' => false, //array(255,255,255),
                'text' => true,
                'font' => 'helvetica',
                'fontsize' => 18,
                'stretchtext' => 1
            );

            $storeAddress = $shipment->store->address;
            $customerAddress = $shipment->address;

            $pdf->SetFont('helvetica', '', 20);
            $pdf->Cell(0, 0, 'Afzender:', 0, 1);
            $pdf->SetFont('helvetica', '', 18);
            $pdf->Cell(0, 0, $shipment->store->name, 0, 2);
            $pdf->Cell(0, 0, $storeAddress->street_name . ' ' . $storeAddress->house_number, 0, 3);
            $pdf->Cell(0, 0, $storeAddress->postal_code . ' ' . $storeAddress->city, 0, 4);

            $pdf->Ln(3 * $pdf->getFontSize());

            $pdf->SetFont('helvetica', '', 20);
            $pdf->Cell(0, 0, 'Ontvanger:', 0, 10);
            $pdf->SetFont('helvetica', '', 18);
            $pdf->Cell(0, 0, $customerAddress->first_name . ' ' . $customerAddress->last_name, 0, 1);
            $pdf->Cell(0, 0, $customerAddress->street_name . ' ' . $customerAddress->house_number, 0, 2);
            $pdf->Cell(0, 0, $customerAddress->postal_code . ' ' . $customerAddress->city, 0, 3);

            $pdf->Ln(3 * $pdf->getFontSize());
            $pdf->Cell(0, 0, $shipment->carrier->name, 0, 1);
            $pdf->write1DBarcode($shipment->tracking_number, 'C39', 7, 120, 200, 48, 0.4, $style, 'N');
        }

        $pdf->Output('verzendlabels.pdf', 'D');
    }

    public function store(LabelCreateRequest $request)
    {
        $request->validated();
        $carrier = Carrier::find($request->carrier_id);

        $shipments = $this->getShipments($request->shipment_id);
        foreach($shipments as $shipment) {
            // Update shipment
            $shipment->carrier()->associate($carrier);
            $shipment->tracking_number = TrackingNumberGenerator::generate($shipment->id, $carrier->name);
            $shipment->save();

            // Update shipment status
            ShipmentStatus::create([
                'status' => ShipmentStatusEnum::Printed,
                'shipment_id' => $shipment->id
            ]);
        }

        return to_route('store.shipments.overview');
    }

    private function getShipments($ids) {
        return Shipment::whereIn('id', array_values($ids))->get();
    }
}

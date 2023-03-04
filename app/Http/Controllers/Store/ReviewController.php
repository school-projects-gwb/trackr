<?php


namespace App\Http\Controllers\Store;


use App\Http\Controllers\Controller;
use App\Models\ShipmentReview;
use App\Models\Webstore;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    private string $defaultSortField = 'created_at';
    private array $sortableFields = ['id', 'rating', 'created_at', 'shipment_id'];

    public function overview(Request $request)
    {
        $storeId = $request->cookie('selected_store_id');

        $sortField = request('sort', $this->defaultSortField);
        $sortDirection = request('dir', 'asc');
        $sortableFields = $this->sortableFields;
        $itemsPerPage = 15;

        $reviews = ShipmentReview::whereHas('shipment', function ($query) use ($storeId) {
            $query->where('webstore_id', $storeId);
        })->paginate($itemsPerPage);

        return view('store.reviews.overview', compact('reviews', 'sortField', 'sortDirection', 'sortableFields'));
    }
}

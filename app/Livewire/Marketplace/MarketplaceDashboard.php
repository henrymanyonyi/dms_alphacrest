<?php

namespace App\Livewire\Marketplace;

use App\Models\DataSector;
use App\Models\DataParameter;
use App\Models\DataPoint;
use App\Models\Purchase;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.marketplace')]
class MarketplaceDashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedSector = '';
    public $selectedParameter = '';
    public $priceRange = 'all';
    public $sortBy = 'latest';
    public $viewMode = 'grid'; // grid or list

    // Preview modal
    public $previewingDataPoint = null;
    public $showPreview = false;

    // Purchase modal
    public $purchasingDataPoint = null;
    public $showPurchase = false;
    public $paymentMethod = 'mpesa';
    public $phoneNumber = '';
    public $agreedToTerms = false;

    protected $queryString = ['search', 'selectedSector', 'selectedParameter', 'priceRange', 'sortBy'];

    public function render()
    {
        $sectors = DataSector::where('is_active', true)
            ->withCount('parameters')
            ->get();

        $parameters = DataParameter::where('is_active', true)
            ->when($this->selectedSector, function ($query) {
                $query->where('data_sector_id', $this->selectedSector);
            })
            ->with('sector')
            ->get();

        $dataPoints = DataPoint::with(['parameter.sector', 'attachments'])
            ->where('is_active', true)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('data_source', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedSector, function ($query) {
                $query->whereHas('parameter', function ($q) {
                    $q->where('data_sector_id', $this->selectedSector);
                });
            })
            ->when($this->selectedParameter, function ($query) {
                $query->where('data_parameter_id', $this->selectedParameter);
            })
            ->when($this->sortBy === 'latest', function ($query) {
                $query->latest();
            })
            ->when($this->sortBy === 'oldest', function ($query) {
                $query->oldest();
            })
            ->when($this->sortBy === 'name', function ($query) {
                $query->orderBy('name', 'asc');
            })
            ->paginate($this->viewMode === 'grid' ? 12 : 10);

        // Calculate stats
        $stats = [
            'total_datasets' => DataPoint::where('is_active', true)->count(),
            'sectors' => DataSector::where('is_active', true)->count(),
            'total_downloads' => rand(1200, 5000), // Replace with actual download count
            'avg_rating' => 4.7
        ];

        return view('livewire.marketplace.marketplace-dashboard', [
            'sectors' => $sectors,
            'parameters' => $parameters,
            'dataPoints' => $dataPoints,
            'stats' => $stats
        ]);
    }

    public function previewData($id)
    {
        $this->previewingDataPoint = DataPoint::with(['parameter.sector', 'attachments', 'creator'])
            ->findOrFail($id);
        $this->showPreview = true;
    }

    public function closePreview()
    {
        $this->showPreview = false;
        $this->previewingDataPoint = null;
    }

    public function initiatePurchase($id)
    {
        $this->purchasingDataPoint = DataPoint::with(['parameter.sector', 'attachments'])
            ->findOrFail($id);
        $this->showPurchase = true;
        $this->showPreview = false;
    }

    public function processPurchase()
    {
        $this->validate([
            'paymentMethod' => 'required|in:mpesa,card,paypal',
            'phoneNumber' => 'required_if:paymentMethod,mpesa|regex:/^[0-9]{9}$/',
            'agreedToTerms' => 'accepted',
        ]);

        $purchase = Purchase::create([
            'user_id' => auth()->id(),
            'customer_email' => auth()->user()->email ?? 'guest@example.com',
            'customer_phone' => $this->phoneNumber,
            'data_point_id' => $this->purchasingDataPoint->id,
            'amount' => $this->getPrice($this->purchasingDataPoint),
            'payment_method' => $this->paymentMethod,
            'status' => 'pending',
        ]);

        if ($this->paymentMethod === 'mpesa') {
            // // Initiate M-Pesa STK Push
            // $mpesa = new \Safaricom\Mpesa\Mpesa();
            // $response = $mpesa->STKPush(
            //     $purchase->order_id,
            //     $purchase->amount,
            //     '254' . $this->phoneNumber,
            //     'Payment for ' . $this->purchasingDataPoint->name
            // );

            // if ($response->ResponseCode == 0) {
            //     session()->flash('purchase_success', 'Payment request sent! Check your phone.');
            // }
        }

        if ($this->paymentMethod === 'card') {
            // \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            // $intent = \Stripe\PaymentIntent::create([
            //     'amount' => $purchase->amount * 100, // Convert to cents
            //     'currency' => 'kes',
            //     'metadata' => ['order_id' => $purchase->order_id],
            // ]);

            // // Return client secret for frontend payment
            // return redirect()->to('/payment/card?intent=' . $intent->client_secret);
        }

        // use App\Notifications\PurchaseCompleted;

        // // After successful payment
        // $purchase->update(['status' => 'completed']);
        // $purchase->user->notify(new PurchaseCompleted($purchase));

        $this->closePurchase();
    }

    public function closePurchase()
    {
        $this->showPurchase = false;
        $this->purchasingDataPoint = null;
        $this->reset(['phoneNumber', 'agreedToTerms']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedSector()
    {
        $this->selectedParameter = '';
        $this->resetPage();
    }

    public function updatingSelectedParameter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'selectedSector', 'selectedParameter', 'priceRange', 'sortBy']);
        $this->resetPage();
    }

    // Helper method to get price for a data point
    public function getPrice($dataPoint)
    {
        // You can implement dynamic pricing based on data point attributes
        $basePrice = 500; // Base price in KES
        $attachmentPrice = $dataPoint->attachments->count() * 100;
        return $basePrice + $attachmentPrice;
    }
}

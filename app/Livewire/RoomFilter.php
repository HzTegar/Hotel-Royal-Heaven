<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Kamar;
use App\Models\TipeKamar;
use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RoomFilter extends Component
{
    use WithPagination;

    public $search = '';
    public $type = '';
    public $min_price = '';
    public $max_price = '';
    public $check_in = '';
    public $check_out = '';
    public $capacity = '';
    public $facilities = '';
    public $sort = 'recommendation';

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'min_price' => ['except' => ''],
        'max_price' => ['except' => ''],
        'check_in' => ['except' => ''],
        'check_out' => ['except' => ''],
        'capacity' => ['except' => ''],
        'facilities' => ['except' => ''],
        'sort' => ['except' => 'recommendation'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function updatingMinPrice()
    {
        $this->resetPage();
    }

    public function updatingMaxPrice()
    {
        $this->resetPage();
    }

    public function updatingCheckIn()
    {
        $this->resetPage();
    }

    public function updatingCheckOut()
    {
        $this->resetPage();
    }

    public function updatingCapacity()
    {
        $this->resetPage();
    }

    public function updatingFacilities()
    {
        $this->resetPage();
    }

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Kamar::with(['tipe', 'reviews'])
            ->where('status_ketersediaan', 'available');

        // Search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nomor_kamar', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
                  ->orWhereHas('tipe', function ($subQ) {
                      $subQ->where('nama_tipe', 'like', '%' . $this->search . '%')
                           ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Room type filter
        if ($this->type) {
            $query->where('id_tipe', $this->type);
        }

        // Price range filters
        if ($this->min_price) {
            $query->whereHas('tipe', function ($q) {
                $q->where('harga_dasar', '>=', $this->min_price);
            });
        }

        if ($this->max_price) {
            $query->whereHas('tipe', function ($q) {
                $q->where('harga_dasar', '<=', $this->max_price);
            });
        }

        // Capacity filter
        if ($this->capacity) {
            $query->whereHas('tipe', function ($q) {
                $q->where('kapasitas', '>=', $this->capacity);
            });
        }

        // Facilities filter
        if ($this->facilities) {
            $query->whereHas('tipe', function ($q) {
                $q->where('fasilitas', 'like', '%' . $this->facilities . '%');
            });
        }

        // Date availability filter
        if ($this->check_in && $this->check_out) {
            $checkIn = Carbon::parse($this->check_in);
            $checkOut = Carbon::parse($this->check_out);

            $query->whereDoesntHave('pemesanans', function ($q) use ($checkIn, $checkOut) {
                $q->where(function ($bookingQ) use ($checkIn, $checkOut) {
                    $bookingQ->where('status_pemesanan', 'confirmed')
                             ->where(function ($dateQ) use ($checkIn, $checkOut) {
                                 $dateQ->whereBetween('tgl_check_in', [$checkIn, $checkOut])
                                       ->orWhereBetween('tgl_check_out', [$checkIn, $checkOut])
                                       ->orWhere(function ($overlapQ) use ($checkIn, $checkOut) {
                                           $overlapQ->where('tgl_check_in', '<=', $checkIn)
                                                    ->where('tgl_check_out', '>=', $checkOut);
                                       });
                             });
                });
            });
        }

        // Sorting
        switch ($this->sort) {
            case 'price_low':
                $query->join('tipe_kamar', 'kamar.id_tipe', '=', 'tipe_kamar.id_tipe')
                      ->orderBy('tipe_kamar.harga_dasar', 'asc')
                      ->select('kamar.*');
                break;
            case 'price_high':
                $query->join('tipe_kamar', 'kamar.id_tipe', '=', 'tipe_kamar.id_tipe')
                      ->orderBy('tipe_kamar.harga_dasar', 'desc')
                      ->select('kamar.*');
                break;
            case 'rating':
                $query->leftJoin('reviews', 'kamar.id_kamar', '=', 'reviews.id_kamar')
                      ->select('kamar.*', DB::raw('AVG(reviews.rating) as avg_rating'))
                      ->groupBy('kamar.id_kamar')
                      ->orderBy('avg_rating', 'desc');
                break;
            case 'newest':
                $query->orderBy('kamar.created_at', 'desc');
                break;
            default: // recommendation
                $query->orderBy('kamar.created_at', 'desc');
                break;
        }

        $kamars = $query->paginate(10);
        $tipeKamars = TipeKamar::whereHas('kamars', function ($q) {
            $q->where('status_ketersediaan', 'available');
        })->get();

        return view('livewire.room-filter', [
            'kamars' => $kamars,
            'tipeKamars' => $tipeKamars,
        ]);
    }
}

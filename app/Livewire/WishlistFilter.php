<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Wishlist;
use App\Models\TipeKamar;
use Illuminate\Support\Facades\Auth;

class WishlistFilter extends Component
{
    use WithPagination;

    public $search = '';
    public $tipe_kamar = '';
    public $status = '';
    public $harga_min = '';
    public $harga_max = '';
    public $sort = 'latest';

    protected $queryString = [
        'search' => ['except' => ''],
        'tipe_kamar' => ['except' => ''],
        'status' => ['except' => ''],
        'harga_min' => ['except' => ''],
        'harga_max' => ['except' => ''],
        'sort' => ['except' => 'latest'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTipeKamar()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingHargaMin()
    {
        $this->resetPage();
    }

    public function updatingHargaMax()
    {
        $this->resetPage();
    }

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Wishlist::where('id_user', Auth::id())
            ->with(['kamar.tipe']);

        // Search functionality
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('kamar', function ($kamarQuery) {
                    $kamarQuery->where('nomor_kamar', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('kamar.tipe', function ($tipeQuery) {
                    $tipeQuery->where('nama_tipe', 'like', '%' . $this->search . '%');
                });
            });
        }

        // Filter by room type
        if ($this->tipe_kamar) {
            $query->whereHas('kamar.tipe', function ($q) {
                $q->where('id_tipe', $this->tipe_kamar);
            });
        }

        // Filter by availability
        if ($this->status) {
            $query->whereHas('kamar', function ($q) {
                $q->where('status_ketersediaan', $this->status);
            });
        }

        // Filter by price range
        if ($this->harga_min) {
            $query->whereHas('kamar.tipe', function ($q) {
                $q->where('harga_dasar', '>=', $this->harga_min);
            });
        }

        if ($this->harga_max) {
            $query->whereHas('kamar.tipe', function ($q) {
                $q->where('harga_dasar', '<=', $this->harga_max);
            });
        }

        // Sort options
        switch ($this->sort) {
            case 'price_low':
                $query->join('kamar', 'wishlists.id_kamar', '=', 'kamar.id_kamar')
                      ->join('tipe_kamar', 'kamar.id_tipe', '=', 'tipe_kamar.id_tipe')
                      ->orderBy('tipe_kamar.harga_dasar', 'asc')
                      ->select('wishlists.*');
                break;
            case 'price_high':
                $query->join('kamar', 'wishlists.id_kamar', '=', 'kamar.id_kamar')
                      ->join('tipe_kamar', 'kamar.id_tipe', '=', 'tipe_kamar.id_tipe')
                      ->orderBy('tipe_kamar.harga_dasar', 'desc')
                      ->select('wishlists.*');
                break;
            case 'name':
                $query->join('kamar', 'wishlists.id_kamar', '=', 'kamar.id_kamar')
                      ->orderBy('kamar.nomor_kamar', 'asc')
                      ->select('wishlists.*');
                break;
            default:
                $query->latest();
                break;
        }

        $wishlists = $query->paginate(12);

        // Get filter options
        $tipeKamarOptions = TipeKamar::whereHas('kamars', function ($q) {
            $q->whereHas('wishlists', function ($w) {
                $w->where('id_user', Auth::id());
            });
        })->get();

        return view('livewire.wishlist-filter', [
            'wishlists' => $wishlists,
            'tipeKamarOptions' => $tipeKamarOptions,
        ]);
    }
}

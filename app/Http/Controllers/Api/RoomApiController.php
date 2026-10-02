<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Resources\RoomResource;

class RoomApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Kamar::with('tipe');

        if ($request->filled('type')) {
            $query->whereHas('tipe', function($q) use ($request){
                $q->where('nama_tipe', 'like', '%'.$request->input('type').'%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status_ketersediaan', $request->input('status'));
        }

        $kamars = $query->paginate(10);
        return RoomResource::collection($kamars)->additional(['meta' => [
            'current_page' => $kamars->currentPage(),
            'last_page' => $kamars->lastPage(),
            'per_page' => $kamars->perPage(),
            'total' => $kamars->total(),
        ]]);
    }

    public function show($id)
    {
        $kamar = Kamar::with('tipe')->findOrFail($id);
        return new RoomResource($kamar);
    }

    public function store(StoreRoomRequest $request)
    {
        $this->authorizeAdmin();

        $k = Kamar::create($request->validated());
        return (new RoomResource($k))->response()->setStatusCode(201);
    }

    public function update(UpdateRoomRequest $request, $id)
    {
        $this->authorizeAdmin();
        $kamar = Kamar::findOrFail($id);
        $kamar->update($request->validated());
        return new RoomResource($kamar);
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();
        $k = Kamar::findOrFail($id);
        $k->delete();
        return response()->json(['message' => 'deleted']);
    }

    protected function authorizeAdmin()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user || (($user->role ?? '') !== 'admin')) {
            abort(403);
        }
    }
}

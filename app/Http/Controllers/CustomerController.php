<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\CustomerRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Customer;
use Storage;
use Auth;


class CustomerController extends Controller
{

    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Customer::query();

//        Filter name
        if ($name = $request->get('name', '')) {
            $query->where('name', 'like', "%$name%");
        }

//        Filter surname
        if ($surname = $request->get('surname', '')) {
            $query->where('surname', 'like', "%$surname%");
        }

//        orderBy
        if ($orderBy = $request->get('sortBy')) {
            $sortDesct = $request->get('sortDesc', 'false');
            if ($sortDesct === 'true') {
                $query->orderBy($orderBy, 'desc');
            } else {
                $query->orderBy($orderBy);
            }
        } else {
            $query->orderBy('id');
        }

//        pagination
        if ($request->get('page', '')) {
            $perPage = $request->get('perPage', 10);
            $customers = $query->paginate($perPage);
        } else {
            $customers = $query->get();
        }

        return CustomerResource::collection($customers);
    }

    public function store(CustomerRequest $request): JsonResponse
    {
        $request->offsetSet('creator_id', Auth::user()->id);

        $customer = Customer::create($request->except('photo'));

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {

            $pathImage = $request->file('photo')->store('customer_photos', 'public');

            $customer->photo = $pathImage;
            $customer->save();
        }

        return response()->json([
            'message' => 'Successfully created customer!'
        ], 201);
    }

    public function show(Customer $customer): CustomerResource
    {
        return new CustomerResource($customer);
    }

    public function update(CustomerRequest $request, Customer $customer): JsonResponse
    {
        $request->offsetSet('updater_id', Auth::user()->id);
        $customer->update($request->only(['name', 'surname', 'updater_id']));

        return response()->json([
            'message' => 'Successfully updated customer!'
        ]);
    }

    public function destroy(Customer $customer): JsonResponse
    {
        $customer->delete();

        return response()->json([
            'message' => 'Successfully deleted customer!'
        ]);
    }

    public function uploadPhoto(Request $request, Customer $customer)
    {

        $request->validate([
            'photo' => [
                'required',
                'image',
                Rule::dimensions()->maxWidth(500)->maxHeight(500)
            ],
        ]);

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {

            $pathImage = $request->file('photo')->store('customer_photos', 'public');

            if ($customer->photo) {
                Storage::delete('public/' . $customer->photo);
            }

            $customer->photo = $pathImage;
            $customer->save();

            return response()->json([
                'message' => 'Successfully uploaded customer photo!'
            ]);
        }

        return response()->json([
            'message' => "The customer's photo could not be uploaded"
        ], 500);


    }

    public function deletePhoto(Customer $customer): JsonResponse
    {

        if ($customer->photo) {
            Storage::delete('public/' . $customer->photo);
            $customer->photo = null;
            $customer->save();
        }

        return response()->json([
            'message' => 'Successfully deleted customer photo!'
        ]);

    }
}

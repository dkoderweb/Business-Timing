<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use DataTables;
use Storage;

class BusinessController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $businesses = Business::all();
    
            return DataTables::of($businesses)
                ->addColumn('action', function ($business) {
                    return '<a href="' . route('businesses.edit', $business->id) . '" class="btn btn-warning btn-sm">Edit</a>
                            <form action="' . route('businesses.destroy', $business->id) . '" method="POST" style="display: inline;">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>
                            </form>';
                })
                ->make(true);
        }
    
        return view('business.index');
    }

    public function create()
    {
        return view('business.create');
    }

    public function store(Request $request)
    {
        $this->validateBusiness($request);

        $logoPath = $this->handleLogo($request);

        Business::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'logo' => $logoPath,
        ]);

        return redirect()->route('businesses.index')->with('success', 'Business created successfully.');
    }

    public function show($id)
    {
        $business = Business::findOrFail($id);
        return view('business.show', compact('business'));
    }

    public function edit($id)
    {
        $business = Business::findOrFail($id);
        return view('business.edit', compact('business'));
    }

    public function update(Request $request, $id)
    {
        $this->validateBusiness($request, $id);

        $business = Business::findOrFail($id);

        $business->logo = $this->handleLogo($request, $business);

        $business->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('businesses.index')->with('success', 'Business updated successfully.');
    }

    public function destroy($id)
    {
        $business = Business::findOrFail($id);
        
        $this->deleteLogo($business);

        $business->delete();

        return redirect()->route('businesses.index')->with('success', 'Business deleted successfully.');
    }

    private function validateBusiness(Request $request, $id = null)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:businesses,email,' . $id,
            'phone_number' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $request->validate($rules);
    }

    private function handleLogo(Request $request, Business $business = null)
    {
        if ($request->hasFile('logo')) {
            // New logo is selected
            if ($business && $business->logo) {
                // Delete old logo
                Storage::disk('public')->delete($business->logo);
            }
            // Store the new logo
            return $request->file('logo')->store('logos', 'public');
        }

        // No new logo selected, return the existing logo path
        return $business ? $business->logo : null;
    }


    private function deleteLogo(Business $business)
    {
        if ($business->logo) {
            Storage::disk('public')->delete($business->logo);
        }
    }
}

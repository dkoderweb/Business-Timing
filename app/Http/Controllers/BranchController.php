<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Business;
use DataTables;
use Storage;

class BranchController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $branches = Branch::with('business')->get();

            return DataTables::of($branches)
                ->addColumn('sunday_timing', function ($branch) {
                    return $this->formatTiming($branch->sunday_timing);
                })
                ->addColumn('monday_timing', function ($branch) {
                    return $this->formatTiming($branch->monday_timing);
                })
                ->addColumn('tuesday_timing', function ($branch) {
                    return $this->formatTiming($branch->tuesday_timing);
                })
                ->addColumn('wednesday_timing', function ($branch) {
                    return $this->formatTiming($branch->wednesday_timing);
                })
                ->addColumn('thursday_timing', function ($branch) {
                    return $this->formatTiming($branch->thursday_timing);
                })
                ->addColumn('friday_timing', function ($branch) {
                    return $this->formatTiming($branch->friday_timing);
                })
                ->addColumn('saturday_timing', function ($branch) {
                    return $this->formatTiming($branch->saturday_timing);
                })
                ->addColumn('action', function ($branch) {
                    return '<a href="' . route('branches.show', $branch->id) . '" class="btn btn-info btn-sm">View</a>
                            <a href="' . route('branches.edit', $branch->id) . '" class="btn btn-warning btn-sm">Edit</a>
                            <form action="' . route('branches.destroy', $branch->id) . '" method="POST" style="display: inline;">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>
                            </form>';
                })
                ->make(true);
        }

        return view('branch.index');
    }

    private function formatTiming($timing)
    {
        return $timing['closed'] ? 'Closed' : implode(', ', array_map(fn ($time) => "{$time['start']} - {$time['end']}", $timing['timing']));
    }

    public function create()
    {
        $businesses = Business::all();
        return view('branch.create', compact('businesses'));
    }

    public function store(Request $request)
    {
        $this->validateBranch($request);

        $images = $this->handleImages($request);

        $branch = Branch::create([
            'business_id' => $request->input('business_id'),
            'name' => $request->input('name'),
            'sunday_timing' => $this->getTimingArray($request, 'sunday'),
            'monday_timing' => $this->getTimingArray($request, 'monday'),
            'tuesday_timing' => $this->getTimingArray($request, 'tuesday'),
            'wednesday_timing' => $this->getTimingArray($request, 'wednesday'),
            'thursday_timing' => $this->getTimingArray($request, 'thursday'),
            'friday_timing' => $this->getTimingArray($request, 'friday'),
            'saturday_timing' => $this->getTimingArray($request, 'saturday'),
            'date_close' => $request->input('closing_dates'),  
            'images' => json_encode($images), 
        ]);


        return redirect()->route('branches.index')->with('success', 'Branch created successfully!');
    }

    public function update(Request $request, $id)
    {
        $this->validateBranch($request);

        $branch = Branch::findOrFail($id);

        $images = $this->handleImages($request, $branch);

        $branch->update([
            'business_id' => $request->input('business_id'),
            'name' => $request->input('name'),
            'sunday_timing' => $this->getTimingArray($request, 'sunday'),
            'monday_timing' => $this->getTimingArray($request, 'monday'),
            'tuesday_timing' => $this->getTimingArray($request, 'tuesday'),
            'wednesday_timing' => $this->getTimingArray($request, 'wednesday'),
            'thursday_timing' => $this->getTimingArray($request, 'thursday'),
            'friday_timing' => $this->getTimingArray($request, 'friday'),
            'saturday_timing' => $this->getTimingArray($request, 'saturday'),
            'date_close' => $request->input('closing_dates'),
            'images' => json_encode($images),
        ]);


        return redirect()->route('branches.index')->with('success', 'Branch updated successfully!');
    }

    private function validateBranch(Request $request)
    {
        $rules = [
            'business_id' => 'required|exists:businesses,id',
            'name' => 'required',
            'date_close' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

        foreach ($days as $day) {
            $closedKey = $day . '_closed';
            $startKey = $day . '_timing_start';
            $endKey = $day . '_timing_end';

            $rules[$closedKey] = 'sometimes|required|in:on';

            $rules[$startKey] = $request->has($closedKey) && $request->input($closedKey) === 'on' ? 'array' : 'required|array';
            $rules[$endKey] = $request->has($closedKey) && $request->input($closedKey) === 'on' ? 'array' : 'required|array';
        }

        $request->validate($rules);
    }

    private function getTimingArray(Request $request, $day)
    {
        $startTimes = $request->input($day . '_timing_start');
        $endTimes = $request->input($day . '_timing_end');
        $closed = $request->has($day . '_closed');

        $timingArray = [];

        if ($startTimes && $endTimes) {
            foreach ($startTimes as $key => $startTime) {
                $timingArray[] = [
                    'start' => $startTime,
                    'end' => $endTimes[$key],
                ];
            }
        }

        return [
            'timing' => $timingArray,
            'closed' => $closed,
        ];
    }
    public function show($id)
    {
         $branch = Branch::findOrFail($id);
        return view('branch.show', compact('branch'));
    }
    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        $businesses = Business::all();
        return view('branch.edit', compact('branch', 'businesses'));
    }



    private function handleImages(Request $request, $branch = null)
    {
        $images = [];
    
        if ($request->hasFile('images')) {
            if ($branch && $branch->images) {
                $oldImages = json_decode($branch->images, true);
                foreach ($oldImages as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
    
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                $images[] = $path;
            }
        } elseif ($branch) {
            $images = json_decode($branch->images, true);
        }
    
        return $images;
    }
    


    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return redirect()->route('branches.index')->with('success', 'Branch deleted successfully.');
    } 
}

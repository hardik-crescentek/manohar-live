<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Land;
use App\Models\Plant;
use App\Models\WaterEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LandsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $lands = Land::with('plant')->orderBy('id', 'desc')->get();
            return response()->json(['status' => 200, 'data' => $lands], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:120',
                'plant_id' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'address' => 'required',
                'plants' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $fileName = apiFileUpload('lands', $request->image);

            $createLand = Land::create([
                'image' => $fileName,
                'name' => $request->name,
                'plant_id' => $request->plant_id,
                'address' => $request->address,
                'plants' => $request->plants
            ]);

            if ($createLand) {
                return response()->json(['status' => 200, 'message' => 'Land added successfully!', 'data' => $createLand], 200);
            } else {
                throw new \Exception('Something went wrong!');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $land = Land::findOrFail($id);
            $plants = Plant::pluck('name', 'id')->toArray();
            return response()->json(['status' => 200, 'data' => ['land' => $land, 'plants' => $plants]], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 404, 'message' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:120',
                'plant_id' => 'required',
                'address' => 'required',
                'plants' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $updateLand = Land::where('id', $id)->update([
                'name' => $request->name,
                'plant_id' => $request->plant_id,
                'address' => $request->address,
                'plants' => $request->plants
            ]);

            if ($request->image != '') {
                $land = Land::where('id', $id)->first();

                if (isset($land->image) && $land->image != null) {
                    $fileName = fileUpload('lands', $request->image, $land->image);
                } else {
                    $fileName = fileUpload('lands', $request->image);
                }

                $land->image = $fileName;
                $land->save();
            }

            if ($updateLand) {
                return response()->json(['status' => 200, 'message' => 'Land updated successfully!', 'data' => $updateLand], 200);
            } else {
                throw new \Exception('Something went wrong!');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deleteLand = Land::where('id', $id)->delete();

            if ($deleteLand) {
                return response()->json(['status' => 200, 'message' => 'Land deleted successfully!', 'data' => []], 200);
            } else {
                throw new \Exception('Error deleting land');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function saveWater(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'land_id' => 'required',
                'land_part_id' => 'required',
                'date' => 'required',
                'time' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $createWaterEntry = WaterEntry::create([
                'user_id' => Auth::user()->id,
                'land_id' => $request->land_id,
                'land_part_id' => $request->land_part_id,
                'date' => date('Y-m-d', strtotime($request->date)),
                'time' => date('H:i:s', strtotime($request->time)),
                'person' => $request->person,
                'volume' => $request->volume,
                'notes' => $request->notes
            ]);

            if ($createWaterEntry) {
                return response()->json(['status' => 200, 'message' => 'Water Entry added successfully!', 'data' => $createWaterEntry], 200);
            } else {
                throw new \Exception('Something went wrong!');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    public function getWaterLandPartWise(Request $request, $id)
    {

        try {
            $waterEntries = WaterEntry::whereJsonContains('land_part_id', $id)->orderBy('id', 'desc')->get();
            return response()->json(['status' => 200, 'data' => $waterEntries], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    // public function updateWaterLandPartWise(Request $request, $id)
    // {
    //     \Log::info("API Called");
    //     \Log::info($request->all());

    //     try {
    //         // // Validate the input data
    //         // $validator = Validator::make($request->all(), [
    //         //     'land_id' => 'required',
    //         //     'land_part_id' => 'required', // Ensure it's an array
    //         //     // 'land_part_id.*' => 'integer', // Ensure each item in the array is an integer
    //         //     'date' => 'nullable', // Allow empty date, but validate if provided
    //         //     'time' => 'nullable', // Allow empty time, but validate if provided
    //         // ]);


    //         $validator = Validator::make($request->all(), [
    //             'land_id' => 'required|integer',
    //             'land_part_id' => 'required|array', // Ensure it's an array
    //             'land_part_id.*' => 'integer', // Ensure each item in the array is an integer
    //             'date' => 'nullable|date_format:Y-m-d', // Validate date format if provided
    //             'time' => 'nullable|date_format:H:i:s', // Validate time format if provided
    //         ]);

    //         if ($validator->fails()) {
    //             throw new \Exception($validator->errors()->first());
    //         }

    //         // Ensure land_part_id is an array
    //         $landPartIds = $request->input('land_part_id');

    //         // If it's a string (stringified array), decode it
    //         if (is_string($landPartIds)) {
    //             $landPartIds = json_decode($landPartIds, true);
    //         }

    //         // Ensure it's an array after decoding (if needed)
    //         if (!is_array($landPartIds)) {
    //             throw new \Exception('Invalid land_part_id format.');
    //         }

    //         // Find the water entry by ID
    //         $waterEntry = WaterEntry::find($id);

    //         if (!$waterEntry) {
    //             throw new \Exception('Water entry not found.');
    //         }

    //         // If date is provided, convert it to the correct format (Y-m-d)
    //         $date = !empty($request->date) ? date('Y-m-d', strtotime($request->date)) : null;

    //         // If time is provided, convert it to the correct format (H:i:s)
    //         $time = !empty($request->time) ? date('H:i:s', strtotime($request->time)) : null;

    //         // Update the water entry
    //         $waterEntry->update([
    //             'land_id' => $request->land_id,
    //             'land_part_id' => $landPartIds, // Update with the array
    //             'date' => $date, // If no date, it will remain null
    //             'time' => $time, // If no time, it will remain null
    //             'person' => $request->person ?? null, // If person is empty, set as null
    //             'volume' => $request->volume ?? null, // If volume is empty, set as null
    //             'notes' => $request->notes ?? null, // If notes are empty, set as null
    //         ]);

    //         return response()->json(['status' => 200, 'message' => 'Water Entry updated successfully!', 'data' => $waterEntry], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
    //     }
    // }

    // public function updateWaterLandPartWise(Request $request, $id)
    // {
    //     \Log::info("API Called");
    //     \Log::info($request->all());

    //     try {
    //         // Convert 'land_part_id[]' to 'land_part_id' if it exists
    //         if ($request->has('land_part_id[]')) {
    //             $landPartIds = $request->input('land_part_id[]');

    //             // Convert string keys to integers
    //             if (is_array($landPartIds)) {
    //                 $landPartIds = array_map('intval', $landPartIds); // Convert each item to an integer
    //             }

    //             // Replace 'land_part_id[]' with 'land_part_id' in the request
    //             $request->merge(['land_part_id' => $landPartIds]);
    //         }

    //         // Validate the input data
    //         $validator = Validator::make($request->all(), [
    //             'land_id' => 'required|integer',
    //             'land_part_id' => 'required|array', // Ensure it's an array
    //             'land_part_id.*' => 'integer', // Ensure each item in the array is an integer
    //             'date' => 'nullable|date_format:Y-m-d', // Validate date format if provided
    //             'time' => 'nullable|date_format:H:i:s', // Validate time format if provided
    //         ]);

    //         if ($validator->fails()) {
    //             throw new \Exception($validator->errors()->first());
    //         }

    //         // Find the water entry by ID
    //         $waterEntry = WaterEntry::find($id);

    //         if (!$waterEntry) {
    //             throw new \Exception('Water entry not found.');
    //         }

    //         // If date is provided, convert it to the correct format
    //         $date = !empty($request->date) ? date('Y-m-d', strtotime($request->date)) : null;

    //         // If time is provided, convert it to the correct format
    //         $time = !empty($request->time) ? date('H:i:s', strtotime($request->time)) : null;

    //         // Update the water entry
    //         $waterEntry->update([
    //             'land_id' => $request->land_id,
    //             'land_part_id' => $request->land_part_id, // Use the converted array
    //             'date' => $date, // Set null if no date provided
    //             'time' => $time, // Set null if no time provided
    //             'person' => $request->person ?? null, // Set null if empty
    //             'volume' => $request->volume ?? null, // Set null if empty
    //             'notes' => $request->notes ?? null, // Set null if empty
    //         ]);

    //         return response()->json([
    //             'status' => 200,
    //             'message' => 'Water Entry updated successfully!',
    //             'data' => $waterEntry
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 400,
    //             'message' => $e->getMessage()
    //         ], 400);
    //     }
    // }

    public function updateWaterLandPartWise(Request $request, $id)
    {
        \Log::info("API Called");
        \Log::info($id);
        \Log::info($request->all());

        try {
            // Convert 'land_part_id[]' to 'land_part_id' if it exists
            if ($request->has('land_part_id[]')) {
                $landPartIds = $request->input('land_part_id[]');

                // Convert each item to a string and ensure it's wrapped in double quotes
                if (is_array($landPartIds)) {
                    $landPartIds = array_map(function ($id) {
                        return (string)$id; // Convert to string
                    }, $landPartIds);
                }

                // Replace 'land_part_id[]' with 'land_part_id' in the request
                $request->merge(['land_part_id' => $landPartIds]);
            }

            // Validate the input data
            $validator = Validator::make($request->all(), [
                'land_id' => 'required|integer',
                'land_part_id' => 'required|array', // Ensure it's an array
                'land_part_id.*' => 'integer', // Ensure each item in the array is an integer
                'date' => 'nullable|date_format:Y-m-d',
                'time' => 'nullable|date_format:H:i:s',
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            // Find the water entry by ID
            $waterEntry = WaterEntry::find($id);

            if (!$waterEntry) {
                throw new \Exception('Water entry not found.');
            }

            // If date is provided, convert it to the correct format
            $date = !empty($request->date) ? date('Y-m-d', strtotime($request->date)) : null;

            // If time is provided, convert it to the correct format
            $time = !empty($request->time) ? date('H:i:s', strtotime($request->time)) : null;

            // Convert land_part_id to JSON format
            $landPartIdsJson = json_encode($request->land_part_id);

            // Update the water entry
            $waterEntry->update([
                'land_id' => $request->land_id,
                'land_part_id' => $landPartIdsJson, // Save as JSON string
                'date' => $date,
                'time' => $time,
                'person' => $request->person ?? null,
                'volume' => $request->volume ?? null,
                'notes' => $request->notes ?? null,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Water Entry updated successfully!',
                'data' => $waterEntry
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }




    public function destroyWaterLandPartWise(string $id)
    {
        try {
            $deleteWaterEntry = WaterEntry::where('id', $id)->delete();

            if ($deleteWaterEntry) {
                return response()->json(['status' => 200, 'message' => 'Water entry deleted successfully!', 'data' => []], 200);
            } else {
                throw new \Exception('Error deleting water entry');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FertilizerEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class FertilizerEntryController extends Controller
{
    public function saveFertilizerEntry(Request $request)
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

            $createFertilizerEntry = FertilizerEntry::create([
                'user_id' => Auth::user()->id,
                'land_id' => $request->land_id,
                'land_part_id' => $request->land_part_id,
                'fertilizer_name' => $request->fertilizer_name,
                'date' => date('Y-m-d', strtotime($request->date)),
                'time' => date('H:i:s', strtotime($request->time)),
                'person' => $request->person
            ]);

            if ($createFertilizerEntry) {
                return response()->json(['status' => 200, 'message' => 'Fertilizer Entry added successfully!', 'data' => $createFertilizerEntry], 200);
            } else {
                throw new \Exception('Something went wrong!');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    public function getFertilizerPlotWise(Request $request, $id)
    {

        try {
            $fertilizerEntries = FertilizerEntry::whereJsonContains('land_part_id', $id)->orderBy('id', 'desc')->get();
            return response()->json(['status' => 200, 'data' => $fertilizerEntries], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()], 400);
        }
    }

    public function updateFertilizerPlotWise(Request $request, $id)
    {
        \Log::info("API Called");
        \Log::info($id);
        \Log::info($request->all());

        try {
            // Convert 'land_part_id[]' to 'land_part_id' if it exists
            if ($request->has('land_part_id[]')) {
                $landPartIds = $request->input('land_part_id[]');

                // Convert string keys to integers
                if (is_array($landPartIds)) {
                    $landPartIds = array_map('intval', $landPartIds); // Convert each item to an integer
                }

                // Replace 'land_part_id[]' with 'land_part_id' in the request
                $request->merge(['land_part_id' => $landPartIds]);
            }

            // Validate the input data
            $validator = Validator::make($request->all(), [
                'land_id' => 'required|integer',
                'land_part_id' => 'required|array', // Ensure it's an array
                'land_part_id.*' => 'integer', // Ensure each item in the array is an integer
                'date' => 'nullable', // Validate date format if provided
                'time' => 'nullable', // Validate time format if provided
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            // Find the FertilizerEntry record
            $fertilizerEntry = FertilizerEntry::find($id);

            if (!$fertilizerEntry) {
                throw new \Exception('Fertilizer entry not found.');
            }

            // If date is provided, convert it to the correct format
            $date = !empty($request->date) ? date('Y-m-d', strtotime($request->date)) : null;

            // If time is provided, convert it to the correct format
            $time = !empty($request->time) ? date('H:i:s', strtotime($request->time)) : null;

            // Update the FertilizerEntry record
            $fertilizerEntry->update([
                'land_id' => $request->land_id,
                'land_part_id' => $request->land_part_id, // Use the converted array
                'fertilizer_name' => $request->fertilizer_name ?? null, // Set null if empty
                'date' => $date, // Set null if no date provided
                'time' => $time, // Set null if no time provided
                'person' => $request->person ?? null, // Set null if empty
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Fertilizer Entry updated successfully!',
                'data' => $fertilizerEntry
            ], 200);
        } catch (\Exception $e) {
            \Log::error("Error updating fertilizer entry: " . $e->getMessage());

            return response()->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    public function destroyFertilizerPlotWise(string $id)
    {
        try {
            $deleteFertilizerEntries = FertilizerEntry::where('id', $id)->delete();

            if ($deleteFertilizerEntries) {
                return response()->json(['status' => 200, 'message' => 'Fertilizer Entry deleted successfully!', 'data' => []], 200);
            } else {
                throw new \Exception('Error deleting FertilizerEntry Entry');
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }
}

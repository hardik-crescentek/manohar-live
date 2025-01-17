<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Google\Client as GoogleClient;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $admins = User::role('admin')->orderBy('id', 'desc')->get();
            return response()->json(['status' => 200, 'data' => $admins], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|max:120|unique:users',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $createAdmin = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            // $permissionsAr = $request->permissions;
            $createAdmin->assignRole(2);
            // $createAdmin->syncPermissions($permissionsAr);

            return response()->json(['status' => 200, 'message' => 'Admin added successfully!', 'data' => $createAdmin], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    /**
     * Display the specified resource for editing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $admin = User::findOrFail($id);

            return response()->json(['status' => 200, 'message' => 'Admin edit.', 'data' => $admin], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email,'.$id,
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first());
            }

            $admin = User::find($id);

            if (!$admin) {
                throw new \Exception('Admin not found');
            }

            $admin->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            return response()->json(['status' => 200, 'message' => 'Admin updated successfully!', 'data' => $admin], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $admin = User::find($id);

            if (!$admin) {
                throw new \Exception('User not found');
            }

            $admin->delete();
            $admins = User::role('admin')->orderBy('id', 'desc')->get();
            return response()->json(['status' => 200, 'message' => 'Admin deleted successfully', 'data' => $admins], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => []], 400);
        }
    }

    public function sendPushNotification(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string',
        ]);
        $devicetoken = request()->get('device_token');
        $credentialsFilePath = public_path('service-account.json');

        $client = new GoogleClient();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();

        // Retrieve the access token
        $token = $client->getAccessToken();
        $access_token = $token['access_token'];

        // Set up the HTTP headers
        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];

        // Prepare the payload (updated to match the new structure)
        $data = [
            "message" => [
                "token" => $devicetoken, // Example token
                "notification" => [
                    "body" => "This is an FCM notification message!", // Notification body
                    "title" => "FCM Message" // Notification title
                ]
            ]
        ];

        $payload = json_encode($data);

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/manohar-farms/messages:send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification (useful for testing, but not recommended for production)
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging

        // Execute the cURL request and capture the response
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        // Check if there's any error during the request
        if ($err) {
            // Log error or return a response
            return response()->json(['error' => $err], 500);
        } else {
            // Return response from FCM
            return response()->json(['response' => json_decode($response)], 200);
        }
    }
}

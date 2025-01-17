<?php

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Google\Client as GoogleClient;

function fileUpload($folder, $file, $oldfile = null)
{
    $fileName = NULL;
    $path = 'uploads/' . $folder;

    if (isset($file) && $file != null) {

        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path($path), $fileName);
    }

    if ($oldfile != null) {
        if (file_exists(public_path($path . '/' . $oldfile))) {
            unlink(public_path($path . '/' . $oldfile));
        }
    }

    return $fileName;
}

function apiFileUpload($folder, $file, $oldfile = null)
{

    $imageName = null;
    $path = 'uploads/' . $folder . '/';

    $binary  = base64_decode($file);
    $imageName = time() . '.jpg';
    file_put_contents(public_path($path) . $imageName, $binary);

    if ($oldfile != null) {
        if (file_exists(public_path($path . '/' . $oldfile))) {
            unlink(public_path($path . '/' . $oldfile));
        }
    }

    return $imageName;
}

function generateString($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}


function generateInteger($n)
{
    $characters = '0123456789';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}

// function sendNotification(array $device_token, string $title, string $body)
// {

//     \Log::info('Preparing to send notification', [
//         'device_tokens' => $device_token,
//         'title' => $title,
//         'body' => $body
//     ]);
//     try {
//         $SERVER_API_KEY = env('SERVER_API_KEY');

//         $data = [
//             "registration_ids" => $device_token,
//             "notification" => [
//                 "title" => $title,
//                 "body" => $body,
//             ]
//         ];
//         $dataString = json_encode($data);

//         $headers = [
//             'Authorization: key=' . $SERVER_API_KEY,
//             'Content-Type: application/json',
//         ];

//         if (is_array($device_token) && !empty($device_token)) {

//             foreach ($device_token as $key => $token) {

//                 $user = User::where('device_token', $token)->first();
//                 $createNotification = Notification::create([
//                     'user_id' => $user->id,
//                     'device_token' => $token,
//                     'title' => $title,
//                     'body' => $body,
//                     'status' => 0
//                 ]);
//             }
//         }

//         $ch = curl_init();

//         curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
//         curl_setopt($ch, CURLOPT_POST, true);
//         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

//         $response = curl_exec($ch);
//         Log::info('Notification sent: ' . $body);
//         return $response;
//     } catch (\Exception $e) {
//         Log::info('Notification Error: ' . $e->getMessage());
//     }
// }


// function sendPushNotification(array $device_token, string $title, string $body)
// {
//     $request->validate([
//         'device_token' => 'required|string',
//     ]);
//     $devicetoken = request()->get('device_token');
//     $credentialsFilePath = public_path('service-account.json');

//     $client = new GoogleClient();
//     $client->setAuthConfig($credentialsFilePath);
//     $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
//     $client->refreshTokenWithAssertion();

//     // Retrieve the access token
//     $token = $client->getAccessToken();
//     $access_token = $token['access_token'];

//     // Set up the HTTP headers
//     $headers = [
//         "Authorization: Bearer $access_token",
//         'Content-Type: application/json'
//     ];

//     // Prepare the payload (updated to match the new structure)
//     $data = [
//         "message" => [
//             "token" => $devicetoken, // Example token
//             "notification" => [
//                 "body" => "This is an FCM notification message!", // Notification body
//                 "title" => "FCM Message" // Notification title
//             ]
//         ]
//     ];

//     $payload = json_encode($data);

//     // Initialize cURL
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/manohar-farms/messages:send');
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification (useful for testing, but not recommended for production)
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
//     curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging

//     // Execute the cURL request and capture the response
//     $response = curl_exec($ch);
//     $err = curl_error($ch);
//     curl_close($ch);

//     // Check if there's any error during the request
//     if ($err) {
//         // Log error or return a response
//         return response()->json(['error' => $err], 500);
//     } else {
//         // Return response from FCM
//         return response()->json(['response' => json_decode($response)], 200);
//     }
// }

function sendNotification(array $device_token, string $title, string $body)
{
    \Log::info('Preparing to send notification', [
        'device_tokens' => $device_token,
        'title' => $title,
        'body' => $body
    ]);

    try {
        // Path to Firebase service account credentials
        $credentialsFilePath = public_path('service-account.json');
        $client = new GoogleClient();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();

        // Retrieve the access token
        $token = $client->getAccessToken();
        $access_token = $token['access_token'];

        // HTTP headers
        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];

        // Prepare data for FCM
        $messages = [];
        foreach ($device_token as $token) {
            $user = User::where('device_token', $token)->first();
            if ($user) {
                Notification::create([
                    'user_id' => $user->id,
                    'device_token' => $token,
                    'title' => $title,
                    'body' => $body,
                    'status' => 0
                ]);

                $messages[] = [
                    "token" => $token,
                    "notification" => [
                        "title" => $title,
                        "body" => $body
                    ]
                ];
            }
        }

        if (empty($messages)) {
            return response()->json(['error' => 'No valid device tokens found'], 400);
        }

        // Send each message
        foreach ($messages as $message) {
            $data = ["message" => $message];
            $payload = json_encode($data);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/manohar-farms/messages:send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error) {
                \Log::error('FCM Error: ' . $error);
            } else {
                \Log::info('Notification sent: ' . $response);
            }
        }

        return response()->json(['message' => 'Notifications sent successfully'], 200);

    } catch (\Exception $e) {
        \Log::error('Notification Error: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


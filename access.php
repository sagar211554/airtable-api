<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://airtable.com/oauth2/v1/token',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'code=b92dd005b9f4fb939522a2850fe86fa0&client_id=67318d2e-2198-4df7-bd17-9203158be842&redirect_uri=https%3A%2F%2Fmdev.topscripts.in%2Ftestmdev%2Findex.php&grant_type=authorization_code&code_verifier=zXcVbNmLkJhGfDsApQwErTyUiOpAsDfGhJkLzXcVbNmLkJhGfDsA',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);

// Check for cURL errors
if ($response === false) {
    echo 'cURL Error: ' . curl_error($curl);
} else {
    // Get HTTP status code
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    if ($httpCode === 200) {
        // Parse JSON response
        $tokenData = json_decode($response, true);
        if ($tokenData) {
            echo 'Access Token: ' . $tokenData['access_token'] . "\n";
            echo 'Refresh Token: ' . ($tokenData['refresh_token'] ?? 'N/A') . "\n";
            echo 'Expires In: ' . $tokenData['expires_in'] . " seconds\n";
        } else {
            echo 'Error: Failed to parse response as JSON';
        }
    } else {
        echo 'HTTP Error: ' . $httpCode . "\n";
        echo 'Response: ' . $response . "\n";
    }
}

curl_close($curl);

?>
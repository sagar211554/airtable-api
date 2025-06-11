<?php
function generateRandomString($length = 64) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._';
    $charLen = strlen($chars);
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= $chars[random_int(0, $charLen - 1)];
    }
    return $result;
}

function generateCodeChallenge($code_verifier) {
    $hash = hash('sha256', $code_verifier, true);
    return rtrim(strtr(base64_encode($hash), '+/', '-_'), '=');
}

$code_verifier = generateRandomString(64);
$code_challenge = generateCodeChallenge($code_verifier);
$state = generateRandomString(32);

echo "✅ PKCE + state values:\n";
echo "code_verifier:  $code_verifier\n";
echo "code_challenge: $code_challenge\n";
echo "state:          $state\n";

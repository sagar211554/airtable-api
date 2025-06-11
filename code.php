<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Generate Airtable OAuth URL</title>
</head>
<body>
  <script>
    // Function to generate a random string for code_verifier
    function generateRandomString(length) {
      const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~";
      let result = "";
      for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * characters.length));
      }
      return result;
    }

    // Function to compute code_challenge from code_verifier (SHA-256 + base64 URL encode)
    async function generateCodeChallenge(codeVerifier) {
      const encoder = new TextEncoder();
      const data = encoder.encode(codeVerifier);
      const hashBuffer = await crypto.subtle.digest("SHA-256", data);
      const hashArray = Array.from(new Uint8Array(hashBuffer));
      const base64String = btoa(String.fromCharCode(...hashArray));
      // Base64 URL encode: replace + with -, / with _, remove =
      return base64String.replace(/\+/g, "-").replace(/\//g, "_").replace(/=/g, "");
    }

    // Main function to generate the OAuth URL and redirect
    (async () => {
      try {
        // Airtable OAuth parameters (replace with your values)
        const clientId = "67318d2e-2198-4df7-bd17-79203158be42"; // Replace with your Airtable client ID
        const redirectUri = "https://mdev.topscripts.in/testmdev/index.php"; // Replace with your redirect URI
        const scope = "data.records:read"; // Adjust scopes as needed
        const state = generateRandomString(16); // Generate a 16-character state

        // Generate code_verifier (43 characters)
        const codeVerifier = generateRandomString(43);
        // Generate code_challenge from code_verifier
        const codeChallenge = await generateCodeChallenge(codeVerifier);

        // Store code_verifier and state in sessionStorage for later use
        sessionStorage.setItem("code_verifier", codeVerifier);
        sessionStorage.setItem("state", state);

        // Construct the Airtable authorization URL
        const authUrl = `https://airtable.com/oauth2/v1/authorize?client_id=${clientId}&redirect_uri=${encodeURIComponent(redirectUri)}&response_type=code&scope=${encodeURIComponent(scope)}&state=${state}&code_challenge=${codeChallenge}&code_challenge_method=S256`;

        // Redirect to the authorization URL
        window.location.href = authUrl;
      } catch (error) {
        console.error("Error generating OAuth URL:", error);
      }
    })();
  </script>
</body>
</html>
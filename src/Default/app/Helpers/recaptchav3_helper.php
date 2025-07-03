
<?php

     function recaptchav3Verify($token, ?string &$error = null)
     {
         $secretKey = getenv('reCAPTCHA.secretKey');
         
         $scoreThreshold = 0.6;

         if (!$token || empty($secretKey)) {
             $error = 'Missing token or secret key.';
             return false;
         }

         $url = 'https://www.google.com/recaptcha/api/siteverify';
         $data = [
             'secret'   => $secretKey,
             'response' => $token,
             'remoteip' => $_SERVER['REMOTE_ADDR'] ?? null,
         ];

         $options = [
             'http' => [
                 'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                 'method'  => 'POST',
                 'content' => http_build_query($data),
                 'timeout' => 5,
             ],
         ];

         $context = stream_context_create($options);
         $result = file_get_contents($url, false, $context);

         if ($result === false) {
             $error = 'Failed to connect to Google reCAPTCHA.';
             return false;
         }

         $responseData = json_decode($result, true);

         if (!empty($responseData['success']) && $responseData['score'] >= $scoreThreshold) {
             return true;
         }

         $error = 'Invalid CAPTCHA or low score.';
         // Debug (optional):
         var_dump($responseData);

         return false;
     }
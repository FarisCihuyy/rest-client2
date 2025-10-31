<?php
// system-test.php
// White Box Testing REST Client PHP untuk NewsAPI.org

$baseUrl = "https://newsapi.org/v2/";
$apiKey  = "YOUR_API_KEY"; // Ganti dengan API key kamu

/**
 * Fungsi pemanggil API dengan curl agar bisa tangani HTTP error
 */
function callNewsApi($endpoint, $params = []) {
    global $baseUrl, $apiKey;
    $url = $baseUrl . $endpoint . "?" . http_build_query(array_merge($params, ["apiKey" => $apiKey]));

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        throw new Exception("Curl error: " . curl_error($ch));
    }

    curl_close($ch);

    if ($httpCode >= 400) {
        throw new Exception("HTTP Error Code: " . $httpCode);
    }

    return json_decode($response, true);
}

/**
 * Cetak hasil test
 */
function printResult($testName, $result) {
    echo $testName . " => " . ($result ? "PASS ✅" : "FAIL ❌") . PHP_EOL;
}

/* =======================================================
   TEST CASE 1
   =======================================================
   Tujuan: Pastikan endpoint top-headlines bekerja dengan parameter valid
*/
try {
    $response = callNewsApi("top-headlines", ["country" => "us"]);
    $result = isset($response["status"]) && $response["status"] === "ok" && !empty($response["articles"]);
    printResult("TEST 1 - Valid headlines request", $result);
} catch (Exception $e) {
    printResult("TEST 1 - Valid headlines request", false);
}

/* =======================================================
   TEST CASE 2
   =======================================================
   Tujuan: Tangani parameter tidak valid (expect error dari API)
*/
try {
    // Dalam NewsAPI, country harus 2 huruf ISO code. Ini akan error.
    $response = callNewsApi("top-headlines", ["country" => "invalid_country_code"]);
    // Jika tidak error, berarti FAIL karena API seharusnya menolak
    $result = isset($response["status"]) && $response["status"] === "error";
    printResult("TEST 2 - Invalid parameter handling", $result);
} catch (Exception $e) {
    // Jika memang terlempar error HTTP 400, berarti PASS
    printResult("TEST 2 - Invalid parameter handling", true);
}

/* =======================================================
   TEST CASE 3
   =======================================================
   Tujuan: Tangani API key tidak valid (expect authentication error)
*/
try {
    $invalidKey = "INVALID_KEY";
    $response = callNewsApi("everything", ["q" => "technology", "apiKey" => $invalidKey]);
    $result = isset($response["status"]) && $response["status"] === "error" && stripos($response["message"], "apiKey") !== false;
    printResult("TEST 3 - Invalid API key handling", $result);
} catch (Exception $e) {
    printResult("TEST 3 - Invalid API key handling", true);
}
?>

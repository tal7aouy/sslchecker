<?php
namespace Tal7aouy\SSLChecker;

use Exception;

/**
 * Class for checking the expiry date of an SSL certificate for a given domain
 */
class SSLChecker implements SSLCheckerInterface
{
 /**
  * Checks the expiry date of an SSL certificate for a given domain
  *
  * @param string $domain The domain to check
  * @return array An array containing the valid from and valid until dates of the SSL certificate
  * @throws Exception If there is an error connecting to the domain or parsing the SSL certificate
  */
 public function checkExpiry($domain)
 {
  // Set up SSL options for stream context
  $sslOptions = array(
   "capture_peer_cert" => true,
   "verify_peer" => false,
   "verify_peer_name" => false,
  );

  // Create stream context with SSL options
  $streamContext = stream_context_create(array("ssl" => $sslOptions));

  // Open SSL connection to domain
  $stream = stream_socket_client("ssl://" . $domain . ":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $streamContext);
  if (!$stream) {
   throw new Exception("Failed to connect to " . $domain . ": " . $errstr);
  }

  // Get SSL certificate information from stream context
  $params = stream_context_get_params($stream);
  if (!isset($params["options"]["ssl"]["peer_certificate"])) {
   throw new Exception("No SSL certificate found for " . $domain);
  }

  // Parse SSL certificate information
  $certInfo = openssl_x509_parse($params["options"]["ssl"]["peer_certificate"]);
  if (!$certInfo) {
   throw new Exception("Failed to parse SSL certificate for " . $domain);
  }

  // Convert valid from and valid until timestamps to human-readable date strings
  $validFrom = date('Y-m-d H:i:s', $certInfo['validFrom_time_t']);
  $validUntil = date('Y-m-d H:i:s', $certInfo['validTo_time_t']);

  // Return valid from and valid until dates as an array
  return array(
   'valid_from' => $validFrom,
   'valid_until' => $validUntil
  );
 }
}
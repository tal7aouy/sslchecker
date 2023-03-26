<?php

namespace Tal7aouy\SSLChecker;

/**
 * Interface that defines the methods for checking SSL certificate expiry
 */
interface SSLCheckerInterface
{
 /**
  * Check the expiry date of the SSL certificate for a given domain
  *
  * @param string $domain The domain to check
  * @return array An array containing the valid from and valid until dates of the SSL certificate
  * @throws \Exception If an error occurs while checking the SSL certificate expiry
  */
 public function checkExpiry($domain);
}
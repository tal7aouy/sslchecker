<?php
namespace Tal7aouy\SSLChecker\Tests;

use Tal7aouy\SSLChecker\SSLChecker;
use Exception;

test('can check the expiry date of an SSL certificate', function () {
 $checker = new SSLChecker();
 $expiryDates = $checker->checkExpiry('google.com');

 expect($expiryDates)->toBeArray();
 expect(array_key_exists('valid_from', $expiryDates))->toBeTrue();
 expect(array_key_exists('valid_until', $expiryDates))->toBeTrue();
});

test('throws an exception if the domain is invalid', function () {
 $checker = new SSLChecker();

 $this->expectException(Exception::class);
 $this->expectExceptionMessage('Failed to connect to invalid_domain: php_network_getaddresses: getaddrinfo for invalid_domain failed: Temporary failure in name resolution');

 $checker->checkExpiry('invalid_domain');
});

test('throws an exception if there is no SSL certificate for the domain', function () {
 $checker = new SSLChecker();

 $this->expectException(Exception::class);

 // Use a domain name that does not exist to simulate a domain without an SSL certificate
 $checker->checkExpiry('nonexistent-domain.com');
});


test('throws an exception if there is an error parsing the SSL certificate', function () {
 $checker = new SSLChecker();

 $this->expectException(Exception::class);
 $this->expectExceptionMessage('unable to get local issuer certificate');

 $checker->checkExpiry('expired.badssl.com');
});
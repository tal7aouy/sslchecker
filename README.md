# SSLChecker

The SSLChecker library is a PHP class that allows you to check the expiry date of an SSL certificate for a given domain. It uses an SSL connection to retrieve the SSL certificate information and parses the valid from and valid until timestamps into human-readable date strings.

## 💡Usage

To use the SSLChecker library, follow these steps:

- install sslchecker in your project.

```bash
composer require tal7aouy/sslchecker
```

- Include the SSLChecker.php file in your PHP code:

```php
require __DIR__ . "/vendor/autoload.php";
```

- Create an instance of the SSLChecker class:

```php
use Tal7aouy\SSLChecker\SSLChecker;

$checker = new SSLChecker();

```

- Call the checkExpiry method with the domain you want to check:

```php
$expiryDates = $checker->checkExpiry('example.com');

```

The `checkExpiry` method returns an array containing the valid from and valid until dates of the SSL certificate for the given domain:

```php
Array
(
    [valid_from] => 2022-01-01 00:00:00
    [valid_until] => 2023-01-01 00:00:00
)

```

If there is an error connecting to the domain or parsing the SSL certificate, the method will throw an exception.

## ✅ Example

Here's an example of how to use the SSLChecker library in a PHP script:

```php
$checker = new SSLChecker();

try {
    $expiryDates = $checker->checkExpiry('example.com');
    echo 'SSL certificate for example.com is valid from ' . $expiryDates['valid_from'] . ' to ' . $expiryDates['valid_until'] . PHP_EOL;
} catch (Exception $e) {
    echo 'Error checking SSL certificate: ' . $e->getMessage() . PHP_EOL;
}
```

## 🎉 License

The SSLChecker is released under the [MIT License](LICENSE).

[![Latest Stable Version][latest stable version]][packagist]
 [![GitHub stars][github stars]][packagist]
 [![Total Downloads][total downloads]][packagist]
 [![GitHub Workflow Status][github workflow status]][github actions]
 [![Scrutinizer code quality][code quality]][code quality link]
 [![Type Coverage][type coverage]][sheperd type coverage]
 [![Code Coverage][code coverage]][code quality link]
 [![License][license]][packagist]
 [![Donate!][donate github]][github sponsor]
 [![Donate!][donate paypal]][paypal sponsor]

# PHPSpec Time

A [PHPSpec][phpspec] extension providing matchers for measuring time in tests.

New matchers:

* `shouldTakeLessThan(float $timeUnit)`
* `shouldTakeMoreThan(float $timeUnit)`
* `shouldTakeInBetween(float $fromTimeUnit, float $toTimeUnit)`

## Installation

`composer require loophp/phpspec-time`

## Usage

Add the extension to the phpspec configuration file:

```yaml
extensions:
    loophp\phpspectime\Extension: ~
```

By default, the time unit is in `second`, however other units are available:

* `nanosecond`
* `microsecond`
* `millisecond`
* `second`
* `minute`
* `hour`
* `day`
* `week`

If you want to change the time unit edit the extension configuration as such:

```yaml
extensions:
    loophp\phpspectime\Extension:
        timeunit: nanosecond
```

In your tests, you'll have now access to the following new matchers:

```php
    $this
        ->shouldTakeMoreThan(10)
        ->during('method');

    $this
        ->shouldNotTakeMoreThan(10)
        ->during('method');

    $this
        ->shouldTakeLessThan(10)
        ->during('method');

    $this
        ->shouldNotTakeLessThan(10)
        ->during('method');

    $this
        ->shouldTakeInBetween(3.0, 3.2)
        ->during('method');

    $this
        ->shouldNotTakeInBetween(3.0, 3.2)
        ->during('method');
```

## Code quality, tests and benchmarks

Every time changes are introduced into the library, [Github][github actions] run the
tests.

The library has tests written with [PHPSpec][phpspec].
Feel free to check them out in the `spec` directory. Run `composer phpspec` to trigger the tests.

Before each commit some inspections are executed with [GrumPHP][grumphp],
run `composer grumphp` to check manually.

The quality of the tests is tested with [Infection][infection] a PHP Mutation testing
framework,  run `composer infection` to try it.

Static analysers are also controlling the code. [PHPStan][phpstan] and
[PSalm][psalm] are enabled to their maximum level.

## Contributing

Feel free to contribute by sending Github pull requests. I'm quite reactive :-)

If you can't contribute to the code, you can also sponsor me on [Github][github sponsor] or [Paypal][paypal sponsor].

## Changelog

See [CHANGELOG.md][changelog-md] for a changelog based on [git commits][git-commits].

For more detailed changelogs, please check [the release changelogs][changelog-releases].

[latest stable version]: https://img.shields.io/packagist/v/loophp/phpspec-time.svg?style=flat-square
[packagist]: https://packagist.org/packages/loophp/phpspec-time

[github stars]: https://img.shields.io/github/stars/loophp/phpspec-time.svg?style=flat-square

[total downloads]: https://img.shields.io/packagist/dt/loophp/phpspec-time.svg?style=flat-square

[github workflow status]: https://img.shields.io/github/workflow/status/loophp/phpspec-time/Continuous%20Integration?style=flat-square
[github actions]: https://github.com/loophp/phpspec-time/actions

[code quality]: https://img.shields.io/scrutinizer/quality/g/loophp/phpspec-time/master.svg?style=flat-square
[code quality link]: https://scrutinizer-ci.com/g/loophp/phpspec-time/?branch=master

[type coverage]: https://shepherd.dev/github/loophp/phpspec-time/coverage.svg
[sheperd type coverage]: https://shepherd.dev/github/loophp/phpspec-time

[code coverage]: https://img.shields.io/scrutinizer/coverage/g/loophp/phpspec-time/master.svg?style=flat-square
[code quality link]: https://img.shields.io/scrutinizer/quality/g/loophp/phpspec-time/master.svg?style=flat-square

[license]: https://img.shields.io/packagist/l/loophp/phpspec-time.svg?style=flat-square

[donate github]: https://img.shields.io/badge/Sponsor-Github-brightgreen.svg?style=flat-square
[github sponsor]: https://github.com/sponsors/drupol

[donate paypal]: https://img.shields.io/badge/Sponsor-Paypal-brightgreen.svg?style=flat-square
[paypal sponsor]: https://www.paypal.me/drupol

[phpspec]: http://www.phpspec.net/
[grumphp]: https://github.com/phpro/grumphp
[infection]: https://github.com/infection/infection
[phpstan]: https://github.com/phpstan/phpstan
[psalm]: https://github.com/vimeo/psalm
[changelog-md]: https://github.com/loophp/phpspec-time/blob/master/CHANGELOG.md
[git-commits]: https://github.com/loophp/phpspec-time/commits/master
[changelog-releases]: https://github.com/loophp/phpspec-time/releases

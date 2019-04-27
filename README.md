## Installation

Install this library by require it via [Composer](https://getcomposer.org):

```
composer require --dev dmecke/coverage-checker
```

Composer will install an executable in its `bin-dir` which defaults to `vendor/bin`.



## Usage

Add a configuration file called `coverage-checker.yaml` to your project root:

```yaml
coverage:
    App: 80
    App\Repository: 50
    App\Domain: 100
```

Run your test suite with clover coverage enabled:

```
phpunit --coverage-clover coverage.xml
```

Run the code coverage check with:

```
vendor/bin/coverage-checker check coverage.xml
```

The script will use a return code > 0 if any code coverage is below the defined minimum. This way it can be used in CI.

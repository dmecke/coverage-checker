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

The script will use a return code > 0 if any code coverage does not meet the specified criteria. This way it can be used in CI.



## FAQ

###### Why does the check fail when the coverage is better than defined?
If you managed to improve your test coverage you should increase your defined limits. Otherwise you could fall back to a lower coverage again.

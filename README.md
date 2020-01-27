# Тесты PHPUnit для Bitrix

Запуск всех тестов:

```sh
phpunit --bootstrap local/phpunit/bootstrap.php local/phpunit/tests/simple
```

Запуск тестов по фильтру `testCmodule`:

```sh
phpunit --bootstrap local/phpunit/bootstrap.php --filter '/::testCmodule$/' local/phpunit/tests/simple/SimpleTest.php
```

# Покрытие кода

```sh
phpunit --coverage-text --whitelist ./bitrix/modules/main/classes/general/module.php --bootstrap local/phpunit/bootstrap.php local/phpunit/tests/simple/SimpleTest.php
```

# Ссылки

* [Руководство по PHPUnit](https://phpunit.readthedocs.io/ru/latest/)

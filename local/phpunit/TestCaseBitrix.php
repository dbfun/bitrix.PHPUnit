<?php

namespace PHPUnit\Framework;

class TestCaseBitrix extends \PHPUnit\Framework\TestCase {
	// Черный список глобальных переменных, которые восстанавливаются после каждого теста
	// @see https://phpunit.readthedocs.io/ru/latest/fixtures.html

	protected $backupGlobalsBlacklist = ['DB'];

}

<?php
use PHPUnit\Framework\TestCase;

final class SimpleTest extends TestCase
{

  // Черный список глобальных переменных, которые восстанавливаются после каждого теста
  // @see https://phpunit.readthedocs.io/ru/latest/fixtures.html

  protected $backupGlobalsBlacklist = ['DB'];

  // Тест подключения модуля
  public function testCmodule()
  {
    $this->assertTrue(CModule::IncludeModule('iblock'));
    $this->assertFalse(CModule::IncludeModule('module.not.exists'));
  }

  // Тест на Exception
  public function testInvalidArgumentException()
  {
    $this->setExpectedException('InvalidArgumentException');
    throw new InvalidArgumentException("Error Processing Request", 1);
  }

}

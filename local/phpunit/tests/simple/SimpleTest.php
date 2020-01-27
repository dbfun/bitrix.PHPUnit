<?php
use PHPUnit\Framework\TestCaseBitrix;

final class SimpleTest extends TestCaseBitrix
{

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

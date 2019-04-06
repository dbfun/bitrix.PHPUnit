<?php
use PHPUnit\Framework\TestCase;

final class AuthorizationTest extends TestCase
{

  // Черный список глобальных переменных, которые восстанавливаются после каждого теста
  // @see https://phpunit.readthedocs.io/ru/latest/fixtures.html

  protected $backupGlobalsBlacklist = ['DB'];

  /**
   * @dataProvider canonizeProvider
   */
  public function testCanonizeLdapLogin($login, $expected)
  {
    $this->assertSame(VendorAuth::canonizeLdapLogin($login), $expected);
  }

  /**
   * @dataProvider userBitrixLoginProvider
   */
  public function testOnBeforeUserLoginHandler($arFields, $expected)
  {
    $this->assertSame(VendorAuth::OnBeforeUserLoginHandler($arFields), $expected);
  }

  /**
   * @dataProvider userLdapLoginProvider
   */
  public function testOnUserLoginExternalHandler($ip, $arFields, $expected)
  {
    $_SERVER['REMOTE_ADDR'] = $ip;
    $this->assertSame(VendorAuth::OnUserLoginExternalHandler($arFields), $expected);
  }


  /**
   * @dataProvider userAllLoginProvider
   */

  public function testLogin($ip, $arFields, $expected)
   {
     $_SERVER['REMOTE_ADDR'] = $ip;
    $res = $GLOBALS['USER']->Login($arFields['LOGIN'], $arFields['PASSWORD'], 'N', $arFields['PASSWORD_ORIGINAL']);
    $this->assertSame($res, $expected);
   }

  public function canonizeProvider()
  {
    return [
      ['company\\user', 'user'],
      ['user', 'user'],
      ['user@company.ru', 'user'],
      ['user@company.com.ua', 'user'],
      ['user@mail.ru', false] // это не из AD, поэтому false
    ];
  }

  public function userBitrixLoginProvider()
  {
    return [
      'Empty login' => [['LOGIN' => ''], false],
      'No user (1)' => [['LOGIN' => 'not_exists@site.ru'], true],
      'No user (2)' => [['LOGIN' => 'user'], true],
      'Exists user login' => [['LOGIN' => 'admin'], true],
      'Exists user email' => [['LOGIN' => 'user@site.ru'], true],
    ];
  }

  public function userLdapLoginProvider()
  {
    return [
      'LDAP success LAN 192.168' => ['192.168.58.122', ['LOGIN' => 'user', 'PASSWORD' => 'password', 'PASSWORD_ORIGINAL' => 'Y'], 1],
      // другие кейсы
    ];
  }

  public function userAllLoginProvider()
  {
    $incorrectLoginPass = [
      'MESSAGE' => 'Incorrect login or password<br>',
      'TYPE' => 'ERROR',
      'ERROR_TYPE' => 'LOGIN',
    ];

    $loginIsBlocked = [
      'MESSAGE' => 'Your login is blocked<br>',
      'TYPE' => 'ERROR'
    ];

    // Политика безопасности блокирует неудачные попытки входа (сейчас - более трех). Это надо учитывать при тестировании

    return [
      'Bitrix by login success WAN' => ['8.8.8.8', ['LOGIN' => 'user', 'PASSWORD' => 'password', 'PASSWORD_ORIGINAL' => 'Y'], true],
      // другие кейсы
    ];
  }



}

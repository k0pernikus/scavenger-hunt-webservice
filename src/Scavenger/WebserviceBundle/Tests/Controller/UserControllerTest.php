<?php

namespace Scavenger\WebserviceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
  private $createdUserId;

  public function testUserGet()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/user/');

        $this->assertTrue($client->getResponse()->isOk(), "get userdata");
        //$this->assertTrue();
    }
    
    public function testUserCreate()
    {
      $name = "CreateTestUser";
      $deviceId = "CreateTestUserDeviceId";
      // id is determined by webservice

      $client = static::createClient();
      $params = array('name' => $name, 'deviceId' => $deviceId);
      $client->request('POST', '/user/', $params);

      $response = json_decode($client->getResponse()->getContent(), true);

      $this->assertTrue($client->getResponse()->isOk());
      $this->assertTrue($response['id'] > 0);

      // wtf phpunit $this->assertEqual( ... ) undefined!?
      $this->assertTrue($response['name'] === $name);
      $this->assertTrue($response['deviceId'] === $deviceId);

      $this->createdUserId;
    }

    public function testUserDelete()
    {
      /* lol -- it seems that function is as of yet not implented */
    }
}

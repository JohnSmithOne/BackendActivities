<?php
/**
 * CHANGE ME!!
 *
 * Change the "SystemName" to the System you will working for. ex. PolanguiTreasury (use PascalCase).
 * Change the "ModuleNameTest" to the Module you will working for. ex. OrNumbers (use PascalCase).
 */
namespace Tests\Resources\Inventory\Modules\StockAlert;


use PHPUnit\Framework\TestCase;


/**
 * CHANGE ME!!
 *
 * Change the "SystemName" to the System you will working for. ex. PolanguiTreasury (use PascalCase).
 * Change the "ModuleName" to the Module you will working for. ex. OrNumbers (use PascalCase).
 */
use Resources\Inventory\Modules\StockAlert\API;


class APISuccessTest extends TestCase
{
    protected function setUp(): void
    {
        $this->api = new API();
    }

    public function testPayloadGetIdEntry(): array
    {
        $load = array(
            'id' => 1
        );
        $this->assertIsArray($load);
        $this->assertNotEmpty($load);

        return $load;
    }

    public function testPayloadGetRfidEntry(): array
    {
        $load = array(
            'rfid' => 'HG03J2KA2',

        );
        $this->assertIsArray($load);
        $this->assertNotEmpty($load);

        return $load;
    }


    public function testPayloadEmptyEntry(): array
    {
        $load = array();

        $this->assertIsArray($load);
        $this->assertEmpty($load);
        return $load;
    }


    /**
     * @depends testPayloadGetIdEntry
     */

    public function testHttpGetIdEntry($load)
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $result = json_decode($this->api->httpGet($load), true);

        $this->assertArrayHasKey('status', $result);
        $this->assertEquals($result['status'], 'success');
        $this->assertArrayHasKey('data', $result);
        return $result['data'];
    }

     /**
     * @depends testPayloadGetRfidEntry
     */

     public function testHttpGetRfidEntry($load)
     {
         $_SERVER['REQUEST_METHOD'] = 'GET';
 
         $result = json_decode($this->api->httpGet($load), true);
 
         $this->assertArrayHasKey('status', $result);
         $this->assertEquals($result['status'], 'success');
         $this->assertArrayHasKey('data', $result);
         return $result['data'];
     }
 
    /**
     * @depends testPayloadEmptyEntry
     */

    public function testHttpEmptyEntry($load)
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $result = json_decode($this->api->httpGet($load), true);

        $this->assertArrayHasKey('status', $result);
        $this->assertEquals($result['status'], 'success');
        $this->assertArrayHasKey('data', $result);
        $this->assertNotEmpty($result['data']);
        $this->assertIsArray($result['data']);

        return $result['data'];
    }


    


    // public function testHttpPut($load)
    // {

    // }


    // public function testHttpDelete($load)
    // {

    // }
}

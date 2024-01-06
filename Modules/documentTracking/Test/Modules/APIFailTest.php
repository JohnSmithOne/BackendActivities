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


class APIFailTest extends TestCase
{
    protected function setUp(): void
    {
        $this->api = new API();
    }

    public function testPayloadFailGetNoResultFound(): array
    {
        $payload = array(
            'id' => 4567999999
        );

        $load = $payload;
        $this->assertIsArray($load);
        $this->assertNotEmpty($load);

        return $load;
    }


    /**
     * @depends testPayloadFailGetNoResultFound
     */

    public function testHttpFailGetNoResultFound($load)
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        
        $result = json_decode($this->api->httpGet($load), true);

        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals($result['status'], 'fail');
        $this->assertEquals($result['message'][0], "No results found");
        
        return $result;
    }



    



    // public function testHttpPut($load)
    // {

    // }


    // public function testHttpDelete($load)
    // {

    // }
}

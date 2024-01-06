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

    public function testPayloadFailGetSpecificIssue(): array
    {
        $payload = array(
            'product_name' => 'Frame'
        );

        $load = $payload;
        $this->assertIsArray($load);
        $this->assertNotEmpty($load);

        return $load;
    }


    /**
     * @depends testPayloadPostSpecificItem
     */
    // public function testHttpPost($load)
    // {
        
    // }

    /**
     * @depends testPayloadFailGetSpecificIssue
     */

    public function testHttpFailGetSpecificIssue($load)
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        
        $result = json_decode($this->api->httpGet($load), true);

        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals($result['status'], 'fail');
        $this->assertEquals($result['message'][0], "No Data from the DB");
        
        return $result;
    }


    public function testHttpPostFailPropertyNotSet(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
      $payload = array(
        "retail_product" => "Acer Nitro 5",
	    "serial_no." => ["5345SDVREWRTG"],
	    "issue_slabel" => "Damage Product",
	    "quantity" => 1,
	    "action" => "Cancel"
      );


      $result = json_decode($this->api->httpPost($payload), true);
      
      $this->assertNotEmpty($result);
      $this->assertArrayHasKey('status', $result);
      $this->assertEquals($result['status'], 'fail');
        
      $this->assertArrayHasKey('message', $result);
      $this->assertIsString($result['message']);
      $this->assertEquals($result['message'], "Invalid Payload Properties: Each Property Not Set");
    }

    public function testHttpPostQuantityCountUnequalToSerialNumberCount(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $payload = array(
        "retail_product" => "Acer Nitro 5",
        "serial_no." => ["6456ASKLJDHFSDF1111111"],
        "issue_label"=> "Damage Product",
        "quantity" => 1,
        "action"=> "Cancel"
      );

      $result = json_decode($this->api->httpPost($payload), true);
      
      $this->assertNotEmpty($result);
      $this->assertArrayHasKey('status', $result);
      $this->assertEquals($result['status'], 'fail');
        
      $this->assertArrayHasKey('message', $result);
      $this->assertIsString($result['message']);
      $this->assertEquals($result['message'], "Invalid Payload Properties: Quantity Count Not Equal to Number of Serial Number or Serial Number does not Exist Basied on Retail Product");

    }

    public function testHttpPostFailRetailProductDoesntExist(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $payload = array(
        "retail_product" => "Acer Nitro 5",
        "serial_no." => ["6456ASKLJDHFSDF1111111"],
        "issue_label" => "Damage Product",
        "quantity" => 1,
        "action" => "Cancel"
      );

      $result = json_decode($this->api->httpPost($payload), true);
      
      $this->assertNotEmpty($result);
      $this->assertArrayHasKey('status', $result);
      $this->assertEquals($result['status'], 'fail');
        
      $this->assertArrayHasKey('message', $result);
      $this->assertIsString($result['message']);
      $this->assertEquals($result['message'], "Retail Product Doesn't Exists");

    }

    public function testHttpPostFailQuantityUnequalToBatchNumberCount(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $payload = array(
            "retail_product" => "Logitech Extended Mouse Pad",
            "batch_no" => ["Batch 2"],
            "issue_label" => "Damage Product",
            "quantity"=> 1,
            "quantity_issue" =>.5,
            "action" => "Cancel"
      );

      $result = json_decode($this->api->httpPost($payload), true);
      
      $this->assertNotEmpty($result);
      $this->assertArrayHasKey('status', $result);
      $this->assertEquals($result['status'], 'fail');
        
      $this->assertArrayHasKey('message', $result);
      $this->assertIsString($result['message']);
      $this->assertEquals($result['message'], "Invalid Payload Properties: Quantity Not Equal to Batch Number Count");

    }



    public function testHttpPutUpdateFailCancelNoTransferId(): void
    {
      $_SERVER['REQUEST_METHOD'] = 'PUT';
      $payload = array(
        'report_issue_id' => 400,
        'product_name' => 'RGB Red Light',
        'request_restock_to' => 'Store_3',
        'quantity' => 400,
        'message'  => 'a I would like to not request for restock from your store and deliver here ASAP',
        'action' => 'Cancel'
      );
     
      $result = json_decode($this->api->httpPut($payload['report_issue_id'], $payload), true);

      //checking if resulting json has content
      $this->assertNotEmpty($result);

      //check if json result is fail
      $this->assertArrayHasKey('status', $result);
      $this->assertEquals($result['status'], 'fail');
        
      //check if message is similar to expected output
      $this->assertArrayHasKey('message', $result);
      $this->assertIsString($result['message']);
      $this->assertEquals($result['message'], "Invalid Payload Properties: Cannot Cancel: Restock Request Doesn't Exists");
    }

    public function testHttpPutUpdateFailNoEntryMatch(): void
    {
      $_SERVER['REQUEST_METHOD'] = 'PUT';
      $payload = array(
        'report_issue_id' => 1,
        'product_name' => 'RGB Red Light',
        'request_restock_to' => 'Store_3',
        'quantity' => 100,
        'message'  => 'I would like to not request for restock from your store and deliver here ASAP',
        'action' => 'Cancel',
        'amongus' => 'sus'
      );
     
      $result = json_decode($this->api->httpPut($payload['report_issue_id'], $payload), true);
      
      //checking if resulting json has content
      $this->assertNotEmpty($result);

      //check if json result is fail
      $this->assertArrayHasKey('status', $result);
      $this->assertEquals($result['status'], 'fail');
        
      //check if message is similar to expected output
      $this->assertArrayHasKey('message', $result);
      $this->assertIsString($result['message']);
      $this->assertEquals($result['message'], "Invalid Payload Properties: Entry Doesn't Match Expected Values");
    }

    public function testHttpPutUpdateFailRequestStoreId(): void
    {
      $_SERVER['REQUEST_METHOD'] = 'PUT';
      $payload = array(
        'report_issue_id' => 1,
        'product_name' => 'RGB LED Light',
	      'serial_no.' => '123456ABCDEFG',
	      'expiration_date' => '4-29-2023',
	      'quantity' => 50,    
	      'action' => 'Restock'
      );
      $result = json_decode($this->api->httpPut($payload['report_issue_id'], $payload), true);
      
      //checking if resulting json has content
      $this->assertNotEmpty($result);

      //check if json result is fail
      $this->assertArrayHasKey('status', $result);
      $this->assertEquals($result['status'], 'fail');
        
      //check if message is similar to expected output
      $this->assertArrayHasKey('message', $result);
      $this->assertIsString($result['message']);
      $this->assertEquals($result['message'], "Invalid Payload Properties: Entry Doesn't Match Expected Values");
    }

    public function testHttpDeleteFailIdIssueAlreadyExist(): void
    {
      $_SERVER['REQUEST_METHOD'] = 'DELETE';
      $payload = array(
        'id' => 1,
	    'issue_name' => 'Damage Product'
      );
      
     
      $result = json_decode($this->api->httpDel($payload['id'], $payload), true);
      
      //checking if resulting json has content
      $this->assertNotEmpty($result);

      //check if json result is fail
      $this->assertArrayHasKey('status', $result);
      $this->assertEquals($result['status'], 'fail');
        
      //check if message is similar to expected output
      $this->assertArrayHasKey('message', $result);
      $this->assertIsString($result['message']);
      $this->assertEquals($result['message'], 'Invalid Payload Properties: Cannot Delete: The Issue Label is assigned to a Reported Issue');
    }

    public function testHttpDeleteFailIdDoesNotExist(): void
    {
      $_SERVER['REQUEST_METHOD'] = 'DELETE';
      $payload = array(
        'id' => 800,
	    'issue_name' => 'Delete_Test_1'
      );
      
     
      $result = json_decode($this->api->httpDel($payload['id'], $payload), true);
      
      //checking if resulting json has content
      $this->assertNotEmpty($result);

      //check if json result is fail
      $this->assertArrayHasKey('status', $result);
      $this->assertEquals($result['status'], 'fail');
        
      //check if message is similar to expected output
      $this->assertArrayHasKey('message', $result);
      $this->assertIsString($result['message']);
      $this->assertEquals($result['message'], "Invalid Payload Properties: Issue Label Doesn't Exist");
    }

    public function testHttpDeleteFailIssueUnknown(): void
    {
      $_SERVER['REQUEST_METHOD'] = 'DELETE';
      $payload = array(
        'id' => 14,
	    'issue_name' => 'Delete_Test_1rsxgrs'
      );
      
      $result = json_decode($this->api->httpDel($payload['id'], $payload), true);
      
      //checking if resulting json has content
      $this->assertNotEmpty($result);

      //check if json result is fail
      $this->assertArrayHasKey('status', $result);
      $this->assertEquals($result['status'], 'fail');
        
      //check if message is similar to expected output
      $this->assertArrayHasKey('message', $result);
      $this->assertIsString($result['message']);
      $this->assertEquals($result['message'], "Invalid Payload Properties: Unknown Issue Label");
    }


    // public function testHttpPut($load)
    // {

    // }


    // public function testHttpDelete($load)
    // {

    // }
}

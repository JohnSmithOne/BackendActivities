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

    public function testPayloadGetSpecificIssue(): array
    {
        $payload = array(
            'product_name' => 'Acer Nitro 5'
        );

        $load = $payload;
        $this->assertIsArray($load);
        $this->assertNotEmpty($load);

        return $load;
    }
    public function testPayloadGetAllIssue(): array
    {
        $payload = array(
            'product_name' => ''
        );

        $load = $payload;
        $this->assertIsArray($load);
        $this->assertNotEmpty($load);

        return $load;
    }

    public function testPayloadPostSingleSerialNo(): array
    {
        $payload = array(
            "retail_product" => "Acer Nitro 5",
	        "serial_no." =>["5345SDVREWRTG"],
	        "issue_label"=> "Damage Product",
	        "quantity" => 1,
	        "action" => "Cancel"
        );

        $load = $payload;
        $this->assertIsArray($load);
        $this->assertNotEmpty($load);
        return $load;
    }

    //Test Payloads for POST Request
    public function testPayloadPostMultipleSerialNo(): array
    {
        $payload = array(
            "retail_product" => "Acer Nitro 5",
	        "serial_no." => ["5345SDVREWRTG", "42353SLKHJDFHEOWF"],
	        "issue_label" => "Damage Product",
	        "quantity" => 2,
	        "action" => "Restock"
        );

        $load = $payload;
        $this->assertIsArray($load);
        $this->assertNotEmpty($load);
        return $load;
    }

    public function testPayloadPostSingleBatchNo(): array
    {
        $payload = array(
            "retail_product" => "Logitech Extended Mouse Pad",
	        "batch_no" => ["Batch 1"],
	        "issue_label"=> "Damage Product",
	        "quantity"=> 1,
	        "quantity_issue" => 10,
	        "action" => "Cancel"
        );

        $load = $payload;
        $this->assertIsArray($load);
        $this->assertNotEmpty($load);
        return $load;
    }

    public function testPayloadPostMultipleBatchNo(): array
    {
        $payload = array(
            "retail_product" => "Logitech Extended Mouse Pad",
	        "batch_no" => ["Batch 2", "Batch 1"],
	        "issue_label" => "Damage Product",
	        "quantity" => 2,
	        "quantity_issue" => 10,
	        "action" => "Cancel"
        );

        $load = $payload;
        $this->assertIsArray($load);
        $this->assertNotEmpty($load);
        return $load;
    }

    //Test Payloads for PUT Request
    public function testPayloadReportRestock(): array
    {
        $payload = array(
            'report_issue_id' => 1,
            'product_name' => 'RGB RED Light',
            'request_restock_to' => 'Store_3',
            'quantity' => 50,
            'message' => 'I would like to request for restock from your store and deliver here ASAP',
            'action' => 'Restock'
        );

        $load = $payload;
        $this->assertIsArray($load);
        $this->assertNotEmpty($load);

        return $load;
    }
    public function testPayloadReportCancel(): array
    {
        $payload = array(
            'report_issue_id' => 1,
            'product_name' => 'RGB RED Light',
            'request_restock_to' => 'Store_3',
            'quantity' => 50,
            'message' => 'I would like to request for restock from your store and deliver here ASAP',
            'action' => 'Cancel'
        );

        $load = $payload;
        $this->assertIsArray($load);
        $this->assertNotEmpty($load);

        return $load;
    }
    public function testPayloadTransferRequest(): array
    {
        $payload = array(
            'report_issue_id' => 63,
            'product_name' => 'RGB RED Light',
            'request_restock_to' => 'Store_3',
            'quantity' => 400,
            'message' => 'I would like to not request for restock from your store and deliver here ASAP',
            'action' => 'Restock'
        );

        $load = $payload;
        $this->assertIsArray($load);
        $this->assertNotEmpty($load);

        return $load;
    }

    public function testPayloadDelete(): array
    {
        $payload = array(
            'id' => 14,
            'issue_name' => 'Delete_Test_1'
        );

        $load = $payload;
        $this->assertIsArray($load);
        $this->assertNotEmpty($load);

        return $load;
    }




    /**
     * @depends testPayloadGetSpecificIssue
     */

    public function testHttpGetSpecificIssue($load)
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $result = json_decode($this->api->httpGet($load), true);

        $this->assertArrayHasKey('status', $result);
        $this->assertEquals($result['status'], 'success');
        $this->assertArrayHasKey('data', $result);
        return $result['data'];
    }

    /**
     * @depends testPayloadGetAllIssue
     */

    public function testHttpGetAllIssue($load)
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


     /**
     * @depends testPayloadPostSingleSerialNo
     */
    public function testHttpPostSingleSerialNo($load)
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $result = json_decode($this->api->httpPost($load), true);
        //Check if array has a key "status", then check if the response is success
        $this->assertArrayHasKey('status', $result);
        $this->assertEquals($result['status'], 'success');

        //Check if array has a key "data", then check if it is empty and and is an array
        $this->assertArrayHasKey('data', $result);
        $this->assertNotEmpty($result['data']);
        $this->assertIsArray($result['data']);
    }

    /**
     * @depends testPayloadPostMultipleSerialNo
     */
    public function testHttpPostMultiplSerialNo($load): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $result = json_decode($this->api->httpPost($load), true);
        //Check if array has a key "status", then check if the response is success
        $this->assertArrayHasKey('status', $result);
        $this->assertEquals($result['status'], 'success');

        //Check if array has a key "data", then check if it is empty and and is an array
        $this->assertArrayHasKey('data', $result);
        $this->assertNotEmpty($result['data']);
        $this->assertIsArray($result['data']);
    }

     /**
     * @depends testPayloadPostSingleBatchNo
     */
    public function testHttpPostSingleBatchNo($load)
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $result = json_decode($this->api->httpPost($load), true);
        //Check if array has a key "status", then check if the response is success
        $this->assertArrayHasKey('status', $result);
        $this->assertEquals($result['status'], 'success');

        //Check if array has a key "data", then check if it is empty and and is an array
        $this->assertArrayHasKey('data', $result);
        $this->assertNotEmpty($result['data']);
        $this->assertIsArray($result['data']);
    }

     /**
     * @depends testPayloadPostMultipleBatchNo
     */

    public function testHttpPostMultipleBatchNo($load)
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $result = json_decode($this->api->httpPost($load), true);
        //Check if array has a key "status", then check if the response is success
        $this->assertArrayHasKey('status', $result);
        $this->assertEquals($result['status'], 'success');

        //Check if array has a key "data", then check if it is empty and and is an array
        $this->assertArrayHasKey('data', $result);
        $this->assertNotEmpty($result['data']);
        $this->assertIsArray($result['data']);
    }
    

    /**
     * @depends testPayloadReportRestock
     */
    public function testHttpPutUpdateReportRestock($load): void
    {
        $_SERVER['REQUEST_METHOD'] = 'PUT';

        

        $result = json_decode($this->api->httpPut($load['report_issue_id'], $load), true);
        //Check if array has a key "status", then check if the response is success
        $this->assertArrayHasKey('status', $result);
        $this->assertEquals($result['status'], 'success');

        //Check if array has a key "data", then check if it is empty and and is an array
        $this->assertArrayHasKey('data', $result);
        $this->assertNotEmpty($result['data']);
        $this->assertIsArray($result['data']);
    }

    /**
     * @depends testPayloadReportCancel
     */
    public function testHttpPutUpdateReportCancel(array $payload): void
    {
        $_SERVER['REQUEST_METHOD'] = 'PUT';

        $result = json_decode($this->api->httpPut($payload['report_issue_id'], $payload), true);
        //Check if array has a key "status", then check if the response is success
        $this->assertArrayHasKey('status', $result);
        $this->assertEquals($result['status'], 'success');

        //Check if array has a key "data", then check if it is empty and and is an array
        $this->assertArrayHasKey('data', $result);
        $this->assertNotEmpty($result['data']);
        $this->assertIsArray($result['data']);
    }

    /**
     * @depends testPayloadTransferRequest
     */
    public function testHttpPutUpdateReportNoTransferRequestId(array $payload): void
    {
        $_SERVER['REQUEST_METHOD'] = 'PUT';

       

        $result = json_decode($this->api->httpPut($payload['report_issue_id'], $payload), true);
        //Check if array has a key "status", then check if the response is success
        $this->assertArrayHasKey('status', $result);
        $this->assertEquals($result['status'], 'success');

        //Check if array has a key "data", then check if it is empty and and is an array
        $this->assertArrayHasKey('data', $result);
        $this->assertNotEmpty($result['data']);
        $this->assertIsArray($result['data']);
    }

    /**
     * @depends testPayloadDelete
     */
    public function testHttpDelete(array $payload): void
    {

        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        
        $result = json_decode($this->api->httpDel($payload['id'], $payload), true);

        //checking if resulting json has content
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('status', $result);
        $this->assertEquals($result['status'], 'success');

        //Check if array has a key "data", then check if it is empty and and is an array
        $this->assertArrayHasKey('data', $result);
        $this->assertNotEmpty($result['data']);
        $this->assertIsArray($result['data']);
    }


    // public function testHttpPut($load)
    // {

    // }


    // public function testHttpDelete($load)
    // {

    // }
}

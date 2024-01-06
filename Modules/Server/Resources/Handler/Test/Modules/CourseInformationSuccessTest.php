<?php

 namespace Tests\Resources\Handler\Modules\CourseInformation;

use PHPUnit\Framework\TestCase;

use Resources\Handler\Modules\CourseInformation\API;

class APITest extends TestCase
{
    protected function setUp(): void
    {
        $this->api = new API();
    }

    public function testPayload(): array
    {
        $payload = array(
            "id" => 1,
	        "course_name" => "BS Computer Science",
            "category" => 4,
        );

        $load = $payload;
        $this->assertNotEmpty($load);
       
        return $load;
    }

     /**
     * @depends testPayload
     */
    public function testHttpPut($load) : array
    {
        $_SERVER['REQUEST_METHOD'] = 'PUT';

        $id = $load['id'];
        unset($load['id']);

        $result = json_decode($this->api->httpPut($id, $load), true);

        $this->assertArrayHasKey('status', $result);
        $this->assertEquals($result['status'], 'success');

        $this->assertArrayHasKey('data', $result);
        $this->assertIsArray($result['data']);
        $this->assertNotEmpty($result['data']);

        $this->assertArrayHasKey('id', $result['data']);
        $this->assertNotEmpty($result['data']['id']);
        $this->assertArrayHasKey('course_name', $result['data']);
        $this->assertNotEmpty($result['data']['course_name']);
        $this->assertArrayHasKey('category', $result['data']);
        $this->assertNotEmpty($result['data']['category']);

        return $load;

    }

     /**
     * @depends testHttpPut
     */
    public function testHttpPost($load) : array
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $result = json_decode($this->api->httpPost($load),true);
        $this->assertArrayHaskey('status',$result);
        $this->assertEquals($result['status'],'success');

        $this->assertArrayHasKey('data', $result);
        $this->assertIsArray($result['data']);
        $this->assertNotEmpty($result['data']);

        $this->assertArrayHasKey('course_name', $result['data']);
        $this->assertNotEmpty($result['data']['course_name']);
        $this->assertArrayHasKey('category', $result['data']);
        $this->assertNotEmpty($result['data']['category']);

        return $load;
    }

    /**
     * @depends testHttpPost
     */
    public function testHttpGetEmptyRequest($load) : array
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        
        $load = array();

        $result = json_decode($this->api->httpGet($load), true);
        $this->assertArrayHasKey('status', $result);
        $this->assertEquals($result['status'], 'success');

        $this->assertArrayHasKey('data', $result);
        $this->assertIsArray($result['data']);
        $this->assertNotEmpty($result['data']);

        foreach($result['data'] as $data){
            $this->assertArrayHasKey('id', $data);
            $this->assertNotEmpty($data['id']);
            $this->assertArrayHasKey('category', $data);
            $this->assertNotEmpty($data['category']);
            $this->assertArrayHasKey('course_name', $data);
            $this->assertNotEmpty($data['course_name']);
        }

        return($load);
    }

    /**
     * @depends testHttpPost
     */
    public function testHttpGetSpecificData($load) : array
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $load['id'] = 1;
        unset($load['course_name']);

        $result = json_decode($this->api->httpGet($load), true);
        $this->assertArrayHasKey('status', $result);
        $this->assertEquals($result['status'], 'success');

        $this->assertArrayHasKey('data', $result);
        $this->assertIsArray($result['data']);
        $this->assertNotEmpty($result['data']);

        $this->assertArrayHasKey('id', $result['data'][0]);
        $this->assertNotEmpty($result['data'][0]['id']);
        $this->assertArrayHasKey('course_name', $result['data'][0]);
        $this->assertNotEmpty($result['data'][0]['course_name']);
        $this->assertArrayHasKey('category', $result['data'][0]);
        $this->assertNotEmpty($result['data'][0]['category']);

        return($load);
    }


}
?>

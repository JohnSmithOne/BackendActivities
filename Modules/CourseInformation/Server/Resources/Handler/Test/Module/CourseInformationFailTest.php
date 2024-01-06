<?php

namespace Tests\Resources\Handler\Modules\CourseInformation;

use PHPUnit\Framework\TestCase;

use Resources\Handler\Modules\CourseInformation\API;

class APIFail extends TestCase
{
    protected function setUp(): void
    {
        $this->api = new API();
    }

    public function testPayload(): array
    {
        $payload = array(
            "id" => 65,
	        "course_name" => "BS Computer Science",
            "category" => 4,
            "amogus" => "sus"
        );

        $load = $payload;
        $this->assertNotEmpty($load);
       
        return $load;
    }

    /**
     * @depends testPayload
     */
    public function testHttpPostInvalidPayloadProperties($load) : array 
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $result = json_decode($this->api->httpPost($load),true);
        $this->assertArrayHaskey('status',$result);
        $this->assertEquals($result['status'],'fail');
        $this->assertArrayHaskey('message',$result);
        $this->assertEquals($result['message'], "Invalid Payload Properties: variable not set");

        return $load;
    }


    /**
     * @depends testHttpPostInvalidPayloadProperties
     */
    public function testHttpGetInvalidPayloadProperties($load) : array
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $result = json_decode($this->api->httpGet($load),true);
        $this->assertArrayHaskey('status',$result);
        $this->assertEquals($result['status'],'fail');
        $this->assertArrayHaskey('message',$result);
        $this->assertEquals($result['message'], "Invalid Payload Properties: variable not set");

        return $load;
    }


     /**
     * @depends testHttpPostInvalidPayloadProperties
     */
    public function testHttpGetFailDataDoesntExist($load) : array
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        unset($load['course_name']);
        unset($load['amogus']);      

        $result = json_decode($this->api->httpGet($load),true);
        $this->assertArrayHaskey('status',$result);
        $this->assertEquals($result['status'],'fail');
        $this->assertArrayHaskey('message',$result);
        $this->assertEquals($result['message'], "Invalid Payload Properties: Data Doesn't Exist ");

        return $load;
    }



    /**
     * @depends testHttpGetInvalidPayloadProperties
     */
    public function testHttpPutFailInvalidPayloadProperties($load) : array 
    {
        $_SERVER['REQUEST_METHOD'] = 'PUT';

        $id = $load['id'];
        unset($load['id']);

        $result = json_decode($this->api->httpPut($id, $load),true);
        $this->assertArrayHaskey('status',$result);
        $this->assertEquals($result['status'],'fail');
        $this->assertArrayHaskey('message',$result);
        $this->assertEquals($result['message'], "Invalid Payload Properties: variable not set");

        return $load;
    }


    /**
     * @depends testHttpGetInvalidPayloadProperties
     */
    public function testHttpPutFailDataDoesntExist($load) : array
    {
        $_SERVER['REQUEST_METHOD'] = 'PUT';

        $id = $load['id'];
        unset($load['id']);
        unset($load['amogus']);

        $result = json_decode($this->api->httpPut($id, $load),true);
        $this->assertArrayHaskey('status',$result);
        $this->assertEquals($result['status'],'fail');
        $this->assertArrayHaskey('message',$result);
        $this->assertEquals($result['message'], "Invalid Payload Properties: ID Doesn't Exist");

        return $load;
    }


}
?>

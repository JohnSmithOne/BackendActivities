<?php

//alisin niyo na po itong mga comments na CHANGE ME
//goodluck

/**
 * CHANGE ME!!
 *
 * Change the "SystemName" to the System you will working for. ex. PolanguiTreasury (use PascalCase).
 * Change the "ModuleName" to the Module you will working for. ex. OrNumbers (use PascalCase).
 */
namespace Resources\Inventory\Modules\StockAlert;

use Core\Modules\ModuleInterface;


use Resources\Inventory\System\Main;


class API extends Main implements ModuleInterface
{

    public const GET_PERMISSION_ALIAS = null;

    public const POST_PERMISSION_ALIAS = null;

    public const PUT_PERMISSION_ALIAS = null;

    public const DELETE_PERMISSION_ALIAS = null;

    public const FILE_UPLOAD_PERMISSION_ALIAS = null;

    /**
     * Table name
     *
     * @var string
     */
    protected $table;


    /**
     * Acceptable parameters
     *
     * @var array
     */
    protected $accepted_parameters;

    /**
     * Response column
     *
     * @var array
     */
    protected $response_column;

    protected $actions;
    public function __construct()
    {

        $this->actions = array(
            "Cancel" => 0,
            "Restock" => 1,
            null => null
        );

        $this->accepted_parameters = [
            // ex. id
            "retail_product_id",
            "batch_no",
            "retail_product",
            "serial_no.",
            "issue_label",
            "quantity",
            "action",
            // ex. first_name

            //for PUT method
            "report_issue_id",
            "product_name",
            "request_restock_to",
            "action_status",
            "message",

            //for DELETE method
            "id",
            "issue_name",

            //for get method
            "product_name"
        ];


        $this->response_column = [
            "retail_product_id",
            "batch_no",
            "reported_issue_id",
            "retail_product",
            "serial_no.",
            "issue_label_id",
            "quantity",
            "action",

            //for PUT method
            "report_issue_id",
            "product_name",
            "request_restock_to",
            "action_status",
            "message",

            //for DELETE method
            "id",
            "issue_name",
            "issue_id",
            "product",
            "serial_numbers",
            "stock_issue",
            "actions",

            // for get method
            "Product",
            "batch_number",
            "serial_number",
            "batch_quantity"
        ];

        $this->table = 'reported_issues';

        parent::__construct();
    }

    /**
     * HTTP GET handler
     *
     * @param array $params
     * @param bool $api
     * @return array|false|\MysqliDb|string
     * @throws \Exception
     */
    public function httpGet($params = array(), $api = true)
    {
        $data = array();
        
        //checks if params is array
        if (!is_array($params)) {
            return $this->Messages->jsonErrorInvalidParameters();
        }

        //Validate each property if correct
        foreach ($params as $key => $value) {
            if (!in_array($key, $this->accepted_parameters)) {
                return $this->Messages->jsonErrorInvalidParameters();
            }
        }

        /**
         * MYSQL Where Clause
         *
         * Get the specific row from the table using spefic id
         */
        // Check if a keyword for product_name has been specified otherwise null
        $name_keyword = isset($params['product_name']) ? $params['product_name'] : null;

        // The initial query will collect fundamental details and identifiers associated with the product from several interconnected tables

        $this->db->startTransaction();
        // Join queries


        // Filters the query based on the provided keywords
        if ($name_keyword != null) {
            $this->db->where("name", $name_keyword);
            $product = $this->db->getOne("products", null, "id, name, enable_serial_number, enable_batch_tracking");
        } else {

            //GETTING ALL THE DATA IN TBL_SERIAL_NUMBER_ISSUES
            $serial_data = $this->db->rawQuery("select sni.issue_id, p.name AS Product, group_concat(Distinct sn.serial_number SEPARATOR ', ') AS serial_number,
             ri.retail_product_id, ri.quantity, il.issue_name,il.id as issue_label_id, (CASE
            WHEN ri.action > 0 THEN 'Restock'
            ELSE 'Cancel'
        END) as action from tbl_serial_number_issues sni left join tbl_reported_issues ri on ri.id=sni.issue_id JOIN tbl_issue_labels il 
        on il.id=ri.issue_label_id join tbl_retail_products rp on rp.id=ri.retail_product_id join tbl_products p on p.id=rp.product_id 
        join tbl_serial_numbers sn ON sn.id=sni.serial_number_id group by sni.issue_id;");

            //getting all the data in tbl_batch_number_issues
            $batch_data = $this->db->rawQuery("select bni.issue_id,p.name as Product,group_concat(Distinct bn.batch_number SEPARATOR ', ') 
            AS batch_number, ri.retail_product_id, ri.quantity, il.issue_name, il.id as issue_label_id,(CASE
            WHEN ri.action > 0 THEN 'Restock'
            ELSE 'Cancel'
        END) as action from tbl_batch_number_issues bni left join tbl_reported_issues ri on ri.id=bni.issue_id JOIN tbl_issue_labels il 
        on il.id=ri.issue_label_id join tbl_retail_products rp on rp.id=ri.retail_product_id join tbl_products p on p.id=rp.product_id 
        join tbl_batch_numbers bn ON bn.id=bni.batch_id group by bni.issue_id;");

            //MERGING ALL THE DATA 
            $data = array_merge($serial_data, $batch_data);
        }
        //Determine if User inputed a product name
        if (isset($product)) {
            //IF PRODUCT IS SERIAL NUMBER ENABLED
            if ($product['enable_serial_number']) {
                //Getting the Necessary Information of Each Row
                $data = $this->db->rawQuery("select sni.issue_id, p.name as product, group_concat(Distinct sn.serial_number SEPARATOR ', ') 
                AS serial_numbers, ri.retail_product_id, il.issue_name,il.id as issue_label_id, ri.quantity,(CASE
                WHEN ri.action > 0 THEN 'Restock'
                ELSE 'Cancel'
            END) as action  from tbl_serial_number_issues sni JOIN tbl_reported_issues ri ON ri.id=sni.issue_id JOIN tbl_issue_labels il 
            ON il.id=ri.issue_label_id JOIN tbl_retail_products rp ON ri.retail_product_id=rp.id JOIN tbl_serial_numbers sn 
            ON sn.id=sni.serial_number_id JOIN tbl_products p ON p.id=rp.product_id WHERE rp.product_id='" . $product['id'] . "' group 
            by sni.issue_id;");

                //IF PRODUCT IS BATCH TRACKING ENABLED
            } else if ($product['enable_batch_tracking']) {
                //code for batch number
                $data = array();

                //Getting the Necessary Information of Each Row
                $data = $this->db->rawQuery("select bni.issue_id, p.name as product, group_concat(Distinct bn.batch_number SEPARATOR ', ') AS batch_number,  ri.retail_product_id, il.issue_name, il.id as issue_label_id,ri.quantity,(CASE
                WHEN ri.action > 0 THEN 'Restock'
                ELSE 'Cancel'
                END) as action  from tbl_batch_number_issues bni JOIN tbl_reported_issues ri ON ri.id=bni.issue_id JOIN tbl_issue_labels il 
                ON il.id=ri.issue_label_id JOIN tbl_retail_products rp ON ri.retail_product_id=rp.id JOIN tbl_batch_numbers bn ON 
                bn.id=bni.batch_id JOIN tbl_products p ON p.id=rp.product_id  WHERE rp.product_id='" . $product['id'] . "' group by bni.issue_id;");

            }
        }
        if ($data) {
            return $this->buildApiResponse(
                $data,
                $this->response_column
            );
        } {
            return $this->buildApiResponse(["No Data from the DB"], $this->response_column, false);
        }

    }

    /**
     * HTTP POST handler
     *
     * @param $payload
     * @return false|string
     * @throws \Exception
     */
    public function httpPost($payload)
    {

        $data = array();
        $modality = null;

        /** Determined the Modality */
        if (isset($payload['batch_no']) && isset($payload['quantity_issue'])) {
            $modality = 1;
        } else {
            $modality = 0;
        }


        //Basic validation

        /** Lists of required field must be filled up */
        $required_fields = [
            "retail_product",
            "serial_no.",
            "issue_label",
            "quantity",
            "action"
        ];

        /** Adding new field for batch modality */
        if ($modality) {
            array_push($this->accepted_parameters, "quantity_issue");
            array_push($required_fields, "quantity_issue");
            array_push($this->response_column, "quantity_issue");

            array_push($this->accepted_parameters, "batch_no");
            array_push($required_fields, "batch_no");
            array_push($this->response_column, "batch_no");

            unset($this->accepted_parameters[1]);
            unset($required_fields[1]);
            unset($this->response_column[1]);

        }

        if (!is_array($payload)) {

            return $this->Messages->jsonErrorInvalidParameters("Not An Array");

        }

        //Validate each property if correct
        foreach ($payload as $key => $value) {
            if (!in_array($key, $this->accepted_parameters)) {

                return $this->Messages->jsonErrorInvalidParameters("Each Property Not Set");
            }
        }


        // Clean payload
        $trimmedPayload = $this->trimPayload($payload);

        /** Check if all fields required are filled */
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $trimmedPayload)) {
                return $this->Messages->jsonErrorRequiredFieldsNotFilled();
            }
        }
        /** Getting the  quantity of issue*/
        $data['quantity'] = $payload['quantity'];

        /** Getting the action for the issue */
        if (array_key_exists($payload['action'], $this->actions)) {
            $data['action'] = $this->actions[$payload['action']];
        }



        /** check if issue label exists*/
        $this->db->where('issue_name', $payload['issue_label']);
        $result = $this->db->getOne('issue_labels');
        if (!$result) {
            /** Insert if it does not exists */
            $this->db->startTransaction();
            $id = $this->db->insert('issue_labels', array("issue_name" => $payload['issue_label']));
            if (!$id) {
                $this->db->rollback();
                return $this->Messages->jsonErrorRequiredFieldsNotFilled('Query Unsuccessful');
            }
            $data['issue_label_id'] = $id;
            $trimmedPayload['issue_label_id'] = $id;
        } else {
            $data['issue_label_id'] = $result['id'];
            $trimmedPayload['issue_label_id'] = $result['id'];
        }


        /** Getting the Retail Product Id */
        $this->db->join("retail_products rp", "rp.product_id=p.id", "LEFT");
        $this->db->where('p.name', $payload['retail_product']);
        $products = $this->db->getOne('products p');
        if (!$products) {
            $this->db->rollback();
            return $this->Messages->jsonErrorInvalidParameters("Retail Product Doesn't Exists");
        }
        $data['retail_product_id'] = $products['id'];


        /**
         * Record when the data is added
         * Comment out if not needed
         */
        // $trimmedPayload['date_added'] = date("Y-m-d");
        $data['action'] = $this->actions[$payload['action']];
        //MYSQL Insert query
        $data['reported_issue_id'] = $this->db->insert($this->table, $data);
        $trimmedPayload['issue_id'] = $data['reported_issue_id'];

        //Check if insert successful or not
        if (empty($data['reported_issue_id'])) {
            $this->db->rollback();
            return $this->Messages->jsonErrorInvalidParameters("Query Unsuccessful");
        }
        /** Check if their are serial numbers to determine the MODALITY*/
        $quantity = $data['quantity'];
        if ($modality) {
            // BATCH MODALITY
            $data['quantity_issue'] = $trimmedPayload['quantity_issue'];
            // MULTIPLE Batch
            if (is_array($payload['batch_no'])) {
                $batches = array();
                /** Getting all the batch base on retail_product_id */
                foreach ($trimmedPayload['batch_no'] as $value) {

                    $value = explode(" ", $value)[1];
                    array_push($batches, $value);
                }
                $this->db->where('batch_number', $batches, "IN");
                $this->db->where('retail_product_id', $data['retail_product_id']);
                $this->db->where('quantity', $data['quantity_issue']);
                $batch_result = $this->db->get("batch_numbers");

                $batch_issues_data = array();
                /**Checking if quantity is equal to serial number count */
                if (count($batch_result) == $quantity) {
                    foreach ($batch_result as $value) {
                        array_push($batch_issues_data, array('issue_id' => $data['reported_issue_id'], "batch_id" => $value['id'], "quantity" => $data['quantity_issue']));
                    }

                    /**Inserting data to tbl_serial_number_issues */
                    $issue_serial_ids = $this->db->insertMulti('batch_number_issues', $batch_issues_data);
                    if (!$issue_serial_ids) {
                        $this->db->rollback();
                        return $this->buildApiResponse([
                            'message' => $this->db->getLastError()
                        ], $this->response_column, false);
                    } else {
                        $this->db->commit();
                        return $this->buildApiResponse(
                            $trimmedPayload,
                            $this->response_column
                        );
                    }
                } else {
                    $this->db->rollback();
                    return $this->Messages->jsonErrorInvalidParameters("Quantity Not Equal to Batch Number Count");
                }

            }

        } else {

            // SERIAL MODALITY

            /**Serial Number Validation if it is a multiple serial number */

            if (is_array($trimmedPayload['serial_no.'])) {
                /** Getting all the serial numbers base on retail_product_id */
                $this->db->where('serial_number', $trimmedPayload['serial_no.'], "IN");
                $this->db->where('retail_product_id', $data['retail_product_id']);
                $serials = $this->db->get("serial_numbers");

                $serial_issues_data = array();
                /**Checking if quantity is equal to serial number count */
                if (count($serials) == $quantity) {
                    foreach ($serials as $value) {
                        array_push($serial_issues_data, array("issue_id" => $data['reported_issue_id'], "serial_number_id" => $value['id']));
                    }
                    /**Inserting data to tbl_serial_number_issues */
                    $issue_serial_ids = $this->db->insertMulti('serial_number_issues', $serial_issues_data);
                    if (!$issue_serial_ids) {
                        $this->db->rollback();
                        return $this->buildApiResponse([
                            'message' => $this->db->getLastError()
                        ], $this->response_column, false);
                    } else {
                        $this->db->commit();
                        return $this->buildApiResponse(
                            $trimmedPayload,
                            $this->response_column
                        );
                    }
                } else {
                    $this->db->rollback();
                    return $this->Messages->jsonErrorInvalidParameters("Quantity Count Not Equal to Number of Serial Number or Serial Number does not Exist Basied on Retail Product");
                }


            }
        }
    }
    /**
     * HTTP PUT handler
     *
     * @param null|int $id
     * @param $payload
     * @return false|string
     * @throws \Exception
     */
    public function httpPut($id, $payload)
    {
        $id = $payload['report_issue_id'];
        // Checks if Input Response are valid
        if (empty($id) || !is_numeric($id) || !array_key_exists('report_issue_id', $payload)) {
            return $this->Messages->jsonErrorInvalidParameters("Invalid Input Requests");
        }

        //Validate each property if correct
        foreach ($payload as $key => $value) {
            if (!in_array($key, $this->accepted_parameters)) {
                return $this->Messages->jsonErrorInvalidParameters("Entry Doesn't Match Expected Values");
            }
        }

        // Clean payload
        $trimmedPayload = $this->trimPayload($payload);
        /** Lists of required field must be filled */
        $required_fields = [
            "report_issue_id",
            "product_name",
            "request_restock_to",
            "message",
            "quantity",
            "action"
        ];

        /* Check if all fields required are filled */
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $trimmedPayload)) {
                return $this->Messages->jsonErrorRequiredFieldsNotFilled("Inputs for required fields were incomplete ");
            }
        }

        //array keys to be passed on transfer_request
        $this->db->where('name', $trimmedPayload['request_restock_to']);
        $store = $this->db->getOne('retail_stores');
        $requesting_store_id = $store['id'];

        $message = $trimmedPayload['message'];
        //array keys to be passed on transfer_request_products
        $this->db->where('name', $trimmedPayload['product_name']);
        $product = $this->db->getOne('products');
        $product_id = $product['id'];
        $quantity = $trimmedPayload['quantity'];

        $this->db->where('product_id', $product_id);
        $retail_product = $this->db->getOne('retail_products');
        $retail_productID = $retail_product['id'];

    
        // Check what action is being done
        $actionValue = isset($this->actions[$trimmedPayload['action']]) ? $this->actions[$trimmedPayload['action']] : null;
        
        if ($actionValue == 1) {
            //Initiate Update for "Restock" action
            $this->db->where('id', $id);
            $result = $this->db->getOne($this->table);

            // Checks if the report_issue_id exists in the database
            if ($result) {
                /** Update contents related to transfer_request_id if it is present in the database*/
                $this->db->where('id', $id);
                $data = array(
                    'message' => $trimmedPayload['message'],
                    'requesting_store_id' => $requesting_store_id,
                    'status' => 0
                );
                $result = $this->db->update('transfer_requests', $data);       

                /**Update contents in transfer_requeststable related to transfer_request_id */
                $this->db->where('request_id', $id);
                $requestProduct = array(
                    'retail_product_id' => $retail_productID,
                    'quantity' => $quantity,
                    'status' => 0
                );

                $result = $this->db->update('transfer_request_products', $requestProduct);
    
                $this->db->where('id', $id);
                $reportedIssue = array(
                    'retail_product_id' => $retail_productID,
                    'quantity' => $quantity,
                    'action' => isset($this->actions[$trimmedPayload['action']]) ? $this->actions[$trimmedPayload['action']] : null
                );
                $result = $this->db->update($this->table, $reportedIssue);

                if ($result) {
                    $trimmedPayload['action_status'] = 'Restock Succesfully Requested';
                    return $this->buildApiResponse($trimmedPayload, $this->response_column);

                } else {
                    $this->db->rollback();
                    return $this->Messages->jsonErrorInvalidParameters("Query Unsuccessful");
                }

            } 
            //Insert new data if report_issue_id doesn't exist in the reported_issues
            else {
                 /*Insert data in reported_issues*/
                $array = array(
                    'id'=> $id,
                    'retail_product_id' => $retail_productID,
                    'quantity' => intval($quantity),
                    'action' => isset($this->actions[$trimmedPayload['action']]) ? $this->actions[$trimmedPayload['action']] : null
                );
                $this->db->insert($this->table, $array);

                $result = $this->db->insert('transfer_requests', array(  
                    'message' => $trimmedPayload['message'],
                    'requesting_store_id' => $requesting_store_id,
                    'status' => 0
                ));
                if($result){
                $this->db->where('message', $trimmedPayload['message']);
                $transferRequestRow = $this->db->getOne('transfer_request');
                $transferRequestID = $transferRequestRow['id'];

                /*Insert report issue in transfer_request_product table */
                $result = $this->db->insert('transfer_request_products', array(
                    'request_id' => $transferRequestID,
                    'retail_product_id' => $retail_productID,
                    'quantity' => $quantity,
                    'status' => 0
                ));

                //JSON Output Response
                if ($result) {
                    $this->db->where('id', $id);
                    $insertResult = $this->db->getOne($this->table);
                    if ($insertResult) {
                        $trimmedPayload['action_status'] = 'Restock Request Added';

                        return $this->buildApiResponse($trimmedPayload, $this->response_column);
                    } else {
                        $this->db->rollback();

                        return $this->Messages->jsonErrorInvalidParameters("Query Unsuccessful");
                    }
                }

                } 
                else {
                    return $this->buildApiResponse([
                        'message' => "Query Unsuccesful"
                    ], $this->response_column, false);
                } 

            }
        } else {

            // Initiate Update for "Cancel" action
            $this->db->where('id', $id);
            $result = $this->db->getOne($this->table);
            // Checks if the transfer_request_id exists in the database
            if ($result) {
                //Cancels a Restock Request
                $this->db->where('id', $id);
                $data = array(
                    'status' => 2
                );
                $result = $this->db->update('transfer_requests', $data);
                /**Update contents in transfer_requests_id trable related to transfer_request */
                $this->db->where('request_id', $id);
                $requestProduct = array(
                    'status' => 2
                );
                $result = $this->db->update('transfer_request_products', $requestProduct);

                /**Update contents in reported_issues */
                $this->db->where('id', $id);
                $reportedIssue = array(
                    'action' => isset($this->actions[$trimmedPayload['action']]) ? $this->actions[$trimmedPayload['action']] : null
                );
                $result = $this->db->update($this->table, $reportedIssue);

                if ($result) {
                    $trimmedPayload['action_status'] = 'Restock Request Cancelled';

                    return $this->buildApiResponse($trimmedPayload, $this->response_column);

                } else {
                    $this->db->rollback();

                    return $this->buildApiResponse([
                        'message' => $this->db->getLastError()
                    ], $this->response_column, false);
                }
            } else {
                $this->db->rollback();

                return $this->Messages->jsonErrorInvalidParameters("Cannot Cancel: Restock Request Doesn't Exists");
            }
        }

    }


    /**
     * HTTP DELETE handler
     *
     * @param $id
     * @param $payload
     * @return false|string
     * @throws \Exception
     */
    public function httpDel($id, $payload)
    {
        $id = $payload['id'];

        $selected_ids = is_array($id) ? $id : [$id];
        // Check if IDs were specified
        if (empty($selected_ids) || empty($id)) {
            return $this->Messages->jsonErrorInvalidParameters("Invalid ID");
        }

        // Validate Payload
        if (is_array($payload)) {
            foreach ($payload as $key => $value) {
                if (!in_array($key, $this->accepted_parameters)) {
                    return ($this->Messages->jsonErrorInvalidParameters("IncorrecT Payload Parameters"));

                }
            }
        }

        $trimmedPayload = $this->trimPayload($payload);
        //if-statement if there are multiple id entries from the input request
        if (is_array($trimmedPayload['issue_name']) && is_array($id)) {

            // Checks if id is in the database and checks if it has a correct issue_name
            $this->db->where('id', $id);
            $issueLabelId = $this->db->getOne('issue_labels');
            if (!$issueLabelId) {
                return $this->Messages->jsonErrorInvalidParameters("Issue Label Doesn't Exist");
            } else {
                $this->db->where('issue_name', $trimmedPayload['issue_name']);
                $issueName = $this->db->getOne('issue_labels');
                if (!$issueName) {
                    return $this->Messages->jsonErrorInvalidParameters("Unknown Issue Label");
                }
            }
        } else {
            $this->db->where('id', $id);
            $issueLabelId = $this->db->getOne('issue_labels');
            if (!$issueLabelId) {
                return $this->Messages->jsonErrorInvalidParameters("Issue Label Doesn't Exist");

            } else {
                $this->db->where('issue_name', $trimmedPayload['issue_name']);
                $issueName = $this->db->getOne('issue_labels');
                if (!$issueName) {
                    return $this->Messages->jsonErrorInvalidParameters("Unknown Issue Label");

                }
            }
        }

        $issueLabel = $issueName['id'];
        $this->db->where('issue_label_id', $issueLabel);
        $result = $this->db->getOne($this->table);

        //for multiple IDS
        if (is_array($trimmedPayload['issue_name']) && is_array($id)) {
            $issueNames = array();
            foreach ($trimmedPayload['issue_name'] as $value) {
                $issue_array = explode(" ", $value)[1];
                array_push($issueNames, $issue_array);
            }

            $issueId = array();
            foreach ($id as $value) {
                $issueIDS = explode(" ", $value)[1];
                array_push($issueId, $issueIDS);
            }

            $deleted_data = [];
            foreach ($selected_ids as $id) {
                // Access other values related to the ID 
                $this->db->where('id', $id);
                $query_id = $this->db->getOne('issue_labels');
                if (!$query_id) {

                    return $this->Messages->jsonErrorInvalidParameters("Query Unsuccessful");
                }
                $this->db->where('issue_name', $trimmedPayload('issue_name'));
                $query_issueName = $this->db->getOne('issue_labels');
                if (!$query_issueName) {

                    return $this->Messages->jsonErrorInvalidParameters("Query Unsuccessful");
                }
            }
        }

        $this->db->where('id', $id);
        $deleteResult = $this->db->delete('issue_labels');
        if ($deleteResult) {
            return $this->buildApiResponse($trimmedPayload, $this->response_column);

        } else {
            $this->db->rollback();
            return $this->Messages->jsonErrorInvalidParameters("Query Unsuccessful");
        }
    }

    public function httpFileUpload(int $identity, array $payload)
    {
        // TODO: Implement httpFileUpload() method.
    }
}

?>

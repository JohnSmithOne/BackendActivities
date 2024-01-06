<?php

/**
 * CHANGE ME!!
 *
 * Change the "SystemName" to the System you will working for. ex. PolanguiTreasury (use PascalCase).
 * Change the "ModuleName" to the Module you will working for. ex. OrNumbers (use PascalCase).
 */
namespace Resources\documentTracking\Modules\EscalationManagement;

use Core\Modules\ModuleInterface;

/**
 * CHANGE ME!!
 *
 * Change the "SystemName" to the System you will working for. ex. PolanguiTreasury (use PascalCase).
 */
use Resources\documentTracking\System\Main;

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


    public function __construct()
    {
        // COMMENT LINE 58 WHEN COMMITTING & PUSHING CHANGES TO THE REMOTE REPOSITORY
        // $_SESSION['_active_session'] = array();

        /**
         *
         * Set the Specific Role of an User
         *
         * NOTE: Make sure to comment line 66 before to commit & push changes to the remote repository.
         */
        // $_SESSION['_active_session']['role'] = 1;

        
        /**
         * CHANGE ME!!
         *
         * Accepted Parameters only accepts allowed properties to be sent here in API.
         * If property is not in the list error will occure.
         */
        $this->accepted_parameters = [
            'id',
            'rfid',
            'escalate_documents',
            'document_histories',
            'note'
        ];
            
        /**
         * CHANGE ME!!
         *
         * Response Column limits the allowed property to be sent back from the request.
         * Just copy all the paremeters from "accepted parameters" and paste it inside "response column"
         */
        $this->response_column = [
            'id',
            'rfid',
            'client_name',
            'document_type',
            'status',
            'escalation_level',
            'escalate_documents',
            'document_histories',
            'note',
            'activity_date'
        ];

        /**
         * CHANGE ME!!
         *
         * Name of the main table. Usually the table name matches to the module name.
         * Ex. or_numbers (use snake_case).
         */
        $this->table = 'documents';

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
         * Needed Functions or Process by User
         *
         */
        if (isset($_SESSION['_active_session']) && array_key_exists('role', $_SESSION['_active_session'])) {
            switch ($_SESSION['_active_session']['role']) {
                case 0:
                    // Admin
                    break;
                case 1:
                    // User 1

                    // MYSQL Select query
                    $this->db->join("document_types dt", "d.document_type_id = dt.id", "LEFT");

                    $select = "d.*, d.document_type_id as document_type, dt.document_type";

                    if (isset($params['id']) && !isset($params['rfid'])){
                        $this->db->join("document_histories dh", "d.id = dh.document_id", "LEFT");
                        $this->db->join("user_management u", "dh.staff_id = u.id", "LEFT");
                        $this->db->where('d.id', $params['id']); 

                        // Concat select query
                        $select .= ", concat(u.first_name,' ', u.middle_name, ' ', u.last_name, ' ', u.suffix_name) as client_name,  dh.activity_date";
                    }

                    // Escalation level is needed in GET ALL and when searching for a specific RFID
                    if(empty($params) || isset($params['rfid'])){
                        $this->db->join("escalate_documents e", "d.id = e.document_id ", "LEFT");

                        // Concat select query
                        $select .= ", e.escalation_level";
                    }
                    
                    if(isset($params['rfid']) && !isset($params['id'])){
                        $this->db->where('rfid', $params['rfid']);
                    }
                    
                    $queryResult =  $this->db->get($this->table." d", null, $select);
                    
                    if (empty($queryResult)) return $this->errorResponse('No results found');
            
                    return $api ? $this->buildApiResponse($queryResult, $this->response_column) : $queryResult;
                    break;

                case 2:
                    // User 2
                    break;
                case 3:
                    // User 3
                    break;
                default:
                    break;
            }
        } else {
            return $this->Messages->jsonErrorInvalidToken();
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
        //Basic validation
        if (!is_array($payload)) {
            return $this->Messages->jsonErrorInvalidParameters();
        }
        
        //Validate each property if correct
        foreach ($payload as $key => $value) {
            if (!in_array($key, $this->accepted_parameters)) {
                return $this->Messages->jsonErrorInvalidParameters();
            }
        }

        /** Lists of required field must be filled up */
        $required_fields = [
            'id',
            'escalate_documents',
            'document_histories',
            'note'
        ];

        // Clean payload
        $trimmedResult = $trimmedPayload = $this->trimPayload($payload);

        /** Check if all fields required are filled */
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $trimmedPayload)) {
                return $this->Messages->jsonErrorRequiredFieldsNotFilled();
            }
        }

        // MYSQL where query
        $documents = $this->db->where('id', $trimmedPayload['id'])->get($this->table);

        // Check if id exist
        if(empty($documents)) return $this->errorResponse('ID does not exist');

        $trimmedPayload['escalate_documents']['document_id'] = $trimmedPayload['id'];
        $trimmedPayload['escalate_documents']['note'] = $trimmedPayload['note'];

        $query = $this->db->insert('escalate_documents', $trimmedPayload['escalate_documents']);

        // Check if insert is not successful
        if (empty($query)) return $this->errorResponse();
       
        $trimmedPayload['document_histories']['activity_date'] = date("Y-m-d H:i:s");
        $trimmedPayload['document_histories']['document_id'] = $trimmedPayload['id'];
        $trimmedPayload['document_histories']['note'] = $trimmedPayload['note'];
        
        $queryResult = $this->db->insert('document_histories', $trimmedPayload['document_histories']);
       
        // Check if insert is not successful
        if (empty($queryResult)) return $this->errorResponse();

        return $this->buildApiResponse(
            $trimmedResult,
            $this->response_column, true
        );
        
    }

    /**
     * Format error respones
     *
     * @param null|string $message
     * @return $string
     * @throws \Exception
     */
    public function errorResponse($message = null){
        if (!$message)
            $message = $this->db->getLastError();
            
        return $this->buildApiResponse([
            $message
        ], $this->response_column, false);
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
        //Basic validation
        if (empty($id) || !is_numeric($id) || !array_key_exists('id', $payload)) {
            return $this->Messages->jsonErrorInvalidParameters();
        }

        /** Validate each property if correct */
        foreach ($payload as $key => $value) {
            if (!in_array($key, $this->accepted_parameters)) {
                return $this->Messages->jsonErrorInvalidParameters();
            }
        }

        // Clean payload
        $trimmedPayload = $this->trimPayload($payload);

        /** Lists of required field must be filled */
        $required_fields = [];

        /* Check if all fields required are filled */
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $payload)) {
                return $this->Messages->jsonErrorRequiredFieldsNotFilled();
            }
        }

        // Check if id is equal to the id from paypoad
        if ($id != $payload['id']) {
            return $this->Messages->jsonErrorInvalidParameters();
        }

        /**
         * MYSQL Where Clause
         *
         * Get the specific row from the table using spefic id
         */
        $this->db->where('id', $id);

        //Execute query
        $queryResult = $this->db->update($this->table);

        if ($queryResult) {
            return $this->buildApiResponse($payload, $this->response_column);
        } else {
            return $this->buildApiResponse([
                'message' => $this->db->getLastError()
            ], $this->response_column, false);
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
        // Check if ID exists
        if (empty($id) || !is_string($id)) {
            return $this->Messages->jsonErrorInvalidParameters();
        } else {
            // Validate Payload
            foreach ($payload as $key => $value) {
                if (!in_array($key, $this->accepted_parameters)) {
                    exit($this->Messages->jsonErrorInvalidParameters());
                }
            }

            /**
             * MYSQL Where Clause
             *
             * Get the specific row from the table using spefic id
             */
            $this->db->where('id', $id);
            $queryResult = $this->db->delete($this->table);

            // MYSQL Delete query
            if ($queryResult) {
                return $this->buildApiResponse([], $this->response_column);
            } else {
                return $this->buildApiResponse([
                    'message' => $this->db->getLastError()
                ], $this->response_column, false);
            }
        }
    }
    public function httpFileUpload(int $identity, array $payload)
    {
        // TODO: Implement httpFileUpload() method.
    }
}

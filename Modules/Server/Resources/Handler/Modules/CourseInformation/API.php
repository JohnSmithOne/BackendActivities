<?php
  namespace Resources\Handler\Modules\CourseInformation;

  use Core\Modules\ModuleInterface;

  use Resources\System\Main;

    class API extends Main implements ModuleInterface {

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


        public function __construct() {
         
            $this->accepted_parameters = [
                'id', 
                'category',
                'course_name',
            ];

            $this->response_column = [
                'id', 
                'category',
                'course_name'
            ];

           
            $this->table = 'courses';

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
        public function httpGet($params = array(), $api = true) {
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

        if (empty($params)) {
            // Empty GET request
            $queryResult = $this->db->get($this->table);    
            if (empty($queryResult)) {
                return $this->Messages->jsonErrorInvalidParameters('No results found');
            }
            
            return $api ? $this->buildApiResponse($queryResult, $this->response_column) : $queryResult;
        }
        else{
            //Get Specific Data.
        if (isset($params['id']) && isset($params['category'])) {
            $id = intval($params['id']);
            $category = $params['category'];

            $this->db->where('id', $id);
            $this->db->where('category', $category);
    
            $queryResult = $this->db->get($this->table);
    
        if (empty($queryResult)) {
                return $this->Messages->jsonErrorInvalidParameters("Data Doesn't Exist ");
            }
        else{
            return $api ? $this->buildApiResponse($queryResult, $this->response_column) : $queryResult;
        }
    }        
    }            
    }

        /**
         * HTTP POST handler
         *
         * @param $payload
         * @return false|string
         * @throws \Exception
         */
        public function httpPost($payload) {
            

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
            'course_name',
            'category'
        ];
        
        // Clean payload
        $trimmedPayload = $this->trimPayload($payload);
        /** Check if all fields required are filled */
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $trimmedPayload)) {
                return $this->Messages->jsonErrorRequiredFieldsNotFilled();
            }
        }
        
         $result = $this->db->insert($this->table, array(
            'course_name' => $trimmedPayload['course_name'],
            'category' => $trimmedPayload['category'],
        ));

        //JSON Output Response
        if ($result) {
            $this->db->where('course_name', $trimmedPayload['course_name']);
            $insertResult = $this->db->getOne($this->table);
            if ($insertResult) {
                return $this->buildApiResponse($trimmedPayload, $this->response_column);
            } else {
                $this->db->rollback();

                return $this->Messages->jsonErrorInvalidParameters("Query Unsuccessful");
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
        public function httpPut ($id, $payload) {

            $id = intval($id);
            $payload['id'] = $id;
            
            
            //Basic validation
            if(empty($id) || !is_numeric($id) || !array_key_exists('id', $payload)) {
                return $this->Messages->jsonErrorInvalidParameters();
            }
            /** Validate each property if correct */
            foreach ($payload as $key => $value) {
                if(!in_array($key, $this->accepted_parameters)) {
                    return $this->Messages->jsonErrorInvalidParameters();
                }
            }
            // Clean payload
            $trimmedPayload = $this->trimPayload($payload);

            $required_fields = [
                "id",
                "course_name",
                "category"
            ];

                /** Check if all fields required are filled */
            foreach($required_fields as $field) {
                if(!array_key_exists($field, $payload)) {
                    return $this->Messages->jsonErrorRequiredFieldsNotFilled();
                    }
                }
                /**
                 * MYSQL Where Clause
                 *
                 * Get the specific row from the table using spefic id
                 */
                $this->db->where('id', $id);
                $result = $this->db->getOne($this->table);

                if($result){
                $updateInfo = array(
                    'course_name' => $trimmedPayload['course_name'],
                    'category' => $trimmedPayload['category']
                );
                $this->db->where('id', $id);
                $result = $this->db->update($this->table, $updateInfo);
                if ($result) {
                    return $this->buildApiResponse($trimmedPayload, $this->response_column);

                } else {
                    $this->db->rollback();
                    return $this->Messages->jsonErrorInvalidParameters("Query Unsuccessful");
                }
            }
                else{
                $this->db->rollback();
                    return $this->Messages->jsonErrorInvalidParameters("ID Doesn't Exist");
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
        public function httpDel($id, $payload) {
            // Module Doesnt have a DELETE Method
           
        }
        public function httpFileUpload(array $payload)
        {
            // TODO: Implement httpFileUpload() method.
        }
    }

        
    
?>

<?php

namespace Resources\DocumentTracking\Helpers;

/** This Global Helper Class */
class GlobalHelpers
{
    public function __construct()
    {
    }

    /**
     * buildEmployeeAvatar
     *
     * This Function Read Employee Photo and Convert it to base64
     * @param mixed $params
     * @return void
     */

    public function buildEmployeeAvatar($params)
    {
        $target_directory = __DIR__ . './../Uploads/Employee/Avatars';
        $file_name = $params['photo'];
        if (!empty($file_name)) {
            if (file_exists("$target_directory/$file_name")) {
                $img = file_get_contents("$target_directory/$file_name");
                return base64_encode($img);
            }
        }
    }

    /**
     * @param $table
     * @param int $type
     */
    public function addCommittedBy(&$table, $type = 0)
    {
        /* Add Modified By  */
        $commit = null;
        if ($type == 1) {
            $commit = 'created_by';
        } elseif ($type == 2) {
            $commit = 'modified_by';
        } elseif ($type == 3) {
            $commit = 'deleted_by';
        } else {
            $commit = 0;
        }
//        $table[$commit] = $_SESSION['token']->getClaim('claims')['user']['id'];
        $table[$commit] = array_key_exists("id", $_SESSION['_active_session']) ? $_SESSION['_active_session']['id'] : null;
    }
}

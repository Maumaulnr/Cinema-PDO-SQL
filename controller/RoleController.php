<!-- RoleController -->

<?php
require_once 'app/DAO.php';

class RoleController
{
    

    // Insert Role
    public function insertRole() {
        $dao = new DAO();

        if(isset($_POST['submit'])) {
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPACIAL_CHARS);

            if(!empty($role)) {
                $sqlInsertRole = 'INSERT INTO role (role) VALUES (:role)';
                $insertRole = dao->executeRequest($sqlInsertRole, [':role' => $role]);

                if($insertRole) {
                    echo "Add Role";
                } else {
                    echo "Error";
                }
            }
        }
        // Reload the page after submit
        $this->insertRoleForm();
    }
}
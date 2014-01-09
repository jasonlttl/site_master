<?php
namespace SiteMaster\Registry\Site;

use DB\Record;

class Role extends Record
{
    public $id;               //int required
    public $role_name;        //varchar required

    public function keys()
    {
        return array('id');
    }

    public static function getTable()
    {
        return 'roles';
    }

    /**
     * Get a role object by a role name
     * 
     * @param $role_name
     * @return false|Role
     */
    public static function getByRoleName($role_name)
    {
        return self::getByAnyField(__class__, 'role_name', $role_name);
    }

    /**
     * Create a new role
     * 
     * @param $role_name
     * @return bool|Role
     */
    public static function createRole($role_name)
    {
        $role = new self();
        $role->role_name = $role_name;
        
        if (!$role->insert()) {
            return false;
        }
        
        return $role;
    }
}

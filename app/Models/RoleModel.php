<?php

namespace Models;

use CodeIgniter\Model;
use Models\Entities\Role;
use Models\Entities\User;

class RoleModel extends Model
{
    protected $table = 'Roles';
    protected $primaryKey = 'Id';
    protected $allowedFields = [
      'Id', 'Name'
    ];

    public function find($id = null): Role
    {
        $builder = $this->builder($this->table);
        $query = $builder
            ->where('Id', $id);

        $response = $query->get();
        $role = Role::parseFromArray($response->getRowArray());

        $response->freeResult();
        return $role;
    }

    public function findByName(string $roleName): ?Role
    {
        $builder = $this->builder($this->table);
        $query = $builder
            ->where('Name', $roleName);

        $response = $query->get();
        $role = $response->getNumRows() > 0 ? Role::parseFromArray($response->getRowArray()) : null;

        $response->freeResult();
        return $role;
    }

    /***
     * @return User[]
     */
    public function findUsersWithRole(string $roleName): array {
        $builder = $this->builder($this->table);
        $query = $builder
            ->select("Users.*, Roles.Name as RoleName")
            ->join('Users', 'Users.RoleId = Roles.Id')
            ->where('Roles.Name', $roleName);

        $response = $query->get();
        $users = [];
        foreach ($response->getResultArray() as $userRow)
            $users[] = User::parseFromArray($userRow);

        $response->freeResult();
        return $users;
    }

}
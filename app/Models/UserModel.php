<?php

namespace Models;

use CodeIgniter\Model;
use Models\Entities\User;

class UserModel extends Model
{
    protected $table = 'Users';
    protected $primaryKey = 'Id';
    protected $allowedFields = [
      'Id', 'Login', 'HashedPassword', 'Email', 'RoleId', 'Discount', 'LastAuthenticationToken', 'Avatar'
    ];

    public function findByLogin(string $login): ?User {
        $builder = $this->builder($this->table);
        $response = $builder->where('Login', $login)
            ->select('Users.Id, Users.Login, Users.HashedPassword, Users.Email, Users.Discount, Users.Avatar, Users.LastAuthenticationToken, Roles.Name as RoleName')
            ->join('Roles', 'Roles.Id = Users.RoleId')
            ->get();

        $result = $response->getNumRows() < 1 ? null : User::parseFromArray($response->getRowArray());
        $response->freeResult();
        return $result;
    }

    public function updateAuthenticationTokenByLogin(string $login, string $newAuthenticationToken): bool {
        $builder = $this->builder($this->table);
        return $builder
            ->where('Login', $login)
            ->update(['LastAuthenticationToken' => $newAuthenticationToken]);
    }

    /***
     * @return User[]
     */
    public function findAll(int $limit = 0, int $offset = 0): array
    {
        $builder = $this->builder($this->table);
        $query = $builder->select('Users.Id, Users.Login, Users.HashedPassword, Users.Email, Users.Discount, Users.Avatar, Users.LastAuthenticationToken, Roles.Name as RoleName')
            ->join('Roles', 'Roles.Id = Users.RoleId');

        if ($limit > 0)
            $query = $query->limit($limit);

        if ($offset > 0)
            $query = $query->offset($offset);

        $response = $query->get();
        $users = [];
        foreach ($response->getResultArray() as $row)
            $users[] = User::parseFromArray($row);

        $response->freeResult();
        return $users;
    }

}
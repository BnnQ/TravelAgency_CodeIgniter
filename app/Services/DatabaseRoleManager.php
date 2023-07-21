<?php

namespace Services;

use Models\Entities\Role;
use Models\Entities\User;
use Models\RoleModel;
use Services\Abstractions\IRoleManager;

class DatabaseRoleManager implements IRoleManager
{
    private readonly RoleModel $context;
    public function __construct()
    {
        $this->context = model('Models\RoleModel');
    }

    public function getRoleByName(string $name): Role
    {
        return $this->context->findByName($name);
    }

    public function getRoleById(int $id): Role
    {
        return $this->context->find($id);
    }

    public function getUsersWithRole(string $roleName): array
    {
        return $this->context->findUsersWithRole($roleName);
    }

    public function addRole(Role $role): void
    {
        $this->context->insert(['Name' => $role->name]);
    }

    public function isUserInRole(User $user, string $roleName): bool
    {
        $users = $this->getUsersWithRole($roleName);
        return in_array($user->id, array_column($users, 'id'));
    }

    public function changeUserRole(User $user, Role $role): void
    {
        $userContext = model('Models\UserModel');
        $userContext->update($user->id, ['RoleId' => $role->id]);
    }

    public function deleteRole(int $roleId): void
    {
        $this->context->delete($roleId);
    }

}
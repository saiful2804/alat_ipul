<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Classroom;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassroomPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Classroom');
    }

    public function view(AuthUser $authUser, Classroom $classroom): bool
    {
        return $authUser->can('View:Classroom');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Classroom');
    }

    public function update(AuthUser $authUser, Classroom $classroom): bool
    {
        return $authUser->can('Update:Classroom');
    }

    public function delete(AuthUser $authUser, Classroom $classroom): bool
    {
        return $authUser->can('Delete:Classroom');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Classroom');
    }

    public function restore(AuthUser $authUser, Classroom $classroom): bool
    {
        return $authUser->can('Restore:Classroom');
    }

    public function forceDelete(AuthUser $authUser, Classroom $classroom): bool
    {
        return $authUser->can('ForceDelete:Classroom');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Classroom');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Classroom');
    }

    public function replicate(AuthUser $authUser, Classroom $classroom): bool
    {
        return $authUser->can('Replicate:Classroom');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Classroom');
    }

}
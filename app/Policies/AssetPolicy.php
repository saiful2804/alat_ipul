<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Asset;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Asset');
    }

    public function view(AuthUser $authUser, Asset $asset): bool
    {
        return $authUser->can('View:Asset');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Asset');
    }

    public function update(AuthUser $authUser, Asset $asset): bool
    {
        return $authUser->can('Update:Asset');
    }

    public function delete(AuthUser $authUser, Asset $asset): bool
    {
        return $authUser->can('Delete:Asset');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Asset');
    }

    public function restore(AuthUser $authUser, Asset $asset): bool
    {
        return $authUser->can('Restore:Asset');
    }

    public function forceDelete(AuthUser $authUser, Asset $asset): bool
    {
        return $authUser->can('ForceDelete:Asset');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Asset');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Asset');
    }

    public function replicate(AuthUser $authUser, Asset $asset): bool
    {
        return $authUser->can('Replicate:Asset');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Asset');
    }

}
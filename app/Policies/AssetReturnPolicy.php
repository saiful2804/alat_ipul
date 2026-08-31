<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AssetReturn;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetReturnPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AssetReturn');
    }

    public function view(AuthUser $authUser, AssetReturn $assetReturn): bool
    {
        return $authUser->can('View:AssetReturn');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AssetReturn');
    }

    public function update(AuthUser $authUser, AssetReturn $assetReturn): bool
    {
        return $authUser->can('Update:AssetReturn');
    }

    public function delete(AuthUser $authUser, AssetReturn $assetReturn): bool
    {
        return $authUser->can('Delete:AssetReturn');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:AssetReturn');
    }

    public function restore(AuthUser $authUser, AssetReturn $assetReturn): bool
    {
        return $authUser->can('Restore:AssetReturn');
    }

    public function forceDelete(AuthUser $authUser, AssetReturn $assetReturn): bool
    {
        return $authUser->can('ForceDelete:AssetReturn');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AssetReturn');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AssetReturn');
    }

    public function replicate(AuthUser $authUser, AssetReturn $assetReturn): bool
    {
        return $authUser->can('Replicate:AssetReturn');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AssetReturn');
    }

}
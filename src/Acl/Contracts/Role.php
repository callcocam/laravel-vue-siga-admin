<?php

namespace SIGA\Acl\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface Role
{
    /**
     * Roles can belong to many users.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany;

    public function hasPermissionFlags(): bool;
    public function hasPermissionThroughFlag(): bool;
}

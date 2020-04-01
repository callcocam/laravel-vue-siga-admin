<?php

namespace SIGA\Acl\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface Permission
{
    /**
     * Permissions can belong to many roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany;
}

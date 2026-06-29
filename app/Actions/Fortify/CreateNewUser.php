<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * When a new user registers, we automatically provision a Tenant (school)
     * for them using their name as the school name. The tenant_id is then
     * assigned to the user so all multi-tenant queries work immediately.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ])->validate();

        return DB::transaction(function () use ($input): User {
            // Provision a new school/tenant for this registering user.
            $tenant = Tenant::create([
                'school_name' => $input['name'] . "'s School",
                'address'     => null,
            ]);

            return User::create([
                'name'      => $input['name'],
                'email'     => $input['email'],
                'password'  => $input['password'],
                'tenant_id' => $tenant->tenant_id,
            ]);
        });
    }
}

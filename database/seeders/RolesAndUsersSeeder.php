<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\User;
use App\Models\Domain;
use App\Models\Address;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // Creazione dei ruoli
        $roles = ['superadmin', 'admin', 'user'];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // Creazione del superadmin
        $superAdmin = User::create([
            'name' => 'Super',
            'family_name' => 'Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
            'phone_number' => fake()->phoneNumber,
            'birthday' => fake()->date('Y-m-d', '2000-01-01'),
        ]);
        $superAdmin->assignRole('superadmin');

        // Creazione degli admin
        for ($i = 1; $i <= 3; $i++) {
            $admin = User::create([
                'name' => "Admin",
                'family_name' => "User $i",
                'email' => "admin$i@example.com",
                'password' => bcrypt('password'),
                'phone_number' => fake()->phoneNumber,
                'birthday' => fake()->date('Y-m-d', '2000-01-01'),
            ]);
            $admin->assignRole('admin');
        }

        // Creazione degli utenti
        for ($i = 1; $i <= 20; $i++) {
            $isCompany = rand(0, 1) === 1;
            $userType = $isCompany ? 'company' : 'individual';

            $user = $userType === 'individual' ? User::create([
                'name' => fake()->firstName,
                'family_name' => fake()->lastName,
                'email' => "user$i@example.com",
                'password' => bCrypt('password'),
                'phone_number' => fake()->phoneNumber,
                'birthday' => fake()->date('Y-m-d', '2000-01-01'),
            ]) : User::create([
                            'company_name' => fake()->company,
                            'email' => "company$i@example.com",
                            'password' => bCrypt('password'),
                            'phone_number' => fake()->phoneNumber,
                            'birthday' => fake()->date('Y-m-d', '2000-01-01'),
                        ]);

            $user->assignRole('user');

            // Add registration address
            $address = Address::create([
                'street' => fake()->streetAddress,
                'city' => fake()->city,
                'province' => fake()->state,
                'postal_code' => fake()->postcode,
                'country' => fake()->country,
            ]);

            $user->update(['address_id' => $address->id]);

            // Create a billing address if necessary
            $billingAddress = $address;
            if (rand(0, 1)) {
                $billingAddress = Address::create([
                    'street' => fake()->streetAddress,
                    'city' => fake()->city,
                    'province' => fake()->state,
                    'postal_code' => fake()->postcode,
                    'country' => fake()->country,
                ]);
            }

            // Add user details
            $type = $i % 2 == 0 ? 'company' : 'individual';
            $fiscal_code = $type == 'individual' ? fake()->phoneNumber() : null;
            $vat_number = $type == 'company' ? 'IT' . str_pad(fake()->numberBetween(1, 99999999999), 11, '0', STR_PAD_LEFT) : null;

            UserDetail::create([
                'user_id' => $user->id,
                'type' => $type,
                'fiscal_code' => $fiscal_code,
                'vat_number' => $vat_number,
                'billing_address_id' => $billingAddress->id,
            ]);

            // Assign 1 to 5 domains per user
            $numDomains = rand(1, 5);
            for ($j = 1; $j <= $numDomains; $j++) {
                $domain = Domain::create([
                    'user_id' => $user->id,
                    'url' => fake()->domainName,
                ]);

                // Assign 1 to 3 links per domain
                $numLinks = rand(1, 3);
                for ($k = 1; $k <= $numLinks; $k++) {
                    Link::create([
                        'domain_id' => $domain->id,
                        'user_id' => $user->id,
                        'url' => fake()->url,
                        'is_active' => (bool) rand(0, 1),
                        'is_follow' => (bool) rand(0, 1),
                        'http_status' => rand(200, 500),
                        'anchor_text' => fake()->sentence(3),
                        'link_position' => 'main',
                        'points_to_correct_domain' => (bool) rand(0, 1),
                    ]);
                }
            }
        }
    }
}



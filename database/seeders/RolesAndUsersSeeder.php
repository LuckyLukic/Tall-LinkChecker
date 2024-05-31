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
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
            'phone_number' => fake()->phoneNumber,
            'birthday' => fake()->date('Y-m-d', '2000-01-01'),
        ]);
        $superAdmin->assignRole('superadmin');

        // Creazione degli admin
        for ($i = 1; $i <= 3; $i++) {
            $admin = User::create([
                'name' => "Admin User $i",
                'email' => "admin$i@example.com",
                'password' => bcrypt('password'),
                'phone_number' => fake()->phoneNumber,
                'birthday' => fake()->date('Y-m-d', '2000-01-01'),
            ]);
            $admin->assignRole('admin');
        }

        // Creazione degli utenti
        for ($i = 1; $i <= 20; $i++) {
            $user = User::create([
                'name' => "User $i",
                'email' => "user$i@example.com",
                'password' => bcrypt('password'),
                'phone_number' => fake()->phoneNumber,
                'birthday' => fake()->date('Y-m-d', '2000-01-01'),
            ]);
            $user->assignRole('user');

            // Aggiungi indirizzo di registrazione
            $address = Address::create([
                'street' => fake()->streetAddress,
                'city' => fake()->city,
                'province' => fake()->state,
                'postal_code' => fake()->postcode,
                'country' => fake()->country,
            ]);

            $user->update(['address_id' => $address->id]);

            // Creare un secondo indirizzo se necessario
            $billingAddress = null;
            if (rand(0, 1)) { // 50% probabilità di avere un indirizzo di fatturazione diverso
                $billingAddress = Address::create([
                    'street' => fake()->streetAddress,
                    'city' => fake()->city,
                    'province' => fake()->state,
                    'postal_code' => fake()->postcode,
                    'country' => fake()->country,
                ]);
            } else {
                $billingAddress = $address;
            }

            // Aggiungi dettagli utente
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

            // Assegna da 1 a 5 domini per ogni utente
            $numDomains = rand(1, 5);
            for ($j = 1; $j <= $numDomains; $j++) {
                $domain = Domain::create([
                    'user_id' => $user->id,
                    'url' => fake()->domainName,
                ]);

                // Assegna da 1 a 3 link per ogni dominio
                $numLinks = rand(1, 3);
                for ($k = 1; $k <= $numLinks; $k++) {
                    Link::create([
                        'domain_id' => $domain->id,
                        'user_id' => $user->id, // Ensure user_id is set
                        'url' => fake()->url,
                        'is_active' => (bool) rand(0, 1),
                        'is_follow' => (bool) rand(0, 1),
                        'http_status' => rand(200, 500), // Random HTTP status
                        'anchor_text' => fake()->sentence(3), // Random anchor text
                        'link_position' => 'main', // Placeholder for position
                        'points_to_correct_domain' => (bool) rand(0, 1), // Random domain check
                    ]);
                }
            }
        }
    }

}



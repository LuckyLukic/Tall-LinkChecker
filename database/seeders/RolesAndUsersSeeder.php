<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\User;
use App\Models\Domain;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'superadmin',
            'admin',
            'user'
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // Creazione del superadmin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
        ]);
        $superAdmin->assignRole('superadmin');

        // Creazione degli admin
        for ($i = 1; $i <= 3; $i++) {
            $admin = User::create([
                'name' => "Admin User $i",
                'email' => "admin$i@example.com",
                'password' => bcrypt('password'),
            ]);
            $admin->assignRole('admin');
        }

        // Creazione degli utenti
        for ($i = 1; $i <= 20; $i++) {
            $user = User::create([
                'name' => "User $i",
                'email' => "user$i@example.com",
                'password' => bcrypt('password'),
            ]);
            $user->assignRole('user');

            // Assegna da 1 a 5 domini per ogni utente
            $numDomains = rand(1, 5);
            for ($j = 1; $j <= $numDomains; $j++) {
                $domain = Domain::create([
                    'user_id' => $user->id,
                    'url' => "user{$i}-domain{$j}.com",
                ]);

                // Assegna da 1 a 3 link per ogni dominio
                $numLinks = rand(1, 3);
                for ($k = 1; $k <= $numLinks; $k++) {
                    Link::create([
                        'domain_id' => $domain->id,
                        'user_id' => $user->id, // Ensure user_id is set
                        'url' => "http://external-site{$k}.com/link-to-user{$i}-domain{$j}",
                        'is_active' => (bool) rand(0, 1),
                        'is_follow' => (bool) rand(0, 1),
                        'http_status' => rand(200, 500), // Random HTTP status
                        'anchor_text' => "Link to user{$i} domain{$j}", // Random anchor text
                        'link_position' => 'main', // Placeholder for position
                        'points_to_correct_domain' => (bool) rand(0, 1), // Random domain check
                    ]);
                }
            }
        }
    }

}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Dokter;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678') // Encrypt password
        ])->assignRole('admin');

        // Create user (evan)
        $evan = User::create([
            'name' => 'evan',
            'email' => 'evan@gmail.com',
            'password' => bcrypt('12345678') // Encrypt password
        ])->assignRole('user');

        // Create another user (john)
        $john = User::create([
            'name' => 'john',
            'email' => 'john@gmail.com',
            'password' => bcrypt('12345678') // Encrypt password
        ])->assignRole('user');

        // Create doctor user (dokter)
        $dokterUser = User::create([
            'name' => 'dokter',
            'email' => 'dokter@gmail.com',
            'password' => bcrypt('12345678'),
            'spesialis' => 'ahlibedah'
        ])->assignRole('dokter');

        // Create pasien for evan
        Pasien::create([
            'user_id' => $evan->id,
            'nama' => 'Evan Pasien',
            'alamat' => 'Alamat Evan',
            'no_hp' => '08123456789',
            'tanggal_lahir' => '1990-01-01',
        ]);

        // Create pasien for john
        Pasien::create([
            'user_id' => $john->id,
            'nama' => 'John Pasien',
            'alamat' => 'Alamat John',
            'no_hp' => '08223456789',
            'tanggal_lahir' => '1985-05-15',
        ]);

        // Create dokter for dokterUser
        Dokter::create([
            'user_id' => $dokterUser->id,
            'nama' => 'Dr. Dokter',
            'spesialis' => 'Ahli Bedah',
            'no_hp' => '08987654321',
            'image' => null, // Or provide a default image path if needed
        ]);
    }
}


// v2
// <?php

// namespace Database\Seeders;

// use App\Models\Dokter;
// use App\Models\Pasien;
// use App\Models\User;
// use App\Models\Kunjungan;
// use Illuminate\Database\Seeder;

// class UserSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         // Create admin user
//         $admin = User::create([
//             'name' => 'admin',
//             'email' => 'admin@gmail.com',
//             'password' => bcrypt('12345678')  // Encrypt password
//         ])->assignRole('admin');

//         // Create regular users
//         $users = [
//             ['name' => 'evan', 'email' => 'evan@gmail.com'],
//             ['name' => 'john', 'email' => 'john@gmail.com'],
//             ['name' => 'lisa', 'email' => 'lisa@gmail.com'],
//             ['name' => 'mike', 'email' => 'mike@gmail.com'],
//             ['name' => 'sarah', 'email' => 'sarah@gmail.com']
//         ];

//         foreach ($users as $userData) {
//             User::create([
//                 'name' => $userData['name'],
//                 'email' => $userData['email'],
//                 'password' => bcrypt('12345678')
//             ])->assignRole('user');
//         }

//         // Create doctor users first
//         $doctors = [
//             ['name' => 'Dr. Ahli Bedah', 'spesialis' => 'Ahli Bedah', 'no_hp' => '08987654321'],
//             ['name' => 'Dr. Gigi', 'spesialis' => 'Ahli Gigi', 'no_hp' => '08987654322'],
//             ['name' => 'Dr. Jantung', 'spesialis' => 'Ahli Jantung', 'no_hp' => '08987654323'],
//             ['name' => 'Dr. Mata', 'spesialis' => 'Ahli Mata', 'no_hp' => '08987654324'],
//             ['name' => 'Dr. THT', 'spesialis' => 'Ahli THT', 'no_hp' => '08987654325']
//         ];

//         foreach ($doctors as $doctorData) {
//             // Buat user untuk dokter
//             $user = User::create([
//                 'name' => $doctorData['name'],
//                 'email' => strtolower(str_replace(' ', '', $doctorData['name'])) . '@gmail.com',
//                 'password' => bcrypt('12345678')
//             ])->assignRole('dokter');

//             // Buat dokter dengan user_id yang sesuai
//             Dokter::create([
//                 'nama' => $doctorData['name'],
//                 'spesialis' => $doctorData['spesialis'],
//                 'no_hp' => $doctorData['no_hp'],
//                 'user_id' => $user->id  // Pastikan user_id ada
//             ]);
//         }

//         $pasiens = [
//             ['user_id' => 1, 'nama' => 'Evan Pasien', 'alamat' => 'Alamat Evan', 'no_hp' => '08123456789', 'tanggal_lahir' => '1990-01-01'],
//             ['user_id' => 2, 'nama' => 'John Pasien', 'alamat' => 'Alamat John', 'no_hp' => '08223456789', 'tanggal_lahir' => '1985-05-15'],
//             ['user_id' => 3, 'nama' => 'Lisa Pasien', 'alamat' => 'Alamat Lisa', 'no_hp' => '08323456789', 'tanggal_lahir' => '1992-11-30'],
//             ['user_id' => 4, 'nama' => 'Mike Pasien', 'alamat' => 'Alamat Mike', 'no_hp' => '08423456789', 'tanggal_lahir' => '1988-08-22'],
//             ['user_id' => 5, 'nama' => 'Sarah Pasien', 'alamat' => 'Alamat Sarah', 'no_hp' => '08523456789', 'tanggal_lahir' => '1993-02-14']
//         ];

//         foreach ($pasiens as $pasienData) {
//             Pasien::create($pasienData);
//         }

//         $kunjungans = [
//             ['user_id' => 1, 'pasien_id' => 1, 'dokter_id' => 1, 'keluhan' => 'Sakit kepala', 'tanggal_kunjungan' => '2025-02-21'],
//             ['user_id' => 2, 'pasien_id' => 2, 'dokter_id' => 2, 'keluhan' => 'Gigi sakit', 'tanggal_kunjungan' => '2025-02-22'],
//             ['user_id' => 3, 'pasien_id' => 3, 'dokter_id' => 3, 'keluhan' => 'Nyeri dada', 'tanggal_kunjungan' => '2025-02-23'],
//             ['user_id' => 4, 'pasien_id' => 4, 'dokter_id' => 4, 'keluhan' => 'Mata merah', 'tanggal_kunjungan' => '2025-02-24'],
//             ['user_id' => 5, 'pasien_id' => 5, 'dokter_id' => 5, 'keluhan' => 'Telinga berdenging', 'tanggal_kunjungan' => '2025-02-25']
//         ];

//         foreach ($kunjungans as $kunjunganData) {
//             Kunjungan::create($kunjunganData);
//         }
//     }
// }


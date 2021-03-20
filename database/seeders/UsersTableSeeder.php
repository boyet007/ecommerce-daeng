<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           //SIMPAN DATA KE TABLE users MELALUI MODEL USER
        //DENGAN DATA YANG ADA DIDALAM ARRAY DIBAWAH
        //BCRYPT DIGUNAKAN UNTUK MEN-ENKRIPSI SEBUAH STRING
        //KARENA PASSWORD HARUS DISIMPAN DALAM KEADAAN TER-ENKRIPSI
        User::create([
            'name' => 'Admin Daengweb',
            'email' => 'admin@daengweb.id',
            'password' => bcrypt('secret')
        ]);
    }
}

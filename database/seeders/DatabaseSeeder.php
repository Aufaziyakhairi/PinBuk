<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin Perpustakaan',
            'email' => 'admin@perpustakaan.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        // Create regular users
        User::factory()->count(5)->create([
            'role' => 'user',
        ]);

        // Create sample books
        Book::create([
            'title' => 'Laskar Pelangi',
            'author' => 'Andrea Hirata',
            'isbn' => '978-9793947783',
            'description' => 'Novel fiksi tentang kehidupan siswa sekolah di Belitung',
            'publisher' => 'Bentang Pustaka',
            'publication_year' => 2005,
            'quantity' => 5,
            'available_quantity' => 5,
            'category' => 'Fiksi',
            'location' => 'Rak A1',
            'status' => 'ready',
        ]);

        Book::create([
            'title' => 'Negeri 5 Menara',
            'author' => 'Ahmad Fuadi',
            'isbn' => '978-9790633479',
            'description' => 'Novel tentang perjuangan dan persahabatan di pesantren',
            'publisher' => 'Gramedia Pustaka Utama',
            'publication_year' => 2009,
            'quantity' => 3,
            'available_quantity' => 3,
            'category' => 'Fiksi',
            'location' => 'Rak A2',
            'status' => 'ready',
        ]);

        Book::create([
            'title' => 'Si Anak Badai',
            'author' => 'Tere Liye',
            'isbn' => '978-9793947677',
            'description' => 'Novel petualangan yang menginspirasi',
            'publisher' => 'Gramedia',
            'publication_year' => 2013,
            'quantity' => 4,
            'available_quantity' => 4,
            'category' => 'Fiksi',
            'location' => 'Rak B1',
            'status' => 'ready',
        ]);

        Book::create([
            'title' => 'Fundamental Algoritma dan Pemrograman',
            'author' => 'Budi Sutrisno',
            'isbn' => '978-9796880020',
            'description' => 'Buku teknis tentang algoritma dan pemrograman',
            'publisher' => 'Andi Offset',
            'publication_year' => 2018,
            'quantity' => 2,
            'available_quantity' => 2,
            'category' => 'Teknik',
            'location' => 'Rak C1',
            'status' => 'ready',
        ]);

        Book::create([
            'title' => 'Habis Gelap Terbitlah Terang',
            'author' => 'R.A. Kartini',
            'isbn' => '978-6020495768',
            'description' => 'Kumpulan surat-surat R.A. Kartini yang menginspirasi',
            'publisher' => 'Balai Pustaka',
            'publication_year' => 2012,
            'quantity' => 3,
            'available_quantity' => 3,
            'category' => 'Biografi',
            'location' => 'Rak D1',
            'status' => 'ready',
        ]);
    }
}


<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ============ CREATE USERS ============
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin Perpustakaan',
            'email' => 'admin@perpustakaan.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        // Create regular users
        $users = User::factory()->count(15)->create([
            'role' => 'user',
        ]);

        // ============ CREATE BOOKS ============
        $books = [
            // Fiksi Nasional
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'isbn' => '978-9793947783',
                'description' => 'Novel fiksi tentang kehidupan siswa sekolah di Belitung',
                'publisher' => 'Bentang Pustaka',
                'publication_year' => 2005,
                'quantity' => 8,
                'category' => 'Fiksi Nasional',
                'location' => 'Rak A1',
            ],
            [
                'title' => 'Negeri 5 Menara',
                'author' => 'Ahmad Fuadi',
                'isbn' => '978-9790633479',
                'description' => 'Novel tentang perjuangan dan persahabatan di pesantren',
                'publisher' => 'Gramedia Pustaka Utama',
                'publication_year' => 2009,
                'quantity' => 6,
                'category' => 'Fiksi Nasional',
                'location' => 'Rak A2',
            ],
            [
                'title' => 'Si Anak Badai',
                'author' => 'Tere Liye',
                'isbn' => '978-9793947677',
                'description' => 'Novel petualangan yang menginspirasi',
                'publisher' => 'Gramedia',
                'publication_year' => 2013,
                'quantity' => 7,
                'category' => 'Fiksi Nasional',
                'location' => 'Rak A3',
            ],
            [
                'title' => 'Saya Ingin Mencintai Mu dengan Sederhana',
                'author' => 'Iwan Setyawan',
                'isbn' => '978-6020495649',
                'description' => 'Kumpulan cerpen tentang cinta dan kehidupan',
                'publisher' => 'Haru',
                'publication_year' => 2012,
                'quantity' => 5,
                'category' => 'Fiksi Nasional',
                'location' => 'Rak A4',
            ],
            [
                'title' => 'Entrok',
                'author' => 'Perempuan Penulis',
                'isbn' => '978-9791007777',
                'description' => 'Novel tentang kehidupan perempuan Jawa',
                'publisher' => 'Gramedia',
                'publication_year' => 2012,
                'quantity' => 4,
                'category' => 'Fiksi Nasional',
                'location' => 'Rak A5',
            ],

            // Fiksi Internasional
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'isbn' => '978-0143039982',
                'description' => 'Klasik literatur Amerika tentang cinta dan ambisi',
                'publisher' => 'Penguin Classics',
                'publication_year' => 1925,
                'quantity' => 6,
                'category' => 'Fiksi Internasional',
                'location' => 'Rak B1',
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'isbn' => '978-0061120084',
                'description' => 'Novel tentang keadilan dan perlindungan',
                'publisher' => 'HarperCollins',
                'publication_year' => 1960,
                'quantity' => 5,
                'category' => 'Fiksi Internasional',
                'location' => 'Rak B2',
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'isbn' => '978-0451524935',
                'description' => 'Distopia tentang pemerintahan totaliter',
                'publisher' => 'Signet Classics',
                'publication_year' => 1949,
                'quantity' => 4,
                'category' => 'Fiksi Internasional',
                'location' => 'Rak B3',
            ],
            [
                'title' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'isbn' => '978-0141439518',
                'description' => 'Roman klasik tentang cinta dan masyarakat',
                'publisher' => 'Penguin Classics',
                'publication_year' => 1913,
                'quantity' => 5,
                'category' => 'Fiksi Internasional',
                'location' => 'Rak B4',
            ],

            // Non-Fiksi Bisnis & Pengembangan Diri
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'isbn' => '978-0735211292',
                'description' => 'Panduan membangun kebiasaan yang efektif',
                'publisher' => 'Avery',
                'publication_year' => 2018,
                'quantity' => 7,
                'category' => 'Pengembangan Diri',
                'location' => 'Rak C1',
            ],
            [
                'title' => 'Think and Grow Rich',
                'author' => 'Napoleon Hill',
                'isbn' => '978-1585424337',
                'description' => 'Kunci kesuksesan dalam hidup dan bisnis',
                'publisher' => 'Dover Publications',
                'publication_year' => 1937,
                'quantity' => 5,
                'category' => 'Pengembangan Diri',
                'location' => 'Rak C2',
            ],
            [
                'title' => 'The Lean Startup',
                'author' => 'Eric Ries',
                'isbn' => '978-0307887894',
                'description' => 'Metodologi untuk membangun startup yang sukses',
                'publisher' => 'Crown Business',
                'publication_year' => 2011,
                'quantity' => 4,
                'category' => 'Bisnis',
                'location' => 'Rak C3',
            ],
            [
                'title' => 'Good to Great',
                'author' => 'Jim Collins',
                'isbn' => '978-0066620992',
                'description' => 'Mengubah perusahaan dari baik menjadi luar biasa',
                'publisher' => 'HarperBusiness',
                'publication_year' => 2001,
                'quantity' => 3,
                'category' => 'Bisnis',
                'location' => 'Rak C4',
            ],

            // Teknologi & Pemrograman
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'isbn' => '978-0132350884',
                'description' => 'Panduan menulis kode yang bersih dan profesional',
                'publisher' => 'Prentice Hall',
                'publication_year' => 2008,
                'quantity' => 5,
                'category' => 'Teknologi',
                'location' => 'Rak D1',
            ],
            [
                'title' => 'The Pragmatic Programmer',
                'author' => 'David Thomas & Andrew Hunt',
                'isbn' => '978-0135957059',
                'description' => 'Panduan praktis untuk programmer profesional',
                'publisher' => 'Addison-Wesley',
                'publication_year' => 2019,
                'quantity' => 4,
                'category' => 'Teknologi',
                'location' => 'Rak D2',
            ],
            [
                'title' => 'Design Patterns',
                'author' => 'Gang of Four',
                'isbn' => '978-0201633610',
                'description' => 'Elemen yang dapat digunakan kembali dari desain OO',
                'publisher' => 'Addison-Wesley',
                'publication_year' => 1994,
                'quantity' => 3,
                'category' => 'Teknologi',
                'location' => 'Rak D3',
            ],
            [
                'title' => 'Fundamental Algoritma dan Pemrograman',
                'author' => 'Budi Sutrisno',
                'isbn' => '978-9796880020',
                'description' => 'Buku teknis tentang algoritma dan pemrograman',
                'publisher' => 'Andi Offset',
                'publication_year' => 2018,
                'quantity' => 6,
                'category' => 'Teknologi',
                'location' => 'Rak D4',
            ],

            // Sains & Alam
            [
                'title' => 'Sapiens',
                'author' => 'Yuval Noah Harari',
                'isbn' => '978-0062316097',
                'description' => 'Sejarah singkat umat manusia dari Zaman Batu hingga zaman modern',
                'publisher' => 'Harper',
                'publication_year' => 2014,
                'quantity' => 6,
                'category' => 'Sains & Sejarah',
                'location' => 'Rak E1',
            ],
            [
                'title' => 'Cosmos',
                'author' => 'Carl Sagan',
                'isbn' => '978-0394504988',
                'description' => 'Perjalanan eksplorasi ruang angkasa dan alam semesta',
                'publisher' => 'Random House',
                'publication_year' => 1980,
                'quantity' => 4,
                'category' => 'Sains & Alam',
                'location' => 'Rak E2',
            ],
            [
                'title' => 'Habis Gelap Terbitlah Terang',
                'author' => 'R.A. Kartini',
                'isbn' => '978-6020495768',
                'description' => 'Kumpulan surat-surat R.A. Kartini yang menginspirasi',
                'publisher' => 'Balai Pustaka',
                'publication_year' => 2012,
                'quantity' => 5,
                'category' => 'Biografi',
                'location' => 'Rak E3',
            ],
            [
                'title' => 'Educated',
                'author' => 'Tara Westover',
                'isbn' => '978-0399590504',
                'description' => 'Biografi tentang pendidikan dan pembebasan diri',
                'publisher' => 'Random House',
                'publication_year' => 2018,
                'quantity' => 5,
                'category' => 'Biografi',
                'location' => 'Rak E4',
            ],

            // Anak-anak & Remaja
            [
                'title' => 'Sherlock Holmes: A Scandal in Bohemia',
                'author' => 'Arthur Conan Doyle',
                'isbn' => '978-0486474649',
                'description' => 'Petualangan detektif terkenal Sherlock Holmes',
                'publisher' => 'Dover Publications',
                'publication_year' => 1902,
                'quantity' => 4,
                'category' => 'Misteri',
                'location' => 'Rak F1',
            ],
            [
                'title' => 'Harry Potter and the Philosopher\'s Stone',
                'author' => 'J.K. Rowling',
                'isbn' => '978-0747532699',
                'description' => 'Petualangan penyihir muda Harry Potter',
                'publisher' => 'Bloomsbury',
                'publication_year' => 1997,
                'quantity' => 7,
                'category' => 'Fantasi',
                'location' => 'Rak F2',
            ],
            [
                'title' => 'The Lord of the Rings',
                'author' => 'J.R.R. Tolkien',
                'isbn' => '978-0544003415',
                'description' => 'Epos fantasi tentang perjalanan menyelamatkan dunia',
                'publisher' => 'Houghton Mifflin Harcourt',
                'publication_year' => 1954,
                'quantity' => 5,
                'category' => 'Fantasi',
                'location' => 'Rak F3',
            ],

            // Hobi & Seni
            [
                'title' => 'The Art of War',
                'author' => 'Sun Tzu',
                'isbn' => '978-0140455778',
                'description' => 'Filosofi strategi militer klasik China',
                'publisher' => 'Penguin Classics',
                'publication_year' => 1901,
                'quantity' => 4,
                'category' => 'Filsafat',
                'location' => 'Rak G1',
            ],
            [
                'title' => 'The Ultimate Hitchhiker\'s Guide',
                'author' => 'Douglas Adams',
                'isbn' => '978-0517226957',
                'description' => 'Petualangan lucu di galaksi dengan humor absurd',
                'publisher' => 'Wings Books',
                'publication_year' => 1979,
                'quantity' => 6,
                'category' => 'Komedi',
                'location' => 'Rak G2',
            ],
        ];

        // Simpan semua buku
        foreach ($books as $book) {
            $bookData = $book;
            $bookData['available_quantity'] = $bookData['quantity'];
            $bookData['status'] = 'ready';
            Book::create($bookData);
        }

        $allBooks = Book::all();
        $allUsers = $users->all();

        // ============ CREATE BORROWINGS ============
        // Create various borrowing records
        $borrowingStatuses = ['pending', 'approved', 'returned', 'rejected'];
        
        for ($i = 0; $i < 45; $i++) {
            $status = $borrowingStatuses[array_rand($borrowingStatuses)];
            $user = collect($allUsers)->random();
            $book = $allBooks->random();
            
            $borrowedAt = null;
            $dueDate = null;
            $returnedAt = null;
            
            if ($status === 'approved') {
                $borrowedAt = Carbon::now()->subDays(rand(1, 20));
                $dueDate = $borrowedAt->copy()->addDays(7);
            } elseif ($status === 'returned') {
                $borrowedAt = Carbon::now()->subDays(rand(10, 40));
                $dueDate = $borrowedAt->copy()->addDays(7);
                $returnedAt = Carbon::now()->subDays(rand(1, 10));
            } elseif ($status === 'pending') {
                // Pending tidak punya borrowedAt
            }
            
            Borrowing::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'borrowed_at' => $borrowedAt,
                'due_date' => $dueDate,
                'returned_at' => $returnedAt,
                'status' => $status,
            ]);
        }

        // ============ CREATE FINES ============
        // Get borrowings that are overdue or returned late
        $borrowingsForFines = Borrowing::where('status', 'returned')
            ->orWhere('status', 'approved')
            ->limit(20)
            ->get();

        foreach ($borrowingsForFines as $borrowing) {
            if ($borrowing->due_date && ($borrowing->returned_at && $borrowing->returned_at->gt($borrowing->due_date) || !$borrowing->returned_at)) {
                $daysLate = 0;
                if ($borrowing->returned_at) {
                    $daysLate = $borrowing->due_date->diffInDays($borrowing->returned_at);
                } else {
                    $daysLate = $borrowing->due_date->diffInDays(now());
                }
                
                if ($daysLate > 0) {
                    $fineAmount = $daysLate * 5000; // Rp 5000 per hari
                    $isPaid = rand(0, 1) ? true : false;
                    
                    Fine::create([
                        'user_id' => $borrowing->user_id,
                        'borrowing_id' => $borrowing->id,
                        'description' => "Denda keterlambatan peminjaman: " . $daysLate . " hari x Rp5.000 = Rp" . number_format($fineAmount, 0, ',', '.'),
                        'status' => $isPaid ? 'paid' : 'unpaid',
                    ]);
                }
            }
        }
    }
}


<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed data awal aplikasi BookStore:
     * - 1 akun Admin
     * - 2 akun User
     * - 6 Kategori buku
     * - 18 Data buku sample
     */
    public function run(): void
    {
        // ─── Akun Admin ───────────────────────────────────────────────
        User::create([
            'name'     => 'Admin BookStore',
            'email'    => 'admin@bookstore.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '081234567890',
            'address'  => 'Jl. Buku Raya No. 1, Jakarta Pusat',
        ]);

        // ─── Akun User Sample ─────────────────────────────────────────
        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@example.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'phone'    => '082345678901',
            'address'  => 'Jl. Merdeka No. 5, Bandung',
        ]);

        User::create([
            'name'     => 'Siti Rahma',
            'email'    => 'siti@example.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'phone'    => '083456789012',
            'address'  => 'Jl. Sudirman No. 10, Surabaya',
        ]);

        // ─── Kategori Buku ────────────────────────────────────────────
        $categories = [
            ['name' => 'Novel', 'description' => 'Karya fiksi panjang berbentuk prosa'],
            ['name' => 'Teknologi', 'description' => 'Buku seputar teknologi, pemrograman, dan IT'],
            ['name' => 'Bisnis', 'description' => 'Buku pengembangan bisnis dan wirausaha'],
            ['name' => 'Pendidikan', 'description' => 'Buku pelajaran dan referensi akademik'],
            ['name' => 'Self-Help', 'description' => 'Buku pengembangan diri dan motivasi'],
            ['name' => 'Sains', 'description' => 'Buku ilmu pengetahuan alam dan sains populer'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // ─── Data Buku Sample ─────────────────────────────────────────
        $books = [
            // Novel
            ['category' => 'Novel', 'title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'publisher' => 'Bentang Pustaka', 'year' => 2005, 'price' => 85000, 'stock' => 25, 'description' => 'Kisah perjuangan anak-anak Belitung dalam menggapai cita-cita.', 'isbn' => '978-979-9101-75-7'],
            ['category' => 'Novel', 'title' => 'Bumi Manusia', 'author' => 'Pramoedya Ananta Toer', 'publisher' => 'Lentera Dipantara', 'year' => 1980, 'price' => 95000, 'stock' => 20, 'description' => 'Kisah cinta dan perjuangan Minke di era kolonial Belanda.', 'isbn' => '978-979-9120-55-5'],
            ['category' => 'Novel', 'title' => 'Dilan: Dia adalah Dilanku tahun 1990', 'author' => 'Pidi Baiq', 'publisher' => 'Pastel Books', 'year' => 2014, 'price' => 79000, 'stock' => 30, 'description' => 'Kisah romantis remaja di Bandung tahun 1990.', 'isbn' => '978-602-7294-10-2'],

            // Teknologi
            ['category' => 'Teknologi', 'title' => 'Clean Code', 'author' => 'Robert C. Martin', 'publisher' => 'Prentice Hall', 'year' => 2008, 'price' => 320000, 'stock' => 15, 'description' => 'Panduan menulis kode yang bersih dan mudah dipelihara.', 'isbn' => '978-0-13-235088-4'],
            ['category' => 'Teknologi', 'title' => 'Laravel: Up & Running', 'author' => 'Matt Stauffer', 'publisher' => "O'Reilly Media", 'year' => 2022, 'price' => 280000, 'stock' => 12, 'description' => 'Panduan lengkap mengembangkan aplikasi web dengan Laravel.', 'isbn' => '978-1-4920-9296-7'],
            ['category' => 'Teknologi', 'title' => 'You Don\'t Know JS', 'author' => 'Kyle Simpson', 'publisher' => "O'Reilly Media", 'year' => 2015, 'price' => 210000, 'stock' => 18, 'description' => 'Seri buku mendalam tentang JavaScript.', 'isbn' => '978-1-491-92446-4'],

            // Bisnis
            ['category' => 'Bisnis', 'title' => 'Rich Dad Poor Dad', 'author' => 'Robert T. Kiyosaki', 'publisher' => 'Plata Publishing', 'year' => 1997, 'price' => 115000, 'stock' => 40, 'description' => 'Pelajaran tentang keuangan dari ayah kaya dan ayah miskin.', 'isbn' => '978-1-612-68090-9'],
            ['category' => 'Bisnis', 'title' => 'Zero to One', 'author' => 'Peter Thiel', 'publisher' => 'Crown Business', 'year' => 2014, 'price' => 135000, 'stock' => 22, 'description' => 'Catatan tentang startup dan cara membangun masa depan.', 'isbn' => '978-0-8041-3218-3'],
            ['category' => 'Bisnis', 'title' => 'The Lean Startup', 'author' => 'Eric Ries', 'publisher' => 'Crown Business', 'year' => 2011, 'price' => 125000, 'stock' => 28, 'description' => 'Metodologi untuk membangun bisnis startup yang sukses.', 'isbn' => '978-0-307-88791-7'],

            // Pendidikan
            ['category' => 'Pendidikan', 'title' => 'Matematika Diskrit', 'author' => 'Kenneth H. Rosen', 'publisher' => 'McGraw-Hill', 'year' => 2018, 'price' => 195000, 'stock' => 10, 'description' => 'Buku teks matematika diskrit untuk mahasiswa ilmu komputer.', 'isbn' => '978-0-07-338309-5'],
            ['category' => 'Pendidikan', 'title' => 'Algoritma dan Pemrograman', 'author' => 'Rinaldi Munir', 'publisher' => 'Informatika', 'year' => 2016, 'price' => 145000, 'stock' => 20, 'description' => 'Pengenalan algoritma dan dasar pemrograman komputer.', 'isbn' => '978-602-8741-97-6'],
            ['category' => 'Pendidikan', 'title' => 'Kalkulus Jilid 1', 'author' => 'James Stewart', 'publisher' => 'Cengage Learning', 'year' => 2016, 'price' => 175000, 'stock' => 15, 'description' => 'Buku kalkulus standar untuk mahasiswa sains dan teknik.', 'isbn' => '978-1-285-74062-1'],

            // Self-Help
            ['category' => 'Self-Help', 'title' => 'Atomic Habits', 'author' => 'James Clear', 'publisher' => 'Avery', 'year' => 2018, 'price' => 148000, 'stock' => 50, 'description' => 'Cara membangun kebiasaan baik dan menghilangkan kebiasaan buruk.', 'isbn' => '978-0-7352-1129-2'],
            ['category' => 'Self-Help', 'title' => 'The 7 Habits of Highly Effective People', 'author' => 'Stephen Covey', 'publisher' => 'Free Press', 'year' => 2004, 'price' => 132000, 'stock' => 35, 'description' => '7 kebiasaan orang-orang yang sangat efektif.', 'isbn' => '978-0-7432-6951-0'],
            ['category' => 'Self-Help', 'title' => 'Ikigai', 'author' => 'Héctor García', 'publisher' => 'Penguin Books', 'year' => 2017, 'price' => 98000, 'stock' => 45, 'description' => 'Rahasia orang Jepang untuk hidup panjang dan bahagia.', 'isbn' => '978-0-14-313472-3'],

            // Sains
            ['category' => 'Sains', 'title' => 'A Brief History of Time', 'author' => 'Stephen Hawking', 'publisher' => 'Bantam Books', 'year' => 1998, 'price' => 155000, 'stock' => 18, 'description' => 'Penjelasan alam semesta dari teori Big Bang hingga lubang hitam.', 'isbn' => '978-0-553-38016-3'],
            ['category' => 'Sains', 'title' => 'Sapiens', 'author' => 'Yuval Noah Harari', 'publisher' => 'Harper', 'year' => 2015, 'price' => 178000, 'stock' => 32, 'description' => 'Sejarah singkat umat manusia dari prasejarah hingga era modern.', 'isbn' => '978-0-06-231609-7'],
            ['category' => 'Sains', 'title' => 'The Gene', 'author' => 'Siddhartha Mukherjee', 'publisher' => 'Scribner', 'year' => 2016, 'price' => 188000, 'stock' => 14, 'description' => 'Sejarah intim tentang gen dan ilmu genetika.', 'isbn' => '978-1-476-73352-4'],
        ];

        foreach ($books as $bookData) {
            $categoryName = $bookData['category'];
            unset($bookData['category']);

            $category = Category::where('name', $categoryName)->first();

            Book::create(array_merge($bookData, [
                'category_id' => $category->id,
            ]));
        }
    }
}

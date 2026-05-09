<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ─────────────────────────────────────────────
        // 1. Akun pengguna (password: 'password')
        // ─────────────────────────────────────────────
        $password = Hash::make('password');

        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@nombaca.test',
            'password' => $password,
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Petugas Perpustakaan',
            'email'    => 'petugas@nombaca.test',
            'password' => $password,
            'role'     => 'petugas',
        ]);

        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@nombaca.test',
            'password' => $password,
            'role'     => 'user',
        ]);

        User::create([
            'name'     => 'Siti Nurhaliza',
            'email'    => 'siti@nombaca.test',
            'password' => $password,
            'role'     => 'user',
        ]);

        // ─────────────────────────────────────────────
        // 2. Kategori buku (5 kategori)
        // ─────────────────────────────────────────────
        $categories = collect([
            'Fiksi',
            'Sains & Teknologi',
            'Sejarah',
            'Bisnis & Ekonomi',
            'Pengembangan Diri',
        ])->map(fn (string $name) => Category::create(['name' => $name]));

        // ─────────────────────────────────────────────
        // 3. Buku (20 data dummy)
        // ─────────────────────────────────────────────
        $books = [
            // Fiksi (index 0)
            ['category' => 0, 'title' => 'Laskar Pelangi',              'author' => 'Andrea Hirata',        'isbn' => '9789793062792'],
            ['category' => 0, 'title' => 'Bumi Manusia',                'author' => 'Pramoedya Ananta Toer','isbn' => '9789799731234'],
            ['category' => 0, 'title' => 'Pulang',                      'author' => 'Tere Liye',            'isbn' => '9786020331234'],
            ['category' => 0, 'title' => 'Perahu Kertas',               'author' => 'Dee Lestari',          'isbn' => '9789792231234'],

            // Sains & Teknologi (index 1)
            ['category' => 1, 'title' => 'A Brief History of Time',     'author' => 'Stephen Hawking',      'isbn' => '9780553380163'],
            ['category' => 1, 'title' => 'Sapiens',                     'author' => 'Yuval Noah Harari',    'isbn' => '9780062316097'],
            ['category' => 1, 'title' => 'Clean Code',                  'author' => 'Robert C. Martin',     'isbn' => '9780132350884'],
            ['category' => 1, 'title' => 'The Pragmatic Programmer',    'author' => 'David Thomas',         'isbn' => '9780135957059'],

            // Sejarah (index 2)
            ['category' => 2, 'title' => 'Sejarah Indonesia Modern',    'author' => 'M.C. Ricklefs',        'isbn' => '9789791015851'],
            ['category' => 2, 'title' => 'Guns, Germs, and Steel',      'author' => 'Jared Diamond',        'isbn' => '9780393317558'],
            ['category' => 2, 'title' => 'Nusantara',                   'author' => 'Bernard Vlekke',       'isbn' => '9786024121234'],
            ['category' => 2, 'title' => 'Indonesia Etc.',              'author' => 'Elizabeth Pisani',      'isbn' => '9780393351279'],

            // Bisnis & Ekonomi (index 3)
            ['category' => 3, 'title' => 'Rich Dad Poor Dad',           'author' => 'Robert Kiyosaki',      'isbn' => '9781612680194'],
            ['category' => 3, 'title' => 'The Lean Startup',            'author' => 'Eric Ries',            'isbn' => '9780307887894'],
            ['category' => 3, 'title' => 'Zero to One',                 'author' => 'Peter Thiel',          'isbn' => '9780804139298'],
            ['category' => 3, 'title' => 'Thinking, Fast and Slow',     'author' => 'Daniel Kahneman',      'isbn' => '9780374533557'],

            // Pengembangan Diri (index 4)
            ['category' => 4, 'title' => 'Atomic Habits',               'author' => 'James Clear',          'isbn' => '9780735211292'],
            ['category' => 4, 'title' => 'Mindset',                     'author' => 'Carol S. Dweck',       'isbn' => '9780345472328'],
            ['category' => 4, 'title' => 'The 7 Habits',                'author' => 'Stephen Covey',        'isbn' => '9781982137274'],
            ['category' => 4, 'title' => 'Deep Work',                   'author' => 'Cal Newport',          'isbn' => '9781455586691'],
        ];

        foreach ($books as $book) {
            Book::create([
                'category_id' => $categories[$book['category']]->id,
                'title'       => $book['title'],
                'author'      => $book['author'],
                'isbn'        => $book['isbn'],
                'stock'       => rand(1, 10),
            ]);
        }
    }
}

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
            [
                'category' => 0, 'title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'isbn' => '9789793062792',
                'description' => 'Novel ini menceritakan perjuangan sepuluh anak dari Belitung yang bersekolah di SD Muhammadiyah dengan segala keterbatasannya. Mereka dipimpin oleh guru bernama Bu Muslimah yang penuh semangat dalam mendidik murid-muridnya. Kisah ini menggambarkan persahabatan, mimpi, dan perjuangan untuk mendapatkan pendidikan yang layak. Dengan latar kehidupan masyarakat sederhana, novel ini memberikan pesan tentang pentingnya pendidikan dan semangat pantang menyerah.',
            ],
            [
                'category' => 0, 'title' => 'Bumi Manusia', 'author' => 'Pramoedya Ananta Toer', 'isbn' => '9789799731234',
                'description' => 'Novel ini mengisahkan kehidupan Minke, seorang pribumi cerdas pada masa penjajahan Belanda di Indonesia. Minke jatuh cinta kepada Annelies, gadis keturunan Belanda dan pribumi. Melalui kisah cinta dan konflik sosial yang terjadi, novel ini menggambarkan ketidakadilan kolonialisme serta perjuangan rakyat pribumi dalam mencari kesetaraan dan kebebasan. Buku ini juga memperlihatkan kebangkitan pemikiran modern di Indonesia.',
            ],
            [
                'category' => 0, 'title' => 'Pulang', 'author' => 'Tere Liye', 'isbn' => '9786020331234',
                'description' => 'Novel ini menceritakan perjalanan hidup Bujang, seorang anak dari pedalaman Sumatra yang kemudian masuk ke dunia penuh konflik dan kekuasaan. Dalam perjalanannya, Bujang menghadapi banyak tantangan, pengkhianatan, dan pertarungan hidup. Cerita ini mengangkat tema keluarga, persahabatan, dan arti sebenarnya dari pulang dalam kehidupan seseorang.',
            ],
            [
                'category' => 0, 'title' => 'Perahu Kertas', 'author' => 'Dee Lestari', 'isbn' => '9789792231234',
                'description' => 'Novel ini berkisah tentang Kugy dan Keenan, dua anak muda dengan mimpi dan kepribadian yang unik. Kugy adalah gadis kreatif yang suka menulis dongeng, sedangkan Keenan memiliki bakat besar dalam melukis. Kisah mereka dipenuhi perjalanan cinta, persahabatan, dan pencarian jati diri. Novel ini menunjukkan bahwa mimpi dan cinta sering berjalan beriringan dalam kehidupan.',
            ],

            // Sains & Teknologi (index 1)
            [
                'category' => 1, 'title' => 'A Brief History of Time', 'author' => 'Stephen Hawking', 'isbn' => '9780553380163',
                'description' => 'Buku ini menjelaskan konsep-konsep besar dalam ilmu fisika dan kosmologi dengan bahasa yang mudah dipahami. Stephen Hawking membahas asal-usul alam semesta, lubang hitam, waktu, gravitasi, hingga teori relativitas. Buku ini membantu pembaca memahami bagaimana alam semesta bekerja serta berbagai misteri yang masih dipelajari para ilmuwan.',
            ],
            [
                'category' => 1, 'title' => 'Sapiens', 'author' => 'Yuval Noah Harari', 'isbn' => '9780062316097',
                'description' => 'Buku ini membahas sejarah perkembangan manusia dari zaman purba hingga era modern. Harari menjelaskan bagaimana Homo sapiens mampu menjadi spesies paling dominan di bumi melalui kemampuan bekerja sama, menciptakan budaya, agama, dan sistem ekonomi. Buku ini juga membahas revolusi pertanian, revolusi industri, dan perkembangan teknologi yang mengubah kehidupan manusia.',
            ],
            [
                'category' => 1, 'title' => 'Clean Code', 'author' => 'Robert C. Martin', 'isbn' => '9780132350884',
                'description' => 'Buku ini membahas cara menulis kode program yang rapi, mudah dipahami, dan mudah dikembangkan. Penulis menjelaskan berbagai prinsip pemrograman profesional seperti penamaan variabel yang baik, struktur fungsi yang jelas, dan pentingnya menjaga kualitas kode. Buku ini sangat populer di kalangan programmer karena membantu meningkatkan kualitas software.',
            ],
            [
                'category' => 1, 'title' => 'The Pragmatic Programmer', 'author' => 'David Thomas', 'isbn' => '9780135957059',
                'description' => 'Buku ini memberikan panduan bagi programmer untuk menjadi lebih profesional dan efektif dalam bekerja. Isinya membahas cara berpikir pragmatis dalam menyelesaikan masalah pemrograman, meningkatkan kemampuan coding, serta membangun software yang berkualitas. Buku ini juga mengajarkan pentingnya belajar terus-menerus dalam dunia teknologi.',
            ],

            // Sejarah (index 2)
            [
                'category' => 2, 'title' => 'Sejarah Indonesia Modern', 'author' => 'M.C. Ricklefs', 'isbn' => '9789791015851',
                'description' => 'Buku ini membahas perjalanan sejarah Indonesia dari masa kolonial hingga era modern. Penulis menjelaskan perkembangan politik, sosial, budaya, dan ekonomi Indonesia secara detail. Buku ini membantu pembaca memahami bagaimana Indonesia berkembang menjadi negara modern setelah melewati berbagai masa penjajahan dan perjuangan kemerdekaan.',
            ],
            [
                'category' => 2, 'title' => 'Guns, Germs, and Steel', 'author' => 'Jared Diamond', 'isbn' => '9780393317558',
                'description' => 'Buku ini menjelaskan mengapa beberapa peradaban berkembang lebih cepat dibandingkan yang lain. Jared Diamond berpendapat bahwa faktor geografis, lingkungan, penyakit, dan teknologi memiliki pengaruh besar terhadap perkembangan suatu bangsa. Buku ini menggabungkan sejarah, ilmu pengetahuan, dan antropologi untuk menjelaskan perkembangan dunia modern.',
            ],
            [
                'category' => 2, 'title' => 'Nusantara', 'author' => 'Bernard Vlekke', 'isbn' => '9786024121234',
                'description' => 'Buku ini membahas sejarah kepulauan Indonesia dari masa kerajaan kuno hingga masa kolonial. Penulis menjelaskan perkembangan budaya, perdagangan, dan politik di wilayah Nusantara. Buku ini memberikan gambaran tentang bagaimana Indonesia terbentuk melalui perjalanan sejarah yang panjang.',
            ],
            [
                'category' => 2, 'title' => 'Indonesia Etc.', 'author' => 'Elizabeth Pisani', 'isbn' => '9780393351279',
                'description' => 'Buku ini menceritakan perjalanan penulis menjelajahi berbagai daerah di Indonesia. Melalui pengalaman langsung, penulis menggambarkan keberagaman budaya, kehidupan masyarakat, politik lokal, dan tantangan sosial di Indonesia. Buku ini memberikan sudut pandang unik tentang Indonesia dari berbagai wilayah yang jarang dibahas.',
            ],

            // Bisnis & Ekonomi (index 3)
            [
                'category' => 3, 'title' => 'Rich Dad Poor Dad', 'author' => 'Robert Kiyosaki', 'isbn' => '9781612680194',
                'description' => 'Buku ini membahas cara pandang berbeda tentang uang dan keuangan. Robert Kiyosaki membandingkan pelajaran hidup dari ayah kaya dan ayah miskin untuk menunjukkan pentingnya investasi, aset, dan kebebasan finansial. Buku ini mengajarkan bahwa pendidikan keuangan sangat penting untuk mencapai kesuksesan ekonomi.',
            ],
            [
                'category' => 3, 'title' => 'The Lean Startup', 'author' => 'Eric Ries', 'isbn' => '9780307887894',
                'description' => 'Buku ini menjelaskan metode membangun bisnis startup dengan cara yang lebih efisien dan minim risiko. Penulis memperkenalkan konsep membuat produk sederhana terlebih dahulu, menguji pasar, lalu memperbaiki produk berdasarkan feedback pengguna. Buku ini sangat populer di dunia bisnis dan startup modern.',
            ],
            [
                'category' => 3, 'title' => 'Zero to One', 'author' => 'Peter Thiel', 'isbn' => '9780804139298',
                'description' => 'Buku ini membahas bagaimana menciptakan bisnis yang benar-benar baru dan inovatif. Peter Thiel menjelaskan bahwa kesuksesan besar datang dari menciptakan sesuatu yang unik, bukan hanya mengikuti kompetitor. Buku ini memberikan wawasan tentang teknologi, startup, dan cara berpikir inovatif dalam bisnis.',
            ],
            [
                'category' => 3, 'title' => 'Thinking, Fast and Slow', 'author' => 'Daniel Kahneman', 'isbn' => '9780374533557',
                'description' => 'Buku ini menjelaskan cara kerja pikiran manusia dalam mengambil keputusan. Daniel Kahneman membagi sistem berpikir manusia menjadi dua, yaitu berpikir cepat yang spontan dan berpikir lambat yang lebih logis. Buku ini membahas berbagai bias psikologis yang sering memengaruhi keputusan manusia dalam kehidupan sehari-hari.',
            ],

            // Pengembangan Diri (index 4)
            [
                'category' => 4, 'title' => 'Atomic Habits', 'author' => 'James Clear', 'isbn' => '9780735211292',
                'description' => 'Buku ini membahas bagaimana kebiasaan kecil yang dilakukan secara konsisten dapat membawa perubahan besar dalam hidup. James Clear menjelaskan cara membangun kebiasaan baik dan menghilangkan kebiasaan buruk dengan metode yang sederhana dan mudah diterapkan. Buku ini juga menjelaskan pentingnya sistem dibanding hanya fokus pada tujuan. Cocok untuk meningkatkan produktivitas, disiplin, dan pengembangan diri.',
            ],
            [
                'category' => 4, 'title' => 'Mindset', 'author' => 'Carol S. Dweck', 'isbn' => '9780345472328',
                'description' => 'Buku ini menjelaskan dua jenis pola pikir manusia, yaitu fixed mindset dan growth mindset. Fixed mindset membuat seseorang percaya bahwa kemampuan tidak dapat berubah, sedangkan growth mindset membuat seseorang percaya bahwa kemampuan dapat berkembang melalui usaha dan belajar. Buku ini menunjukkan bagaimana pola pikir memengaruhi kesuksesan dalam pendidikan, pekerjaan, bisnis, dan kehidupan sehari-hari.',
            ],
            [
                'category' => 4, 'title' => 'The 7 Habits', 'author' => 'Stephen Covey', 'isbn' => '9781982137274',
                'description' => 'Buku ini membahas tujuh kebiasaan yang dimiliki orang-orang efektif dalam kehidupan dan pekerjaan. Stephen Covey menjelaskan pentingnya disiplin diri, manajemen waktu, komunikasi, kerja sama, dan pengembangan diri secara terus-menerus. Buku ini membantu pembaca membangun karakter dan kebiasaan positif untuk mencapai keberhasilan pribadi maupun profesional.',
            ],
            [
                'category' => 4, 'title' => 'Deep Work', 'author' => 'Cal Newport', 'isbn' => '9781455586691',
                'description' => 'Buku ini membahas pentingnya fokus mendalam dalam bekerja di era modern yang penuh distraksi. Cal Newport menjelaskan bahwa kemampuan untuk bekerja dengan konsentrasi tinggi adalah keterampilan yang sangat berharga. Buku ini memberikan strategi untuk meningkatkan fokus, produktivitas, dan kualitas kerja dengan mengurangi gangguan seperti media sosial dan multitasking.',
            ],
        ];

        foreach ($books as $book) {
            Book::create([
                'category_id' => $categories[$book['category']]->id,
                'title'       => $book['title'],
                'author'      => $book['author'],
                'isbn'        => $book['isbn'],
                'stock'       => rand(1, 10),
                'description' => $book['description'],
            ]);
        }
    }
}

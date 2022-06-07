<?php
    return [
        'intro' => "Halo, selamat datang di 'Laptop Chatbot'!",
        'menu_angka' => [
            ['1','2','3','4'],
            ['1','2','3','4','5','6'],
        ],
        'menu' => [
            [
                'Rekomendasi laptop',
                'Daftar merek laptop',
                'Bantuan',
                'Live chat',
            ],
            [
                'Harga laptop',
                'Merek laptop',
                'Nama laptop',
                'Prosesor laptop',
                'Rincian laptop',
                'Ukuran laptop',
            ]
        ],
        'merk_list' => 'Berikut ini merupakan daftar merek laptop yang dapat saya rekomendasikan',
        'error' => 'Maaf saya tidak mengerti maksud anda',
        'rekomendasi' => [
            'Rekomendasi laptop dari harga xxx sampai harga xxx',
            'Rekomendasi laptop dengan merek xxx',
            'Rekomendasi laptop dengan nama xxx',
            'Rekomendasi laptop dengan prosesor xxx',
            'Rekomendasi laptop dengan rincian xxx',
            'Rekomendasi laptop dengan ukuran xx.x',
        ],
        'replies' => [

            'Berikut ini merupakan daftar menu yang dapat anda akses:<br/>'.
            '1. Rekomendasi laptop<br/>'.
            '2. Daftar merek laptop<br/>'.
            '3. Bantuan<br/>'.
            '4. Live chat<br/>',

            'Ingin mendapatkan rekomendasi bedasarkan apa?<br/>'.
            '1. Harga laptop<br/>'.
            '2. Merek laptop<br/>'.
            '3. Nama laptop<br/>'.
            '4. Prosesor laptop<br/>'.
            '5. Rincian laptop<br/>'.
            '6. Ukuran laptop<br/>',

            'Berikut ini adalah informasi yang saya dapat sampaikan untuk membantu anda<br/>'.
            '<u>Menu rekomendasi</u><br/>'.
            '1. Menu rekomendasi dapat diakses secara utama lewat pilihan menu yang disediakan.<br/>'.
            '2. Menu rekomendasi juga dapat diakses menggunakan daftar perintah yang disugestikan pada kolom chat. Ketika sugesti menu sudah dipilih, kolom yang ditandai dengan kalimat xxx dapat diganti bedasarkan masukan yang telah dipilih pengguna.<br/>'.
            '3. Menu rekomendasi akan menghasilkan daftar laptop sesuai dengan masukan pengguna.<br/>'.
            '<u>Menu daftar merek laptop</u><br/>'.
            '1. Menu daftar merek akan menampilkan daftar merek (<i>brand</i>) laptop yang dapat direkomendasikan oleh saya.<br/>'.
            'Selamat mencoba...',

            'Untuk pertanyaan diluar Chatbot silahkan kirimkan ke:&nbsp;<br/><a class="btn btn-primary" href="mailto:LaptopChatbot@gmail.com">Email Kami</a>',

            [
                ["Masukan harga minimal (Rp)", "Masukan harga maksimal (Rp)"],
                ["Masukan merek laptop"],
                ["Masukan nama laptop"],
                ["Masukan nama jenis prosesor laptop"],
                ["Masukan rincian laptop"],
                ["Masukan ukuran laptop (inch)"],
            ]
        ],
    ];
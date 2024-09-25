{{-- resources/views/frontend/about.blade.php --}}
@extends('layouts.frontend.app')

@section('content')
<div class="container-fluid p-0">
    {{-- Banner Section --}}
    <div class="banner-image" style="background-image: url('{{ asset('me/img/about-sawitshop.jpg') }}'); height: 500px; background-size: cover; background-position: center;">
    <div class="banner-text">
        <h2 style="color:white;" >Melayani sejak 1916</h2>
        <p  style="color:white;" >Merupakan lembaga yang telah lama mengabdi dalam riset perkebunan kelapa sawit di Indonesia. Berkomitmen untuk kemajuan industri perkelapasawitan di Indonesia.</>
    </div>
</div>


    {{-- About Section --}}
    <div class="container my-5 about-section">
        <h1 class="text-center">Sejarah terbentuknya PPKS</h1>
        <p class="text-center">
            Cikal bakal PPKS bernama APA (Algemeene Proefstation der AVROS/Algemeene Vereeniging van Rubberplanters ter Oostkust van Sumatra) 
            yang didirikan pada tanggal 26 September 1916. APA merupakan sebuah lembaga penelitian perkebunan pertama di Sumatra. Pada saat itu, 
            fokus utama penelitian APA adalah komoditi karet, setelah semakin berkembang APA juga menangani penelitian teh dan kelapa sawit.
        </p>
        <p class="text-center">
            Latar belakang pendirian APA adalah krisis yang melanda industri tembakau pada tahun-tahun sebelumnya. Krisis industri tembakau telah 
            memberikan pelajaran berharga yaitu dibutuhkan suatu dukungan kuat dari penelitian dan pengembangan (research and development) untuk 
            keberlanjutan dan kemajuan suatu komoditas pertanian.
        </p>
        <p class="text-center">
        Lembaga penelitian APA berganti nama menjadi Balai Penyelidikan GAPPERSU atau Research Institute of The Sumatra Planters Association (RISPA) pada 1957. Status dan nama RISPA terus menerus berganti hingga pada 1987, kemudian berganti nama menjadi Pusat Penelitian Perkebunan (Puslitbun) Medan dan bertahan sampai terlaksananya penggabungan antara Puslitbun Marihat, Bandar Kuala, dan Medan pada 24 Desember 1992. Gabungan Puslitbun inilah akhirnya yang menjadi Pusat Penelitian Kelapa Sawit (PPKS).
        </p>
    </div>
</div>
@endsection

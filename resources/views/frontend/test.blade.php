{{-- resources/views/frontend/faq.blade.php --}}
@extends('layouts.frontend.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@section('content')
<div class="container-fluid p-0">
    {{-- Banner Section --}}
    <div class="banner-image" style="background-image: url('{{ asset('me/img/faq-banner.png') }}'); height: 500px; background-size: cover; background-position: center;">
        <div class="banner-text">
            <h2 style="color:white;" >Frequently Asked Questions (FAQ)</h2>
            <p  style="color:white;" >Temukan jawaban dari pertanyaan-pertanyaan yang sering diajukan mengenai PPKS dan layanan kami.</p>
        </div>
    </div>

    {{-- FAQ Section --}}
    <div class="container my-5 faq-section">
        <h1 class="text-center">Frequently Asked Questions</h1>
        <div class="accordion" id="faqAccordion">
            {{-- Question 1 --}}
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Apa itu Pusat Penelitian Kelapa Sawit (PPKS)?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Pusat Penelitian Kelapa Sawit (PPKS) adalah lembaga riset yang telah beroperasi sejak 1916 dan berfokus pada penelitian dan pengembangan industri kelapa sawit di Indonesia. Kami berkomitmen untuk mendukung kemajuan industri perkelapasawitan melalui inovasi dan riset mendalam.
                    </div>
                </div>
            </div>

            {{-- Question 2 --}}
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Apa layanan utama yang ditawarkan oleh SawitShop?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        SawitShop menawarkan berbagai layanan, yang utama adalah menyediakan kebutuhan petani seperti Kecambah dan produk lainnya.
                    </div>
                </div>
            </div>

            {{-- Question 3 --}}
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Bagaimana cara menghubungi PPKS?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Anda dapat menghubungi kami melalui situs web resmi PPKS atau melalui email dan nomor telepon yang tertera di halaman kontak kami. Kami siap membantu dengan informasi lebih lanjut mengenai layanan dan penelitian kami.
                    </div>
                </div>
            </div>

            {{-- Add more FAQ items as needed --}}
        </div>
    </div>
</div>
@endsection

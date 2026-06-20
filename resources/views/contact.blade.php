@extends('layouts.app')

@section('content')
<h1 style="font-size: 2.25rem; font-weight:800; margin-bottom: 2rem; text-align: center; letter-spacing: -0.5px;">Hubungi Saya</h1>

<div class="bento-card" style="max-width: 600px; margin: 0 auto; padding: 2.5rem;">
    @if(session('success'))
        <div style="background-color: rgba(52, 199, 89, 0.15); color:#34c759; padding: 1rem; border-radius: 16px; margin-bottom: 1.5rem; font-weight:600; font-size: 0.95rem;">
            ✓ {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('contact.store') }}" method="POST" style="display:flex; flex-direction:column; gap: 1.5rem;">
        @csrf
        <div style="display:flex; flex-direction:column; gap:0.5rem;">
            <label for="name" style="font-weight:600; font-size: 0.95rem;">Nama</label>
            <input type="text" name="name" id="name" required placeholder="Masukkan nama Anda">
        </div>

        <div style="display:flex; flex-direction:column; gap:0.5rem;">
            <label for="email" style="font-weight:600; font-size: 0.95rem;">Email</label>
            <input type="email" name="email" id="email" required placeholder="name@example.com">
        </div>

        <div style="display:flex; flex-direction:column; gap:0.5rem;">
            <label for="message" style="font-weight:600; font-size: 0.95rem;">Pesan</label>
            <textarea name="message" id="message" rows="5" required placeholder="Tuliskan pesan Anda di sini..."></textarea>
        </div>

        <button type="submit" class="btn" style="width:100%; margin-top:0.5rem; justify-content: center;">Kirim Pesan</button>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
<h1 style="font-size: 2rem; font-weight:700; margin-bottom: 2rem;">Hubungi Saya</h1>

<div class="bento-card" style="max-width: 600px; margin: 0 auto; padding: 2rem;">
    @if(session('success'))
        <div style="background-color: rgba(52, 199, 89, 0.15); color:#34c759; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; font-weight:500;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('contact.store') }}" method="POST" style="display:flex; flex-direction:column; gap: 1.25rem;">
        @csrf
        <div style="display:flex; flex-direction:column; gap:0.5rem;">
            <label for="name" style="font-weight:500;">Nama</label>
            <input type="text" name="name" id="name" required style="background:var(--bg-primary); border:1px solid var(--border); color:var(--text-primary); padding:0.75rem; border-radius:10px; font-size:1rem; outline:none;">
        </div>

        <div style="display:flex; flex-direction:column; gap:0.5rem;">
            <label for="email" style="font-weight:500;">Email</label>
            <input type="email" name="email" id="email" required style="background:var(--bg-primary); border:1px solid var(--border); color:var(--text-primary); padding:0.75rem; border-radius:10px; font-size:1rem; outline:none;">
        </div>

        <div style="display:flex; flex-direction:column; gap:0.5rem;">
            <label for="message" style="font-weight:500;">Pesan</label>
            <textarea name="message" id="message" rows="5" required style="background:var(--bg-primary); border:1px solid var(--border); color:var(--text-primary); padding:0.75rem; border-radius:10px; font-size:1rem; outline:none; resize:vertical;"></textarea>
        </div>

        <button type="submit" class="btn" style="border:none; cursor:pointer; width:100%; margin-top:0.5rem;">Kirim Pesan</button>
    </form>
</div>
@endsection

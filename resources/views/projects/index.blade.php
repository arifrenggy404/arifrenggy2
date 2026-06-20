@extends('layouts.app')

@section('content')
<h1 style="font-size: 2rem; font-weight:700; margin-bottom: 2rem;">Semua Proyek</h1>

<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
    @forelse($projects as $project)
        <div class="bento-card">
            <div>
                <h2 style="font-size:1.25rem; font-weight:600;">{{ $project->title }}</h2>
                <p style="margin-top: 0.5rem; color:var(--text-secondary); font-size: 0.9rem;">{{ $project->summary }}</p>
            </div>
            <div style="margin-top: 1.5rem; display:flex; justify-content:space-between; align-items:center;">
                <a href="{{ route('projects.show', $project->slug) }}" style="color:var(--accent); text-decoration:none; font-weight:600;">Lihat Detail &rarr;</a>
            </div>
        </div>
    @empty
        <p style="color:var(--text-secondary);">Belum ada proyek yang ditambahkan.</p>
    @endforelse
</div>
@endsection

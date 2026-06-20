@extends('layouts.app')

@section('content')
<h1 style="font-size: 2.25rem; font-weight:800; margin-bottom: 2rem; letter-spacing:-0.5px;">Semua Proyek</h1>

<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
    @forelse($projects as $project)
        <div class="bento-card">
            <div>
                <h2 style="font-size:1.25rem; font-weight:700; letter-spacing:-0.3px; color: var(--text-primary);">{{ $project->title }}</h2>
                <p style="margin-top: 0.75rem; color:var(--text-secondary); font-size: 0.9rem; line-height: 1.5;">{{ $project->summary }}</p>
            </div>
            <div style="margin-top: 1.5rem; display:flex; justify-content:space-between; align-items:center;">
                <a href="{{ route('projects.show', $project->slug) }}" style="color:var(--accent-solid); text-decoration:none; font-weight:600; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 0.25rem;">
                    Lihat Detail <span>&rarr;</span>
                </a>
            </div>
        </div>
    @empty
        <p style="color:var(--text-secondary);">Belum ada proyek yang ditambahkan.</p>
    @endforelse
</div>
@endsection

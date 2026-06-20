@extends('layouts.app')

@section('content')
<div class="bento-grid">
    <!-- Hero Box -->
    <div class="bento-card col-span-2" style="min-height: 250px;">
        <div>
            <h1 style="font-size: 2.5rem; font-weight:700; line-height:1.2;">Halo, Saya {{ $profile->tagline ?? 'Arif Renggy' }}</h1>
            <p style="margin-top: 1rem; color: var(--text-secondary);">Selamat datang di website portofolio pribadi saya.</p>
        </div>
        <div>
            @if(!empty($profile->resume_path))
                <a href="/storage/{{ $profile->resume_path }}" class="btn" download>Unduh CV</a>
            @endif
        </div>
    </div>

    <!-- About Me -->
    <div class="bento-card">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 600;">Tentang Saya</h2>
            <p style="margin-top: 1rem; color: var(--text-secondary); font-size: 0.95rem;">
                {{ $profile->bio ?? 'Saya adalah mahasiswa IT.' }}
            </p>
        </div>
    </div>

    <!-- Featured Projects -->
    <div class="bento-card col-span-2">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">Proyek/Tugas Unggulan</h2>
        <div style="display:flex; flex-direction:column; gap: 1rem;">
            @forelse($featuredProjects as $project)
                <div style="border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                    <a href="{{ route('projects.show', $project->slug) }}" style="color:var(--text-primary); font-weight:600; font-size:1.1rem; text-decoration:none;">{{ $project->title }}</a>
                    <p style="color:var(--text-secondary); font-size:0.9rem; margin-top:0.25rem;">{{ $project->summary }}</p>
                </div>
            @empty
                <p style="color:var(--text-secondary);">Belum ada proyek unggulan.</p>
            @endforelse
        </div>
    </div>

    <!-- Tech Stack -->
    <div class="bento-card">
        <h2 style="font-size: 1.25rem; font-weight: 600;">Teknologi</h2>
        <div class="skills-list">
            @forelse($skills as $skill)
                <span class="skill-tag">{{ $skill->name }}</span>
            @empty
                <span class="skill-tag">PHP</span>
                <span class="skill-tag">Laravel</span>
            @endforelse
        </div>
    </div>
</div>
@endsection

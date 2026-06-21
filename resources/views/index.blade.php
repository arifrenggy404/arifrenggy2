@extends('layouts.app')

@section('content')
<div class="bento-grid">
    <!-- Hero Box -->
    <div class="bento-card bento-hero col-span-2">
        <div>
            <h1 style="font-size: 2.75rem; font-weight:800; line-height:1.15; letter-spacing:-1px;">
                Halo, Saya <span class="title-gradient">Arif Renggy</span>
            </h1>
            <p style="font-size: 1.25rem; font-weight: 600; margin-top: 0.5rem; color: var(--text-primary);">
                {{ $profile->tagline ?? 'IT Student & Aspiring Fullstack Developer' }}
            </p>
            <p style="margin-top: 1rem; color: var(--text-secondary); max-width: 90%; font-size: 1rem;">
                Selamat datang di website portofolio pribadi saya. Di sini Anda dapat menemukan proyek, keterampilan, dan cara menghubungi saya secara langsung.
            </p>
        </div>
        <div>
            @if(!empty($profile->resume_path))
                <a href="/storage/{{ $profile->resume_path }}" class="btn" download>Unduh CV</a>
            @else
                <a href="{{ route('projects.index') }}" class="btn">Lihat Semua Proyek</a>
            @endif
        </div>
    </div>

    <!-- About Me -->
    <div class="bento-card">
        <div>
            <h2 style="font-size: 1.35rem; font-weight: 700; letter-spacing:-0.5px; margin-bottom: 0.75rem;">Tentang Saya</h2>
            <p style="color: var(--text-secondary); font-size: 0.95rem; line-height: 1.6;">
                {{ $profile->bio ?? 'Saya adalah mahasiswa IT di Unkriswina Sumba (Universitas Kristen Wira Wacana Sumba) yang bercita-cita menjadi seorang Fullstack Developer profesional.' }}
            </p>
        </div>
        <div style="margin-top: 1.5rem; font-size: 0.85rem; font-weight: 600; color: var(--text-primary); border-top: 1px solid var(--border); padding-top: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
            <svg style="width: 16px; height: 16px; color: var(--accent-solid); fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;" viewBox="0 0 24 24">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"></path>
            </svg>
            <span>Unkriswina Sumba</span>
        </div>
    </div>

    <!-- Tech Stack -->
    <div class="bento-card">
        <div>
            <h2 style="font-size: 1.35rem; font-weight: 700; letter-spacing:-0.5px; margin-bottom: 0.5rem;">Teknologi</h2>
            <p style="color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 1rem;">Perkakas & bahasa yang saya kuasai:</p>
            <div class="skills-list">
                @forelse($skills as $skill)
                    <span class="skill-tag">{{ $skill->name }}</span>
                @empty
                    <span class="skill-tag">Laravel</span>
                    <span class="skill-tag">PHP</span>
                    <span class="skill-tag">MySQL</span>
                    <span class="skill-tag">CSS3</span>
                    <span class="skill-tag">Alpine.js</span>
                    <span class="skill-tag">Git</span>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Featured Projects -->
    <div class="bento-card">
        <div>
            <h2 style="font-size: 1.35rem; font-weight: 700; letter-spacing:-0.5px; margin-bottom: 1rem;">Tugas & Proyek</h2>
            <div style="display:flex; flex-direction:column; gap: 1.5rem;">
                @forelse($featuredProjects as $project)
                    <div style="border-left: 4px solid var(--accent-solid); padding-left: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 1.25rem;">
                        <a href="{{ route('projects.show', $project->slug) }}" style="color:var(--text-primary); font-weight:700; font-size:1.05rem; text-decoration:none; display:block;">
                            {{ $project->title }}
                        </a>
                        
                        @if($project->tags)
                            <div style="display:flex; flex-wrap:wrap; gap:0.35rem; margin-top:0.4rem; margin-bottom: 0.5rem;">
                                @foreach($project->tags as $tag)
                                    <span class="skill-tag" style="font-size:0.65rem; padding:0.15rem 0.5rem; margin:0;">{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif

                        <p style="color:var(--text-secondary); font-size:0.85rem; margin-top:0.25rem; line-height: 1.5;">{{ $project->summary }}</p>
                        
                        @if($project->image_path)
                            <img src="{{ \Illuminate\Support\Str::startsWith($project->image_path, ['http', '/']) ? $project->image_path : '/storage/' . $project->image_path }}" alt="{{ $project->title }}" onerror="this.style.display='none';" style="width: 100%; height: 110px; object-fit: cover; border-radius: 8px; margin-top: 0.75rem; border: 1px solid var(--border);">
                        @endif

                        <div style="display:flex; gap: 1rem; margin-top: 0.85rem; align-items: center; flex-wrap: wrap;">
                            <a href="{{ route('projects.show', $project->slug) }}" style="color:var(--accent-solid); text-decoration:none; font-weight:600; font-size:0.85rem; display: inline-flex; align-items: center; gap: 0.25rem;">Detail &rarr;</a>
                            @if($project->github_url)
                                <a href="{{ $project->github_url }}" target="_blank" style="color:var(--text-primary); text-decoration:none; font-weight:500; font-size:0.8rem; display:inline-flex; align-items:center; gap:0.25rem;">
                                    <svg style="width:14px; height:14px; fill:currentColor;" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                    GitHub
                                </a>
                            @endif
                            @if($project->demo_url)
                                <a href="{{ $project->demo_url }}" target="_blank" style="color:var(--text-primary); text-decoration:none; font-weight:500; font-size:0.8rem; display:inline-flex; align-items:center; gap:0.25rem;">
                                    <svg style="width:14px; height:14px; fill:none; stroke:currentColor; stroke-width:2; stroke-linecap:round; stroke-linejoin:round;" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                    Live Demo
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p style="color:var(--text-secondary); font-size:0.9rem;">Belum ada proyek unggulan.</p>
                @endforelse
            </div>
        </div>
        <div style="margin-top: 1rem;">
            <a href="{{ route('projects.index') }}" style="color:var(--accent-solid); text-decoration:none; font-weight:600; font-size:0.9rem; display: inline-flex; align-items: center; gap: 0.25rem;">Seluruh Proyek &rarr;</a>
        </div>
    </div>

    <!-- Socials & Kontak -->
    <div class="bento-card">
        <div>
            <h2 style="font-size: 1.35rem; font-weight: 700; letter-spacing:-0.5px; margin-bottom: 0.5rem;">Kontak & Sosmed</h2>
            <p style="color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 1rem;">Hubungi atau temukan saya di:</p>
            <div class="socials-container">
                <a href="https://github.com/arifrenggy404" target="_blank" class="social-item github">
                    <svg viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    GitHub
                </a>
                <a href="https://wa.me/6285122531230" target="_blank" class="social-item whatsapp">
                    <svg viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.513 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.458L0 24zm6.07-4.148c1.564.928 3.125 1.414 4.88 1.415 5.485.002 9.948-4.464 9.95-9.95.002-2.657-1.03-5.155-2.906-7.03C16.175 2.41 13.682 1.378 11.026 1.378 5.542 1.378 1.08 5.84 1.077 11.323c-.001 1.83.483 3.616 1.402 5.176l-.99 3.613 3.693-.969zm13.126-7.25c-.247-.123-1.464-.722-1.692-.805-.227-.083-.393-.123-.558.124-.166.248-.641.805-.786.97-.145.166-.29.186-.537.063-.247-.124-.98-.362-1.868-1.154-.69-.616-1.157-1.379-1.292-1.61-.137-.233-.015-.359.108-.481.111-.11.247-.29.372-.434.124-.145.165-.248.247-.414.083-.165.042-.31-.02-.434-.063-.124-.559-1.348-.766-1.847-.2-.484-.403-.418-.558-.426-.145-.007-.31-.01-.476-.01-.166 0-.434.062-.661.31-.227.247-.867.847-.867 2.065 0 1.219.887 2.396 1.011 2.562.124.165 1.745 2.664 4.227 3.733.59.254 1.05.405 1.408.52.593.189 1.133.162 1.558.098.473-.07 1.464-.598 1.67-.177.206-.421.206-.783.145-.847-.061-.063-.227-.145-.474-.268z"/></svg>
                    WhatsApp
                </a>
                <a href="https://instagram.com/arifrenggy" target="_blank" class="social-item instagram">
                    <svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0 3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    Instagram
                </a>
                <a href="https://facebook.com/arifrenggy00" target="_blank" class="social-item facebook">
                    <svg viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                    Facebook
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<h1 style="font-size: 2.25rem; font-weight:800; margin-bottom: 2rem; letter-spacing:-0.5px;">Semua Proyek</h1>

<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
    @forelse($projects as $project)
        <div class="bento-card" style="border-top: 4px solid var(--accent-solid);">
            <div>
                <h2 style="font-size:1.25rem; font-weight:700; letter-spacing:-0.3px; color: var(--text-primary);">{{ $project->title }}</h2>
                <p style="margin-top: 0.75rem; color:var(--text-secondary); font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.5rem;">{{ $project->summary }}</p>
            </div>
            <div style="display:flex; flex-wrap:wrap; gap: 0.5rem; justify-content: flex-start; align-items:center; border-top: 1px solid var(--border); padding-top: 1rem; margin-top: auto;">
                <a href="{{ route('projects.show', $project->slug) }}" class="btn" style="margin: 0; padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 12px;">Detail</a>
                @if($project->github_url)
                    <a href="{{ $project->github_url }}" class="btn btn-secondary" style="margin: 0; padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 12px; display: inline-flex; align-items: center; gap: 0.25rem;" target="_blank">
                        <svg style="width:14px; height:14px; fill:currentColor;" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                        GitHub
                    </a>
                @endif
                @if($project->demo_url)
                    <a href="{{ $project->demo_url }}" class="btn btn-secondary" style="margin: 0; padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 12px; display: inline-flex; align-items: center; gap: 0.25rem;" target="_blank">
                        <svg style="width:14px; height:14px; fill:none; stroke:currentColor; stroke-width:2; stroke-linecap:round; stroke-linejoin:round;" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        Demo
                    </a>
                @endif
            </div>
        </div>
    @empty
        <p style="color:var(--text-secondary);">Belum ada proyek yang ditambahkan.</p>
    @endforelse
</div>
@endsection

@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('projects.index') }}" style="color: var(--text-secondary); text-decoration:none; font-weight:500; display: inline-flex; align-items: center; gap: 0.25rem;">
        <span>&larr;</span> Kembali ke Proyek
    </a>
</div>

<div class="bento-card" style="padding: 2.5rem;">
    <h1 style="font-size: 2.25rem; font-weight:800; margin-bottom: 0.5rem; letter-spacing: -0.5px;">{{ $project->title }}</h1>
    <p style="color:var(--text-secondary); font-size:1.1rem; margin-bottom: 1.5rem;">{{ $project->summary }}</p>

    <div style="display:flex; gap: 0.75rem; margin-bottom: 2.5rem;">
        @if($project->github_url)
            <a href="{{ $project->github_url }}" class="btn" style="margin:0;" target="_blank">GitHub</a>
        @endif
        @if($project->demo_url)
            <a href="{{ $project->demo_url }}" class="btn btn-secondary" style="margin:0;" target="_blank">Demo Live</a>
        @endif
    </div>

    <!-- Tabs Header -->
    <div style="display:flex; border-bottom: 1px solid var(--border); margin-bottom: 1.5rem; gap: 1.5rem;">
        <button class="tab-btn active" onclick="switchTab('deskripsi')">Deskripsi</button>
        <button class="tab-btn" onclick="switchTab('arsitektur')">Arsitektur</button>
        <button class="tab-btn" onclick="switchTab('kode')">Cuplikan Kode</button>
    </div>

    <!-- Tabs Content -->
    <div id="tab-deskripsi" class="tab-content" style="display:block; line-height: 1.7;">
        {!! $project->desc_content !!}
    </div>
    <div id="tab-arsitektur" class="tab-content" style="display:none; line-height: 1.7;">
        {!! $project->arch_content ?? '<p style="color:var(--text-secondary);">Tidak ada data arsitektur.</p>' !!}
    </div>
    <div id="tab-kode" class="tab-content" style="display:none; line-height: 1.7;">
        {!! $project->code_content ?? '<p style="color:var(--text-secondary);">Tidak ada cuplikan kode.</p>' !!}
    </div>
</div>

<script>
    function switchTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
        
        // Show selected tab content
        document.getElementById('tab-' + tabName).style.display = 'block';

        // Update tab buttons styles
        const buttons = document.querySelectorAll('.tab-btn');
        buttons.forEach(btn => {
            btn.classList.remove('active');
        });

        // Set clicked button to active
        event.currentTarget.classList.add('active');
    }
</script>
@endsection

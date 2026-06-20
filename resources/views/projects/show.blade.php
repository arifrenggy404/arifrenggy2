@extends('layouts.app')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('projects.index') }}" style="color: var(--text-secondary); text-decoration:none; font-weight:500;">&larr; Kembali ke Proyek</a>
</div>

<div class="bento-card" style="padding: 2rem;">
    <h1 style="font-size: 2.25rem; font-weight:700; margin-bottom: 0.5rem;">{{ $project->title }}</h1>
    <p style="color:var(--text-secondary); font-size:1.1rem; margin-bottom: 1.5rem;">{{ $project->summary }}</p>

    <div style="display:flex; gap: 1rem; margin-bottom: 2rem;">
        @if($project->github_url)
            <a href="{{ $project->github_url }}" class="btn" style="margin:0;" target="_blank">GitHub</a>
        @endif
        @if($project->demo_url)
            <a href="{{ $project->demo_url }}" class="btn" style="margin:0; background-color: var(--text-secondary);" target="_blank">Demo Live</a>
        @endif
    </div>

    <!-- Tabs Header -->
    <div style="display:flex; border-bottom: 1px solid var(--border); margin-bottom: 1.5rem; gap: 1.5rem;">
        <button class="tab-btn active" onclick="switchTab('deskripsi')" style="background:none; border:none; color:var(--accent); font-weight:600; font-size:1rem; padding-bottom:0.75rem; border-bottom: 2px solid var(--accent); cursor:pointer;">Deskripsi</button>
        <button class="tab-btn" onclick="switchTab('arsitektur')" style="background:none; border:none; color:var(--text-secondary); font-weight:500; font-size:1rem; padding-bottom:0.75rem; border-bottom: 2px solid transparent; cursor:pointer;">Arsitektur</button>
        <button class="tab-btn" onclick="switchTab('kode')" style="background:none; border:none; color:var(--text-secondary); font-weight:500; font-size:1rem; padding-bottom:0.75rem; border-bottom: 2px solid transparent; cursor:pointer;">Cuplikan Kode</button>
    </div>

    <!-- Tabs Content -->
    <div id="tab-deskripsi" class="tab-content" style="display:block;">
        {!! $project->desc_content !!}
    </div>
    <div id="tab-arsitektur" class="tab-content" style="display:none;">
        {!! $project->arch_content ?? '<p style="color:var(--text-secondary);">Tidak ada data arsitektur.</p>' !!}
    </div>
    <div id="tab-kode" class="tab-content" style="display:none;">
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
            btn.style.color = 'var(--text-secondary)';
            btn.style.fontWeight = '500';
            btn.style.borderBottomColor = 'transparent';
        });

        // Set clicked button to active
        const clickedBtn = event.currentTarget;
        clickedBtn.classList.add('active');
        clickedBtn.style.color = 'var(--accent)';
        clickedBtn.style.fontWeight = '600';
        clickedBtn.style.borderBottomColor = 'var(--accent)';
    }
</script>
@endsection

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectDetailsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_project_details(): void
    {
        $project = Project::create([
            'title' => 'Sample Project',
            'slug' => 'sample-project',
            'summary' => 'Sample summary',
            'desc_content' => '<p>Description text</p>',
            'arch_content' => '<p>Architecture text</p>'
        ]);

        $response = $this->get('/projects/sample-project');
        $response->assertStatus(200);
        $response->assertSee('Sample Project');
        $response->assertSee('Description text');
    }
}

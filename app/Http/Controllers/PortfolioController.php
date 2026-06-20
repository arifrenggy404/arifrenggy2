<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Skill;
use App\Models\Project;

class PortfolioController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        $skills = Skill::orderBy('order')->get();
        $featuredProjects = Project::where('is_featured', true)->orderBy('order')->get();

        return view('index', compact('profile', 'skills', 'featuredProjects'));
    }

    public function projects()
    {
        $projects = Project::orderBy('order')->get();
        return view('projects.index', compact('projects'));
    }

    public function show($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        return view('projects.show', compact('project'));
    }

    public function contact()
    {
        return view('contact');
    }
}

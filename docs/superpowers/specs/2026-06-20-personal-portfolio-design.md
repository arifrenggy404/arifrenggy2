# Design Specification: Personal Portfolio with Laravel & Filament PHP

This document outlines the detailed system architecture, database schema, administrative controls, and frontend layout for the personal portfolio of Arif Renggy.

---

## 1. Overview & Purpose
The goal is to build a modern, minimalist, and elegant personal portfolio website for an IT student. The site will feature a dynamic frontend to showcase projects, skills, and personal information, backed by a robust and secure backend powered by Laravel and a Filament admin panel. 

### Key Objectives
*   Provide a premium, highly aesthetic, minimalist frontend featuring both dark and light modes (dual mode toggle).
*   Implement a Bento Grid layout on the homepage.
*   Implement a Tabbed Showcase on the project details pages.
*   Allow full administrative control over website content (text, skills, projects, and incoming contact messages) using Filament PHP.
*   Ensure absolute fast load times and clean SEO practices.

---

## 2. Technical Stack
*   **Core Backend Framework:** Laravel 11 (PHP 8.2+)
*   **Database:** SQLite (efficient, serverless, file-based)
*   **Administration Panel:** Filament v3 (Laravel Livewire, Alpine.js, Tailwind CSS)
*   **Frontend Templating:** Laravel Blade
*   **Frontend Styling:** Vanilla CSS (curated modern color palette, micro-animations, glassmorphism, responsive grid)
*   **Frontend Interactivity:** Alpine.js (reused from Filament's asset injection or light vanilla JavaScript)

---

## 3. Database Schema (Models & Migrations)

### 3.1. `Profile`
Stores personal branding information. There will only be one record in this table.
*   `id` (Primary Key, integer)
*   `avatar_path` (string, nullable) - Path to the profile photo.
*   `tagline` (string) - Hero section title (e.g., "IT Student & Fullstack Developer").
*   `bio` (text) - Detailed description for "About Me" section.
*   `resume_path` (string, nullable) - Path to the uploaded CV/Resume PDF.
*   `socials` (json, nullable) - Key-value store for GitHub, LinkedIn, Email, Twitter/X, etc.
*   `created_at`, `updated_at` (timestamps)

### 3.2. `Skill`
Stores technical capabilities.
*   `id` (Primary Key, integer)
*   `name` (string) - Name of the technology (e.g., "Laravel", "React", "Docker").
*   `category` (enum: 'frontend', 'backend', 'tools') - Classification.
*   `icon_svg` (text, nullable) - Inline SVG string or icon class for custom rendering.
*   `order` (integer, default: 0) - For drag-and-drop sort order in the admin panel.
*   `created_at`, `updated_at` (timestamps)

### 3.3. `Project`
Stores portfolio items.
*   `id` (Primary Key, integer)
*   `title` (string) - Name of the project.
*   `slug` (string, unique) - URL-friendly slug.
*   `summary` (string) - Brief one-liner description shown on cards/bento boxes.
*   `desc_content` (text) - Tab 1 content: Overview, challenge, features.
*   `arch_content` (text, nullable) - Tab 2 content: Database structure, flowcharts, architecture description.
*   `code_content` (text, nullable) - Tab 3 content: Sample code snippets or explanation of complex logic.
*   `image_path` (string, nullable) - Project cover image.
*   `github_url` (string, nullable) - Link to repository.
*   `demo_url` (string, nullable) - Link to live project.
*   `is_featured` (boolean, default: false) - Displays project on the home bento grid.
*   `order` (integer, default: 0) - Sorting sequence.
*   `created_at`, `updated_at` (timestamps)

### 3.4. `Message`
Stores user inquiries submitted via the frontend contact form.
*   `id` (Primary Key, integer)
*   `name` (string)
*   `email` (string)
*   `message` (text)
*   `created_at`, `updated_at` (timestamps)

---

## 4. Administrative Interface (Filament Admin Panel)

We will implement the following Filament resources inside the admin panel (`/admin`):

1.  **`ProfileResource` or Custom Page:**
    *   Since there is only one profile, we will create a dedicated Settings/Profile page in Filament using a single record strategy.
    *   Form elements: File uploaders for avatar and resume (PDF), textarea for bio, text input for tagline, and a repeater for social media profiles.
2.  **`SkillResource`:**
    *   CRUD operations in a grid layout.
    *   Select dropdown for `category`.
    *   Textarea for raw `icon_svg` input to support custom styling.
    *   Filament's sortable features to drag and drop rows to set the order.
3.  **`ProjectResource`:**
    *   CRUD interface with automatic slug generation from the title.
    *   Uploader for cover image (automatically saved in public storage).
    *   Toggle for `is_featured`.
    *   Rich text editors (e.g., Markdown or RichEditor) for `desc_content`, `arch_content`, and `code_content`.
4.  **`MessageResource`:**
    *   Read-only list showing name, email, submission timestamp, and message body.
    *   Delete actions to clean up inbox. No creation or editing allowed.

---

## 5. Frontend Pages Design (Laravel Blade & Vanilla CSS)

### 5.1. Layout & Color System
A clean, premium modern dual-mode system using standard CSS custom properties:
*   **Dark Mode (Default/User Selected):** Background `#09090b` (zinc-950), text `#f4f4f5` (zinc-100), borders `#27272a` (zinc-800), card background `#18181b` (zinc-900), accent color `#6366f1` (indigo-500).
*   **Light Mode (Toggle Selected):** Background `#fafafa` (zinc-50), text `#09090b` (zinc-950), borders `#e4e4e7` (zinc-200), card background `#ffffff` (white), accent color `#4f46e5` (indigo-600).
*   **Typography:** System fonts or Outfit/Inter loaded from Google Fonts for a modern, sleek look.

### 5.2. Page Details
1.  **Home Page (`index.blade.php`):**
    *   **Hero Bento Item:** Name, big animated greeting, tagline, CV download button.
    *   **About Bento Item:** Elegant short bio with avatar.
    *   **Featured Projects Bento Item:** Slider or list of projects with `is_featured = true`.
    *   **Tech Stack Bento Item:** Grid of dynamic SVGs from `Skill` ordered by `order`.
    *   **Socials Bento Item:** Sleek icon grid.
    *   **Interactive Theme Switcher:** Float or navbar button with smooth micro-animations.
2.  **Projects List Page (`projects/index.blade.php`):**
    *   Grid of all projects.
    *   Simple filter header to filter projects.
3.  **Project Detail Page (`projects/show.blade.php`):**
    *   Cover image, title, repository links.
    *   **Tabbed Section:** Interactive tab switcher built with light JS/Alpine.js:
        *   *Tab 1: Deskripsi* (Rendered safe HTML of `desc_content`).
        *   *Tab 2: Arsitektur* (Rendered safe HTML of `arch_content` or structural data).
        *   *Tab 3: Cuplikan Kode* (Formatted code blocks with syntax highlighting).
4.  **Contact Page (`contact.blade.php`):**
    *   Clean minimal contact form.
    *   Submits asynchronously or via standard POST request. Upon success, displays an elegant, custom success toast/modal.

---

## 6. Testing & Verification Plan
*   **Database Migrations:** Run migrations and verify SQLite file creation.
*   **Seeding:** Write a standard database seeder containing initial mock data for profile, skills, and projects to instantly populate the site for review.
*   **Filament Admin Verification:** Log into `/admin`, test creating, editing, and sorting skills and projects. Test file uploading for avatar and PDF resumes.
*   **Frontend Verification:** Open pages locally, check responsive viewport breakpoints, click layout elements, test dark/light theme toggle persistence in LocalStorage, test tab switching on project details, and submit a contact inquiry to verify it appears in Filament's message list.

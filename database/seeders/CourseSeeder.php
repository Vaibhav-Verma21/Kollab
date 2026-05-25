<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::truncate();

        $courses = [

            // ── Design ──────────────────────────────────────────────────────────
            [
                'slug'        => 'uiux101',
                'title'       => 'Brutalist Interface Design',
                'domain'      => 'Design',
                'duration'    => '12 Weeks',
                'level'       => 'Beginner',
                'description' => 'Learn the rules so you can break them. A comprehensive guide to anti-design and editorial web layouts.',
                'theme_color' => 'bg-pink-200',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'motion-design',
                'title'       => 'Motion & Micro-Interaction',
                'domain'      => 'Design',
                'duration'    => '8 Weeks',
                'level'       => 'Intermediate',
                'description' => 'Craft delightful animations with CSS, GSAP, and Framer Motion. Transform static UIs into living products.',
                'theme_color' => 'bg-rose-300',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'design-systems',
                'title'       => 'Design Systems at Scale',
                'domain'      => 'Design',
                'duration'    => '10 Weeks',
                'level'       => 'Advanced',
                'description' => 'Build and maintain enterprise-grade design systems. Tokens, component libraries, documentation, and governance.',
                'theme_color' => 'bg-fuchsia-200',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'typography',
                'title'       => 'Editorial Typography',
                'domain'      => 'Design',
                'duration'    => '6 Weeks',
                'level'       => 'Beginner',
                'description' => 'Master type hierarchies, font pairing, and optical sizing. Turn blank canvases into reading experiences that hold attention.',
                'theme_color' => 'bg-amber-200',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],

            // ── Development ─────────────────────────────────────────────────────
            [
                'slug'        => 'fsdev',
                'title'       => 'Full-Stack Architecture',
                'domain'      => 'Development',
                'duration'    => '24 Weeks',
                'level'       => 'Advanced',
                'description' => 'Build robust, scalable systems using modern frameworks like Laravel, Vue, and high-performance databases.',
                'theme_color' => 'bg-blue-200',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'reactjs',
                'title'       => 'React & Next.js Mastery',
                'domain'      => 'Development',
                'duration'    => '16 Weeks',
                'level'       => 'Intermediate',
                'description' => 'From hooks to server components — build production-grade React apps with Next.js 14 and modern tooling.',
                'theme_color' => 'bg-sky-200',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'devops',
                'title'       => 'DevOps & CI/CD Pipelines',
                'domain'      => 'Development',
                'duration'    => '12 Weeks',
                'level'       => 'Intermediate',
                'description' => 'Containerise with Docker, orchestrate with Kubernetes, and automate deployments with GitHub Actions and Terraform.',
                'theme_color' => 'bg-cyan-300',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'api-design',
                'title'       => 'API Design & GraphQL',
                'domain'      => 'Development',
                'duration'    => '8 Weeks',
                'level'       => 'Intermediate',
                'description' => 'Design RESTful and GraphQL APIs that developers love. Versioning, auth, rate-limiting, and documentation best practices.',
                'theme_color' => 'bg-indigo-200',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],

            // ── Theory ──────────────────────────────────────────────────────────
            [
                'slug'        => 'sysarch',
                'title'       => 'Distributed Systems',
                'domain'      => 'Theory',
                'duration'    => '16 Weeks',
                'level'       => 'Advanced',
                'description' => 'Design scalable backend systems. Learn about microservices, caching, consensus, and database scaling.',
                'theme_color' => 'bg-yellow-300',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'algorithms',
                'title'       => 'Algorithms & Complexity',
                'domain'      => 'Theory',
                'duration'    => '14 Weeks',
                'level'       => 'Advanced',
                'description' => 'Sorting, graphs, dynamic programming, and NP-completeness — the concepts that separate great engineers from good ones.',
                'theme_color' => 'bg-lime-200',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'ml-foundations',
                'title'       => 'ML Foundations',
                'domain'      => 'Theory',
                'duration'    => '18 Weeks',
                'level'       => 'Intermediate',
                'description' => 'Linear algebra, probability, and gradient descent demystified. Build intuition before you touch a framework.',
                'theme_color' => 'bg-teal-200',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],

            // ── Business ────────────────────────────────────────────────────────
            [
                'slug'        => 'bizmgmt',
                'title'       => 'Startup Operations',
                'domain'      => 'Business',
                'duration'    => '10 Weeks',
                'level'       => 'Intermediate',
                'description' => 'From zero to one. Master the fundamentals of unit economics, supply chain management, and go-to-market strategies.',
                'theme_color' => 'bg-green-300',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'marketing',
                'title'       => 'Digital Marketing & SEO',
                'domain'      => 'Business',
                'duration'    => '8 Weeks',
                'level'       => 'Beginner',
                'description' => 'Dominate search rankings and craft high-converting ad campaigns. Stop guessing and start measuring.',
                'theme_color' => 'bg-purple-300',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'finance',
                'title'       => 'Corporate Finance',
                'domain'      => 'Business',
                'duration'    => '12 Weeks',
                'level'       => 'Intermediate',
                'description' => 'Valuation models, capital structures, and financial analysis for modern tech companies.',
                'theme_color' => 'bg-orange-300',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'product-mgmt',
                'title'       => 'Product Management',
                'domain'      => 'Business',
                'duration'    => '10 Weeks',
                'level'       => 'Intermediate',
                'description' => 'Roadmaps, PRDs, user research, and stakeholder communication. Learn to ship products that users actually want.',
                'theme_color' => 'bg-emerald-200',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'leadership',
                'title'       => 'Leadership & Team Dynamics',
                'domain'      => 'Business',
                'duration'    => '6 Weeks',
                'level'       => 'Intermediate',
                'description' => 'High-performance team building, conflict resolution, and executive communication for first-time and seasoned managers.',
                'theme_color' => 'bg-violet-200',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],

            // ── Data Science ─────────────────────────────────────────────────────
            [
                'slug'        => 'python-ds',
                'title'       => 'Python for Data Science',
                'domain'      => 'Data Science',
                'duration'    => '10 Weeks',
                'level'       => 'Beginner',
                'description' => 'NumPy, Pandas, Matplotlib — the essential toolkit to go from raw CSV to actionable insight in record time.',
                'theme_color' => 'bg-blue-300',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'deep-learning',
                'title'       => 'Deep Learning with PyTorch',
                'domain'      => 'Data Science',
                'duration'    => '20 Weeks',
                'level'       => 'Advanced',
                'description' => 'CNNs, transformers, diffusion models — build state-of-the-art neural networks from scratch and deploy them to production.',
                'theme_color' => 'bg-orange-200',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'data-viz',
                'title'       => 'Data Visualization & BI',
                'domain'      => 'Data Science',
                'duration'    => '8 Weeks',
                'level'       => 'Intermediate',
                'description' => 'Turn numbers into narratives with D3.js, Tableau, and Plotly. Tell compelling stories that drive decisions.',
                'theme_color' => 'bg-yellow-200',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'sql-analytics',
                'title'       => 'SQL & Analytics Engineering',
                'domain'      => 'Data Science',
                'duration'    => '6 Weeks',
                'level'       => 'Beginner',
                'description' => 'Window functions, CTEs, dbt, and data warehouse design. Become the analyst who can do it all in SQL.',
                'theme_color' => 'bg-green-200',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],

            // ── Cybersecurity ────────────────────────────────────────────────────
            [
                'slug'        => 'ethical-hacking',
                'title'       => 'Ethical Hacking',
                'domain'      => 'Cybersecurity',
                'duration'    => '14 Weeks',
                'level'       => 'Intermediate',
                'description' => 'Penetration testing, OWASP Top 10, and exploit development. Think like an attacker to defend like a pro.',
                'theme_color' => 'bg-red-200',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'network-security',
                'title'       => 'Network Security & Cryptography',
                'domain'      => 'Cybersecurity',
                'duration'    => '12 Weeks',
                'level'       => 'Intermediate',
                'description' => 'Firewalls, VPNs, TLS, and public-key cryptography explained from first principles to practical implementation.',
                'theme_color' => 'bg-slate-300',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'cloud-security',
                'title'       => 'Cloud Security & Compliance',
                'domain'      => 'Cybersecurity',
                'duration'    => '10 Weeks',
                'level'       => 'Advanced',
                'description' => 'IAM, zero-trust architecture, SOC 2, and securing AWS/GCP/Azure deployments at scale.',
                'theme_color' => 'bg-zinc-300',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],

            // ── Science ─────────────────────────────────────────────────────────
            [
                'slug'        => 'quantum-computing',
                'title'       => 'Quantum Computing Basics',
                'domain'      => 'Science',
                'duration'    => '10 Weeks',
                'level'       => 'Intermediate',
                'description' => 'Superposition, entanglement, and quantum gates — a hands-on introduction using IBM Qiskit and real quantum hardware.',
                'theme_color' => 'bg-purple-200',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'biotech',
                'title'       => 'Biotechnology & Genomics',
                'domain'      => 'Science',
                'duration'    => '12 Weeks',
                'level'       => 'Intermediate',
                'description' => 'CRISPR, gene sequencing, and synthetic biology. Understand how software and biology are converging to reshape medicine.',
                'theme_color' => 'bg-lime-300',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],

            // ── Health & Wellness ────────────────────────────────────────────────
            [
                'slug'        => 'sports-science',
                'title'       => 'Sports Science & Performance',
                'domain'      => 'Health & Wellness',
                'duration'    => '8 Weeks',
                'level'       => 'Beginner',
                'description' => 'Exercise physiology, periodisation, and recovery science. Optimise your body as rigorously as you optimise your code.',
                'theme_color' => 'bg-red-300',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'nutrition',
                'title'       => 'Nutrition & Metabolism',
                'domain'      => 'Health & Wellness',
                'duration'    => '6 Weeks',
                'level'       => 'Beginner',
                'description' => 'Macros, metabolic health, and evidence-based eating strategies. Separate nutrition science from fad-diet noise.',
                'theme_color' => 'bg-green-200',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
            [
                'slug'        => 'mindfulness',
                'title'       => 'Mindfulness & Cognitive Resilience',
                'domain'      => 'Health & Wellness',
                'duration'    => '4 Weeks',
                'level'       => 'Beginner',
                'description' => 'Stress regulation, deep focus, and cognitive load management. Science-backed techniques for high-output work.',
                'theme_color' => 'bg-sky-300',
                'video_url'   => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}

@extends('layouts.editorial')

@section('content')
<div class="flex-grow max-w-5xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 md:py-16">
    
    <div class="mb-4">
        <a href="#" class="font-mono text-sm uppercase hover:underline hover:text-blue-600">← Back to Course</a>
    </div>

    <div class="brutal-border bg-white brutal-shadow">
        <!-- Header -->
        <header class="border-b-2 border-black p-8 bg-yellow-300 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 text-[10rem] font-bold text-yellow-400 leading-none z-0 pointer-events-none uppercase">04</div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-black text-white font-mono text-xs uppercase px-2 py-1 font-bold">Assignment 04</span>
                    <span class="font-mono text-xs border-2 border-black px-2 py-1 bg-white font-bold text-red-600 uppercase">Due: Tomorrow 11:59 PM</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold uppercase tracking-tighter mb-4">Build a REST API with Go</h1>
                <p class="font-mono text-sm max-w-2xl bg-white/80 p-2 border border-black inline-block">
                    Apply your knowledge of goroutines and channels to build a high-performance concurrent API.
                </p>
            </div>
        </header>

        <div class="flex flex-col md:flex-row">
            <!-- Instructions -->
            <div class="w-full md:w-1/2 p-8 border-b-2 md:border-b-0 md:border-r-2 border-black bg-[#f4f3ef]">
                <h2 class="text-2xl font-bold uppercase mb-6 border-b-2 border-black pb-2">Requirements</h2>
                <div class="prose prose-sm font-mono max-w-none text-gray-800">
                    <p>Your API must implement the following endpoints:</p>
                    <ul class="list-disc pl-4 space-y-2 mb-4">
                        <li><code>GET /api/v1/status</code> - Returns server health.</li>
                        <li><code>POST /api/v1/process</code> - Accepts a JSON payload and processes it concurrently using goroutines.</li>
                    </ul>
                    <p class="font-bold">Evaluation Rubric:</p>
                    <div class="bg-white border border-black p-4 mt-2 mb-4">
                        <div class="flex justify-between border-b border-gray-300 pb-2 mb-2">
                            <span>Concurrency Safety</span>
                            <span class="font-bold">40%</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-300 pb-2 mb-2">
                            <span>Code Quality & Tests</span>
                            <span class="font-bold">40%</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Documentation</span>
                            <span class="font-bold">20%</span>
                        </div>
                    </div>
                    <div class="bg-blue-100 border-l-4 border-blue-600 p-4 text-xs">
                        <strong>Note:</strong> Automated tests will be run against your submission upon upload. Ensure `go test` passes locally.
                    </div>
                </div>
            </div>

            <!-- Submission Form -->
            <div class="w-full md:w-1/2 p-8 bg-white flex flex-col justify-center">
                <h2 class="text-2xl font-bold uppercase mb-6 border-b-2 border-black pb-2">Submit Work</h2>
                
                <form class="space-y-6 flex-grow flex flex-col">
                    <div>
                        <label class="block font-mono text-sm font-bold uppercase mb-2">GitHub Repository URL</label>
                        <input type="url" placeholder="https://github.com/username/repo" class="w-full brutal-border p-3 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 bg-[#f4f3ef]">
                    </div>
                    
                    <div class="flex-grow">
                        <label class="block font-mono text-sm font-bold uppercase mb-2">Additional Notes (Optional)</label>
                        <textarea rows="4" placeholder="Any specific instructions for the peer reviewer?" class="w-full h-full brutal-border p-3 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 bg-[#f4f3ef] resize-none"></textarea>
                    </div>

                    <div class="border-2 border-dashed border-black p-8 text-center bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer group">
                        <svg class="mx-auto h-8 w-8 text-gray-400 group-hover:text-black mb-2" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="font-mono text-sm text-gray-600 group-hover:text-black">Drag and drop artifacts here, or click to select</span>
                    </div>

                    <button type="button" class="w-full brutal-border bg-black text-white py-4 font-bold uppercase tracking-wider brutal-shadow hover-lift mt-auto">
                        Submit Assignment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

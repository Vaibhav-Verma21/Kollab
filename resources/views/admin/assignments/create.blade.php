@extends('layouts.editorial')

@section('content')
<div class="flex-grow max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 md:py-16">
    <div class="mb-4">
        <a href="{{ route('admin.dashboard') }}" class="font-mono text-sm uppercase hover:underline hover:text-blue-600">← Back to Dashboard</a>
    </div>

    @if($errors->any())
        <div class="bg-red-300 border-2 border-black p-4 mb-6 brutal-shadow-sm">
            <ul class="font-mono text-xs font-bold text-red-900 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="brutal-border bg-white brutal-shadow p-8">
        <h1 class="text-3xl font-bold uppercase tracking-tighter mb-8 border-b-2 border-black pb-2">Create New Assignment</h1>

        <form action="{{ route('admin.assignments.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="flex space-x-4">
                <div class="w-2/3">
                    <label class="block font-mono text-sm font-bold uppercase mb-2">Assignment Title</label>
                    <input type="text" name="title" required value="{{ old('title') }}" class="w-full brutal-border p-3 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 bg-[#f4f3ef]">
                </div>
                
                <div class="w-1/3">
                    <label class="block font-mono text-sm font-bold uppercase mb-2">Target Course</label>
                    <select name="course_id" required class="w-full brutal-border p-3 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 bg-[#f4f3ef]">
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-mono text-sm font-bold uppercase mb-2">Description / Requirements</label>
                <textarea name="description" required rows="5" class="w-full brutal-border p-3 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 bg-[#f4f3ef]">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block font-mono text-sm font-bold uppercase mb-2">Due Date</label>
                <input type="datetime-local" name="due_date" required value="{{ old('due_date') }}" class="w-full brutal-border p-3 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 bg-[#f4f3ef]">
            </div>

            <!-- Rubric Builder -->
            <div class="mt-8 border-t-4 border-black pt-6">
                <h2 class="text-2xl font-bold uppercase mb-2">Grading Rubric</h2>
                <p class="font-mono text-xs text-gray-500 mb-4">Define the criteria and their weights. Weights must add up to 100%.</p>
                
                <div id="rubric-container" class="space-y-4">
                    <div class="flex space-x-4 items-center rubric-row">
                        <div class="flex-grow">
                            <input type="text" name="rubric_names[]" placeholder="Criteria Name (e.g., Code Quality)" required class="w-full brutal-border p-2 font-mono text-sm">
                        </div>
                        <div class="w-32 flex items-center">
                            <input type="number" name="rubric_weights[]" placeholder="Weight" required min="1" max="100" class="w-20 brutal-border p-2 font-mono text-sm text-center">
                            <span class="ml-2 font-bold font-mono">%</span>
                        </div>
                        <button type="button" class="remove-rubric text-red-500 font-bold text-xl hover:text-red-700 w-8" disabled>×</button>
                    </div>
                </div>

                <button type="button" id="add-rubric" class="mt-4 border-2 border-black bg-gray-100 px-4 py-2 font-mono font-bold text-xs uppercase hover:bg-gray-200 transition-colors">+ Add Criteria</button>
            </div>

            <button type="submit" class="w-full brutal-border bg-black text-white py-4 font-bold uppercase tracking-wider brutal-shadow-sm hover-lift mt-8">
                Publish Assignment
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('rubric-container');
        const addButton = document.getElementById('add-rubric');

        function updateRemoveButtons() {
            const rows = container.querySelectorAll('.rubric-row');
            const btns = container.querySelectorAll('.remove-rubric');
            btns.forEach(btn => {
                btn.disabled = rows.length <= 1;
                btn.style.opacity = rows.length <= 1 ? '0.3' : '1';
            });
        }

        addButton.addEventListener('click', function() {
            const newRow = document.createElement('div');
            newRow.className = 'flex space-x-4 items-center rubric-row mt-4';
            newRow.innerHTML = `
                <div class="flex-grow">
                    <input type="text" name="rubric_names[]" placeholder="Criteria Name" required class="w-full brutal-border p-2 font-mono text-sm">
                </div>
                <div class="w-32 flex items-center">
                    <input type="number" name="rubric_weights[]" placeholder="Weight" required min="1" max="100" class="w-20 brutal-border p-2 font-mono text-sm text-center">
                    <span class="ml-2 font-bold font-mono">%</span>
                </div>
                <button type="button" class="remove-rubric text-red-500 font-bold text-xl hover:text-red-700 w-8 cursor-pointer">×</button>
            `;
            container.appendChild(newRow);
            updateRemoveButtons();
        });

        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-rubric') && !e.target.disabled) {
                e.target.closest('.rubric-row').remove();
                updateRemoveButtons();
            }
        });
        
        updateRemoveButtons();
    });
</script>
@endsection

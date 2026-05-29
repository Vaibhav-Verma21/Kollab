@extends('layouts.editorial')

@section('content')
<div class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 md:py-16">
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('admin.assignments.index') }}" class="font-mono text-sm uppercase hover:underline hover:text-blue-600">← Back to Assignments</a>
    </div>

    <div class="mb-8">
        <h1 class="text-3xl font-bold uppercase tracking-tighter mb-2">Submissions for: {{ $assignment->title }}</h1>
        <p class="font-mono text-sm text-gray-600">Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') }}</p>
    </div>

    @if(session('success'))
        <div class="bg-green-300 border-2 border-black p-4 font-mono font-bold text-center uppercase mb-6 brutal-shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white brutal-border brutal-shadow-sm p-6 overflow-x-auto">
        @if($submissions->isEmpty())
            <p class="font-mono text-center text-gray-500 py-8">No submissions yet.</p>
        @else
            <table class="w-full text-left font-mono text-sm border-collapse">
                <thead>
                    <tr class="border-b-2 border-black">
                        <th class="py-3 px-4 font-bold uppercase">Student</th>
                        <th class="py-3 px-4 font-bold uppercase">Status</th>
                        <th class="py-3 px-4 font-bold uppercase">GitHub URL</th>
                        <th class="py-3 px-4 font-bold uppercase">Grade</th>
                        <th class="py-3 px-4 font-bold uppercase">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submissions as $submission)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="py-3 px-4">{{ collect($users)->get($submission->user_id)->name ?? 'Unknown User' }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-{{ $submission->status === 'graded' ? 'green' : 'yellow' }}-200 border border-black text-xs uppercase font-bold">
                                {{ $submission->status }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ $submission->github_url }}" target="_blank" class="text-blue-600 hover:underline">View Repo</a>
                        </td>
                        <td class="py-3 px-4 font-bold">
                            {{ $submission->grade ?? '-' }}/100
                            @if($submission->graded_by)
                                <br><span class="text-[10px] text-red-500 font-normal uppercase">Admin Override</span>
                            @elseif($submission->grade !== null)
                                <br><span class="text-[10px] text-blue-500 font-normal uppercase">Peer Average</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <form action="{{ route('admin.submissions.grade', $submission->id) }}" method="POST" class="flex space-x-2">
                                @csrf
                                <input type="number" name="grade" min="0" max="100" placeholder="Grade" value="{{ $submission->grade }}" class="w-20 brutal-border px-2 py-1 focus:outline-none" required>
                                <button type="submit" class="brutal-border bg-black text-white px-3 py-1 hover:bg-gray-800 text-xs uppercase font-bold">Save</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection

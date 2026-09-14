<div class="bg-white p-4 rounded shadow mb-6 flex justify-between items-center">
    <h1 class="text-xl font-bold">{{ $title ?? 'Dashboard' }}</h1>
    <div class="flex items-center gap-4">
        <span>Halo, <strong>{{ auth()->user()->name ?? 'Guest' }}</strong></span>
    </div>
</div>

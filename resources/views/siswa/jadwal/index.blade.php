@extends('layouts.app')
@section('content')
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">Jadwal - Kelas {{ $student->kelas->name }} (Minggu {{ $weekType }})</h2>

    <div class="mb-6">
        <h3 class="font-medium">Pelajaran Hari Ini</h3>
        @if($schedules->isEmpty())
            <p>Tidak ada jadwal untuk hari ini.</p>
        @else
            <ul>
                @foreach($schedules as $s)
                    <li class="mb-2">
                        <strong>{{ $s->start_time }} - {{ $s->end_time }}</strong> — {{ $s->mapel?->name ?? $s->subject }} @if($s->room) ({{ $s->room }}) @endif<br>
                        <small>Guru: {{ $s->teacher?->name }}{{ $s->topic? ' • Materi: '.$s->topic : '' }}</small>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="mb-6">
        <h3 class="font-medium">Pelajaran yang Sedang Berlangsung</h3>
        @if($ongoing)
            <div class="p-4 border rounded">
                <h4 class="text-lg">{{ $ongoing->mapel?->name ?? $ongoing->subject }}</h4>
                <p>Guru: {{ $ongoing->teacher?->name }}</p>
                <p>Ruang: {{ $ongoing->room ?? '-' }}</p>
                <p>Materi: {{ $ongoing->topic ?? '-' }}</p>
                <p>Jam: {{ $ongoing->start_time }} - {{ $ongoing->end_time }}</p>
            </div>
        @else
            <p>Tidak ada pelajaran yang sedang berlangsung.</p>
        @endif
    </div>
</div>
@endsection

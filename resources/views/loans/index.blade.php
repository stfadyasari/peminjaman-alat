@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
  <h3 class="text-xl font-semibold text-gray-200 mb-4">Data Peminjaman</h3>

  <div class="bg-white/5 shadow-sm rounded-lg overflow-hidden">
    {{-- Desktop / Tablet: table --}}
    <div class="hidden sm:block overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-700 table-auto">
        <thead class="bg-gray-800">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-300 uppercase">#</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-300 uppercase">User</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-300 uppercase">Alat</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-300 uppercase">Periode</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-300 uppercase">Status</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-300 uppercase">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-transparent divide-y divide-gray-700">
          @forelse($loans as $loan)
          <tr class="hover:bg-white/2">
            <td class="px-6 py-4 text-sm text-gray-200 align-top">{{ $loan->id }}</td>
            <td class="px-6 py-4 text-sm text-gray-200 align-top">{{ optional($loan->user)->name }}</td>
            <td class="px-6 py-4 text-sm text-gray-200 align-top">{{ optional($loan->device)->name }}</td>
            <td class="px-6 py-4 text-sm text-gray-200 align-top">{{ $loan->start_date }} - {{ $loan->end_date }}</td>
            <td class="px-6 py-4 text-sm text-gray-200 align-top">{{ ucfirst($loan->status) }}</td>
            <td class="px-6 py-4 text-sm text-gray-200 align-top space-x-2">
              @if(auth()->user() && auth()->user()->role === 'petugas')
                @if($loan->status === 'pending')
                  <form method="POST" action="{{ route('loans.approve',$loan) }}" class="inline">@csrf
                    <button class="px-3 py-1 text-xs rounded bg-green-600 hover:bg-green-500 text-white">Setujui</button>
                  </form>
                  <form method="POST" action="{{ route('loans.reject',$loan) }}" class="inline">@csrf
                    <button class="px-3 py-1 text-xs rounded bg-yellow-600 hover:bg-yellow-500 text-white">Tolak</button>
                  </form>
                @endif
                @if($loan->status === 'approved')
                  <form method="POST" action="{{ route('loans.return',$loan) }}" class="inline">@csrf
                    <button class="px-3 py-1 text-xs rounded bg-blue-600 hover:bg-blue-500 text-white">Tandai Kembali</button>
                  </form>
                @endif
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="px-6 py-6 text-center text-gray-400">Belum ada data peminjaman.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Mobile: cards --}}
    <div class="sm:hidden p-4 space-y-3">
      @forelse($loans as $loan)
        <div class="bg-gray-800/40 border border-gray-700 rounded-lg p-4">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-300 font-medium">#{{ $loan->id }} — {{ optional($loan->user)->name }}</div>
            <div class="text-xs text-gray-400">{{ ucfirst($loan->status) }}</div>
          </div>
          <div class="mt-2 text-sm text-gray-200">Alat: {{ optional($loan->device)->name }}</div>
          <div class="mt-1 text-sm text-gray-200">Periode: {{ $loan->start_date }} - {{ $loan->end_date }}</div>
          <div class="mt-3 flex flex-wrap gap-2">
            @if(auth()->user() && auth()->user()->role === 'petugas')
              @if($loan->status === 'pending')
                <form method="POST" action="{{ route('loans.approve',$loan) }}">@csrf
                  <button class="px-3 py-1 text-xs rounded bg-green-600 hover:bg-green-500 text-white">Setujui</button>
                </form>
                <form method="POST" action="{{ route('loans.reject',$loan) }}">@csrf
                  <button class="px-3 py-1 text-xs rounded bg-yellow-600 hover:bg-yellow-500 text-white">Tolak</button>
                </form>
              @endif
              @if($loan->status === 'approved')
                <form method="POST" action="{{ route('loans.return',$loan) }}">@csrf
                  <button class="px-3 py-1 text-xs rounded bg-blue-600 hover:bg-blue-500 text-white">Tandai Kembali</button>
                </form>
              @endif
            @endif
          </div>
        </div>
      @empty
        <div class="text-center text-gray-400">Belum ada data peminjaman.</div>
      @endforelse
    </div>
  </div>

  <div class="mt-4 flex justify-center">
    {{ $loans->links() }}
  </div>
</div>
@endsection

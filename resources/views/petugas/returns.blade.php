@extends('layouts.petugas')

@section('page_title', 'Pantau Pengembalian')
@section('page_subtitle', 'Memantau status pengembalian alat')

@section('content')
<div class="mb-3">
  <div class="text-muted">Lihat status pengembalian beserta kondisi barang dan denda yang diinput peminjam.</div>
</div>

<div class="card panel-card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="px-4 py-3">ID</th>
            <th class="px-4 py-3">Peminjam</th>
            <th class="px-4 py-3">Alat</th>
            <th class="px-4 py-3">Kondisi</th>
            <th class="px-4 py-3">Nominal Denda</th>
            <th class="px-4 py-3">Tipe Denda</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Denda</th>
            <th class="px-4 py-3">Tanggal Kembali</th>
            <th class="px-4 py-3">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($loans as $loan)
            @php
              $returnedAt = optional($loan->returned_at)->format('d-m-Y H:i') ?? '-';
              $fineAmount = 'Rp '.number_format((float) ($loan->fine_amount ?? 0), 0, ',', '.');
              $returnStatusLabel = $loan->status === 'returned' ? 'Dikembalikan' : 'Belum Dikembalikan';
              $returnStatusBadgeClass = $loan->status === 'returned' ? 'primary' : 'warning';
              $finePaymentStatusLabel = '-';
              $finePaymentStatusBadgeClass = null;

              if ((float) ($loan->fine_amount ?? 0) > 0) {
                  if ($loan->payment_method === 'none' || !$loan->payment_method) {
                      $finePaymentStatusLabel = 'Belum Lunas';
                      $finePaymentStatusBadgeClass = 'danger';
                  } else {
                      $finePaymentStatusLabel = 'Lunas';
                      $finePaymentStatusBadgeClass = 'success';
                  }
              }

              $phoneNumber = preg_replace('/\D+/', '', (string) ($loan->user->phone ?? ''));
              if (str_starts_with($phoneNumber, '0')) {
                  $phoneNumber = '62'.substr($phoneNumber, 1);
              } elseif ($phoneNumber !== '' && !str_starts_with($phoneNumber, '62')) {
                  $phoneNumber = '62'.$phoneNumber;
              }
              $waMessage = rawurlencode(
                  "Halo {$loan->user->name}, pengembalian alat untuk peminjaman #{$loan->id} sudah selesai.\n"
                  ."Alat: ".($loan->device->name ?? '-')."\n"
                  ."Kondisi: ".($loan->return_condition ?: '-')."\n"
                  ."Denda: {$fineAmount}\n"
                  ."Tanggal kembali: {$returnedAt}\n"
                  ."Status: {$returnStatusLabel}\n"
                  ."Status denda: {$finePaymentStatusLabel}"
              );
            @endphp
            <tr>
              <td class="px-4 py-3">{{ $loans->firstItem() + $loop->index }}</td>
              <td class="px-4 py-3">{{ $loan->user->name ?? '-' }}</td>
              <td class="px-4 py-3">{{ $loan->device->name ?? '-' }}</td>
              <td class="px-4 py-3 text-capitalize">{{ $loan->return_condition ?: '-' }}</td>
              <td class="px-4 py-3">Rp {{ number_format((float) ($loan->fine_amount ?? 0), 0, ',', '.') }}</td>
              <td class="px-4 py-3">{{ $loan->fineTypeLabel() }}</td>
              <td class="px-4 py-3">
                <span class="badge text-bg-{{ $returnStatusBadgeClass }}">
                  {{ $returnStatusLabel }}
                </span>
              </td>
              <td class="px-4 py-3">
                @if($finePaymentStatusBadgeClass && $finePaymentStatusLabel === 'Belum Lunas')
                  <a href="{{ route('petugas.returns.payment.form', $loan) }}" class="badge text-bg-{{ $finePaymentStatusBadgeClass }} text-decoration-none">
                    {{ $finePaymentStatusLabel }}
                  </a>
                @elseif($finePaymentStatusBadgeClass)
                  <span class="badge text-bg-{{ $finePaymentStatusBadgeClass }}">
                    {{ $finePaymentStatusLabel }}
                  </span>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td class="px-4 py-3">{{ optional($loan->returned_at)->format('d-m-Y H:i') ?? '-' }}</td>
              <td class="px-4 py-3">
                @if($loan->status === 'approved')
                  <a href="{{ route('petugas.returns.form', $loan) }}" class="btn btn-primary btn-sm">
                    Tandai Sudah Kembali
                  </a>
                @elseif($phoneNumber !== '')
                  <a href="https://wa.me/{{ $phoneNumber }}?text={{ $waMessage }}" target="_blank" rel="noopener noreferrer" class="btn btn-success btn-sm">
                    <i class="bi bi-whatsapp me-1"></i> Kirim WA
                  </a>
                @else
                  <span class="text-muted small">No. WA belum ada</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="10" class="text-center text-muted py-5">Belum ada data pengembalian.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="mt-3">
  {{ $loans->links() }}
</div>
@endsection

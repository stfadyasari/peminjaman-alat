@extends('layouts.petugas')

@section('page_title', 'Form Pelunasan')
@section('page_subtitle', 'Isi detail pelunasan denda pengembalian')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div class="text-muted">Pilih metode pembayaran untuk menyelesaikan denda pengembalian.</div>
  <a href="{{ route('petugas.returns') }}" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left me-1"></i> Kembali
  </a>
</div>

<div class="row g-4">
  <div class="col-lg-5">
    <div class="card panel-card">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-3">Data Pelunasan</h5>
        <div class="mb-3">
          <div class="text-muted small">ID Peminjaman</div>
          <div class="fw-semibold">#{{ $loan->id }}</div>
        </div>
        <div class="mb-3">
          <div class="text-muted small">Peminjam</div>
          <div class="fw-semibold">{{ $loan->user->name ?? '-' }}</div>
        </div>
        <div class="mb-3">
          <div class="text-muted small">Nama Alat</div>
          <div class="fw-semibold">{{ $loan->device->name ?? '-' }}</div>
        </div>
        <div class="mb-3">
          <div class="text-muted small">Kondisi Barang</div>
          <div class="fw-semibold text-capitalize">{{ $loan->return_condition ?: '-' }}</div>
        </div>
        <div class="mb-3">
          <div class="text-muted small">Tanggal Pengembalian</div>
          <div class="fw-semibold">{{ optional($loan->returned_at)->format('d-m-Y H:i') ?? '-' }}</div>
        </div>
        <div class="rounded-3 border bg-light p-3">
          <div class="small text-muted mb-1">Nominal denda yang harus dilunasi</div>
          <div class="text-primary fw-bold fs-4">Rp {{ number_format((float) ($loan->fine_amount ?? 0), 0, ',', '.') }}</div>
          <div class="small text-muted mt-1">{{ $loan->fineTypeLabel() }}</div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="card panel-card">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-3">Form Pelunasan Denda</h5>
        <form method="POST" action="{{ route('loans.settle-payment', $loan) }}">
          @csrf

          <div class="mb-3">
            <label class="form-label fw-semibold">Metode Pembayaran</label>
            <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
              <option value="">Pilih metode pembayaran</option>
              <option value="tunai" {{ old('payment_method') === 'tunai' ? 'selected' : '' }}>Tunai</option>
              <option value="qris" {{ old('payment_method') === 'qris' ? 'selected' : '' }}>QRIS</option>
            </select>
            @error('payment_method')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div id="qrisPreviewCard" class="card border-0 bg-light mb-4" style="display: none;">
            <div class="card-body p-3">
              <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div>
                  <div class="fw-semibold">Pembayaran QRIS</div>
                  <div class="text-muted small">Tunjukkan kode ini kepada peminjam untuk proses pelunasan.</div>
                </div>
                <span class="badge text-bg-dark">QRIS</span>
              </div>
              <img src="{{ asset('images/qris-placeholder.svg') }}" alt="Kode QRIS pembayaran" class="img-fluid rounded-3 border">
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold">Catatan Pelunasan</label>
            <textarea name="note" rows="4" class="form-control @error('note') is-invalid @enderror" placeholder="Tambahkan catatan bila diperlukan">{{ old('note') }}</textarea>
            @error('note')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="d-flex flex-wrap gap-2">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-check-circle me-1"></i> Simpan Pelunasan
            </button>
            <a href="{{ route('petugas.returns') }}" class="btn btn-outline-secondary">
              Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  (() => {
    const paymentMethod = document.getElementById('payment_method');
    const qrisPreviewCard = document.getElementById('qrisPreviewCard');

    const syncPaymentMethod = () => {
      qrisPreviewCard.style.display = paymentMethod.value === 'qris' ? 'block' : 'none';
    };

    paymentMethod.addEventListener('change', syncPaymentMethod);
    syncPaymentMethod();
  })();
</script>
@endpush

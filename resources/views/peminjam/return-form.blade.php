@extends('layouts.peminjam')

@section('page_title', 'Form Pengembalian')
@section('page_subtitle', 'Isi detail pengembalian alat yang sedang dipinjam')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div class="text-muted">Periksa data barang yang dipinjam, lalu pilih tipe denda yang sesuai.</div>
  <a href="{{ route('peminjam.returns') }}" class="btn btn-outline-secondary">
    <i class="bi bi-arrow-left me-1"></i> Kembali
  </a>
</div>

<div class="row g-4">
  <div class="col-lg-5">
    <div class="card panel-card">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-3">Data Barang Dipinjam</h5>
        <div class="mb-3">
          <div class="text-muted small">ID Peminjaman</div>
          <div class="fw-semibold">#{{ $loan->id }}</div>
        </div>
        <div class="mb-3">
          <div class="text-muted small">Nama Alat</div>
          <div class="fw-semibold">{{ $loan->device->name ?? '-' }}</div>
        </div>
        <div class="mb-3">
          <div class="text-muted small">Jumlah Dipinjam</div>
          <div class="fw-semibold">{{ $loan->quantity ?? 1 }} unit</div>
        </div>
        <div class="mb-3">
          <div class="text-muted small">Kategori</div>
          <div class="fw-semibold">{{ $loan->device->category->name ?? '-' }}</div>
        </div>
        <div class="mb-3">
          <div class="text-muted small">Tanggal Pinjam</div>
          <div class="fw-semibold">{{ $loan->start_date }}</div>
        </div>
        <div>
          <div class="text-muted small">Batas Kembali</div>
          <div class="fw-semibold">{{ $loan->end_date ?? '-' }}</div>
        </div>
        <div class="rounded-3 border bg-light p-3 mt-3">
          <div class="small text-muted mb-1">Estimasi denda otomatis keterlambatan</div>
          <div class="fw-semibold">Terlambat {{ $lateDays }} hari</div>
          <div class="text-primary fw-bold">Rp {{ number_format($automaticFineAmount, 0, ',', '.') }}</div>
          <div class="small text-muted mt-1">Rumus: {{ $lateDays }} x Rp 2.000 per hari</div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="card panel-card">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-3">Isi Pengembalian</h5>
        <form method="POST" action="{{ route('loans.return', $loan) }}">
          @csrf

          <div class="mb-3">
            <label class="form-label fw-semibold">Kondisi Barang</label>
            <select name="return_condition" class="form-select @error('return_condition') is-invalid @enderror" required>
              <option value="">Pilih kondisi barang</option>
              <option value="baik" {{ old('return_condition') === 'baik' ? 'selected' : '' }}>Baik</option>
              <option value="rusak ringan" {{ old('return_condition') === 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
              <option value="rusak berat" {{ old('return_condition') === 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
              <option value="hilang" {{ old('return_condition') === 'hilang' ? 'selected' : '' }}>Hilang</option>
            </select>
            @error('return_condition')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold d-block">Tipe Denda</label>

            <div class="form-check border rounded-3 p-3 mb-2">
              <input class="form-check-input" type="radio" name="fine_type" id="fine_type_auto" value="auto_late" {{ old('fine_type', 'auto_late') === 'auto_late' ? 'checked' : '' }}>
              <label class="form-check-label w-100" for="fine_type_auto">
                <span class="fw-semibold d-block">Otomatis Keterlambatan</span>
                <span class="text-muted small">Dihitung otomatis Rp 2.000 per hari terlambat.</span>
              </label>
            </div>

            <div class="form-check border rounded-3 p-3">
              <input class="form-check-input" type="radio" name="fine_type" id="fine_type_manual" value="manual_damage" {{ old('fine_type') === 'manual_damage' ? 'checked' : '' }}>
              <label class="form-check-label w-100" for="fine_type_manual">
                <span class="fw-semibold d-block">Manual Kerusakan</span>
                <span class="text-muted small">Input nominal denda sendiri untuk barang rusak atau kehilangan.</span>
              </label>
            </div>
            @error('fine_type')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
          </div>

          <div id="automaticFineInfo" class="alert alert-info mb-3">
            Denda otomatis yang akan disimpan adalah <strong>Rp {{ number_format($automaticFineAmount, 0, ',', '.') }}</strong>
            untuk keterlambatan <strong>{{ $lateDays }} hari</strong>.
          </div>

          <div id="manualFineFields" class="border rounded-3 p-3 mb-3" style="display: none;">
            <div class="mb-3">
              <label class="form-label fw-semibold">Nominal Denda Kerusakan</label>
              <input
                type="number"
                min="0"
                step="1000"
                name="manual_fine_amount"
                value="{{ old('manual_fine_amount', $loan->fine_amount) }}"
                class="form-control @error('manual_fine_amount') is-invalid @enderror"
                placeholder="Contoh: 10000"
              >
              @error('manual_fine_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div>
              <label class="form-label fw-semibold">Catatan Kerusakan</label>
              <textarea name="manual_fine_note" rows="3" class="form-control @error('manual_fine_note') is-invalid @enderror" placeholder="Contoh: layar retak, tombol rusak, casing pecah">{{ old('manual_fine_note') }}</textarea>
              @error('manual_fine_note')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Metode Pembayaran</label>
            <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
              <option value="">Pilih metode pembayaran</option>
              <option value="cash" {{ old('payment_method', $loan->payment_method) === 'cash' ? 'selected' : '' }}>Tunai</option>
              <option value="qris" {{ old('payment_method', $loan->payment_method) === 'qris' ? 'selected' : '' }}>QRIS</option>
            </select>
            @error('payment_method')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div id="qrisPreviewCard" class="card border-0 bg-light mb-4" style="display: none;">
            <div class="card-body p-3">
              <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div>
                  <div class="fw-semibold">Pembayaran QRIS</div>
                  <div class="text-muted small">Scan kode ini untuk membayar denda pengembalian.</div>
                </div>
                <span class="badge text-bg-dark">QRIS</span>
              </div>
              <img src="{{ asset('images/qris-placeholder.svg') }}" alt="Kode QRIS pembayaran" class="img-fluid rounded-3 border">
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold">Catatan Pengembalian</label>
            <textarea name="note" rows="4" class="form-control @error('note') is-invalid @enderror" placeholder="Tambahkan catatan bila diperlukan">{{ old('note') }}</textarea>
            @error('note')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="d-flex flex-wrap gap-2">
            <button type="submit" class="btn btn-warning text-white">
              <i class="bi bi-check-circle me-1"></i> Kirim Pengembalian
            </button>
            <a href="{{ route('peminjam.returns') }}" class="btn btn-outline-secondary">
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
    const autoInput = document.getElementById('fine_type_auto');
    const manualInput = document.getElementById('fine_type_manual');
    const autoInfo = document.getElementById('automaticFineInfo');
    const manualFields = document.getElementById('manualFineFields');
    const paymentMethod = document.getElementById('payment_method');
    const qrisPreviewCard = document.getElementById('qrisPreviewCard');

    const syncFineFields = () => {
      const isManual = manualInput.checked;
      manualFields.style.display = isManual ? 'block' : 'none';
      autoInfo.style.display = isManual ? 'none' : 'block';
    };

    const syncPaymentMethod = () => {
      qrisPreviewCard.style.display = paymentMethod.value === 'qris' ? 'block' : 'none';
    };

    autoInput.addEventListener('change', syncFineFields);
    manualInput.addEventListener('change', syncFineFields);
    paymentMethod.addEventListener('change', syncPaymentMethod);
    syncFineFields();
    syncPaymentMethod();
  })();
</script>
@endpush

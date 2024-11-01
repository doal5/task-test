@extends('layouts.master')
@section('content')
    <div class="card">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card-header">
            <a href="{{ route('home.tambah') }}">
                <button class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> tugas baru
                </button>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th width="30%">Status</th>
                            <th width="10%"><i class="fa fa-gears"></i></th>
                            <th width="10%">gambar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $item)
                            <tr id="row-{{ $item->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>
                                    <div id="alert-container"></div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input shadow status-radio" type="radio"
                                            name="status_{{ $item->id }}" value="belum selesai"
                                            {{ $item->status === 'belum selesai' ? 'checked' : '' }}>
                                        <label class="form-check-label">Belum Selesai</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input shadow status-radio" type="radio"
                                            name="status_{{ $item->id }}" value="selesai"
                                            {{ $item->status === 'selesai' ? 'checked' : '' }}>
                                        <label class="form-check-label">Selesai</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-danger btn-sm" onclick="hapus({{ $item->id }})"><i
                                                class="fa fa-trash"></i> hapus</button>
                                    </div>
                                </td>
                                <td>
                                    @if ($item->gambar && Storage::disk('public')->exists($item->gambar))
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $item->gambar) }}"
                                                alt="Gambar {{ $item->nama }}" width="100" class="img-thumbnail">
                                        </div>
                                    @endif
                                    <form id="upload-form-{{ $item->id }}"
                                        action="{{ route('home.upload', $item->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="gambar" class="form-control"
                                            onchange="document.getElementById('upload-form-{{ $item->id }}').submit();">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $(".status-radio").change(function() {
                const status = $(this).val();
                const taskId = $(this).attr("name").split("_")[
                    1]; //mengambil ID berdasarkan nama radio button + id
                $.ajax({
                    type: "put",
                    url: "{{ url('updateStatus') }}/" + taskId,
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status,
                    },
                    success: function(response) {
                        // Tampilkan alert sukses Bootstrap
                        $("#alert-container").html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Status berhasil diperbarui.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                    },
                });
            });
        });

        function hapus(id) {
            if (confirm("Apakah Anda yakin ingin menghapus item ini?")) {
                $.ajax({
                    url: "hapusTugas/" + id, // Ubah URL sesuai route delete Anda
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}", // Token CSRF dari blade
                    },
                    success: function(response) {
                        // Tampilkan alert sukses Bootstrap
                        $("#alert-container").html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Item berhasil dihapus.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                        // Hapus baris tabel setelah penghapusan berhasil
                        $("#row-" + id).remove();
                    },
                    error: function(xhr) {
                        // Tampilkan alert error Bootstrap
                        $("#alert-container").html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Terjadi kesalahan: ${xhr.responseText}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                    },
                });
            }
        }
    </script>
@endpush

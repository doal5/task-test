@extends('layouts.master')
@section('content')
    <div class="card shadow mb-5 mt-5">
        <div class="card-header">
            <h5>Form Tambah Tugas Baru</h5>
        </div>
        <div class="card-body text-capitalize ">
            <form action="{{ route('home.simpan') }}" method="POST">
                @csrf
                <div class="col-md-7 mb-3">
                    <label for="nama">nama</label>
                    <input type="text" class="form-control shadow" name="nama" required placeholder="Masukan Nama Tugas">
                </div>
                <div class="mb-3">
                    <label for="deskripsi">deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control shadow" cols="10" rows="10"></textarea>
                </div>
                <button class="btn btn-primary" type="submit">simpan</button>
            </form>
        </div>
    </div>
@endsection

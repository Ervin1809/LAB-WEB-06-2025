@extends('layouts.app')

@section('title','Tambah Ikan')

@section('content')
<h2 class="text-xl font-bold mb-4 text-white">Tambah Ikan Baru</h2>

<form action="{{ route('fishes.store') }}" method="POST"
      class="bg-[#1e2a38] text-gray-200 p-6 rounded shadow border border-gray-700">
  @csrf

  @include('fishes._form', ['fish' => null])

  <div class="mt-6 flex items-center gap-3">
    <button type="submit" 
            class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded">
      Simpan
    </button>

    <a href="{{ route('fishes.index') }}" 
       class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded text-center">
       Batal
    </a>
  </div>
</form>
@endsection

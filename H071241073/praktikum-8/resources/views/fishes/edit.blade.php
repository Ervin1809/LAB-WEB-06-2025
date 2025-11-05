@extends('layouts.app')

@section('title','Edit Ikan')

@section('content')
<h2 class="text-xl font-bold mb-4 text-white">Edit Ikan</h2>

<form action="{{ route('fishes.update', $fish->id) }}" method="POST"
      class="bg-[#1e2a38] text-gray-200 p-6 rounded shadow border border-gray-700">
  @csrf
  @method('PUT')

  @include('fishes._form', ['fish' => $fish])

  <div class="mt-6 flex items-center gap-3">
    <button type="submit" 
            class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded">
      Update
    </button>

    <a href="{{ route('fishes.index') }}" 
       class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded text-center">
      Batal
    </a>
  </div>
</form>
@endsection

@extends('template.master')
@section('title','Kontak')

@section('content')
  {{-- overlay tipis biar kontras di atas background --}}
  <div class="fixed inset-0 bg-black/30 pointer-events-none -z-10"></div>

  <section class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl sm:text-4xl font-semibold text-center mb-8">Kontak</h1>

    <form action=""
          class="mx-auto max-w-xl bg-white/10 ring-1 ring-white/20 backdrop-blur
                 rounded-2xl p-6 sm:p-8 shadow-[0_10px_40px_rgba(0,0,0,.35)] space-y-5">

      {{-- Username --}}
      <div>
        <label for="username" class="block text-sm font-medium text-white/90">Username</label>
        <input type="text" name="username" id="username" placeholder="Username"
               class="mt-2 w-full rounded-xl bg-white/10 text-white placeholder-white/60
                      ring-1 ring-white/25 focus:ring-2 focus:ring-white/60
                      outline-none px-4 py-2.5 transition">
      </div>

      {{-- Email --}}
      <div>
        <label for="email" class="block text-sm font-medium text-white/90">Email</label>
        <input type="email" name="email" id="email" placeholder="nama@contoh.com"
               class="mt-2 w-full rounded-xl bg-white/10 text-white placeholder-white/60
                      ring-1 ring-white/25 focus:ring-2 focus:ring-white/60
                      outline-none px-4 py-2.5 transition">
      </div>

      {{-- Phone --}}
      <div>
        <label for="phone" class="block text-sm font-medium text-white/90">Phone</label>
        <input type="text" name="phone" id="phone" placeholder="08xxxxxxxxxx"
               class="mt-2 w-full rounded-xl bg-white/10 text-white placeholder-white/60
                      ring-1 ring-white/25 focus:ring-2 focus:ring-white/60
                      outline-none px-4 py-2.5 transition">
      </div>

      {{-- Pesan --}}
      <div>
        <label for="pesan" class="block text-sm font-medium text-white/90">Pesan</label>
        {{-- kalau butuh input satu baris, pakai input di bawah; kalau mau paragraf, ganti ke textarea: --}}
        {{-- <textarea id="pesan" name="pesan" rows="4" placeholder="Tulis pesanmu di sini..."
                  class="mt-2 w-full rounded-xl bg-white/10 text-white placeholder-white/60
                         ring-1 ring-white/25 focus:ring-2 focus:ring-white/60
                         outline-none px-4 py-3 transition"></textarea> --}}
        <input type="text" name="pesan" id="pesan" placeholder="Tulis pesan singkat"
               class="mt-2 w-full rounded-xl bg-white/10 text-white placeholder-white/60
                      ring-1 ring-white/25 focus:ring-2 focus:ring-white/60
                      outline-none px-4 py-2.5 transition">
      </div>

      {{-- Tombol --}}
      <div class="pt-2">
        <button type="submit"
                class="w-full inline-flex items-center justify-center gap-2
                       rounded-xl bg-white/20 hover:bg-white/30
                       ring-1 ring-white/30 text-white font-medium
                       px-5 py-2.5 transition">
          <i class="fa-solid fa-paper-plane"></i>
          Kirim
        </button>
      </div>

     
    </form>
  </section>
@endsection

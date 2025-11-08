<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  <div>
    <label class="block mb-1 text-gray-200">Nama ikan</label>
    <input type="text" name="name" value="{{ old('name', $fish->name ?? '') }}" 
           class="w-full p-2 rounded bg-gray-800 text-gray-200 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500" />
    @error('name')<div class="text-red-600 mt-1">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block mb-1 text-gray-200">Rarity</label>
    <select name="rarity" 
            class="w-full p-2 rounded bg-gray-800 text-gray-200 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500">
      @foreach(['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'] as $r)
        <option value="{{ $r }}" {{ old('rarity', $fish->rarity ?? '') == $r ? 'selected' : '' }}>
          {{ $r }}
        </option>
      @endforeach
    </select>
    @error('rarity')<div class="text-red-600 mt-1">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block mb-1 text-gray-200">Berat minimum (kg)</label>
    <input type="number" step="0.01" name="base_weight_min" value="{{ old('base_weight_min', $fish->base_weight_min ?? '') }}" 
           class="w-full p-2 rounded bg-gray-800 text-gray-200 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500" />
    @error('base_weight_min')<div class="text-red-600 mt-1">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block mb-1 text-gray-200">Berat maksimum (kg)</label>
    <input type="number" step="0.01" name="base_weight_max" value="{{ old('base_weight_max', $fish->base_weight_max ?? '') }}" 
           class="w-full p-2 rounded bg-gray-800 text-gray-200 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500" />
    @error('base_weight_max')<div class="text-red-600 mt-1">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block mb-1 text-gray-200">Harga jual per kg (Coins)</label>
    <input type="number" name="sell_price_per_kg" value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg ?? '') }}" 
           class="w-full p-2 rounded bg-gray-800 text-gray-200 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500" />
    @error('sell_price_per_kg')<div class="text-red-600 mt-1">{{ $message }}</div>@enderror
  </div>

  <div>
    <label class="block mb-1 text-gray-200">Peluang tertangkap (%)</label>
    <input type="number" step="0.01" name="catch_probability" value="{{ old('catch_probability', $fish->catch_probability ?? '') }}" 
           class="w-full p-2 rounded bg-gray-800 text-gray-200 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500" />
    @error('catch_probability')<div class="text-red-600 mt-1">{{ $message }}</div>@enderror
  </div>

  <div class="md:col-span-2">
    <label class="block mb-1 text-gray-200">Deskripsi (opsional)</label>
    <textarea name="description" rows="4" 
              class="w-full p-2 rounded bg-gray-800 text-gray-200 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('description', $fish->description ?? '') }}</textarea>
    @error('description')<div class="text-red-600 mt-1">{{ $message }}</div>@enderror
  </div>
</div>

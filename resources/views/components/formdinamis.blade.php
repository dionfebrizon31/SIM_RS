<div class="mb-3 flex items-center gap-4">
    <!-- Label: Lebar 1/3 pada layar lebih besar -->
    <label for="{{ $tittle }}"
        class="text-sm font-semibold {{ $styletext }} flex-shrink-0 sm:w-1/3">{{ $tittle }}</label>

    <!-- Input field: Lebar 2/3 pada layar lebih besar -->
    <input type="{{ $tipe }}"
        class="form-input w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500 sm:w-2/3"
        name="{{ $send }}" value="{{ $value }}">
</div>

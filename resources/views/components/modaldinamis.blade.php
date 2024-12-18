<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label"
    aria-hidden="true">
    <div class="modal-dialog {{ $size }}">
        <div class="modal-content">
            <div class="modal-header bg-slate-100">
                <h1 class="modal-title fs-5" id="{{ $id }}Label">{{ $tittle }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-slate-200">
                {{ $slot }}

            </div>


        </div>
    </div>
</div>

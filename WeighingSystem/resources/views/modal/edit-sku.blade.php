<button style="outline: none;box-shadow: none;" class="btn btn-sm btn-icon mb-0 me-2 border-0" data-bs-toggle="modal"
    data-bs-target="#editSKUModal-{{ $sku->id }}">
    <span class="btn-inner--icon">
        <i class="fa-solid fa-pen-to-square"></i>
    </span>
    {{-- <span class="btn-inner--text">Add Parameter</span> --}}
</button>
<button style="outline: none;box-shadow: none;" class="btn btn-sm btn-icon mb-0 me-2 border-0" data-bs-toggle="modal"
    data-bs-target="#deleteSKUModal-{{ $sku->id }}">
    <span class="btn-inner--icon">
        <i class="fa-solid fa-trash"></i>
    </span>
    {{-- <span class="btn-inner--text">Add Parameter</span> --}}
</button>

<!-- Modal -->
<div class="modal fade" id="editSKUModal-{{ $sku->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="/edit_sku">
                @method('put')
                @csrf
                <input type="text" class="form-control" id="sku-id" name="id" value="{{ $sku->id }}"
                    hidden required>
                <input type="text" class="form-control" id="sku-name" name="sku_name" value="{{ $sku->sku_name }}"
                    hidden required>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit {{ $sku->sku_name }}
                    </h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="sku-target" class="col-form-label">Target:</label>
                        <input type="number" step="any" class="form-control @error('target') is-invalid @enderror"
                            id="sku-target" name="target" value="{{ old('target', $sku->target) }}">
                        @error('target')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="sku-th-H" class="col-form-label">Threshold High:</label>
                        <input type="number" step="any" class="form-control @error('th_H') is-invalid @enderror"
                            id="sku-th-H" name="th_H" value="{{ old('th_H', $sku->th_H) }}">
                        @error('th_H')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="sku-th-L" class="col-form-label">Threshold Low:</label>
                        <input type="number" step="any" class="form-control @error('th_L') is-invalid @enderror"
                            id="sku-th-L" name="th_L" value="{{ old('th_L', $sku->th_L) }}">
                        @error('th_L')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteSKUModal-{{ $sku->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="/delete_sku">
                @method('delete')
                @csrf
                <input type="text" class="form-control" id="sku-id" name="id" value="{{ $sku->id }}"
                    hidden required>
                <input type="text" class="form-control" id="sku-name" name="sku_name" value="{{ $sku->sku_name }}"
                    hidden required>
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="py-3 text-center">
                        <i class="ni ni-bell-55 ni-3x"></i>
                        <h4 class="text-gradient text-danger mt-4">Delete {{ $sku->sku_name }} ?</h4>
                        <p>You will not be able to restore deleted SKU.
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

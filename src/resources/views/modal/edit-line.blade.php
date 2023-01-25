<button style="outline: none;box-shadow: none;" class="btn btn-sm btn-icon mb-0 me-2 border-0" data-bs-toggle="modal"
    data-bs-target="#deleteLineModal-{{ $line->id }}">
    <span class="btn-inner--icon">
        <i class="fa-solid fa-trash"></i>
    </span>
</button>

<!-- Modal -->
<div class="modal fade" id="deleteLineModal-{{ $line->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="/delete_line">
                @method('delete')
                @csrf
                <input type="text" class="form-control" id="line-id" name="id" value="{{ $line->id }}"
                    hidden required>
                <input type="text" class="form-control" id="line-name" name="line_name"
                    value="{{ $line->line_name }}" hidden required>
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="py-3 text-center">
                        <i class="ni ni-bell-55 ni-3x"></i>
                        <h4 class="text-gradient text-danger mt-4">Delete {{ $line->line_name }} ?</h4>
                        <p>You will not be able to restore deleted Line.
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

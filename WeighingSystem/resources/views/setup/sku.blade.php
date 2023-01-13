@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-12">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">SKU list</h6>
                            <p class="text-sm">See information about all SKU.</p>
                        </div>
                        <div class="ms-auto d-flex">
                            {{-- <button type="button" class="btn btn-sm btn-white me-2">
                                View all
                            </button> --}}
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2"
                                data-bs-toggle="modal" data-bs-target="#addSKUModal">
                                <span class="btn-inner--icon me-2">
                                    <i class="fa-solid fa-plus"></i>
                                </span>
                                <span class="btn-inner--text">Add SKU</span>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="addSKUModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form method="post" action="/add_sku">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add new SKU
                                                </h5>
                                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="sku-name" class="col-form-label">SKU Name:</label>
                                                    <input type="text"
                                                        class="form-control @error('sku_name') is-invalid @enderror"
                                                        id="sku-name" name="sku_name" value="{{ old('sku_name') }}">
                                                    @error('sku_name')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="sku-target" class="col-form-label">Target:</label>
                                                    <input type="number" step="any"
                                                        class="form-control @error('target') is-invalid @enderror"
                                                        id="sku-target" name="target" value="{{ old('target') }}">
                                                    @error('target')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="sku-th-H" class="col-form-label">Threshold High:</label>
                                                    <input type="number" step="any"
                                                        class="form-control @error('th_H') is-invalid @enderror"
                                                        id="sku-th-H" name="th_H" value="{{ old('th_H') }}">
                                                    @error('th_H')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="sku-th-L" class="col-form-label">Threshold Low:</label>
                                                    <input type="number" step="any"
                                                        class="form-control @error('th_L') is-invalid @enderror"
                                                        id="sku-th-L" name="th_L" value="{{ old('th_L') }}">
                                                    @error('th_L')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-white"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-dark">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="sku_list" class="display text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>Created At</th>
                                <th>SKU Name</th>
                                <th>Target</th>
                                <th>Threshold High</th>
                                <th>Threshold Low</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

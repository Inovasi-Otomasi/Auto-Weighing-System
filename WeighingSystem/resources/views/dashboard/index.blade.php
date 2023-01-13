@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="d-md-flex align-items-center mb-3 mx-2">
                <div class="mb-md-0 mb-3">
                    <h3 class="font-weight-bold mb-0">Hello, {{ Auth::user()->name }}</h3>
                    <p class="mb-0">These are details about your site!</p>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0">
    {{-- <div class="input-group mb-3"> --}}
    <div class="btn-group flex-wrap mt-3">
        <div class="dropdown me-3 mb-2">
            <button class="btn btn-outline-iot mb-0 dropdown-toggle" type="button" id="dropdown-line"
                data-bs-toggle="dropdown" aria-expanded="false">
                Line : {{ request('line') ? $lines->where('id', request('line'))->first()->line_name : 'All' }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdown-line">
                <li><a class="dropdown-item" href="{{ $request->fullUrlWithQuery(['line' => null]) }}">All</a></li>
                @foreach ($lines as $line)
                    <li><a class="dropdown-item"
                            href="{{ $request->fullUrlWithQuery(['line' => $line->id]) }}">{{ $line->line_name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="dropdown me-3 mb-2">
            <button class="btn btn-outline-iot mb-0 dropdown-toggle" type="button" id="dropdown-machine"
                data-bs-toggle="dropdown" aria-expanded="false">
                Machine :
                {{ request('machine') ? $machines->where('id', request('machine'))->first()->machine_name : 'All' }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdown-machine">
                <li><a class="dropdown-item" href="{{ $request->fullUrlWithQuery(['machine' => null]) }}">All</a></li>
                @foreach ($machines as $machine)
                    <li><a class="dropdown-item"
                            href="{{ $request->fullUrlWithQuery(['machine' => $machine->id]) }}">{{ $machine->machine_name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="dropdown me-3 mb-2">
            <button class="btn btn-outline-iot mb-0 dropdown-toggle" type="button" id="dropdown-shift"
                data-bs-toggle="dropdown" aria-expanded="false">
                Shift : {{ request('shift') ? $shifts->where('id', request('shift'))->first()->shift_name : 'All' }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdown-shift">
                <li><a class="dropdown-item" href="{{ $request->fullUrlWithQuery(['shift' => null]) }}">All</a></li>
                @foreach ($shifts as $shift)
                    <li><a class="dropdown-item"
                            href="{{ $request->fullUrlWithQuery(['shift' => $shift->id]) }}">{{ $shift->shift_name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="dropdown me-3 mb-2">
            <button class="btn btn-outline-iot mb-0 dropdown-toggle" type="button" id="dropdown-sku"
                data-bs-toggle="dropdown" aria-expanded="false">
                SKU : {{ request('sku') ? $sku_list->where('id', request('sku'))->first()->sku_name : 'All' }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdown-sku">
                <li><a class="dropdown-item" href="{{ $request->fullUrlWithQuery(['sku' => null]) }}">All</a></li>
                @foreach ($sku_list as $sku)
                    <li><a class="dropdown-item"
                            href="{{ $request->fullUrlWithQuery(['sku' => $sku->id]) }}">{{ $sku->sku_name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="dropdown me-3 mb-2">
            <button class="btn btn-outline-iot mb-0 dropdown-toggle" type="button" id="dropdown-time"
                data-bs-toggle="dropdown" aria-expanded="false">
                Time Range :
                {{ request('from') && request('to') ? date('Y-m-d H:i:s', request('from')) . ' to ' . date('Y-m-d H:i:s', request('to')) : (request('range') ? 'Last ' . request('range') . ' Day(s)' : 'Last 1 Day') }}
            </button>
            <div class="dropdown-menu" style=" width: 500px !important;" aria-labelledby="dropdown-time">
                <div class="row">
                    <div class="col">
                        <div class="mx-4 my-2">
                            {{-- <label for="datetimerange" class="form-label">Range</label> --}}
                            <div id="datetimerange"
                                style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                        <div class="mx-4 my-1">
                            <a href="{{ $request->fullUrlWithQuery(['range' => 1, 'from' => null, 'to' => null]) }}"
                                class="dropdown-item rounded  ">Last
                                1 Day</a>
                            <a href="{{ $request->fullUrlWithQuery(['range' => 7, 'from' => null, 'to' => null]) }}"
                                class="dropdown-item rounded 'text-white bg-primary'">Last
                                7
                                Days</a>
                            <a href="{{ $request->fullUrlWithQuery(['range' => 30, 'from' => null, 'to' => null]) }}"
                                class="dropdown-item rounded">Last
                                30
                                Days</a>
                            <a href="{{ $request->fullUrlWithQuery(['range' => 90, 'from' => null, 'to' => null]) }}"
                                class="dropdown-item rounded ">Last
                                90
                                Days</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <button class="btn btn-outline-success mb-0 " type="button"
                onclick="window.open('{{ route('export', request()->all()) }}','_blank')">
                <span class="btn-inner--icon">
                    <i class="text-success fa-solid fa-file-excel"></i>
                </span>
                <span class="btn-inner--text">Export</span>
            </button>
        </div>
    </div>
    {{-- <input type="text" class="form-control" placeholder="" aria-label="Example text with two button addons"
            aria-describedby="button-addon3">
    </div> --}}

    {{-- @livewire('number-parameter', [
        'device_id' => $device->id,
    ]) --}}
    <div class="row mt-4">
        <div class="col-lg-12 mb-4">
            <div class="card shadow-xs border">
                <div class="card-header pb-0">
                    <div class="d-sm-flex align-items-center mb-3">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0"></h6>
                            <p class="text-sm mb-sm-0 mb-2">Here you have details about your scale .
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3 row mt-3">
                    {{-- <div class="col-lg-4">
                        {!! $charts['chart_gauge']->container() !!}
                        {!! $charts['chart_gauge']->script() !!}
                    </div> --}}
                    <div class="col-lg-4">
                        <div class="chart mt-n5">
                            {!! $charts['chart_bar']->container() !!}
                            {!! $charts['chart_bar']->script() !!}
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="chart mt-n5">
                            {!! $charts['chart_line']->container() !!}
                            {!! $charts['chart_line']->script() !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Historical Log</h6>
                            <p class="text-sm">See information about all events on your site.</p>
                        </div>
                        {{-- <div class="ms-auto d-flex">
                            <button type="button"
                                class="btn btn-sm btn-white btn-icon d-flex align-items-center mb-0 me-2"
                                data-bs-toggle="modal" data-bs-target="#exportModal">
                                <span class="btn-inner--icon">
                                    <i class="text-success fa-solid fa-file-excel"></i>
                                </span>
                            </button>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="historical_log" class="display text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>Created At</th>
                                <th>Line Name</th>
                                <th>Machine Name</th>
                                <th>Shift Name</th>
                                <th>SKU Name</th>
                                <th>Weight</th>
                                <th>Target</th>
                                <th>Threshold High</th>
                                <th>Threshold Low</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- map --}}
@endsection

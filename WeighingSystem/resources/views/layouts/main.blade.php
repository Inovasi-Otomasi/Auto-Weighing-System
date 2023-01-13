<!--
=========================================================
* Corporate UI - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/corporate-ui
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/iot/favicon.png">
    <link rel="icon" type="image/png" href="/assets/img/iot/favicon.png">
    <title>
        IAN Monitoring Platform
    </title>
    {{-- <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
        rel="stylesheet" /> --}}
    <link href="/assets/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/css/iot.css">
    <style>
        #map {
            width: "100%";
            height: 600px;
        }
    </style>
    <link id="pagestyle" href="/assets/css/corporate-ui-dashboard.css?v=1.0.0" rel="stylesheet" />
    <link href="/assets/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="/assets/css/daterangepicker.css" rel="stylesheet" />
    @livewireStyles()
</head>

<body class="g-sidenav-show  bg-gray-100">
    @include('layouts.sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- End Navbar -->
        <div class="container-fluid py-4 px-5">
            @if (session()->has('success'))
                {{-- <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div> --}}
                <div class="alert alert-success alert-dismissible text-sm fade show" role="alert">
                    <span class="alert-text">{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" class="text-dark">&times;</span>
                    </button>
                </div>
            @elseif (session()->has('failed'))
                <div class="alert alert-danger alert-dismissible text-sm fade show" role="alert">
                    <span class="alert-text">{{ session('failed') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" class="text-dark">&times;</span>
                    </button>
                </div>
            @endif
            @yield('container')
            @include('layouts.footer')
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src="/assets/js/jquery-3.5.1.js"></script>
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/chartjs.min.js"></script>
    <script src="/assets/js/plugins/swiper-bundle.min.js" type="text/javascript"></script>
    <script src="/assets/js/all.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/dist/echarts.js"></script>
    <script src="/assets/js/moment.min.js"></script>
    <script src="/assets/js/daterangepicker.min.js"></script>



    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#sku_list').DataTable({
                "processing": false, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "ajax": {
                    "url": "{{ url('sku_list') }}",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                    }
                },
            });
            $('#line_list').DataTable({
                "processing": false, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "ajax": {
                    "url": "{{ url('line_list') }}",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                    }
                },
            });
            $('#machine_list').DataTable({
                "processing": false, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "ajax": {
                    "url": "{{ url('machine_list') }}",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                    }
                },
            });
            $('#shift_list').DataTable({
                "processing": false, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "ajax": {
                    "url": "{{ url('shift_list') }}",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                    }
                },
            });
            $('#historical_log').DataTable({
                "processing": false, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "ajax": {
                    "url": "{{ url('historical_log') }}",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        line: {{ request('line') ?: 'null' }},
                        machine: {{ request('machine') ?: 'null' }},
                        shift: {{ request('shift') ?: 'null' }},
                        sku: {{ request('sku') ?: 'null' }}
                    }
                },
            });
        });
        @if (Request::is('/'))
            $(function() {
                var url = new URL(("{{ $request->fullUrl() }}").replace('&amp;', '&'));
                var start = url.searchParams.has('from') ? moment.unix(url.searchParams.get('from')) : moment()
                    .startOf(
                        'hour').subtract(1, "days");
                var end = url.searchParams.has('to') ? moment.unix(url.searchParams.get('to')) : moment().startOf(
                    'hour');

                function cb_date(start, end) {

                    // window.location.replace('google.com');
                    var url2 = new URL((
                            "{{ $request->fullUrlWithQuery(['range' => null, 'from' => null, 'to' => null]) }}"
                        )
                        .replace('&amp;', '&'));
                    url2.searchParams.set('from', start.unix());
                    url2.searchParams.set('to', end.unix());
                    window.location.replace(url2);

                    // fetch({{ url('/') }})
                }
                $('#datetimerange').daterangepicker({
                    timePicker: true,
                    startDate: start,
                    endDate: end,
                    // startDate: moment().startOf('hour'),
                    // endDate: moment().startOf('hour').add(32, 'hour'),
                    locale: {
                        separator: " to ",
                        format: 'YYYY-MM-DD HH:mm:ss'
                    }
                    // cb_date(start, end);
                }, cb_date);
                $('#datetimerange span').html(start.format('YYYY-MM-DD HH:mm:ss') + ' To ' + end.format(
                    'YYYY-MM-DD HH:mm:ss'));

            });
            $(document).ready(function() {
                let created_at;
                let datapoll;
                let isLoaded = false;
                let getLiveDataOnce = function() {
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('livedata_once') }}',
                        async: true,
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            range: {{ request('range') ?: 'null' }},
                            from: {{ request('from') ?: 'null' }},
                            to: {{ request('to') ?: 'null' }},
                            line: {{ request('line') ?: 'null' }},
                            machine: {{ request('machine') ?: 'null' }},
                            shift: {{ request('shift') ?: 'null' }},
                            sku: {{ request('sku') ?: 'null' }}
                        },
                        success: function(data) {
                            // if ('value' in data && !data.value) {
                            // window.{{ $charts['chart_gauge']->id }}
                            //     .setOption({
                            //         series: [{
                            //             data: [{
                            //                 value: data.value[
                            //                     'weight'
                            //                 ]
                            //             }]
                            //         }]
                            //     });
                            window.{{ $charts['chart_bar']->id }}
                                .setOption({
                                    series: [{
                                        data: [{
                                            value: data.status['OK']
                                        }, {
                                            value: data.status['UNDERWEIGHT']
                                        }, {
                                            value: data.status['OVERWEIGHT']
                                        }]
                                    }]
                                });
                            created_at = data.value['created_at'];
                            window.{{ $charts['chart_line']->id }}
                                .setOption({
                                    series: [{
                                        data: data.log.map(
                                            function(row) {
                                                return [row[
                                                    'created_at'
                                                ], row[
                                                    'weight'
                                                ]];
                                            })
                                    }]
                                });
                            datapoll = data.log;
                            isLoaded = true;
                            // }
                        }
                    });
                }

                let getLiveData = function() {
                    if (isLoaded) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('livedata') }}',
                            async: true,
                            dataType: 'json',
                            data: {
                                _token: "{{ csrf_token() }}",
                                range: {{ request('range') ?: 'null' }},
                                from: {{ request('from') ?: 'null' }},
                                to: {{ request('to') ?: 'null' }},
                                line: {{ request('line') ?: 'null' }},
                                machine: {{ request('machine') ?: 'null' }},
                                shift: {{ request('shift') ?: 'null' }},
                                sku: {{ request('sku') ?: 'null' }}
                            },
                            success: function(data) {
                                // if ('value' in data && !data.value) {
                                // window.{{ $charts['chart_gauge']->id }}
                                //     .setOption({
                                //         series: [{
                                //             data: [{
                                //                 value: data.value[
                                //                     'weight'
                                //                 ]
                                //             }]
                                //         }]
                                //     });
                                window.{{ $charts['chart_bar']->id }}
                                    .setOption({
                                        series: [{
                                            data: [{
                                                value: data.status['OK']
                                            }, {
                                                value: data.status[
                                                    'UNDERWEIGHT']
                                            }, {
                                                value: data.status['OVERWEIGHT']
                                            }]
                                        }]
                                    });
                                if (created_at != data.value['created_at']) {
                                    datapoll.push(data.value);
                                    window.{{ $charts['chart_line']->id }}
                                        .setOption({
                                            series: [{
                                                data: datapoll.map(
                                                    function(row) {
                                                        return [row[
                                                            'created_at'
                                                        ], row[
                                                            'weight'
                                                        ]];
                                                    })
                                            }]
                                        });
                                    // window.{{ $charts['chart_line']->id }}
                                    //     .appendData({
                                    //         seriesIndex: 0,
                                    //         data: [name[data.value[
                                    //             'created_at'
                                    //         ], data.value[
                                    //             'weight'
                                    //         ]]]
                                    //     });

                                    console.log('hehe');
                                    created_at = data.value['created_at'];
                                }
                                // }
                            }
                        });
                    }
                }
                getLiveDataOnce();
                setInterval(getLiveData, 5000);
            });
        @endif
    </script>
    <!-- Github buttons -->
    <!-- Control Center for Corporate UI Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="/assets/js/corporate-ui-dashboard.js?v=1.0.0"></script>
    @livewireScripts()
</body>

</html>

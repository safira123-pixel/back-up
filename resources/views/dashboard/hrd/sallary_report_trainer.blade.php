@extends('dashboard.layouts.app')

@section('title', 'Halaman Trainer Sallary')

@push('css')
    <link href="{{ asset('alsavedutech/assets/libs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('alsavedutech/assets/libs/dropzone/dist/dropzone.css') }}" rel="stylesheet" />
    <link href="{{ asset('alsavedutech/assets/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('alsavedutech/assets/libs/prismjs/themes/prism-okaidia.css') }}" rel="stylesheet" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('alsavedutech/assets/css/theme.min.css') }}" />

    <style>
        #invoice {
            padding: 30px;
        }

        .invoice {
            position: relative;
            background-color: #FFF;
            min-height: 680px;
            padding: 15px
        }

        .invoice header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #3989c6
        }

        .invoice .company-details {
            text-align: right
        }

        .invoice .company-details .name {
            margin-top: 0;
            margin-bottom: 0
        }

        .invoice .contacts {
            margin-bottom: 20px
        }

        .invoice .invoice-to {
            text-align: left
        }

        .invoice .invoice-to .to {
            margin-top: 0;
            margin-bottom: 0
        }

        .invoice .invoice-details {
            text-align: right
        }

        .invoice .invoice-details .invoice-id {
            margin-top: 0;
            color: #3989c6
        }

        .invoice main {
            padding-bottom: 50px
        }

        .invoice main .thanks {
            margin-top: -100px;
            font-size: 2em;
            margin-bottom: 50px
        }

        .invoice main .notices {
            padding-left: 6px;
            border-left: 6px solid #3989c6
        }

        .invoice main .notices .notice {
            font-size: 1.2em
        }

        .invoice table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px
        }

        .invoice table td,
        .invoice table th {
            padding: 15px;
            background: #eee;
            border-bottom: 1px solid #fff
        }

        .invoice table th {
            white-space: nowrap;
            font-weight: 400;
            font-size: 16px
        }

        .invoice table td h3 {
            margin: 0;
            font-weight: 400;
            color: #3989c6;
            font-size: 1.2em
        }

        .invoice table .qty,
        .invoice table .total,
        .invoice table .unit {
            text-align: right;
            font-size: 1.2em
        }

        .invoice table .no {
            color: #fff;
            font-size: 1.6em;
            background: #3989c6
        }

        .invoice table .unit {
            background: #ddd
        }

        .invoice table .total {
            background: #3989c6;
            color: #fff
        }

        .invoice table tbody tr:last-child td {
            border: none
        }

        .invoice table tfoot td {
            background: 0 0;
            border-bottom: none;
            white-space: nowrap;
            text-align: right;
            padding: 10px 20px;
            font-size: 1.2em;
            border-top: 1px solid #aaa
        }

        .invoice table tfoot tr:first-child td {
            border-top: none
        }

        .invoice table tfoot tr:last-child td {
            color: #3989c6;
            font-size: 1.4em;
            border-top: 1px solid #3989c6
        }

        .invoice table tfoot tr td:first-child {
            border: none
        }

        .invoice footer {
            width: 100%;
            text-align: center;
            color: #777;
            border-top: 1px solid #aaa;
            padding: 8px 0
        }

        @media print {
            .invoice {
                font-size: 11px !important;
                overflow: hidden !important
            }

            .invoice footer {
                position: absolute;
                bottom: 10px;
                page-break-after: always
            }

            .invoice>div:last-child {
                page-break-before: always
            }
        }
    </style>
@endpush

@php
    $Carbon = \Carbon\Carbon::now()->timezone(config('app.timezone'));
@endphp

@section('content')
    <div id="db-wrapper">
        <!-- navbar vertical -->
        <!-- Sidebar -->
        @include('dashboard.layouts.sidebar')
        <!-- Page content -->
        <div id="page-content">
            @include('dashboard.layouts.header')
            <!-- Container fluid -->
            <div class="container-fluid px-6 py-4">
                <!-- card body -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <h3 style="font-weight: 700">Trainer Sallary</h3>
                        <hr />
                        @session('success')
                            {{-- <div class="alert alert-success" role="alert">
                            {{ $value }}
                        </div> --}}
                            <div class="flash-data" data-flashdata="{{ $value }}"></div>
                        @endsession

                        @session('error')
                            {{-- <div class="alert alert-danger" role="alert">
                            {{ $value }}
                        </div> --}}
                            <div class="flash-data" data-flashdata="{{ $value }}"></div>
                            <div class="type-flash" data-typeflash="error"></div>
                        @endsession
                        <button data-bs-toggle="collapse" href="#filtersListUser" role="button" aria-expanded="false"
                            aria-controls="filtersTrash" class="btn btn-primary mb-5">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3">
                                </polygon>
                            </svg>
                            Filters
                        </button>
                        <a href="{{ route('hrd.trainer.sallary_report.list') }}" role="button" aria-expanded="false"
                            class="btn btn-primary mb-5">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                <polyline points="1 4 1 10 7 10"></polyline>
                                <polyline points="23 20 23 14 17 14"></polyline>
                                <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                            </svg>
                            Refresh Filter
                        </a>
                        <div class="collapse" id="filtersListUser">
                            <div class="card shadow-lg p-3 mb-5 bg-white rounded-3">
                                <div class="card-body">
                                    <!-- Validation Form -->
                                    <h3 style="font-weight: 700">Field Filters</h3>
                                    <hr />
                                    <form class="row g-3 needs-validation"
                                        action="{{ route('hrd.trainer.sallary_report.list') }}" method="GET">
                                        @csrf
                                        <!-- Input -->
                                        <div class="col-md-3">
                                            <label class="form-label" for="nama_kelas_filter">Class
                                                Name</label>
                                            <input type="text" id="nama_kelas_filter" name="nama_kelas_filter"
                                                class="form-control @error('nama_kelas_filter') is-invalid @enderror"
                                                placeholder="search by nama kelas" value="{{ old('nama_kelas_filter') }}" />
                                            @error('nama_kelas_filter')
                                                <div class="invalid-feedback">{{ $message }}.</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label" for="tanggal_absen_filter">Date</label>
                                            <input type="date" id="tanggal_absen_filter" name="tanggal_absen_filter"
                                                class="form-control @error('tanggal_absen_filter') is-invalid @enderror"
                                                placeholder="search by tanggal kelas"
                                                value="{{ old('tanggal_absen_filter') }}" />
                                            @error('tanggal_absen_filter')
                                                <div class="invalid-feedback">{{ $message }}.</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label" for="bulan_absen_filter">Month</label>
                                            <select id="bulan_absen_filter" name="bulan_absen_filter"
                                                class="form-control @error('bulan_absen_filter') is-invalid @enderror">
                                                <option value="">Select month</option>
                                                @for ($i = 0; $i <= 11; $i++)
                                                    <option value="{{ $i + 1 }}">{{ $Month[$i] }}</option>
                                                @endfor
                                            </select>
                                            @error('bulan_absen_filter')
                                                <div class="invalid-feedback">
                                                    {{ $message }}.
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- Button Block -->
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="submit" class="btn btn-success">
                                                <svg viewBox="0 0 24 24" width="24" height="24"
                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                    <circle cx="11" cy="11" r="8"></circle>
                                                    <line x1="21" y1="21" x2="16.65" y2="16.65">
                                                    </line>
                                                </svg>
                                                Cari
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- tabel kelas -->
                <div class="mt-5">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">trainer Detail</th>
                                    <th scope="col">Trainer Name</th>
                                    <th scope="col">Trainer Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getAbsenOfTrainer as $gaot)
                                    <tr>
                                        <th>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <button type="button"
                                                        class="btn btn-icon btn-white border border-2 rounded-circle btn-dashed ms-2"
                                                        data-bs-target="#modalDetailInvoices--{{ $gaot->id }}"
                                                        data-bs-toggle="modal" data-bs-dismiss="modal">
                                                        <svg viewBox="0 0 24 24" width="44" height="44"
                                                            stroke="#0066ff" stroke-width="2" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="css-i6dzq1">
                                                            <circle cx="12" cy="12" r="10"></circle>
                                                            <line x1="12" y1="16" x2="12"
                                                                y2="12">
                                                            </line>
                                                            <line x1="12" y1="8" x2="12.01"
                                                                y2="8">
                                                            </line>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </th>
                                        <td>{{ $gaot->name }}</td>
                                        <td>{{ $gaot->levelTrainer->nama_level }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end -->

                <!-- modal detail -->
                <!-- logic set gaji berdasarkan pertemuan kelas yang dia handle-->
                @foreach ($getAbsenOfTrainer as $trainer)
                    <div class="modal fade" id="modalDetailInvoices--{{ $trainer->id }}" aria-hidden="true"
                        aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Sallary Report</h5>
                                </div>
                                <div class="modal-body">
                                    <div id="invoice">
                                        <div class="invoice overflow-auto">
                                            <div style="min-width: 600px">
                                                <header>
                                                    <div class="row">
                                                        <div class="col">
                                                            <a target="_blank" href="https://lobianijs.com">
                                                                <img src="{{ asset('alsavedutech/images/bg-1.png') }}"
                                                                    width="20%" data-holder-rendered="true" />
                                                            </a>
                                                        </div>
                                                        <div class="col company-details">
                                                            <h2 class="name">
                                                                <p>Alsavedutech</p>
                                                            </h2>
                                                            <div>JL Dummy NO.6</div>
                                                            <div>(123) 456-789</div>
                                                            <div>alsav@gmail.com</div>
                                                        </div>
                                                    </div>
                                                </header>
                                                <main>
                                                    <div class="row contacts">
                                                        <div class="col invoice-to">
                                                            <div class="text-gray-light">SALLARY TO:</div>
                                                            <h2 class="to">{{ $trainer->name }}</h2>
                                                            <div class="address">{{ $trainer->levelTrainer->nama_level }}
                                                            </div>
                                                            <div class="email"><a
                                                                    href="mailto:john@example.com">{{ $trainer->email }}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @foreach ($trainer->AssignedClass as $assignedClass)
                                                        @if (count($assignedClass->kelas->absens) * $assignedClass->kelas->levelTrainer->sallary_level > 0)
                                                            <td>
                                                                <a href="{{ route('hrd.trainer.sallary_report.confirm', ['users_id' => $trainer->id, 'kelas_id' => $assignedClass->kelas->id, 'total_gaji' => count($assignedClass->kelas->absens) * $assignedClass->kelas->levelTrainer->sallary_level]) }}"
                                                                    class="btn btn-primary mb-5">
                                                                    <svg viewBox="0 0 24 24" width="20"
                                                                        height="20" stroke="currentColor"
                                                                        stroke-width="2" fill="none"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="css-i6dzq1">
                                                                        <polyline points="9 11 12 14 22 4"></polyline>
                                                                        <path
                                                                            d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11">
                                                                        </path>
                                                                    </svg>
                                                                    Submit
                                                                </a>
                                                            </td>
                                                            <hr>
                                                        @endif
                                                        <div class="text-gray-light">STATUS:
                                                            @if (empty($assignedClass->kelas->sallaryReports->status))
                                                                <span class="badge bg-danger">
                                                                    {{ 'Sallary Not Submmited' }}</span>
                                                            @else
                                                                @if ($assignedClass->kelas->sallaryReports->status == 'verified')
                                                                    <span class="badge bg-success">
                                                                        {{ 'Has Verified' }}</span>
                                                                @else
                                                                    <span class="badge bg-warning">
                                                                        {{ 'Not Verified' }}</span>
                                                                @endif
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>NO</th>
                                                                    <th class="text-left">CLASS CODE: <span
                                                                            class="badge bg-info">{{ $assignedClass->kelas->uid_class }}</span>
                                                                    </th>
                                                                    <th class="text-right">CLASS NAME: <span
                                                                            class="badge bg-info">{{ $assignedClass->kelas->nama_kelas }}</span>
                                                                    </th>
                                                                    <th class="text-right">CLASS STATUS: <span
                                                                            class="badge bg-info">{{ $assignedClass->kelas->status_kelas }}</span>
                                                                    </th>
                                                                    <th class="text-right">CLASS LEVEL <span
                                                                            class="badge bg-info">{{ $assignedClass->kelas->levelTrainer->nama_level }}</span>
                                                                    </th>
                                                                    <th class="text-right">SALLARY: <span
                                                                            class="badge bg-info">@mata_uang($assignedClass->kelas->levelTrainer->sallary_level)</span>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($assignedClass->kelas->absens as $absenByOnJadwalOfClass)
                                                                    <tr>
                                                                        <td class="no">{{ $loop->iteration }}</td>
                                                                        {{-- <td class="text-left">
                                                                        <h3>{{ \Carbon\Carbon::parse($absenTrainer->jadwal->tanggal_jadwal_kelas)->format('M d Y') }}
                                                                        </h3>waktu kelas dimulai pada pukul
                                                                        {{ $absenTrainer->jadwal->jam_mulai_jadwal_kelas }}
                                                                        {{ '~' }}
                                                                        {{ $absenTrainer->jadwal->jam_akhir_jadwal_kelas }}
                                                                    </td> --}}
                                                                        <td class="unit">
                                                                            {{ 'Day: ' }}<span
                                                                                class="badge bg-info">{{ $absenByOnJadwalOfClass->jadwal->hari_jadwal_kelas }}</span>
                                                                        </td>
                                                                        <td class="unit">
                                                                            {{ 'Date: ' }}<span
                                                                                class="badge bg-info">{{ $Carbon->parse($absenByOnJadwalOfClass->jadwal->tanggal_jadwal_kelas)->format('d M Y') }}</span>
                                                                        </td>
                                                                        <td class="unit">
                                                                            {{ 'Start At: ' }}<span
                                                                                class="badge bg-info">{{ $Carbon->parse($absenByOnJadwalOfClass->jadwal->jam_mulai_jadwal_kelas)->format('g:i A') }}</span>
                                                                        </td>
                                                                        <td class="qty">
                                                                            {{ 'End At: ' }}<span
                                                                                class="badge bg-info">{{ $Carbon->parse($absenByOnJadwalOfClass->jadwal->jam_akhir_jadwal_kelas)->format('g:i A') }}</span>
                                                                        </td class="unit">
                                                                        <td class="total">
                                                                            {{ 'Has Absens' }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="2"></td>
                                                                    <td colspan="2">GRAND TOTAL</td>
                                                                    <td>@mata_uang(count($assignedClass->kelas->absens) * $assignedClass->kelas->levelTrainer->sallary_level)
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    @endforeach

                                                </main>
                                                <footer>
                                                    Sallary Trainer: total absen from class * class price
                                                </footer>
                                            </div>
                                            <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- end logic -->

                <!-- end -->
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script defer src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script defer src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script defer src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>

    <script src="{{ asset('alsavedutech/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('alsavedutech/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('alsavedutech/assets/libs/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('alsavedutech/assets/libs/feather-icons/dist/feather.min.js') }}"></script>
    <script src="{{ asset('alsavedutech/assets/libs/prismjs/prism.js') }}"></script>
    <script src="{{ asset('alsavedutech/assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('alsavedutech/assets/libs/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('alsavedutech/assets/libs/prismjs/plugins/toolbar/prism-toolbar.min.js') }}"></script>
    <script src="{{ asset('alsavedutech/assets/libs/prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js') }}">
    </script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


    <!-- Theme JS -->
    <script src="{{ asset('alsavedutech/assets/js/theme.min.js') }}"></script>
    <script defer src="{{ asset('alsavedutech/assets/script.js') }}"></script>

    <script>
        $('#printInvoice').click(function() {
            Popup($('.invoice')[0].outerHTML);

            function Popup(data) {
                window.print();
                return true;
            }
        });
    </script>
@endpush

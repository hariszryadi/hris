<!DOCTYPE html>
<html>
<head>
	<title>Report Cuti/Izin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .table {
            font-size:11px;
        }
        .table thead {
            background-color: #1e64b1;
            color: #fff;
        }
        .table > thead > tr > th {
            vertical-align: middle;
        }
        .table-count > tr > td {
            vertical-align: middle;
        }
        .table > tbody {
            border-right: 1px solid #eee;
            border-left: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }
        img {
            height: 55px;
            margin-left: 16px;
        }
        .table-borderless tbody tr td {
            padding-top: 0 !important;
            padding-left: 0 !important;
        }
    </style>
</head>
<body>
    <div class="row">
        <img src="{{public_path('images/logo.png')}}">
    </div>
    <h5 class="text-center">Report Cuti/Izin</h5>
    <table class="table table-count">
        <tr>
            <td>cuti/izin di-<i>approve</i> : {{$status[2]}}</td>
            <td>cuti/izin di-<i>reject</i> : {{$status[0]}}</td>
            <td>cuti/izin di-<i>cancel</i> : {{$status[3]}}</td>
            <td>cuti/izin <i>pending</i> : {{$status[1]}}</td>
        </tr>
    </table>
	<table class="table">
		<thead>
			<tr>
				<th>ID Cuti/Izin</th>
				<th>Detail Pegawai</th>
				<th>Detail Cuti/Izin</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
            @forelse ($data as $item)
                <tr>
                    <td>{{$item->tr_leave_id}}</td>
                    <td>
                        <b>{{$item->empl->empl_name}}</b><br>
                        <i>{{$item->empl->nip}}</i><br>
                        <i>{{$item->empl->division->name}}</i><br>
                    </td>
                    <td>
                        <table class="table-borderless">
                            <tbody>
                                <tr>
                                    <td>Tipe</td>
                                    <td>:</td>
                                    <td>{{$item->typeLeave->type_leave}}</td>
                                </tr>
                                <tr>
                                    <td>Kategori</td>
                                    <td>:</td>
                                    <td>{{$item->categoryLeave->category_leave}}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Mulai</td>
                                    <td>:</td>
                                    <td>{{$item->start_date}}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Selesai</td>
                                    <td>:</td>
                                    <td>{{$item->end_date}}</td>
                                </tr>
                                <tr>
                                    <td>Keterangan</td>
                                    <td>:</td>
                                    <td>{{$item->description}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    @if ($item->status == 2)
                        <td><span class="text-success">Approved</span></td>
                    @elseif($item->status == 3)
                        <td><span class="text-secondary">Cancelled</span></td>
                    @elseif($item->status == 0)
                        <td><span class="text-danger">Rejected</span></td>
                    @else
                        <td><span class="text-warning">Pending</span></td>
                    @endif
                </tr>
            @empty
                <tr>
                    <p style="text-align: center;">Tidak ada report</p>
                </tr>
			@endforelse
		</tbody>
	</table>
    <table class="table table-count">
        <tr>
            <td>cuti/izin di-<i>approve</i> : {{$status[2]}}</td>
            <td>cuti/izin di-<i>reject</i> : {{$status[0]}}</td>
            <td>cuti/izin di-<i>cancel</i> : {{$status[3]}}</td>
            <td>cuti/izin <i>pending</i> : {{$status[1]}}</td>
        </tr>
    </table>
</body>
</html>
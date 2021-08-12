<!DOCTYPE html>
<html>
<head>
	<title>Report Lembur</title>
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
    <p class="text-center"><b>Report Lembur Tanggal {{$start_date}} - {{$end_date}}</b></p>
    <table class="table table-count">
        <tr>
            <td>lembur di-<i>approve</i> : {{isset($status[2]) ? $status[2] : 0}}</td>
            <td>lembur di-<i>reject</i> : {{isset($status[0]) ? $status[0] : 0}}</td>
            <td>lembur di-<i>cancel</i> : {{isset($status[3]) ? $status[3] : 0}}</td>
            <td>lembur <i>pending</i> : {{isset($status[1]) ? $status[1] : 0}}</td>
        </tr>
    </table>
	<table class="table">
		<thead>
			<tr>
				<th>ID Lembur</th>
				<th>Detail Pegawai</th>
				<th>Detail Lembur</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
            @forelse ($data as $item)
                <tr>
                    <td>{{$item->tr_overtime_id}}</td>
                    <td>
                        <b>{{$item->empl->empl_name}}</b><br>
                        <i>{{$item->empl->nip}}</i><br>
                        <i>{{$item->empl->division->name}}</i><br>
                    </td>
                    <td>
                        <table class="table-borderless">
                            <tbody>
                                <tr>
                                    <td>Tanggal Lembur</td>
                                    <td>:</td>
                                    <td>{{$item->overtime_date}}</td>
                                </tr>
                                <tr>
                                    <td>Jam Mulai</td>
                                    <td>:</td>
                                    <td>{{$item->start_time}}</td>
                                </tr>
                                <tr>
                                    <td>Jam Selesai</td>
                                    <td>:</td>
                                    <td>{{$item->end_time}}</td>
                                </tr>
                                <tr>
                                    <td>Durasi</td>
                                    <td>:</td>
                                    <td>{{$item->duration}}</td>
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
            <td>lembur di-<i>approve</i> : {{isset($status[2]) ? $status[2] : 0}}</td>
            <td>lembur di-<i>reject</i> : {{isset($status[0]) ? $status[0] : 0}}</td>
            <td>lembur di-<i>cancel</i> : {{isset($status[3]) ? $status[3] : 0}}</td>
            <td>lembur <i>pending</i> : {{isset($status[1]) ? $status[1] : 0}}</td>
        </tr>
    </table>
</body>
</html>
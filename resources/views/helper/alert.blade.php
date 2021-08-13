@if(session()->has('success'))
    <script type="text/javascript">
        $(function (resp) {
            swal('Sukses!', resp.message, 'success');
        });
    </script>
@endif
@if(session()->has('error'))
    <script type="text/javascript">
        $(function (resp) {
            swal('Error!', resp.message, 'error');
        });
    </script>
@endif
@if ($errors->has('nip'))
    <script type="text/javascript">
        $(function (resp) {
            swal('Error!', 'NIP Duplikat\nTerdapat Pada Pegawai Lain', 'error');
        });
    </script>
@endif
@if ($errors->has('email'))
    <script type="text/javascript">
        $(function (resp) {
            swal('Error!', 'Email Duplikat\nTerdapat Pada Pegawai Lain', 'error');
        });
    </script>
@endif
@if ($errors->has('id_finger'))
    <script type="text/javascript">
        $(function (resp) {
            swal('Error!', 'ID Finger Duplikat\nTerdapat Pada Pegawai Lain', 'error');
        });
    </script>
@endif
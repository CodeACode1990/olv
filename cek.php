<!DOCTYPE html>
<html>
<head>
    <title>Tutorial PHP Datatables Dengan PHP Dan MySQL</title>
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <?php
        include_once('base_functions.php');
        $con = connect_to_database("ut_manado_olv");
        $sql = mysqli_query( $con,"SELECT * FROM kendaraan_rekap_jalan " ) or die (mysqli_error($con));
    ?>
    <table id="tabel-data" class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th >Tanggal</th>
                <th >Plat Nomor</th>
                <th >Kilometer</th>
                <th >Driver</th>
                <th >Keterangan</th>
                <th >Penginput</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $num = 1;
                while($d =  mysqli_fetch_array($sql)){
                    echo "
                        <tr>
                            <td  scope='row'>".$num."</td>
                            <td>".$d['tanggal']."</td>
                            <td>".$d['plat_nomor']."</td>
                            <td>".$d['kilometer']."</td>
                            <td>".$d['driver']."</td>
                            <td>".$d['keterangan']."</td>
                            <td>".$d['penginput']."</td>
                        </tr>
                    ";
                    $num++;
                }
            ?>
        </tbody>

        <script>
            $(document).ready(function(){
                $('#tabel-data').DataTable();
            });
        </script>

    </table>


          
<?php //include_once('../footer.php'); ?>
                

</body>
</html>
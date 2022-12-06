<!-- <div class="border-end bg-white" id="sidebar-wrapper" style="background:red"> -->
<!-- <div class="" id="sidebar-wrapper" style="background:#e200ff36"> -->
<div class="" id="sidebar-wrapper" style="background:#e200ff36">
    <!-- <div class="sidebar-heading border-bottom bg-light" >  -->
    <div class="sidebar-heading border-bottom" style="background:#e200ff00">
        <img src="<?= base_url("images/logo_ut_manado_5.png") ?>"  width=1% class="logo"/>
    </div>
    <div class="list-group list-group-flush">
        <!-- <a class="list-group-item list-group-item-action list-group-item-light p-3" href="<?= base_url("dashboard.php"); ?>">Dashboard</a> -->
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="<?= base_url("dashboard.php"); ?>">Dashboard</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="<?= base_url("olv_formKendaraan"); ?>">Kendaraan</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="<?= base_url("olv_formCuti"); ?>">Form Cuti</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="<?= base_url("olv_formRegistrasi"); ?>">Form Registrasi</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="<?= base_url("olv_ktm"); ?>">Print Blanko KTM</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="<?= base_url("log.php"); ?>">Rekap Log</a>
        <!-- <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!"></a> -->
        <!-- <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!"></a> -->
    </div>

    <script>
        $(".list-group-item.list-group-item-action.list-group-item-light.p-3").on("click", function(){
            //alert('Test...');
            $(".list-group.list-group-flush").find(".active").removeClass("active");

            $(this).addClass("active");
        });
    </script>
</div>
<?php
$model2 = $model;
foreach ($model as $model){
    $returnNum = $model['purchaseReturnNum'];
    $year = $model['year'];
    $month = $model['month'];
    $day = $model['day'];
    if ($model['supplierName'] != '') { 
        $supplierName = $model['supplierName'];
    } else {
        $supplierName = '-';
    }
    if ($model['street'] != '') {
        $alamatSupplier = $model['street'];
    } else {
        $alamatSupplier = '-';
    }
    if ($model['npwp'] != '') {
        $npwpSupplier = $model['npwp'];
    } else {
        $npwpSupplier = '-';
    }   
    $createdBy = $model['fullName'];
    $notes = $model['additionalInfo'];
}
switch ($month){
    case 01:
        $monthName = 'Januari';
        break;
    case 02:
        $monthName = 'Februari';
        break;
    case 03:
        $monthName = 'Maret';
        break;
    case 04;
        $monthName = 'April';
        break;
    case 05;
        $monthName = 'Mei';
        break;
    case 06;
        $monthName = 'Juni';
        break;
    case 07;
        $monthName = 'Juli';
        break;
    case 08;
        $monthName = 'Agustus';
        break;
    case 09;
        $monthName = 'September';
        break;
    case 10;
        $monthName = 'Oktober';
        break;
    case 11;
        $monthName = 'November';
        break;
    case 12; 
        $monthName = 'Desember';
        break;
}
?>
<style>
    body{
        font-size: 12px;
        font-family: "arial";
    }
    table{
        border-collapse: collapse;
    }
</style>
<body>
    <br>
    <br>
    <br>
    <br>
    <div style="border: 2px solid black">
        <div style="text-align: center; padding-top: 15px"><b>NOTA RETUR</b></div>
        <div style="float: right; width: 20%">: <?= $returnNum; ?></div>
        <div style="float: right; width: 77%; text-align: right; padding-right: 3%;">Nomor</div>
        <div style="float: left; width: 25%">(Atas Faktur Pajak Nomor</div>
        <div style="float: left; width: 25%">: 010.000-10.00000174</div>
        <div style="float: right; width: 20%">: <?= $day; ?> <?= $monthName; ?> <?= $year; ?>)</div>
        <div style="float: right; width: 28%; text-align: right; padding-right: 2%;">Tanggal</div>
        <div style="border-top: 1px solid black; border-bottom: 1px solid black; height: 3px; margin-top: 15px"></div>
        <div style="margin-top: 15px"><b>PEMBELI</b></div>
        <div style="float: left; width: 25%">Nama</div>
        <div style="float: left; width: 5%; text-align: right">:</div>
        <div style="float: left; width: 65%; padding-left: 5px"><b><?= app\components\AppHelper::getSetting('CompanyName', 'Company Name'); ?></b></div>
        <div style="float: left; width: 25%">Alamat</div>
        <div style="float: left; width: 5%; text-align: right">:</div>
        <div style="float: left; width: 65%; padding-left: 5px"><?= app\components\AppHelper::getSetting('OfficeAddress', 'Company Address'); ?>, <?= app\components\AppHelper::getSetting('Kelurahan', 'Kelurahan'); ?> <?= app\components\AppHelper::getSetting('Kecamatan', 'Kecamatan'); ?> - <?= app\components\AppHelper::getSetting('City', 'City'); ?>  <?= app\components\AppHelper::getSetting('PostalCode', 'Postal Code'); ?></div>
        <div style="float: left; width: 25%; margin-top: 15px">NPWP</div>
        <div style="float: left; width: 5%; text-align: right">:</div>
        <div style="float: left; width: 65%; padding-left: 5px"><?= app\components\AppHelper::getSetting('NPWP', 'NPWP'); ?></div>        
        <div style="float: left; width: 100%; margin-top: 15px"><b>KEPADA PENJUAL</b></div>        
        <div style="float: left; width: 25%">Nama</div>
        <div style="float: left; width: 5%; text-align: right">:</div>
        <div style="float: left; width: 65%; padding-left: 5px"><b><?= $supplierName; ?> </b></div>
        <div style="float: left; width: 25%">Alamat</div>
        <div style="float: left; width: 5%; text-align: right">:</div>
        <div style="float: left; width: 65%; padding-left: 5px"><?= $alamatSupplier; ?></div>
        <div style="float: left; width: 25%; margin-top: 15px">NPWP</div>
        <div style="float: left; width: 5%; text-align: right">:</div>
        <div style="float: left; width: 65%; padding-left: 5px"><?= $npwpSupplier; ?></div>
        <br>
        <br>
        <table>
            <tr>
                <td style="width: 5%; text-align: center; border: 2px solid black; border-left: none"><b>No Urut</b></td>
                <td style="width: 25%; text-align: center; border: 2px solid black"><b>Macam dan Jenis Barang Kena Pajak</b></td>
                <td style="width: 20%; text-align: center; border: 2px solid black"><b>Kuantum</b></td>
                <td style="width: 25%; text-align: center; border: 2px solid black"><b>Harga Satuan Menurut Faktur Pajak (Rp)</b></td>
                <td style="width: 25%; text-align: center; border: 2px solid black; border-right: none"><b>Harga BKP yang dikembalikan (Rp)</b></td>
            </tr>
            <?php
            $count = count($model2);
            $no = 1;
            $total = '';
            $tax = '';
            foreach ($model2 as $model2) {
            if($no == $count ) { ?>
            <tr>
                <td style="width: 5%; text-align: center; border-left: none; border-bottom: 2px solid black"><?= $no; ?></td>
                <td style="width: 25%; border-left: 2px solid black; border-bottom: 2px solid black"><?= $model2['productName']; ?></td>
                <td style="width: 20%; text-align: right; border-left: 2px solid black; border-bottom: 2px solid black"><?= $model2['qty']; ?> <?= $model2['uomName']; ?></td>
                <td style="width: 25%; text-align: right; border-left: 2px solid black; border-bottom: 2px solid black"><?= number_format($model2['HPP'], 2, ".", ","); ?></td>
                <td style="width: 25%; text-align: right; border-left: 2px solid black; border-right: none; border-bottom: 2px solid black"><?= number_format($model2['subtotal'], 2, ".", ","); ?></td>
            </tr>
            <?php } 
            else { ?>
            <tr>
                <td style="width: 5%; text-align: center; border-left: none"><?= $no; ?></td>
                <td style="width: 25%; border-left: 2px solid black"><?= $model2['productName']; ?></td>
                <td style="width: 20%; text-align: right; border-left: 2px solid black"><?= $model2['qty']; ?> <?= $model2['uomName']; ?></td>
                <td style="width: 25%; text-align: right; border-left: 2px solid black"><?= number_format($model2['HPP'], 2, ".", ","); ?></td>
                <td style="width: 25%; text-align: right; border-left: 2px solid black; border-right: none"><?= number_format($model2['subtotal'], 2, ".", ","); ?></td>
            </tr>
            <?php } 
            $no = $no+1;
            $total = $total + $model2['subtotal'];            
            }
            $tax = 0.1 * $total; ?>
            <tr>
                <td colspan="3" style="border-bottom: 2px solid black">Jumlah Harga BKP Yang Dikembalikan</td>
                <td align="right" style="border-bottom: 2px solid black">:</td>
                <td style="text-align: right; border: 2px solid black; border-right: none"><?= number_format($total, 2, ".", ","); ?></td>
            </tr>
            <tr>
                <td colspan="3" style="border-bottom: 2px solid black">Pajak Pertambahan Nilai yang diminta kembali</td>
                <td align="right" style="border-bottom: 2px solid black">:</td>
                <td style="text-align: right; border: 2px solid black; border-right: none"><?= number_format($tax, 2, ".", ","); ?></td>
            </tr>
            <tr>
                <td colspan="3" style="border-bottom: 2px solid black">Pajak Penjualan Atas Barang Mewah yang diminta kembali</td>
                <td align="right" style="border-bottom: 2px solid black">:</td>
                <td style="text-align: right; border: 2px solid black; border-right: none">-</td>
            </tr>
        </table>
        <div style="float: left; width: 75%; margin-top: 15px"><u><b>Note :</b></u><br><?= $notes; ?></div>
        <?php
        $today = getdate();        
        $today['mon'];        
        switch ($today['mon']){
            case 01: $monthNameB = 'Januari'; break;
            case 02: $monthNameB = 'Februari'; break;
            case 03: $monthNameB = 'Maret'; break;
            case 04; $monthNameB = 'April'; break;
            case 05; $monthNameB = 'Mei'; break;
            case 06; $monthNameB = 'Juni'; break;
            case 07; $monthNameB = 'Juli'; break;
            case 08; $monthNameB = 'Agustus'; break;
            case 09; $monthNameB = 'September'; break;
            case 10; $monthNameB = 'Oktober'; break;
            case 11; $monthNameB = 'November'; break;
            case 12; $monthNameB = 'Desember'; break;
        } ?>
        <div style="float: left; width: 25%">Jakarta, <?= $today['mday']; ?> <?= $monthNameB; ?> <?= $today['year']; ?><br><br><br><br><?= $createdBy; ?></div>
        <div style="border-bottom: 2px solid black; margin-top: 15px"></div>
        <div>Lembar ke-1  : Untuk Pengusaha Kena Pajak yang menerbitkan Faktur Pajak</div>
        <div>Lembar ke-2  : Untuk Pembeli</div>
        
    
</body>


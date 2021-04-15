<?php

use app\components\AppHelper;
use app\models\MsSetting;
use yii\helpers\Html;

date_default_timezone_set('Asia/Jakarta');

$dateYear = date('Y');
$dateMonth = date('m');
$dateDay = date('d');

$dateData = date("Y",strtotime($modelHead['date']));

if($dateData > '2020') 
	$materai = 10000;
else 
	$materai = 6000;

if($modelHead['dueDate'] != null){
    if($modelHead['dueDate'] >= 0){
        $dueDate = $modelHead['dueDate'];
        $jatuhTempo = date("d-M-Y", strtotime("+".$modelHead['dueDate']." days", strtotime($modelHead['date'])));
    }
}
else{
    $dueDate = 0;
    $jatuhTempo = $modelHead['date'];
}
switch ($dateMonth){
    case 1:
        $monthName = 'Januari';
        break;
    case 2:
        $monthName = 'Februari';
        break;
    case 3:
        $monthName = 'Maret';
        break;
    case 4;
        $monthName = 'April';
        break;
    case 5;
        $monthName = 'Mei';
        break;
    case 6;
        $monthName = 'Juni';
        break;
    case 7;
        $monthName = 'Juli';
        break;
    case 8;
        $monthName = 'Agustus';
        break;
    case 9;
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
    .row{
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    .table-border {
        border: 1px solid black;
    }
    .border-horizontal {
        border-bottom: 1px solid black;
    }
    .table-report {
        border-top: 1px solid black;
/*        border-bottom: 1px solid black;
        border-left: 2px solid black;*/
        border-right: 1px solid black;
    }
    table{
		
    }
    .text-center {
        text-align: center;
    }
    .text-right {
        text-align: right;
    }
    .border-summary{
        border-top: 1px solid black;
        border-left: 1px solid black;
/*        border-right: 1px solid black;*/
    }
    .right-bottom {
        border-top: 1px solid black;
        border-right: 1px solid black;
        border-bottom: 1px solid black;
        border-left: 1px solid black;
    }
    .text {
        font-size: 12px;
    }
</style>
<body style="font-family: 'Eurostar'">
	<div class="row" style="height: 130px;"></div>
    <div style="border: 1px solid black; margin-left: -20px; margin-right: -20px; padding: 15px">    

    <div style="float: left; width: 45%; ">Sertifikat Distribusi Farmasi No.</div>
    <div style="float: left"> 
         : <?= AppHelper::getSetting('SertifikatDistribusiFarmasi','Sertifikat Distribusi Farmasi No') ?>
    </div>
    <div style="float:left; width: 45%">Sertifikat CDOB Bahan Obat No.</div>
    <div style="float: left">: <?= AppHelper::getSetting('SertifikatCDOB','Sertifikat CDOB Bahan Obat') ?></div>
    <div style="float:left; width: 45%">Sertifikat CDOB Cold Chain Product (CCP) No.</div>
    <div style="float: left">: <?= AppHelper::getSetting('SertifikatCDOBCCP','Sertifikat CDOB Cold Chain Product') ?></div>
    <div style="float:left; width: 45%">Ijin IT Prekursor Farmasi No.</div>
    <div style="float: left">: <?= AppHelper::getSetting('IjinITPrekursorFarmasi','Ijin IT Prekursor Farmasi No') ?></div>
    <div style="float:left; width: 45%">Ijin Psikotropika No.</div>
    <div style="float: left">
        : <?= AppHelper::getSetting('IjinPsikotropika','Ijin Importir Terdaftar Psikotropika') ?>
    </div>
    <div class="row" style="text-align: center; font-size: 20px; margin-top: 12px; font-weight: bold">Faktur Penjualan</div>
    <div class="row">
        <div class="right-bottom" style="margin-top: 10px; padding-left: 15px; ">
            <div style="float: left; width: 60%;">No. Faktur : <?= $modelHead['invoiceNum'] ?></div>
            <div style="float: left; width: 40%;">Tanggal      : <?= $modelHead['date'] ?></div>
            <div style="float: left; width: 60%;">Pembayaran : <?= $dueDate ?> hari</div>
            <div style="float: left; width: 40%;">Jatuh Tempo  : <?= $jatuhTempo ?></div>
        </div>
        <div class="row border-inside" style="margin-top: 15px; font-size: 18px; font-weight: bold">Pembeli BKP / Penerima JKP</div>
        <div class="row border-inside">
            <div style="float: left; width: 20%">Nama Pelanggan</div>
            <div style="float: left; width: 5%">:</div>
            <div style="float: left"><?= $modelHead['customerName'] ?></div>
        </div>
        <div class="row border-inside">
            <div style="float: left; width: 20%">Alamat</div>
            <div style="float: left; width: 5%">:</div>
            <div>
                <?= nl2br($modelHead['npwpAddress']) ?>
            </div>
        </div>
        <div class="row border-inside">
            <div style="float: left; width: 20%">Telp </div>
            <div style="float: left; width: 5%">:</div>
            <div style="float: left"><?= $modelHead['phone'] ?></div>
        </div>
        <div class="row border-inside">
            <div style="float: left; width: 20%">NPWP </div>
            <div style="float: left; width: 5%">:</div>
            <div style="float: left"><?= $modelHead['npwp'] ?></div>
        </div>
        <br>
        <div class="row border-inside">
            <div style="float: left; width: 20%">PO Customer Number</div>
            <div style="float: left; width: 5%">:</div>
            <div style="float: left"><?= $modelHead['customerOrderNum'] ?></div>
        </div>
        <div class="row border-inside">
            <div style="float: left; width: 20%">DO Number</div>
            <div style="float: left; width: 5%">:</div>
            <div style="float: left"><?= $modelHead['goodsDeliveryNum'] ?></div>
        </div>
        <div class="row">
            <table class="table table-report">
                <thead>
                    <tr>
                        <th style="width: 3%; border-left: 1px solid black; font-size: 2em;">No.</th>
                        <th style="width: 20%; border-left: 1px solid black; font-size: 2em;">Nama Barang</th>
                        <th style="width: 12%; border-left: 1px solid black; font-size: 2em;">Banyaknya</th>
                        <th style="width: 10%; border-left: 1px solid black; font-size: 2em;">Satuan</th>
                        <th style="width: 15%; border-left: 1px solid black; font-size: 2em;">No. Batch</th>
                        <th style="width: 15%; border-left: 1px solid black; font-size: 2em;">Harga Satuan</th>
                        <th colspan="2" style="width: 25%; border-left: 1px solid black; font-size: 2em;">Jumlah</th>
                    </tr>
                </thead>
                <<tbody>
                    <tr>
                        <td colspan="8" style="border-left: 1px solid black; border-top: 1px solid black; "></td>
                    </tr>
                    <?php
                        $totalBasicPrice = 0;
                        $countDetail = 1;
                        foreach($modelDetail as $modelDetail){
                    ?>
                    <tr>
                        <td class="text-center" style="border-left: 1px solid black; border-top: 1px solid black; font-size: 2em;"><?= $countDetail ?></td>
                        <td style="padding-left:10px; border-left: 1px solid black; border-top: 1px solid black; font-size: 2em;"><?= $modelDetail['productName']."<br><span style='font-size: 0.9em;'>".$modelDetail['origin']."</span>" ?></td>
                        <td class="text-center" style="border-left: 1px solid black; border-top: 1px solid black; font-size: 2em;">
                                <?=
                                is_decimal($modelDetail['qty']) ? number_format($modelDetail['qty'], 4, '.', ',') : number_format($modelDetail['qty'], 0, ',', '.')?>
                        </td>
                        <td class="text-center" style="border-left: 1px solid black; border-top: 1px solid black; font-size: 2em;"><?= $modelDetail['uomName']; ?></td>
                        <td class="text-center" style="border-left: 1px solid black; border-top: 1px solid black; font-size: 2em;"><?= $modelDetail['batchNumber']; ?></td>
                        <td class="text-right" style="border-left: 1px solid black; border-top: 1px solid black; font-size: 2em;">Rp <?= number_format($modelDetail['price'],2,",",".")?></td>
                        <td style="border-left: 1px solid black; border-top: 1px solid black; padding-left: 5px; font-size: 2em;">
                            Rp
                        </td>
                        <td class="text-right" style="border-top: 1px solid black; font-size: 2em;"><?= number_format(round($modelDetail['qty']*$modelDetail['price']*(100-$modelDetail['discount'])/100),0,",",".") ?></td>
                    </tr>
                    <?php
                        $totalBasicPrice = $totalBasicPrice + round($modelDetail['qty']*$modelDetail['price']*(100-$modelDetail['discount'])/100);
                        $countDetail++;
                        }
                        $Tax = $modelHead['tax'];
                        
                       ($Tax == 0 ) ?  $taxTotal = 0.00 : $taxTotal = round(0.1*$totalBasicPrice);
                        
                    ?>
                    <tr>
                        <td colspan="4" style="border-top: 1px solid black; font-size: 2em;"></td>
                        <td colspan="2" style="border-top: 1px solid black; font-size: 2em;">Jumlah Harga Jual</td>
                        <td style="border-left: 1px solid black; border-top: 1px solid black; padding-left: 5px; font-size: 2em;">Rp</td>
                        <td style="border-top: 1px solid black; text-align: right; font-size: 2em;"><?= number_format(($totalBasicPrice),0,",",".") ?></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td colspan="2" style="font-size: 2em;">Dasar Pengenaan Pajak</td>
                        <td style="border-left: 1px solid black; border-top: 1px solid black; padding-left: 5px; font-size: 2em;">Rp</td>
                        <td style=" border-top: 1px solid black; text-align: right; font-size: 2em;"><?= number_format(($totalBasicPrice),0,",",".") ?></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td colspan="2" style="font-size: 2em;">PPn 10% x DPP</td>
                        <td style="border-left: 1px solid black; border-top: 1px solid black; padding-left: 5px; font-size: 2em;">Rp</td>
                        <td style="border-top: 1px solid black; text-align: right; font-size: 2em;"><?= number_format($taxTotal,0,",",".") ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" ></td>
                        <td colspan="2" style="font-size: 2em;">Materai</td>
                        <td style="border-left: 1px solid black; border-top: 1px solid black; padding-left: 5px; font-size: 2em;">Rp</td>
                        <td style="border-top: 1px solid black; text-align: right; font-size: 2em;"><?= number_format($materai,0,",","."); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td colspan="2" style="font-size: 2em;">Jumlah Harga Pembelian</td>
                        <td style="border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; padding-left: 5px; font-size: 2em;">Rp</td>
                        <td style="border-top: 1px solid black; border-bottom: 1px solid black; text-align: right; font-size: 2em;"><?= number_format(($totalBasicPrice)+$taxTotal+$materai,0,",",".") ?></td>
                    </tr>
				</tbody>
            </table>
        </div>
        <div class="row" style="margin-top:10px; font-size: 12px">	
            <div style="float: left; width: 10%;">Terbilang</div>
            <div style="float: left; width: 90%; font-weight: bold;"> 
                <?php 
                        $terbilang = new NumberFormatter("id-ID", NumberFormatter::SPELLOUT);
                        echo ": ".ucfirst($terbilang->format($totalBasicPrice+$taxTotal+$materai))." rupiah"; 
                ?>
            </div>
        </div>      
        <div class="row" style=" font-size: 12px">  
            <div style="float: left; width: 10%;">Catatan</div>
            <div style="float: left; width: 90%;"> 
                : <?= $info = str_replace("</p>","",str_replace("<p>","",$modelHead['additionalInfo']));?>
          
                <?php if ($modelHead['additionalInfo'] != NULL) { ?>
                    <ul style="margin-left: -20px; margin-top: 10px;" >
                <?php } else { ?>
                    <ul style="margin-left: -20px; margin-top: -15px;" >
                <?php } ?>
                    <li>Pembayaran dapat ditransfer ke : <br>
                        BCA cab. Green Garden <br>
                        ACC No. 253-30-8030-8 (IDR) <br>
                        attn. PT. Qwinjaya Aditama.
                    </li>
                    <li>Keterlambatan Pembayaran akan dikenakan bunga 1,25% / bulan, hingga pembayaran kami terima</li>
                </ul>
                
            </div>
        </div>    
        <div class="row" style=" border: 1px solid black; border-width: 1px; font-size: 12px; ">
            <div style="float: left; width: 15%; padding-top: 15px;  border-right: 1px solid black; height: 120px;">
                <?php echo Html::img('assets_b/images/qbarcode.png',['height' => '120px', 'width' => '120px']) ?>
                    
            </div>
            <div style="float: left; width: 55%; padding-top: 15px; padding-left: 10px; height: 120px;">
                <div style="float: left; width: 100%; text-align: center; font-weight: bold">Apoteker Penanggung Jawab</div>
                <div style="float: left; width: 30%; margin-top: 5px">Nama</div><div style="float:left">: <?= $pharmacistName['value1']; ?></div>
                <div style="float: left; width: 30%">No. Ijin Kerja</div><div style="float:left">: <?= $pharmacistNumber['value1']; ?></div>
            </div>
            <div style="float: left; height: 90px; text-align: center; border-left: 1px solid black; padding-top: 5px; padding-bottom: 12px;">
                Hormat Kami,
                <br><br>
                <br><br>
				<br><br>
				<br>
                <strong>[ <?= AppHelper::getSetting('CompanyName','Company Name') ?> ]</strong>
            </div>
        </div>
<!--        <div class="row" style=" font-size: 12px">  
            <div style="float: left; width: 10%;">Catatan </div>
            <div style="float: left; width: 90%;" > 
              :  <ul style=" margin-top: -13px;" >
                    <li>Pembayaran dapat ditransfer ke : <br>
                        BCA cab. Green Garden <br>
                        ACC No 253.30.8030.8 (IDR) <br>
                        attn. PT. QWINJAYA Aditama.
                    </li>
                    <li>Keterlambatan Pembayaran akan dikenakan bunga 1,25% / bulan, hingga pembayaran kami terima</li>
                </ul>
            </div>
        </div> -->
    </div>
    </div>
</body>
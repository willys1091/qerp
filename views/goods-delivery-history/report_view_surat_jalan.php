<?php

use app\components\AppHelper;
use app\models\TrSalesorderhead;
use yii\helpers\Html;

$model2 = $model;

$officeCountry = $model[0]['officeCountry'];
$officeCity = $model[0]['officeCity'];
$officeStreet = $model[0]['officeStreet'];
$officePostalCode = $model[0]['officePostalCode'];
$officePhone = $model[0]['officePhone'];
$officeFax = $model[0]['officeFax'];
$no=0;
foreach  ($model2 as $model2) {
    $goodsDeliveryNum = $model2['goodsDeliveryNum'];
    $refNum = $model2['refNum'];
    $year = $model2['year'];
    $month = $model2['month'];
    $day = $model2['day'];
    $customerName = $model2['customerName'];
    $streetC = $model2['street'];
    $cityC = $model2['city'];
    $countryC = $model2['country'];
    $phoneC = $model2['phone'];
    $postC = $model2['postalCode'];
    $shipmentBy = $model2['shipmentBy'];
    $npwpAddress = $model2['npwpAddress'];
$no++;}
$monthName = '';
switch ($month){
    case 1: $monthName = 'Januari'; break;
    case 2: $monthName = 'Februari'; break;
    case 3: $monthName = 'Maret'; break;
    case 4; $monthName = 'April'; break;
    case 5; $monthName = 'Mei'; break;
    case 6; $monthName = 'Juni'; break;
    case 7; $monthName = 'Juli'; break;
    case 8; $monthName = 'Agustus'; break;
    case 9; $monthName = 'September'; break;
    case 10; $monthName = 'Oktober'; break;
    case 11; $monthName = 'November'; break;
    case 12; $monthName = 'Desember'; break;
}

$salesOrderModel = TrSalesorderhead::findOne(['salesOrderNum' => $refNum]);
?>
<style type="text/css">
	@page {
		/*margin-top: 2.54cm;
		margin-bottom: 2.54cm;*/
		margin-left: 1cm;
		margin-right: 1cm;
	}
    table{
        width: 100%;
        font-size: 13px;
        border: 1px solid black;
        border-collapse: collapse;
        border-left: none;
        border-right: none;
    }
    th{
        font-family: 'Eurostar';
    }
    td{
        font-family: 'Eurostar';
    }
</style>

<?php if($no > 1){ ?>
<div class="row" style="height: 100px; "></div>
<div style="border: 2px solid black; margin-left: -20px; margin-right: -20px;  font-family: 'Eurostar'">
    <div style="padding-left: 15px; padding-right: 15px">

        <div style="float: left; width: 40%; margin-top: 10px">Sertifikat Distribusi Farmasi No.</div>
        <div style="float: left"> 
            : <?= AppHelper::getSetting('SertifikatDistribusiFarmasi','Sertifikat Distribusi Farmasi No') ?>
        </div>
        <div style="float:left; width: 40%">Sertifikat CDOB Bahan Obat No.</div>
        <div style="float: left">: <?= AppHelper::getSetting('SertifikatCDOB','Sertifikat CDOB Bahan Obat') ?></div>
        <div style="float:left; width: 40%">Sertifikat CDOB Cold Chain Product (CCP) No.</div>
        <div style="float: left">: <?= AppHelper::getSetting('SertifikatCDOBCCP','Sertifikat CDOB Cold Chain Product') ?></div>
        <div style="float:left; width: 40%">Ijin IT Prekursor Farmasi No.</div>
        <div style="float: left">: <?= AppHelper::getSetting('IjinITPrekursorFarmasi','Ijin IT Prekursor Farmasi No') ?></div>
        <div style="float:left; width: 40%">Ijin Psikotropika No.</div>
        <div style="float: left">
            : <?= AppHelper::getSetting('IjinPsikotropika','Ijin Importir Terdaftar Psikotropika') ?>
        </div>
    </div>
    <div style="height: 4px; margin-top: 10px; border-top: 1px solid black; border-bottom: 1px solid black"></div>
    <div style="padding-left: 15px; padding-right: 15px">
        <div style="text-align: center; font-size: 20px; "><u><b>Surat Penyerahan Barang</b></u></div>
    <div style="font-size: 13px; margin-top: 5px; text-align: center">Tanggal. <?= $day; ?> <?= $monthName; ?> <?= $year; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ No. <?= $goodsDeliveryNum; ?></div>
    <div style="margin-top: 5px; margin-bottom: 10px; height: 120px">
        <div style="float: left; width: 50%;">
            <div style="font-size: 13px; padding-bottom: 5px">Kepada Yth,  </div>
            <div style="padding-left: 10px">
               
                <?php if (true || $officeCountry) { ?>
                
                    <?= $customerName; ?><br>
                    <?= nl2br($officeStreet); ?><br>
                    <u><?= $officeCity.' '; ?><?= $officePostalCode; ?>
					
					<?php if (!$officePostalCode){  ?>
					
					<?= $officeCountry ? $officeCountry : ''; ?></u><br>
					
					<?php  } else {?>
					
					<?= $officeCountry ? ', '.$officeCountry : ''; ?></u><br>
					
					<?php } ?>
					
					
                    Tlp :  <?= $officePhone; ?> 
                    
                <?php } else { ?>
                
                    <?= $customerName; ?><br>
                    <?= $npwpAddress; ?><br>
                    <u><?= $cityC; ?> <?= $postC; ?> <?= $countryC; ?></u><br>
                    Tlp :  <?= $phoneC; ?> 
                
                <?php } ?>
            </div>
        </div>
        <div style="float: left; padding-left: 10px;">
            <div style="font-size: 13px; padding-bottom: 5px">Dikirim ke:</div>
            <div style="padding-left: 10px">
            <?= $customerName; ?><br>
            <?= nl2br($streetC); ?><br>  
            <u><?= $cityC.' '; ?><?= $postC; ?>
			
			<?php if (!$postC){  ?>
					
					<?= $countryC ? $countryC : ''; ?></u><br>
					
					<?php  } else {?>
					
					<?= $countryC ? ', '.$countryC : ''; ?></u><br>
					
					<?php } ?>
			
			
			
            Tlp : <?= $phoneC; ?>
            </div>
        </div>
    </div>
    <div style="float: left; width: 53%; margin-bottom: 5px; font-size: 13px">No. Pesanan Pelanggan : <?= $salesOrderModel->customerOrderNum; ?></div>
    <div style="margin-bottom: 5px; font-size: 13px;">Melalui: <?= $shipmentBy; ?></div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 7%; border-bottom: 1px solid black; border-left: 1px solid black; text-align: center">Jumlah</th>
                <th style="width: 8%; border-left: 1px solid black; border-bottom: 1px solid black; text-align: center">Satuan</th>
                <th style="width: 20%; border-left: 1px solid black; border-bottom: 1px solid black; padding-left: 10px">Nama Barang</th>
                <th style="width: 15%; border-left: 1px solid black; border-bottom: 1px solid black; text-align: center">No. Lot/ Batch</th>
                <th style="width: 50%; border-left: 1px solid black; border-bottom: 1px solid black; padding-left: 10px; border-right: 1px solid black">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5" style="border-left: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black"></td>
            </tr>
            <?php foreach ($model as $model) { ?>
            <tr>
                <td style="font-size: 16px; width: 7%; border-bottom: 1px solid black; border-left: 1px solid black; text-align: center"><?= floatVal($model['qty']); ?></td>
                <td style="font-size: 16px; width: 8%; border-left: 1px solid black; border-bottom: 1px solid black; text-align: center"><?= $model['uomName']; ?></td>
                <td style="font-size: 16px; width: 28%; border-left: 1px solid black; border-bottom: 1px solid black; padding-left: 10px"><?= $model['productName']; ?></td>
                <td style="width: 15%; border-left: 1px solid black; border-bottom: 1px solid black; text-align: center; font-size: 14px"><?= $model['batchNumber']; ?></td>
                <td style="border-left: 1px solid black; border-bottom: 1px solid black; padding-left: 10px; border-right: 1px solid black; font-size: 13px">
                    - Origin : <?= $model['origin'] ?>
                    <br>- Packing Type : <?= $model['packingTypeName'] ?>
                    <?php IF ($model['manufactured']) ECHO "<br>- Mfg Date : ".$model['manufactured']; ?>
                    <?php IF ($model['retest']) ECHO "<br>- Retest Date : ".$model['retest']; ?>
                    <?php IF ($model['expired']) ECHO "<br>- Expired Date : ".$model['expired']; ?>
                    <br><?= $model['notes'] ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div style=" padding-bottom: 10px">
        <div style="float: left; width: 50%; font-size: 12px">
            Catatan Penerima Barang:<br>
        </div>
        <div style="float: left; font-size: 12px; vertical-align: bottom;">
            <div style="text-align: center">Penerima Barang,<br>
            <br>
			
            
            (.........................................................................)<br>
            Nama Jelas & Stempel Perusahaan
            </div>
            <div style="padding-left: 25.5%;">Tanggal:</div>
        </div>
    </div>
    </div>
    <div style="font-size: 12px; border-top: 1px solid black;">
		<div style="float: left; width: 15%; border-right: 1px solid black; height: 30px"><?php echo Html::img('assets_b/images/qbarcode.png',['height' => '90px', 'width' => '100px']) ?></div>
		<div style="float: left; width: 55%; padding-top: 5px; padding-left: 10px">
			<div style="float: left; width: 100%; text-align: center; font-weight: bold; font-size: 14px">Apoteker Penanggung Jawab</div>
			<div style="float: left; width: 23%; margin-top: 5px; font-size: 15px">Nama</div><div style="float:left; font-size: 15px">: <?= $pharmacistName['value1']; ?></div>
			<div style="float: left; width: 23%; font-size: 15px">No. Ijin Kerja</div><div style="float:left; font-size: 15px">: <?= $pharmacistNumber['value1']; ?></div>
		</div>
		<div style="float: left; text-align: center; border-left: 1px solid black; padding-top: 5px; padding-bottom: 5px">
			<span style="font-size:14px;">Hormat Kami,</span><br>
			<br>
			<br>
		
           
			<span style="font-size:14px;"><strong>[ <?= AppHelper::getSetting('CompanyName','Company Name') ?> ]</strong></span>
		</div>
	</div>
</div>
<div style=" font-size: 10px; font-family: 'Eurostar'">*] Mohon Lembar Biru setelah ditanda tangani, Cap Perusahaan, dan tanggal terima. Harap dikirimkan kembali ke alamat kami atau di fax ke 021 - 58355060. [Sesuai dengan Peraturan BPOM]</div>



<?php } else {?>

<div class="row" style="height: 100px; "></div>
<div style="border: 2px solid black; margin-left: -20px; margin-right: -20px;  font-family: 'Eurostar'">
    <div style="padding-left: 15px; padding-right: 15px">

    <div style="float: left; width: 40%; margin-top: 10px">Sertifikat Distribusi Farmasi No.</div>
    <div style="float: left"> 
        : <?= AppHelper::getSetting('SertifikatDistribusiFarmasi','Sertifikat Distribusi Farmasi No') ?>
    </div>
    <div style="float:left; width: 40%">Sertifikat CDOB Bahan Obat No.</div>
    <div style="float: left">: <?= AppHelper::getSetting('SertifikatCDOB','Sertifikat CDOB Bahan Obat') ?></div>
    <div style="float:left; width: 40%">Sertifikat CDOB Cold Chain Product (CCP) No.</div>
    <div style="float: left">: <?= AppHelper::getSetting('SertifikatCDOBCCP','Sertifikat CDOB Cold Chain Product') ?></div>
    <div style="float:left; width: 40%">Ijin IT Prekursor Farmasi No.</div>
    <div style="float: left">: <?= AppHelper::getSetting('IjinITPrekursorFarmasi','Ijin IT Prekursor Farmasi No') ?></div>
    <div style="float:left; width: 40%">Ijin Psikotropika No.</div>
    <div style="float: left">
        : <?= AppHelper::getSetting('IjinPsikotropika','Ijin Importir Terdaftar Psikotropika') ?>
    </div>
</div>
    <div style="height: 4px; margin-top: 10px; border-top: 1px solid black; border-bottom: 1px solid black"></div>
    <div style="padding-left: 15px; padding-right: 15px">
        <div style="text-align: center; font-size: 20px; margin-top: 10px"><u><b>Surat Penyerahan Barang</b></u></div>
    <div style="font-size: 13px; margin-top: 10px; text-align: center">Tanggal. <?= $day; ?> <?= $monthName; ?> <?= $year; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ No. <?= $goodsDeliveryNum; ?></div>
    <div style="margin-top: 15px; margin-bottom: 10px; height: 130px">
        <div style="float: left; width: 50%;">
            <div style="font-size: 13px; padding-bottom: 10px">Kepada Yth,  </div>
            <div style="padding-left: 10px">
               
                <?php if (true || $officeCountry) { ?>
                
                    <?= $customerName; ?><br>
                    <?= nl2br($officeStreet); ?><br>
                    <u><?= $officeCity.' '; ?><?= $officePostalCode; ?>
					
					<?php if (!$officePostalCode){  ?>
					
					<?= $officeCountry ? $officeCountry : ''; ?></u><br>
					
					<?php  } else {?>
					
					<?= $officeCountry ? ', '.$officeCountry : ''; ?></u><br>
					
					<?php } ?>
					
					
                    Tlp :  <?= $officePhone; ?> 
                    
                <?php } else { ?>
                
                    <?= $customerName; ?><br>
                    <?= $npwpAddress; ?><br>
                    <u><?= $cityC; ?> <?= $postC; ?> <?= $countryC; ?></u><br>
                    Tlp :  <?= $phoneC; ?> 
                
                <?php } ?>
            </div>
        </div>
        <div style="float: left; padding-left: 10px;">
            <div style="font-size: 13px; padding-bottom: 10px">Dikirim ke:</div>
            <div style="padding-left: 10px">
            <?= $customerName; ?><br>
            <?= nl2br($streetC); ?><br>  
            <u><?= $cityC.' '; ?><?= $postC; ?>
			
			<?php if (!$postC){  ?>
					
					<?= $countryC ? $countryC : ''; ?></u><br>
					
					<?php  } else {?>
					
					<?= $countryC ? ', '.$countryC : ''; ?></u><br>
					
					<?php } ?>
			
			
			
            Tlp : <?= $phoneC; ?>
            </div>
        </div>
    </div>
    <div style="float: left; width: 53%; margin-bottom: 10px; font-size: 13px">No. Pesanan Pelanggan : <?= $salesOrderModel->customerOrderNum; ?></div>
    <div style="margin-bottom: 10px; font-size: 13px;">Melalui: <?= $shipmentBy; ?></div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 7%; border-bottom: 1px solid black; border-left: 1px solid black; text-align: center">Jumlah</th>
                <th style="width: 8%; border-left: 1px solid black; border-bottom: 1px solid black; text-align: center">Satuan</th>
                <th style="width: 20%; border-left: 1px solid black; border-bottom: 1px solid black; padding-left: 10px">Nama Barang</th>
                <th style="width: 15%; border-left: 1px solid black; border-bottom: 1px solid black; text-align: center">No. Lot/ Batch</th>
                <th style="width: 50%; border-left: 1px solid black; border-bottom: 1px solid black; padding-left: 10px; border-right: 1px solid black">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5" style="border-left: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black"></td>
            </tr>
            <?php foreach ($model as $model) { ?>
            <tr>
                <td style="font-size: 16px; width: 7%; border-bottom: 1px solid black; border-left: 1px solid black; text-align: center"><?= floatVal($model['qty']); ?></td>
                <td style="font-size: 16px; width: 8%; border-left: 1px solid black; border-bottom: 1px solid black; text-align: center"><?= $model['uomName']; ?></td>
                <td style="font-size: 16px; width: 28%; border-left: 1px solid black; border-bottom: 1px solid black; padding-left: 10px"><?= $model['productName']; ?></td>
                <td style="width: 15%; border-left: 1px solid black; border-bottom: 1px solid black; text-align: center; font-size: 14px"><?= $model['batchNumber']; ?></td>
                <td style="border-left: 1px solid black; border-bottom: 1px solid black; padding-left: 10px; border-right: 1px solid black; font-size: 13px">
                    - Origin : <?= $model['origin'] ?>
                    <br>- Packing Type : <?= $model['packingTypeName'] ?>
                    <?php IF ($model['manufactured']) ECHO "<br>- Mfg Date : ".$model['manufactured']; ?>
                    <?php IF ($model['retest']) ECHO "<br>- Retest Date : ".$model['retest']; ?>
                    <?php IF ($model['expired']) ECHO "<br>- Expired Date : ".$model['expired']; ?>
                    <br><?= $model['notes'] ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div style="margin-top: 10px; padding-bottom: 10px">
        <div style="float: left; width: 50%; font-size: 12px">
            Catatan Penerima Barang:<br>
        </div>
        <div style="float: left; font-size: 12px; vertical-align: bottom;">
            <div style="text-align: center">Penerima Barang,<br>
            <br>
            <br>
            <br>
       
           
            (.........................................................................)<br>
            Nama Jelas & Stempel Perusahaan
            </div>
            <div style="padding-left: 25.5%;">Tanggal:</div>
        </div>
    </div>
    </div>
    <div style="font-size: 12px; border-top: 1px solid black;">
		<div style="float: left; width: 15%; border-right: 1px solid black; height: 120px"><?php echo Html::img('assets_b/images/qbarcode.png',['height' => '200px', 'width' => '150px']) ?></div>
		<div style="float: left; width: 55%; padding-top: 5px; padding-left: 10px">
			<div style="float: left; width: 100%; text-align: center; font-weight: bold; font-size: 14px">Apoteker Penanggung Jawab</div>
			<div style="float: left; width: 23%; margin-top: 5px; font-size: 15px">Nama</div><div style="float:left; font-size: 15px">: <?= $pharmacistName['value1']; ?></div>
			<div style="float: left; width: 23%; font-size: 15px">No. Ijin Kerja</div><div style="float:left; font-size: 15px">: <?= $pharmacistNumber['value1']; ?></div>
		</div>
		<div style="float: left; text-align: center; border-left: 1px solid black; padding-top: 5px; padding-bottom: 20px">
			<span style="font-size:14px;">Hormat Kami,</span><br>
			<br>
			<br>
			<br>
			<br>
			
			

			<span style="font-size:14px;"><strong>[ <?= AppHelper::getSetting('CompanyName','Company Name') ?> ]</strong></span>
		</div>
	</div>
</div>
<div style=" font-size: 12px; font-family: 'Eurostar'">*] Mohon Lembar Biru setelah ditanda tangani, Cap Perusahaan, dan tanggal terima. Harap dikirimkan kembali ke alamat kami atau di fax ke 021 - 58355060. [Sesuai dengan Peraturan BPOM]</div>

<?php } ?>
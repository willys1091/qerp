<?php
use yii\helpers\Html;
use app\models\MsSetting;

date_default_timezone_set('Asia/Jakarta');
$dateYear = date('Y');
$dateMonth = date('m');
$dateDay = date('d');
$modelHead = $model;
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
    th, td {
    text-align: center; font-size: 15px; padding: 5px; border-bottom: 1px solid black; border-left: 1px solid black;
    }
    
 
</style>
<body style="font-family: Eurostar">        
<div class="row" style="text-align: center">
	 <div style="text-align: center"><?php echo Html::img('assets_b/images/image.jpg',['height' => '85px', 'width' => '80px']) ?> </div>
</div>                 
<div class="row" style="font-size: 16px; color: green; text-align: center; font-size: 16pt;">PT.QWINJAYA ADITAMA</div>
<div class="row" style="text-align: center; font-size: 13px;">Importer & Supplier of Pharmaceutical Raw Materials and Finished Products</div>
<div class="row" style="text-align: center; font-size: 13px;">
	Kantor/Gudang : <?= MsSetting::findOne(['key1' => 'OfficeAddress'])->value1; ?>, <?= MsSetting::findOne(['key1' => 'Kelurahan'])->value1; ?>, <?= MsSetting::findOne(['key1' => 'Kecamatan'])->value1; ?>, <?= MsSetting::findOne(['key1' => 'Province'])->value1; ?> <?= MsSetting::findOne(['key1' => 'PostalCode'])->value1; ?> - <?= MsSetting::findOne(['key1' => 'Country'])->value1; ?>
</div>
<div class="row" style="text-align: center; font-size: 11px;">
	Telp : <?= MsSetting::findOne(['key1' => 'Phone1'])->value1; ?> ; <?= MsSetting::findOne(['key1' => 'Phone2'])->value1; ?> ; <?= MsSetting::findOne(['key1' => 'Phone3'])->value1; ?>, Fax: <?= MsSetting::findOne(['key1' => 'Fax'])->value1; ?>
</div>
<div class="row" style="text-align: center; font-size: 11px;">
	NPWP : <?= MsSetting::findOne(['key1' => 'NPWP'])->value1; ?>
</div>
<div class="row" style="margin-top: 10px; text-align: center; ">
	<strong>Ijin Pedagang Besar Farmasi No. : <?= MsSetting::findOne(['key1' => 'IjinPedagangFarmasi'])->value1; ?></strong>
</div>
<div class="row" style="text-align: center; ">
	<strong>Ijin IT Prekursor Farmasi No. : <?= MsSetting::findOne(['key1' => 'IjinITPrekursorFarmasi'])->value1; ?></strong>
</div>
<div class="row" style="text-align: center; font-size: 14pt;"><strong>Faktur</strong></div>
    <div class="row table-border">
        <div class="col-xs-12">
            <div class="col-xs-4">No. Faktur : </div>
            <div class="col-xs-4" style="text-align: right; margin-top: -15px;">Jakarta, <?php echo $dateDay." ".$monthName." ".$dateYear; ?></div>
            <div class="row border-horizontal" style="padding:0;"></div>
            <div class="row border-inside" style="margin-top: 15px;"><strong>Pembeli BKP / Penerima JKP</strong>
            </div>
            <div class="row border-inside">
                <div class="col-xs-3 col-sm-3 col-md-3" style="padding:0;"><strong><?= $modelHead[0]['customerName'] ?></strong> </div><div class="col-xs-1"></div>
            </div>
            <div class="row border-inside">
                <div class="col-xs-3 col-sm-3 col-md-3" style="padding:0;">Alamat </div>
                <div class="col-xs-8" style="padding:0; height: 80px;">
                    <?= nl2br($modelHead[0]['npwpAddress']) ?>
                </div>
            </div>
            <div class="row border-inside">
                <div class="col-xs-3 col-sm-3 col-md-3" style="padding:0;">NPWP :<strong> <?= $modelHead[0]['npwp'] ?></strong></div>
            </div>
            <table style="width: 100%; border: 1px solid black; border-collapse: collapse; margin-top: 10px; margin-bottom: 15px;">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 40%;">Nama Barang</th>
                        <th style="width: 15%;">Kwantum</th>
                        <th style="width: 20%;">Harga Satuan</th>
                        <th style="width: 10%;">Diskon</th>
                        <th style="width: 25%;">Jumlah</th>
                    </tr></thead>
                <tbody>
                    <?php
                    $totalBasicPrice = 0;
                    $countDetail = 1;
                    foreach ($modelHead as $modelDetail) {

                        ?>
                        <tr>
                            <td class="text-center"><?= $countDetail ?></td>
                            <td style="padding-left:10px;"><?= $modelDetail['productName'] ?></td>
                            <td class="text-center"><?= $modelDetail['qty'] . ' ' . $modelDetail['uomName'] ?></td>
                            <td class="text-center" style="text-align: right;">Rp <?= number_format($modelDetail['price'], 0, ",", ".") ?></td>
                            <td class="text-center"><?= $modelDetail['discount'] > 0 ? number_format($modelDetail['discount'], 0, ",", ".") . " %" : ""; ?></td>
                            <td class="text-right" style="text-align: right;">Rp <?= number_format($modelDetail['qty'] * $modelDetail['price'] * (100 - $modelDetail['discount']) / 100, 0, ",", ".") ?></td>
                        </tr>
                        <?php
                        $totalBasicPrice = $totalBasicPrice + $modelDetail['qty'] * $modelDetail['price'] * (100 - $modelDetail['discount']) / 100;
                        $countDetail++;
                    }
                    $taxTotal = 0.1 * $totalBasicPrice;

                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div  style="text-align:right;">
        <div class="row" >
            <div class="col-xs-5" >Jumlah Harga Jual</div>
            <div class="col-xs-5 summary-box-border text-right">Rp <?= number_format($totalBasicPrice, 2, ",", ".") ?></div>
        </div>
        <div class="row">
            <div class="col-xs-5">PPn 10% x Harga Jual</div>
            <div class="col-xs-5 summary-box-border text-right">Rp <?= number_format($taxTotal, 2, ",", ".") ?></div>
        </div>
        <div class="row">
            <div class="col-xs-5">Materai</div>
            <div class="col-xs-5 summary-box-border text-right"></div>
        </div>
        <div class="row">
            <div class="col-xs-5">Jumlah Harga Pembelian</div>
            <div class="col-xs-5 summary-box-border text-right">Rp <?= number_format($totalBasicPrice + $taxTotal, 2, ",", ".") ?></div>
        </div>
    </div>
    <div class="row" style="margin-top: -125px;">
        <div class="col-xs-4 col-sm-4 col-md-4">
            Apoteker Penanggung Jawab
        </div>
    </div>
    <div class="row" style="margin-top: 70px; ">	
        <div class="col-xs-2">Nama : <?= Yii::$app->user->identity->fullName; ?> </div>
    </div>
    <div class="row">
        <div class="col-xs-2" >No. Ijin Kerja :</div>
        <div class="col-xs-6">......................................................................</div>
    </div>
	<div class="row" style="margin-top:10px;">	
		<div class="col-xs-2">Terbilang : </div>
		<div class="col-xs-8">
            <i>
                <?php
                $terbilang = new NumberFormatter("id-ID", NumberFormatter::SPELLOUT);
                echo ucfirst($terbilang->format($totalBasicPrice + $taxTotal)) . " rupiah";

                ?>
            </i>
		</div>
	</div>
	<div class="row" style="margin-top:10px;">
		<div class="col-xs-2">Terbilang Nilai Pajak </div>
		<div class="col-xs-8">
            <i>
                <?php
                $terbilangPajak = new NumberFormatter("id-ID", NumberFormatter::SPELLOUT);
                echo ucfirst($terbilangPajak->format($taxTotal)) . " rupiah";

                ?>
            </i>
		</div>
	</div>
	<div class="row" style="margin-top:20px;">
		<div class="col-xs-2">Catatan :</div>
        
	</div>
</body>

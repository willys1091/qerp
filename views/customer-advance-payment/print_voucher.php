<style>
.table-report td{
    padding-left: 5px;
    padding-right: 5px;
}
.table-border {
    border: 1px solid black;
}
.table-signature tr td{
    text-align: center;
    font-weight: bold;
}
</style>

<?php
use yii\helpers\Html;

$model2 = $model;
//if($model[0]['flagCashInOut'] == "in"){
//    $flagCashInOut = "Pemasukan";
//}
//else{
//    $flagCashInOut = "Pengeluaran";
//}
//
//if(substr($model[0]['cashAccount'],0,4) == "1110"){
//    $accountType = "Kas";
//}
//else if(substr($model[0]['cashAccount'],0,4) == "1111"){
//    $accountType = "Bank";
//}
$totalPrice = 0;

?>
<!DOCTYPE html>
<html>
<head> 
</head>
<body style="font-family: Eurostar">
    <div style="width: 10%; float: left;"><?= Html::img('assets_b/images/image.jpg',['height' => '85px', 'width' => '80px']) ?> </div>
    <div style="width: 40%; float: left; padding-top: 20px; padding-left: 10px;">
        <b>PT. Qwinjaya Aditama</b><br/>
        <b>Bukti Penerimaan Bank</b>
    </div>
    <div style="width: 40%; float: left; text-align: right; padding-top: 20px; ">
        No. : <?= $model[0]['custAdvancePaymentNum'] ?> <br/>
        <?php if ($model[0]['custAdvancePaymentDate']) echo "Tgl : ".date('d-M-Y', strtotime($model[0]['custAdvancePaymentDate'])); ?>
    </div>
    <div style="margin-top: 20px; margin-bottom: 10px; border: 1px solid black; width: 100%;"></div>
    <div style="width: 25%; float: left;">
        Dibayar Kepada <br/>
        Mata Uang / Nilai Tukar <br/>
       
    </div>
    <div style="width: 35%; float: left;">
        : <?= $model[0]['customerName'] ?> <br/>
        : <?= "IDR/1.00"?>
       
    </div>
    <div style="width: 20%; float: left;">
        Sumber Dana <br/>
        No Cek/Giro <br/>
    </div>
    <div style="width: 20%; float: left;">
        : <?= $model[0]['paymentCOA'] ?> <br/>
        : <?= $model[0]['giroNum'] ?>
    </div>
    
    <table class="table-report" style="width: 100%; border: 2px solid black; margin-top: 20px; margin-bottom: 10px; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="width: 70%;">Keterangan</th>
                <th style="width: 30%; border-left: 1px solid black;" colspan="2">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($model2 as $modelDetail) { ?>
            <tr>
                <td style="border-top: 1px solid black; width: 70%;"><?= $modelDetail['additionalInfo']."/".$modelDetail['adminFeePaymentCoa'] ?></td>
                <td style="border-left: 1px solid black; border-top: 1px solid black; width: 5%;">Rp</td>
                <td style="border-top: 1px solid black; width: 25%; text-align: right;"><?= number_format($modelDetail['amount'],2,",",".") ?></td>
            </tr>
            <?php 
                $totalPrice = $totalPrice + $modelDetail['amount'];
                $no = $no + 1;
            } ?>
            <tr>
                <td style="border-top: 1px solid black; text-align: right;">Jumlah</td>
                <td style="border-left: 1px solid black; border-top: 1px solid black;">Rp</td>
                <td style="border-top: 1px solid black; text-align: right;"><?= number_format($totalPrice,2,",",".") ?></td>
            </tr>
        </tbody>
    </table>

    <div style="float: left; width: 20%;">Terbilang :</div>
    <div style="float: left; width: 80%;"> 
        <?php 
                $terbilang = new NumberFormatter("id-ID", NumberFormatter::SPELLOUT);
                echo ucfirst($terbilang->format($totalPrice))." Rp"; 
        ?>
    </div>

    <table class="table-signature" style="width: 100%; border: 2px solid black; margin-top: 20px; margin-bottom: 10px; border-collapse: collapse;">
        <tr>
            <td colspan="2" style="border-bottom: 2px solid black;">Accounting</td>
            <td rowspan="2" style="border-bottom: 2px solid black; border-left: 2px solid black;">Disetujui</td>
            <td rowspan="2" style="border-bottom: 2px solid black; border-left: 2px solid black;">Direksi</td>
            <td rowspan="2" style="border-bottom: 2px solid black; border-left: 2px solid black;">Penerima</td>
        </tr>
        <tr>
            <td style="border-bottom: 2px solid black;">Dibukukan</td>
            <td style="border-bottom: 2px solid black; border-left: 2px solid black;">Diperiksa</td>
        </tr>
        <tr>
            <td style="height: 100px;"></td>
            <td style="border-left: 2px solid black;"></td>
            <td style="border-left: 2px solid black;"></td>
            <td style="border-left: 2px solid black;"></td>
            <td style="border-left: 2px solid black;"></td>
        </tr>
    </table>
</body>
</html>


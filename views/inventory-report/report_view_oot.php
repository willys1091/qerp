<?php
use app\models\MsSupplier;
use app\models\MsProduct;
use yii\helpers\Url;
use yii\helpers\Html;

foreach ($model as $model){
    $qty = $model['qty'];
}
$qtyOut = '';
$countOut = count($model5);
$j = 0;
$batchNumberOut = '';
foreach($model5 as $model5){
$qtyOut = $qtyOut + $model5['jumlah'];
$j = $j + 1;
    if($j == $countOut){
        $batchNumberOut = $model5['batchNumber'];
    }
}
?>
<html>
    <head>
        <style type="text/css">
            table{
                border-collapse: collapse;
                width: 100%;
            }
            td,th{
                border: 1px solid black;
                font-size: 12px;
            }
            .header{
                float: left;
                font-size: 12px;
                text-align: left;
            }
        </style>
    </head>
    <body>
        <div style="padding: 10px; border: 1px solid black;">
            <table style="width:100%;">
                <tr>
                    <td style="height:50px; width: 25%; text-align: center; font-family: arial; font-size: 14px">
                        <?php echo Html::img('assets_b/images/logonew.png',['height' => '50px', 'width' => '50px']) ?>                       
                        <br/>PT.QWINJAYA ADITAMA</td>
                    <td style="font-family: arial; font-size: 24px; width: 50%; text-align: center"><?= $type; ?></td>
                    <td style="width: 25%; font-size: 10px; padding: 10px;">No : <br/>Date : <br/>Time Receipt : <br/></td>
                </tr>
            </table>
            <p style="text-align: center">Laporan OOT</p>
            <div style="float: left; width: 50%">
            <table>
                <thead>
                    <tr>
                        <th style="height: 53px;">Tgl/Bln/Thn</th>
                        <th>Saldo Awal Bulan</th>
                        <th>Batch Awal</th>
                        <th>NO.Faktur Masuk</th>
                        <th>Sumber</th>
                        <th>Jumlah Masuk</th>
                        <th>Batch Masuk</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i = 0;
                        $batchNumber = '';                        
                        $qtyIn = '';
                        foreach  ($model2 as $model2) {
                            if ($i == 0){
                            $batchNumberIn = $model2['batchNumber'];
                        }
                    ?>
                    <tr>
                        <td style="height: 48px"><?= date('Y-m-d', strtotime($model2['goodsReceiptDate'])); ?></td>
                        <td style="text-align:center"><?= $qty; ?></td>
                        <td style="text-align:center"><?= $batchNumberIn; ?></td>
                        <td style="text-align:center"><?= $model2['invoiceNum']; ?></td>
                        <td><?= $model2['supplierName']; ?></td>
                        <td style="text-align:center"><?= $model2['qty']; ?></td>
                        <td style="text-align:center"><?= $model2['batchNumber']; ?></td>
                    </tr>                    
                    <?php $i = $i + 1; 
                    $qtyIn = $qtyIn +  $model2['qty']; 
                    } ?>
                </tbody>
            </table>
            </div>
            <div style="float: left; width: 50%">
                <table>
                    <thead>
                        <tr>
                            <th style="height: 50px;">No.Faktur Keluar</th>
                            <th>Tujuan</th>
                            <th>Jumlah Keluar</th>
                            <th>Batch Keluar</th>
                            <th>Saldo Akhir</th>
                            <th>Batch Akhir</th>
                            <th>Expired</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = $qty + $qtyIn - $qtyOut;
                        foreach($model3 as $model3){ ?>
                        <tr>
                            <td style="height: 45px; text-align:center"><?= $model3['goodsDeliveryNum']; ?></td>
                            <td><?= $model3['customerName']; ?></td>
                            <td style="text-align:center"><?= $model3['jumlah']; ?></td>
                            <td style="text-align:center"><?= $model3['batchNumber']; ?></td>
                            <td style="text-align:center"><?= $total.'.00'; ?></td>
                            <td style="text-align:center"><?= $batchNumberOut; ?></td>
                            <td style="text-align:center"><?= date('Y-m-d', strtotime($model3['expiredDate'])); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <br/>
            <br/>
            <br/>
        </div>        
    </body>
</html>





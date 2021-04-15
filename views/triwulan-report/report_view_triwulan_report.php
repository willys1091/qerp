<?php
use app\models\MsSupplier;
use app\models\MsProduct;
use yii\helpers\Url;
use app\components\MdlDb;
use yii\helpers\Html;

$connection = MdlDb::getDbConnection();
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
                    <td style="height:50px; width: 25%; text-align: center; font-family: arial; font-size: 14px; ">
                        <?php echo Html::img('assets_b/images/image.jpg',['height' => '50px', 'width' => '50px']) ?>                     
                        <br/>PT.QWINJAYA ADITAMA</td>
                    <td style="font-family: arial; font-size: 24px; width: 50%; text-align: center; "></td>
                    <td style="width: 25%; font-size: 10px; padding: 10px;">No : <br/>Date : <br/>Time Receipt : <br/></td>
                </tr>
            </table>
                <p style="text-align: center;"><b><font face="Eurostile" size="2" color="#000000">LAPORAN TRI WULAN PENDISTRIBUSIAN BAHAN OBAT </font></b><br/>
                    <b><font face="Eurostile" size="2">PERIODE :OKTOBER - DESEMBER TAHUN 2016</font></b></br>
                    <b><font face="Eurostile" size="2">PBF PT. QWINJAYA ADITAMA</font></b><br/>
                    <b><font face="Eurostile" size="2">ALAMAT KANTOR,GUDANG, LABORATORIUM: GREEN GARDEN BLOK A7 NO 6, JAKARTA BARAT</font><br/>
                    <b><font face="Eurostile" size="2">NOMOR IZIN PBF : HK.07.01.BO/V/405/13</font></b><br/>
                    <b><font face="Eurostile" size="2">APOTEKER PENANGGUNG JAWAB / SIKA :006/2.35.1/31.73.05/-1.779.3/2016</font></b><br/>
                </p>            
            <?php   foreach ($model as $model){ ?>            
            <table style="width: 100%">
                <thead>
                    <tr>
                        <th style="text-align: center">TAHUN PERIODE</th>
                        <th style="text-align: center">PERIODE TRIWULAN</th>
                        <th>NAMA BAHAN</th>
                        <th>NAMA PRODUSEN</th>
                        <th>NEGARA PRODUSEN</th>
                        <th style="text-align: center">STOK AWAL(KG)</th>
                    </tr>                    
                    <tr>
                        <td style="text-align: center"><?= $year; ?></td>
                        <td style="text-align: center"><?= $periode; ?></td>
                        <td><?= $model['productName']; ?></td>
                        <td><?= $model['origin']; ?></td>
                        <td></td>
                        <td style="text-align: center"><?= $model['count']; ?></td>
                    </tr>                    
                </thead>
            </table>
                <br/>
                <div style=" float: left; width:50%">
                <table style="width: 100%">              
                <tr>
                    <td colspan="7" style="height: 50px; text-align: center">PEMASUKAN</td>
                </tr>
                <tr>
                    <td colspan="2">SUMBER</td>
                    <td rowspan="2" style="text-align: center">NO.FAKTUR</td>
                    <td rowspan="2" style="text-align: center">TANGGAL MASUK</td>
                    <td rowspan="2">BATCH NUMBER</td>
                    <td rowspan="2" style="text-align: right">JUMLAH(KG)</td>
                    <td rowspan="2" style="height:40px; text-align: center">TGL KADALUARSA</td>
                </tr>
                <tr>
                    <td>IMPORT</td>
                    <td>PBF LAIN</td>
                </tr>
                <?php
                $sql = 'SELECT b.isImport, d.supplierName, a.goodsReceiptDate, c.batchNumber, c.qty, c.expiredDate '
                        .'FROM tr_goodsreceipthead a '
                        .'INNER JOIN tr_purchaseorderhead b ON b.purchaseOrderNum = a.refNum '
                        .'INNER JOIN tr_goodsreceiptdetail c ON c.goodsReceiptNum = a.goodsReceiptNum '
                        .'INNER JOIN ms_supplier d ON d.supplierID = b.supplierID '
                        .'WHERE YEAR(a.goodsReceiptDate) = '.$year.' AND MONTH(a.goodsReceiptDate)'.$between
                        .' AND c.productID = '.$model['productID'];
                $command = $connection->createCommand($sql);
                $result = $command->queryAll();
                $counts = count($result);
                $qtyIn = '';
                foreach ($result as $result){ ?>
                <tr>
                    <td><?php if($result['isImport']== 1 ){
                                echo $result['supplierName']; } else { echo ''; } ?></td>
                    <td><?php if($result['isImport']== 0 ){
                                echo $result['supplierName']; } else { echo ''; } ?></td>
                    <td style="text-align: center">KOSONG</td>
                    <td style="text-align: center"><?= $result['goodsReceiptDate']; ?></td>
                    <td><?= $result['batchNumber']; ?></td>
                    <td style="text-align: right"><?= $result['qty']; ?></td>
                    <td style="height:50px; text-align: center"><?= $result['expiredDate']; ?></td>
                </tr>
                <?php 
                $qtyIn = $qtyIn + $result['qty']; 
                } ?>
            </table>
                </div>
                
            
                <div style="width: 50%; float: left">
                <table style="width: 100%">              
                <tr>
                    <td colspan="8" style="height: 63px; text-align: center">PENGELUARAN</td>
                    <td rowspan="2" style="text-align: right">STOK AKHIR(KG)</td>
                </tr>
                <tr>
                    <td>NAMA SARANA</td>
                    <td>ALAMAT SARANA</td>
                    <td>JENIS SARANA</td>
                    <td style="text-align: center">NO FAKTUR</td>
                    <td style="text-align: center">TGL KELUAR</td>
                    <td>BATCH NUMBER</td>
                    <td style="text-align: right">JUMLAH(KG)</td>
                    <td style="height:43px; text-align: center">TGL KADALUARSA</td>
                </tr>                
                
                <?php
                $sql2 = 'SELECT c.customerName, c.npwpAddress, d.addressType, a.goodsDeliveryDate, e.batchNumber, e.qty, e.expiredDate '
                        .'FROM tr_goodsdeliveryhead a '
                        .'INNER JOIN tr_salesorderhead b ON a.refNum = b.salesOrderNum '
                        .'INNER JOIN ms_customer c ON b.customerID = c.customerID '
                        .'INNER JOIN ms_customerdetail d ON a.customerDetailID = d.customerDetailID '
                        .'INNER JOIN tr_goodsdeliverydetail e ON a.goodsDeliveryNum = e.goodsDeliveryNum '
                        .'WHERE YEAR(a.goodsDeliveryDate) = '.$year.' AND MONTH(a.goodsDeliveryDate) '.$between 
                        .' AND e.productID = '.$model['productID'];
                $command2 = $connection->createCommand($sql2);
                $result2 = $command2->queryAll();
                $result3 = $result2;
                $qtyOut = '';
                foreach ($result3 as $result3){
                    $qtyOut = $qtyOut + $result3['qty'];
                }
                $total = $model['count'] + $qtyIn - $qtyOut;
                $count = count($result2); ?>
                <?php foreach ($result2 as $result2){ ?>
                <tr>
                    <td><?= $result2['customerName']; ?></td>
                    <td><?= $result2['npwpAddress']; ?></td>
                    <td><?= $result2['addressType']; ?></td>
                    <td style="text-align: center">KOSONG</td>
                    <td style="text-align: center"><?= $result2['goodsDeliveryDate']; ?></td>
                    <td><?= $result2['batchNumber']; ?></td>
                    <td style="text-align: right"><?= $result2['qty']; ?></td>
                    <td style="height:60px; text-align: center"><?= $result2['expiredDate']; ?></td>
                    <td style="text-align: right"><?= $total.'.00'; ?></td>
                </tr>
                <?php } ?>
            </table>
                </div><br>
            <?php } ?>
        </div>
    </body>
</html>





<?php
use yii\helpers\Html;
use yii\helpers\Json;
use app\components\AppHelper;

$temperature = "";
$modelDetail = $model;
$detailCount = sizeof($modelDetail);
for ($i = 0; $i < $detailCount; $i++)
{
    Yii::trace(Json::encode($modelDetail[$i]));
    $temperature .= $modelDetail[$i]['temperature'];
    $temperature .= $i < $detailCount - 1 ? ', ' : '';
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
                font-size: 10px;
            }
            .header{
                float: left;
                font-size: 12px;
                text-align: left;
            }
        </style>
    </head>
    <body style="font-family: Eurostar">
        <div style="padding: 10px; border: 1px solid black; position: absolute; top: 50px; bottom: 50px; left: 50px; right: 50px;">
            <table style="width:100%;">
                <tr>
                    <td style="height:50px; width: 25%; text-align: center; font-family: arial; font-size: 14px">
                        <?php echo Html::img('assets_b/images/logonew.png',['height' => '50px', 'width' => '50px']) ?>
                        <br/>PT.Qwinjaya Aditama</td>
                    <td colspan="3" style="font-family: arial; font-size: 24px; width: 50%; text-align: center"><b>Laporan Barang Masuk Gudang</b></td>
                    <td style="width: 25%; font-size: 14px; padding: 5px;">
                        <table style="border: 0;">
                            <tr>
                                <td style="border: 0;">No</td>
                                <td style="border: 0;"> : </td>
                                <td style="border: 0;"><?= $head->goodsReceiptNum ?></td>
                            </tr>
                            <tr>
                                <td style="border: 0;">Tanggal</td>
                                <td style="border: 0;"> : </td>
                                <td style="border: 0;"><?= date("d/m/Y", strtotime($head->goodsReceiptDate)) ?></td>
                            </tr>
                            <tr>
                                <td style="border: 0;">Jam Tiba</td>
                                <td style="border: 0;"> : </td>
                                <td style="border: 0;"><?= date("H:i", strtotime($head->goodsReceiptDate)) ?></td>
                            </tr>
                            <tr>
                                <td style="border: 0;">Suhu</td>
                                <td style="border: 0;"> : </td>
                                <td style="border: 0;"><?= $temperature ?></td>
                            </tr>
                            <tr>
                                <td style="border: 0;">Halaman</td>
                                <td style="border: 0;"> : </td>
                                <td style="border: 0;">{pageno} dari {pagecount}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="padding-top: 5px;">
                    <td style="text-align:center; height: 100px; vertical-align: top; width:25%; font-size: 14px;">Dibuat oleh,<br/><br/><br/><br/><br/><u><?=AppHelper::getSetting('WarehousePIC') ?></u><br/>(Gudang Bahan Baku)</td>
                    <td style="text-align:center; height: 100px; vertical-align: top; width: 20%; font-size: 14px;">Diperiksa oleh,<br/><br/><br/><br/><br/><u><?= AppHelper::getSetting('PharmacistName','Pharmacist Name') ?></u><br/>(Apoteker Penanggung Jawab)</td>
                    <td style="text-align:center; height: 100px; vertical-align: top; width: 20%; font-size: 14px;">Mengetahui,<br/><br/><br/><br/><br/><u><?= AppHelper::getSetting('ImportPIC','Import Dept. PIC') ?></u><br/>(Impor Dept.)</td>
                    <td colspan="2" style="text-align:center; height: 100px; vertical-align: top; width: 35%; font-size: 14px;">Diaudit oleh,<br/><br/><br/><br/><br/>
                        <table style='width:100%'><tr>
                                <td style='width:50%; border:0; font-size: 14px;'><u><?= AppHelper::getSetting('FinancePIC') ?></u><br>(Finance Dept.)</td>
                            <td style='width:50%; border:0; font-size: 14px;'><u><?= AppHelper::getSetting('SalesAdmin1') ?></u><br>(Sales Admin I)</td>
                        </tr></table>
                </tr>
            </table>       

            <table>
                <thead>
                    <tr>
                        <th style="width: 3%; text-align: center; font-size: 15px;">No.</th>
                        <th style="width: 15%; text-align: center; font-size: 15px;">Nama Barang</th>
                        <th style="width: 15%; text-align: center; font-size: 15px;">Asal barang</th>
                        <th style="width: 15%; text-align: center; font-size: 15px;">Pemasok</th>
                        <th style="width: 10%; text-align: center; font-size: 15px;">No. Faktur</th>
                        <th style="width: 13%; text-align: center; font-size: 15px;">No. PO</th>
                        <th style="width: 10%; text-align: center; font-size: 15px;">Kemasan</th> 
                        <th style="width: 7%; text-align: center; font-size: 15px;">Jumlah</th> 
                        <th style="width: 12%; text-align: center; font-size: 15px;">No. Batch / Lot</th> 
                    </tr>
                </thead>
                <tbody>                    
               <?php 
               $no = 1;
               foreach ($model as $content){ ?> 
                    <tr> 
                        <td style="width: 3%; text-align: center; font-size: 15px;"><?= $no; ?></td>
                        <td style="width: 15%; font-size: 15px;"><?= $content['productName']; ?></td>
                        <td style="width: 15%; font-size: 15px;"><?= $content['origin']; ?></td>
                        <td style="width: 15%; font-size: 15px;"><?= $content['supplierName']; ?></td>
                        <td style="width: 10%; text-align: center; font-size: 15px;"><?= $content['invoiceNum']; ?></td>
                        <td style="width: 13%; text-align: center; font-size: 15px;"><?= $content['refNum']; ?></td>
                        <td style="width: 10%; text-align: center; font-size: 15px;"><?=is_decimal($content['packQty']) ? number_format($content['packQty'] , 4, '.', ',') : number_format($content['packQty'] , 0, ',', '.')?> <?= $content['uomName'] ?>/<?= $content['packingTypeName']; ?></td>
                        <td style="width: 7%; text-align: center; font-size: 15px;">
                        <?=is_decimal($content['qty']) ? number_format($content['qty'] , 4, '.', ',') : number_format($content['qty'] , 0, ',', '.')?> <?= $content['uomName'] ?></td> 
                        <td style="width: 12%; text-align: center; font-size: 15px;"><?= $content['batchNumber']; ?></td> 
                    </tr>                    
                <?php $no++; } ?>
                </tbody>
            </table>
            
            <br/>
            <label style="font-size: 14px;"><u><i>Catatan/Keterangan:</i></u></label>
            
            <div style="width: 85%; margin-top: 10px; padding-right: 10px;">
                <?php 
                    $no = 1;
                    foreach ($modelDetail as $content){
                        Yii::trace(Json::encode($content), 'WKWK');
                ?> 
                        <div style="width: 50%; float: left; font-size: 15px;">
                            <?php echo "<b>".$no."]. ".$content['productName']."</b><br>"; ?>
                            <?php if($content['SKINumber'] != null) 
                                
                                    echo "- SKI/SPI No : ".$content['SKINumber']."<br>"; 
                                else 
                                   echo "- SKI/SPI No : - <br>";  
                            
                            ?>
                            <?php
                                if (date('d F Y', strtotime($content['SKIDate'])) == '01 January 1970' ) {
									echo "- SKI/SPI Date :  - <br>";
                                    
                                } else if($content['SKIDate'] != NULL ) {
									echo "- SKI/SPI Date : " . date('d F Y', strtotime($content['SKIDate'])) . "<br>";
                                    
                                } else {
									 echo "- SKI/SPI Date :  - <br>";
								}
                            ?>
                            <?php echo "- Mfg Date : ".date('d F Y', strtotime($content['manufactureDate']))."<br>"; ?>
                            <?php if($content['expiredDate'] != null) echo "- Expiry Date : ".date('d F Y', strtotime($content['expiredDate']))."<br>"; ?>
                            <?php if($content['retestDate'] != null) echo "- Retest Date : ".date('d F Y', strtotime($content['retestDate']))."<br>"; ?>
                            <?php if($content['notes'] != null || $content != '') echo $content['notes']; ?>
                        </div>
                <?php 
                        $no++; 
                    } 
                ?>
            </div>
            
        </div>     
        <div style="display: block; position: absolute; bottom: 55px; right: 55px; background-color: orange;">
            <?php echo Html::img('assets_b/images/qbarcode.png',['height' => '150px', 'width' => '150px']) ?>
        </div>   
    </body>
</html>









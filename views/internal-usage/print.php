<?php
use yii\helpers\Html;
use yii\helpers\Json;
use app\components\AppHelper;

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
        <div style="padding: 10px;  position: absolute; top: 50px; bottom: 50px; left: 50px; right: 50px;">
            <div style="text-align: center">
                <div style=""><?php echo Html::img('assets_b/images/logonew.png',['height' => '75px', 'width' => '70px']) ?> </div>                       
                <div style="font-size: 32px; color: #4b6b21; "><b><?= AppHelper::getSetting('CompanyName', 'Company Name'); ?></b></div>
                <div style=" font-size: 22px; "><b>Daftar Bahan Baku Klaim/Retur</b></div>
            </div>
            <br>
            <table>
                <thead>
                    <tr>
                        <th style="width: 3%; text-align: center; font-size: 15px;">No.</th>
                        <th style="width: 15%; text-align: center; font-size: 15px;">Tanggal Kirim</th>
                        <th style="width: 15%; text-align: center; font-size: 15px;">Bahan Baku</th>
                        <th style="width: 15%; text-align: center; font-size: 15px;">Asal Barang</th>
                        <th style="width: 10%; text-align: center; font-size: 15px;">Jumlah</th>
                        <th style="width: 13%; text-align: center; font-size: 15px;">Dari Pelanggan</th>
                        <th style="width: 10%; text-align: center; font-size: 15px;">Catatan</th> 
                    </tr>
                </thead>
                <tbody>                    
                <?php 
                    $no = 1;
                    foreach ($model as $content){ ?> 
                    <tr> 
                        <td style="width: 3%; text-align: center; font-size: 15px;"><?= $no; ?></td>
                        <td style="  text-align: center; font-size: 15px;"><?= date('d F Y', strtotime($content['internalUsageDate'])) ?></td>
                        <td style=" text-align: center; font-size: 15px;"><?= $content['productName']; ?></td>
                        <td style=" text-align: center; font-size: 15px;"><?= $content['origin']; ?></td>
                        <td style=" text-align: center; font-size: 15px;"><?= is_decimal($content['qty']) ? number_format($content['qty'] , 4, '.', ',') : number_format($content['qty'] , 0, ',', '.')?> <?=$content['uomName']?> </td>
                        <td style=" text-align: center; font-size: 15px;"></td>
                        <td style=" text-align: center; font-size: 15px;"><?= $content['notes']; ?></td>
                    </tr>                    
                <?php $no++; } ?>
                </tbody>
            </table>
            <br/>
             <div style=" float: left; margin-top: 7px;">
                <div style="float: left; width: 40%; margin-left: 35px;"> Ke Gudang Bahan Baku,</div>
                <div style="float: left; width: 30%; margin-left: 245px;">Jakarta, <?= date('d F Y', strtotime(date('d-m-Y'))) ?><br>Mengetahui,</div>
                <br>
                <br>
                <br>
                <div style="float: left; width: 60%; font-size: 14px;  margin-left: 45px;">
                    <u><b><?= app\components\AppHelper::getSetting('WarehousePIC', 'Warehouse PIC') ?></b></u> 
                </div>
                <div style="float: left; width: 30%; font-size: 14px; margin-left: -100px;">
                    <u><b><?= app\components\AppHelper::getSetting('PharmacistName', 'Pharmacist Name') ?></b></u><br>
                    <div style="font-size: 12px;">Apoteker Penanggung Jawab<br>
                        <?= app\components\AppHelper::getSetting('PharmacistNumber', 'Pharmacist Number') ?></div>
                </div>
                <div style="float: left; width: 10%; font-size: 12px;">
                    <u><b><?= app\components\AppHelper::getSetting('CompanyDirector', 'Company Director') ?></b></u><br><div style="font-size: 14px;">Direktur</div> 
                </div>
                <div style="float: left; width: 100%; margin-left: 35px; margin-top: 30px;">
                <b>Catatan : Lokasi Penyimpanan di Gudang Bahan Baku Lantai 1 (Ruangan Bahan Baku Klaim) </b>
                </div>
            </div>
           
        </div>     
    </body>
</html>









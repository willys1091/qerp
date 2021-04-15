<?php
use yii\helpers\Html;
use yii\bootstrap;
$model2 = $model;
//var_dump($model2);
//yii::$app->end();
foreach ($model as $model){
  $purchaseDate = $model['purchaseOrderDate'];
  $purchaseNum = $model['purchaseOrderNum'];
  $contactPerson = $model['contactPerson'];
  $supplier = $model['supplierName'];
  $uom = $model['uomName'];
  $pack = $model['packingTypeName'];
  $payment = $model['paymentDueName'];
  $notes = $model['additionalInfo'];
}
$purchaseDateYear = date('Y', strtotime($purchaseDate));
$purchaseDateMonth = date('m', strtotime($purchaseDate));
$purchaseDateDay = date('d', strtotime($purchaseDate));
switch ($purchaseDateMonth){
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
<html>
    <head>
<!--        <style type="text/css">
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
        </style>-->
    </head>
    <body> 
        <div style="padding: 10px; border: 1px solid black;">
            <div style="text-align: center"><?php echo Html::img('assets_b/images/logonew.png',['height' => '70px', 'width' => '70px']) ?> </div><br/>                        
            <div style="font-size: 16px; color: green; text-align: center">PT.QWINJAYA ADITAMA</div>
            <div style="text-align: center">Importer & Supplier of Pharmaceutical Raw Materials and Finished Products</div>
            <br>
            <div style="font-size: 16px; text-align: center">Purchase Order</div>
            <div style="text-align: center">No. <?= $purchaseNum; ?></div>
            <br>            
            <div style="float: left; width: 50%; font-size: 12px"><b>Shaoxing Hantai Pharmaceutical Co.,Ltd</b><br>
                Add: 10B-6,Jiayi Plaza, Renming E. Road,<br>
                Xiancang, Shaoxing,<br>
                <u>Zheciang, China.</u>
            </div>
            <div style="float: right; width: 50%; text-align: right; font-size: 12px">Jakarta, <?= $purchaseDateDay; ?> <?= $monthName; ?> <?= $purchaseDateYear; ?></div>
            <br>
            <div style="float: left; width: 100%; font-size: 12px">
            <b><?= $contactPerson; ?></b><br>
            <b>CC. Mr. Victor Huang</b><br></div><br>
            <div style="float: left; width: 100%; font-size: 12px">Dear Tracy,<br>
                We herewith confirmed our order with following conditions:</div> <br>         
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="text-align: center; font-size: 12px">No</th>
                        <th style="font-size: 12px">Product</th>
                        <th style="text-align: center; font-size: 12px">Quantity</th>
                        <th style="text-align: right; font-size: 12px">Unit Price</th>
                        <th style="text-align: right; font-size: 12px">Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($model2 as $model2){ 
                        $total = $model2['qty'] * $model2['price']; ?>
                    <tr>
                        <td style="text-align: center; font-size: 12px"><?= $no; ?></td>
                        <td style="font-size: 12px"><?= $model2['productName'];?></td>
                        <td style="text-align: center; font-size: 12px"><?= $model2['qty']; ?></td>
                        <td style="text-align: right; font-size: 12px"><?= $model2['price']; ?></td>
                        <td style="text-align: right; font-size: 12px"><?= $total.'.00'; ?></td>
                    </tr>
                    <?php 
                    $no = $no + 1;
                    } ?>
                </tbody>
            </table>
            <br>
            <div style="float: left; width: 30%; font-size: 12px"><b>Origin/Country of Origin</b></div>
            <div style="float: left; width: 5%; font-size: 12px">:</div>
            <div style="float: left; width: 45%; font-size: 12px"><?= $supplier; ?></div>
            <div style="float: left; width: 30%; font-size: 12px"><b>Packing Type</b></div>
            <div style="float: left; width: 5%; font-size: 12px">:</div>
            <div style="float: left; width: 45%; font-size: 12px"><?= $uom; ?> / <?= $pack; ?></div>
            <div style="float: left; width: 30%; font-size: 12px"><b>Shipment</b></div>
            <div style="float: left; width: 5%; font-size: 12px">:</div>
            <div style="float: left; width: 45%; font-size: 12px">CIF air Jakarta</div>
            <div style="float: left; width: 30%; font-size: 12px"><b>Delivery</b></div>
            <div style="float: left; width: 5%; font-size: 12px">:</div>
            <div style="float: left; width: 45%; font-size: 12px">Prompt</div>
            <div style="float: left; width: 30%; font-size: 12px"><b>Payment</b></div>
            <div style="float: left; width: 5%; font-size: 12px">:</div>
            <div style="float: left; width: 45%; font-size: 12px"><?= $payment; ?></div><br><br>
            <div style="float: left; width: 100%; font-size: 12px">Notes:<br><?= $notes; ?>test</div>            
            <ul style="font-size: 12px">
                <li>a).aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</li>
                <li>b).bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb</li>
                <li>c).ccccccccccccccccccccccccccccccccc</li>
                <li>d).ddddddddddddddddddddddddddddddddd</li>
            </ul>
            <div style="float: left; width: 30%; font-size: 12px"><label>Consigne:</label></div>
            <div style="float: left; width: 70%; font-size: 12px">PT.Qwinjaya Aditama.<br>
                : Komplek Pertokoan Green Garden Blok A7 No.6<br>
                Kelurahan Kedoya Utara, Kebon Jeruk, Jakarta Barat, DKI.<br>
                <u>Jakarta 11520 - Indonesia</u><br>
                +62 21 9898798, 9889878,9878787,6567689<br>
                Attn. Mr.Nurdin Wijaya. nurdin.wijaya@qwinjaya.com
            </div><br>
            <div style="float: left; text-align: left; font-size: 12px;">Please Confirm,<br>
            Thank you for your kind cooperation and support.</div>
            
            <div style="float: left; width: 25%; height: 80px; font-size: 12px"><b>Yours Faithfully,</b></div>
            <div style="float: left; width: 45%; height: 80px; font-size: 12px"><b>Approval By,</b></div>
            <div style="float: left; width: 28%; height: 80px; font-size: 12px"><b>Confirmed By,</b></div>
            <div style="float: left; width: 25%; font-size: 12px"><b><u>Nurdin Wijaya</u></b><br>Director</div>
            <div style="float: left; width: 45%; font-size: 12px"><b><u>Merry S.Farm, Apt.</u></b><br>Pharmacist,<br>SIKA No. 006/2.35.1/31.7305/-1.779.3/2016</div>
            <div style="float: left; width: 28%; font-size: 12px"><b><u>Confirmer Name</u></b></div><br>
            <div style="text-align: center">Komp. Pertokoan Green Garden Blok A7. No.6, Jakarta 11520, Indonesia</div>          
        </div>
        

         
    </body>
</html>





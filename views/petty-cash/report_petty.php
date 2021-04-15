<?php

use app\components\AppHelper;
use app\models\MsCustomerdetail;
use app\models\MsSetting;
use yii\helpers\Html;

date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            margin-top: 0.5cm;
            margin-bottom: 0.5cm;
        }
        .row { width: 100%; }
        .col { float: left; }
        .col-12 { float: left; width: 100%; }
        .col-11 { float: left; width: 91.66%; }
        .col-10 { float: left; width: 83.33%; }
        .col-9 { float: left; width: 75%; }
        .col-8 { float: left; width: 66.66%; }
        .col-7 { float: left; width: 58.33%; }
        .col-6 { float: left; width: 50%; }
        .col-5 { float: left; width: 41.66%; }
        .col-4 { float: left; width: 33.33%; }
        .col-3 { float: left; width: 25%; }
        .col-2 { float: left; width: 16.66%; }
        .col-1 { float: left; width: 8.33%; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .italic { font-style: italic; }
        .san-serif { font-family: "Times New Roman", Times, serif; }
        .text-important { font-size: 16px; }
        .text-normal { font-size: 14px; }
        .bold { font-weight: bold; }
        .spacey { width: 100%; height: 10px; }
        .spacey-half { width: 100%; height: 5px; }
        th { font-weight: normal; text-align: center; }
        th {
            border: 1px solid black;
            padding: 5px;
        }
        td {
            border: 1px solid #dddddd;
            padding: 5px;
        }
        tfoot td {
            border-top: 2px solid #dddddd;
        }
        .aware {
            color: #004276;
        }
    </style>
</head>

<body style="font-family: Eurostar">
    <div id='header'>
        <div style="text-align: center"><?= Html::img('assets_b/images/logonew.png',['height' => '85px', 'width' => '80px']) ?> </div>
        <br/> 
        <div style="font-size: 25px; color: green; text-align: center; margin-top: -20px;"><?= AppHelper::getSetting('CompanyName','Company Name') ?></div>
        <br>
    </div>
    <div class='col-6'>
        <p>Bukti Pengeluaran Kas <br> Periode : <?=$startDate?> - <?=$endDate?></p>
    </div>
     <div class='col-6' style="text-align: right;">
        <p>Preview <?= date('M-y')?><br></p>
    </div>
  
    <div class='row'>
        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th  class='col-2' style="width:5%;"> No</th>
                    <th  class='col-2' style='width:5%;'>Tanggal</th>
                    <th  class='col-2' style='width:10%;'>Kode</th>
                    <th  class='col-2' style='width:25%;'>Keterangan</th>
                    <th  class='col-2' style='width:10%;'>Debit</th>
                    <th  class='col-2' style='width:10%;'>Credit</th>
                    <th  class='col-1' style='width:10%;'>Saldo</th>
                   
                </tr>
             
            </thead>
            <tbody>
                <?php $no = 1; foreach ($model->each() as $detail)   {
                 $total+=$detail['drAmount'] - $detail['crAmount']; 
                 $dTotal += $detail['drAmount'];
                 $cTotal += $detail['crAmount'];
         
          
                ?>
                <tr>
                    <td class='text-center'><?=$no?></td>
                    <td class='text-center'><?=($detail['pettyCashDate']); ?></td>
                    <td class='text-left'><?=$detail['voucher']?></td>
                    <td class='text-left'><?=$detail['notes']?></td>
                    <td class='text-right'><?= 'Rp. '.number_format($detail['drAmount'], 0, ',', '.') ?></td>
                    <td class='text-right'><?='Rp. '.number_format($detail['crAmount'],0 ,',', '.')?></td>
                    <td class='text-right'><?='Rp. '.number_format($total, 0, ',', '.'); ?></td>
                </tr>
                <?php $no++; }?>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td><b>T O T A L </b></td>
                    <td class='text-right'><b><?='Rp. '.number_format($dTotal, 0, ',', '.'); ?></b></td>
                    <td class='text-right'><b><?='Rp. '.number_format($cTotal , 0, ',', '.'); ?></b></td>
                    <td class='text-right'><b><?='Rp. '.number_format($total, 0, ',', '.'); ?></b></td>
                </tr>
            </tbody>
          
        </table>
    </div>
</body>
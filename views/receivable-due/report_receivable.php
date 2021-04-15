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
            border: 1px solid #dddddd;
            padding: 5px;
        }
        td {
            border: 1px solid white;
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
        <div style="font-size: 14px; text-align: center; ">Importer & Supplier of Pharmaceutical Raw Materials and Finished Products</div>
        <div style="font-size: 13px; text-align: center; font-weight: bold; margin-top: 5px;">Sertifikat Distribusi Farmasi No. <?= AppHelper::getSetting('SertifikatDistribusiFarmasi','Sertifikat Distribusi Farmasi No') ?></div>
        <div style="font-size: 13px; text-align: center; font-weight: bold;">Ijin Importir Terdaftar Psikotropica No. <?= AppHelper::getSetting('IjinPsikotropika','Ijin Importir Terdaftar Psikotropika') ?></div>
        <div style="font-size: 13px; text-align: center; font-weight: bold;">Ijin Importir Terdaftar Prekursor Farmasi No. <?= AppHelper::getSetting('IjinITPrekursorFarmasi','Ijin IT Prekursor Farmasi No') ?></div>
        <br>
    </div>
    <div class='spacey'></div>
    <div class='row san-serif italic text-important'>
        <div class='col-9'>
            <div class='row'>
                <div class='col-2'>No</div>
                <div class='col-1 text-center'>: </div>
                <div class='col-9'><?=$invoice?></div>
            </div>
            <div class='row'>
                <div class='col-2'>Hal</div>
                <div class='col-1 text-center'>:</div>
                <div class='col-9'>SURAT TAGIHAN</div>
            </div>
            <div class='row'>
                Kepada Yth.
            </div>
            <div class='row bold'>
                <div class='col-1'>&nbsp;</div>
                <div class='col-11'>
                   <?=$modelHead[0]['customerName']?>
                    <br>
                   <?=$modelHead[0]['street']?>
              
                </div>
            </div>
        </div>
        <div class='col-3 text-right'>
            Jakarta, <?=date('d-M-y')?>
        </div>
    </div>
    <div class='spacey'></div>
    <div class='row text-important italic san-serif'>
        <div class='col-12 bold'>
            <div class='row'>
                <div class='col-1'>Up :</div>
                <div class='col-11'>Bagian Keuangan  <?= $contactPerson != '' ?'- '.$contactPerson : ''?> </div>
            </div>
        </div>
        <div class='spacey-half'></div>
        <div class='col-12'>
            Dengan Hormat.
            <br>
            <br>Dengan ini kami sampaikan tagihan yang sudah jatuh tempo sebagai berikut :
        </div>
    </div>
    <div class='spacey'></div>
    <div class='row'>
        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th colspan='2' class='col-2'>Faktur</th>
                    <th rowspan='2' class='col-2' style='width:10%; '>Mata Uang</th>
                    <th rowspan='2' class='col-2'>Nilai</th>
                    <th rowspan='2' class='col-2'>Payment</th>
                    <th rowspan='2' class='col-2' style='width:20%; '>Saldo</th>
                    <th rowspan='2' class='col-1' style='width:15%; '>Due Date</th>
                    <th rowspan='2' class='col-1' style='width:10%;'>Overdue</th>
                </tr>
                <tr>
                    <th  style="width:15%;">Tanggal</th>
                    <th style="width:20%;">Nomor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($model as $detail) {
                    
                   $isTax = $modelHead[0]['isTax'];
                   
                   if($isTax){
                       $subtotal =  round($detail['subTotal']+($detail['subTotal'] * 0.1));
                        
                   } else {
                       $subtotal =  $detail['subTotal'];
                   }
                   
                    $saldo = $subtotal - $detail['previousPayment'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td class='text-center'>
                            <?php   
                            $date1=AppHelper::dateConvert($detail['goodsDeliveryDate']);
                            echo $now = date('d-M-y', strtotime($date1));

                            ?>
                    </td>
                    <td class='text-left'><?=$detail['invoiceNum']?></td>
                    <td class='text-center'><?=$detail['currency']?></td>
                    <td class='text-right'><?= number_format($subtotal,2,".",","); ?></td>
                    <td class='text-right'><?= number_format($detail['previousPayment'],2,".",","); ?></td>
                    <td class='text-right aware'><?=  number_format($saldo,2,".",",");?> </td>
                    <td class='text-center'>
                            <?php
                            $date1=AppHelper::dateConvert($detail['goodsDeliveryDate']);
                            $duedate = $detail['duedate'];
                            echo $due = date('d-M-y', strtotime($date1 . "+"."$duedate"." days"));
                            $dates = date('Y-m-d H:i:s', strtotime($date1 . "+"."$duedate"." days"));
                            
                            
                            
                            $datetime1 =  new Datetime($dates);
                            $datetime2 =  new Datetime(date("Y-m-d H:i:s"));
                            $interval = $datetime1->diff($datetime2)->days;
                            ?>
                    </td>
                    <td class='text-right'><?php  echo $interval;  ?></td>
                </tr>
                <?php }?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan='5' class='text-right'>Total : </td>
                    <td class='text-right' style='border: 2px solid #dddddd;'><?=  number_format($total,2,".",",");?></td>
                    <td colspan='2'></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class='row text-normal italic san-serif'>
        <div class='col'>
            Pembayaran dapat ditransfer ke :
        </div>
        <div class='spacey'></div>
        
        <div class='row'>
            <div class='col-3'>Nama Penerima</div>
            <div class='col-9'>: <span class='aware'>PT QWINJAYA ADITAMA</span></div>
        </div>
        <div class='row'>
            <div class='col-3'>Alamat Penerima</div>
            <div class='col-9'>: <span class='aware'>Jl. Green Garden Blok A7 No.6, Jakarta 11520</span></div>
        </div>
        <div class='spacey-half'></div>
        <div class='row'>
            <div class='col-3'>Nama Bank</div>
            <div class='col-9'>: <span class='aware'>Bank Central Asia (BCA), Cabang Green Garden</span></div>
        </div>
        <div class='row'>
            <div class='col-3'>Alamat Bank</div>
            <div class='col-9'>: <span class='aware'>Jl. Green Grden Blok A7 No. 32-34, Jakarta 11520</span></div>
        </div>
        <div class='row'>
            <div class='col-3'>No Rekening</div>
            <div class='col-9'>: <span class='aware'>253 - 30 - 8030 - 8 (Rp)</span></div>
        </div>
        <div class='spacey-half'></div>
        <div class='row'>
            Setiap Pembayaran harus kami terima "Full Amount"
            <br>Mohon bukti pembayaran difax ke no 021-58355060
            <br>Atas perhatian dan kerja sama dari Bapak/Ibu, kami ucapkan terimakasih.
            <br>
            <br>Hormat kami,
            <br><br><br>
            <br><span class='aware'> <?= MsSetting::findOne(['key1' => 'FinancePIC'])->value1; ?></span>
            <br>Finance Department
        </div>
    </div>
</body>
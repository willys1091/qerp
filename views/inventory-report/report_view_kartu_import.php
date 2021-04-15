<?php
use yii\helpers\Html;

?>
<html>
    <head>
        <style type="text/css">
          
            table{
                border-collapse: collapse;
                
                width: 100%;
            }
            td{
                font-size: 12px;
            }
            .header{
                float: left;
                font-size: 12px;
                text-align: left;
            }
            #content{
                font-size: 12px;
                margin-top: -10px;
            }
            .covers{
                top: 10px;
                border-style: solid;
                border-color: #005730;
                border : 3px;
                height: 100%;
                margin-top: 20px;
            }
        </style>
    </head>
    <body style="font-family: eurostar; ">
            <div>
                <div style="margin-left: 108px;"><?php echo Html::img('assets_b/images/logonew.png',['height' => '75px', 'width' => '70px']) ?> </div><br/>                        
                <div style="margin-top: -25px; font-size: 32px; color: #4b6b21; "><b><?= app\components\AppHelper::getSetting('CompanyName', 'Company Name'); ?></b></div>
                <div style="margin-top: -5px; font-size: 13px;">Importer & Supplier of Pharmaceutical Raw Materials</div>
            </div> 
            <div style="margin-top: -80px; margin-left: 320px;">
                <table style="border: 0; ">
                    <tr>
                        <td valign="top" style="border: 0;"><?= $location; ?></td>

                        <td style="border: 0;"><?= $address->value1 ?> </td>
                    </tr>
                    <tr>
                        <td valign="top" style="border: 0;"><?= $imagePhone; ?></td>

                        <td style="border: 0;">+62 21<?= $phone1->value1 ?>, <?= $phone2->value1 ?>, <?= $phone3->value1 ?>, <?= $phone4->value1 ?> </td>
                    </tr>
                    <tr>
                        <td style="border: 0;"><?= $imageFax; ?></td>

                        <td style="border: 0;">+62 21<?= $fax->value1 ?></td>
                    </tr>

                </table>
            </div>
            <br>
            
           <div class="covers">
           <table style="width: 100%; ">
                <tr bgcolor='#77a53b'>
                    <td style="text-align: center; border-color: none;  font-size: 18px;"><b style="color: white;"><h3>KARTU IMPORT</h3></b></td>
                </tr>
            </table>
            <br>        
            <?php
                if(count($model) == 0) {
                    echo '<div style="width; 100%; margin-top: 30px; margin-bottom: 20px; border: 1px solid black">Produk dalam goods receipt yang anda cari tidak ditemukan.</div>';
                } else {
            ?>
               <div id="content">
                       <?php foreach ($model as $models) { ?>
                   <div style="text-align: center; font-size: 22px; margin-top: 30px; font-family: 'eurostar'"><u>PEMBELIAN IMPOR & LOKAL</u><br> <?= "Tahun " . $models['year']; ?></div>
                            <div style="text-align: right; padding-top: -70px; margin-right: 2%"><?php echo Html::img('assets_b/images/qbarcode.png', ['height' => '100px', 'width' => '100px', 'class' => 'image']) ?></div>
                       <?php } ?>
                       <?php
                       foreach ($model as $model) {
                           if ($model['invoiceNum'] != '') {
                               $invoiceNum = $model['invoiceNum'];
                           } else {
                               $invoiceNum = '-';
                           }
                           if ($model['invoiceDate'] != '') {
                               $invoiceDate = $model['invoiceDate'];
                           } else {
                               $invoiceDate = '-';
                           }
                           if ($model['shipmentType'] != '') {
                               $cnfIf = $model['shipmentType'];
                           } else {
                               $cnfIf = '-';
                           }
                           if ($model['AWBNum'] != '') {
                               $awbNum = $model['AWBNum'];
                           } else {
                               $awbNum = '-';
                           }
                           if ($model['AWBDate'] != '') {
                               $awbDate = $model['AWBDate'];
                           } else {
                               $awbDate = '-';
                           }
                           if ($model['PPJK'] != '') {
                               $ppjk = $model['ppjk'];
                           } else {
                               $ppjk = '-';
                           }
                           if ($model['pibNumber'] != '') {
                               $pibNumber = $model['pibNumber'];
                           } else {
                               $pibNumber = '-';
                           }
                           if ($model['pibSubmitCode'] != '') {
                               $pibSC = $model['pibSubmitCode'];
                           } else {
                               $pibSC = '-';
                           }
                           if ($model['importDutyAmount'] != '') {
                               $tax = $model['importDutyAmount'];
                           } else {
                               $tax = '-';
                           }
                           if ($model['taxPercentage'] != '') {
                               $taxrate = $model['taxPercentage'];
                           } else {
                               $taxrate = '-';
                           }
                           if ($model['SKINumber'] != '') {
                               $noIzin = $model['SKINumber'];
                           } else {
                               $noIzin = '-';
                           }
                           if ($model['paymentDueName'] != '') {
                               $payment = $model['paymentDueName'];
                           } else {
                               $payment = '-';
                           }
                           if ($model['hsCode'] != '') {
                               $hsCode = $model['hsCode'];
                           } else {
                               $hsCode = '-';
                           }
                           switch ($model['month']) {
                               case 1: $monthName = 'Januari';
                                   break;
                               case 2: $monthName = 'Februari';
                                   break;
                               case 3: $monthName = 'Maret';
                                   break;
                               case 4:
                                   $monthName = 'April';
                                   break;
                               case 5:
                                   $monthName = 'Mei';
                                   break;
                               case 6:
                                   $monthName = 'Juni';
                                   break;
                               case 7:
                                   $monthName = 'Juli';
                                   break;
                               case 8:
                                    $monthName = 'Agustus';
                                    break;
                               case 9:
                                   $monthName = 'September';
                                   break;
                               case 10:
                                   $monthName = 'Oktober';
                                   break;
                               case 11:
                                   $monthName = 'November';
                                   break;
                               case 12:
                                   $monthName = 'Desember';
                                   break;
                           }
                           switch (date('m', strtotime("now"))) {
                               case 1: $thismonthName = 'Januari';
                                   break;
                               case 2: $thismonthName = 'Februari';
                                   break;
                               case 3: $thismonthName = 'Maret';
                                   break;
                               case 4:
                                   $thismonthName = 'April';
                                   break;
                               case 5:
                                   $thismonthName = 'Mei';
                                   break;
                               case 6:
                                   $thismonthName = 'Juni';
                                   break;
                               case 7:
                                   $thismonthName = 'Juli';
                                   break;
                               case 8:
                                   $thismonthName = 'Agustus';
                                   break;
                               case 9:
                                   $thismonthName = 'September';
                                   break;
                               case 10:
                                   $thismonthName = 'Oktober';
                                   break;
                               case 11:
                                   $thismonthName = 'November';
                                   break;
                               case 12:
                                   $thismonthName = 'Desember';
                                   break;
                           }
                           $today = date('d', strtotime("now"));
                           $thisYear = date('Y', strtotime("now"));

                           ?>
                           <div style="font-size: 12px; margin-left: 5%;">
                               <div style="margin-top: 30px">
                                   <div style="float: left; width: 15%">Nama Barang</div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left; width: 25%; padding-right: 10px"><?= $model['productName']; ?></div>
                                   <div style="float: left; width: 15%">No.Surat pesanan</div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left"><?= $model['purchaseOrderNum']; ?></div>
                               </div>
                               <div style="margin-top: 10px">
                                   <div style="float: left; width: 15%">Pemasok</div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left; width: 25%; padding-right: 10px"><?= $model['supplierName']; ?></div>
                                   <div style="float: left; width: 15%">Tgl. Surat Pesanan</div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left"><?= $model['POdate']; ?> </div>
                               </div>
                               <div style="margin-top: 10px">
                                   <div style="float: left; width: 15%">Asal Barang</div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left; width: 25%; padding-right: 10px"><?= $model['origin']; ?></div>
                                   <div style="float: left; width: 15%">Harga satuan</div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left">Rp. <?= number_format($model['sellPrice'], 2, ".", ",") . ',-'; ?> / <?= $model['uomName']; ?></div>
                               </div>
                               <div style="margin-top: 10px">
                                   <div style="float: left; width: 15%">No / Tgl. Invoice </div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left; width: 25%; padding-right: 10px"><?= $invoiceNum; ?> / (<?= $invoiceDate; ?>)</div>
                                   <div style="float: left; width: 15%">CNF / CIF </div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left"><?= $cnfIf; ?></div>
                               </div>
                               <div style="margin-top: 10px">
                                   <div style="float: left; width: 15%">No / Tgl. AWB</div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left; width: 25%; padding-right: 10px"><?= $awbNum; ?> / (<?= $awbDate; ?>)</div>
                                   <div style="float: left; width: 15%">Bea Masuk</div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left"><?= $taxrate . '%'; ?></div>
                               </div>
                               <div style="margin-top: 10px">
                                   <div style="float: left; width: 15%">No Aju PIB</div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left; width: 25%; padding-right: 10px"><?= $pibSC; ?></div>
                                   <div style="float: left; width: 15%">No. PIB</div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left"><?= $pibNumber; ?></div>
                               </div>
                               <div style="margin-top: 10px">
                                   <div style="float: left; width: 15%">Jumlah</div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left; width: 25%; padding-right: 10px">
                                   <?php foreach ($model4 as $detail) { ?>
                                       
                                       <?=$detail['qty']?> <?= $detail['uomName']; ?> <br>
                                       
                                   <?php } ?>    
                                   </div>
                                   <div style="float: left; width: 15%">No Tarif </div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left"><?=$hsCode?></div>
                               </div>
                               <div style="margin-top: 10px">
                                   <div style="float: left; width: 15%">No. Batch / Lot</div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left; width: 25%; padding-right: 10px">
                                    <?php foreach ($model4 as $detail) { ?>
                                       
                                       <?=$detail['batchNumber']?><br>
                                       
                                   <?php } ?> 
                                   </div>
                                   <div style="float: left; width: 15%">No. Ijin POM / SKI</div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left"><?= $noIzin; ?></div>
                               </div>
                               <div style="margin-top: 10px">
                                   <div style="float: left; width: 15%">PPJK</div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left; width: 25%; padding-right: 10px">
                                        <?php if($ppjk){ ?>
                                          <?= $ppjk ?>
                                        <?php } else { ?> 
                                             -
                                        <?php } ?>     
                                   </div>
                                   <div style="float: left; width: 15%">Pembayaran</div>
                                   <div style="float: left; width: 5%">:</div>
                                   <div style="float: left"><?= $model['paymentDue']; ?></div>
                               </div>
                           </div>
                           <br>
                           <div style="float: left; width: 100%; margin-left: 5%;  margin-right: 5%; font-size: 16px; margin-bottom: 15px; font-weight: bold"><u>Keterangan</u></div>                                    
                           <table style="margin-left: 5%; margin-right: 5%; border: 2px solid black;"> 
                               <tr>
                                   <td>Bea Masuk</td>
                                   <td>: &nbsp;&nbsp;Rp</td>
                                   <td style="text-align: right; padding-right: 10px"><?= number_format($model['importDutyAmount'], 2, ".", ","); ?></td>
                                   <td style="border-left: 1px solid black">Nilai Invoice</td>
                                   <td>: &nbsp;&nbsp;<?= $model['currencyID']; ?></td>
                                   <td style="text-align: right; padding-right: 10px"><?= number_format($model['nilai_invoice'], 2, ".", ","); ?></td>                        
                               </tr>
                               <tr>
                                   <td>PPN Impor</td>
                                   <td>: &nbsp;&nbsp;Rp</td>
                                   <td style="text-align: right; padding-right: 10px"><?= number_format($model['PPNImportAmount'], 2, ".", ","); ?></td>
                                   <td style="border-left: 1px solid black">Kurs Pajak</td>
                                   <td>: &nbsp;&nbsp;Rp</td>
                                   <td style="text-align: right; padding-right: 10px"><?= number_format($model['pibRate'], 2, ".", ","); ?></td>                        
                               </tr>
                               <tr>
                                   <td>PPH Pasal 22 Impor</td>
                                   <td>: &nbsp;&nbsp;Rp</td>
                                   <td style="text-align: right; padding-right: 10px"><?= number_format($model['PPHImportAmount'], 2, ".", ","); ?></td>
                                   <td style="border-left: 1px solid black">Nilai Faktur Pajak</td>
                                   <td>: &nbsp;&nbsp;Rp</td>
                                   <td style="text-align: right; padding-right: 10px"><?= number_format($model['taxInvoiceAmount'], 2, ".", ","); ?></td>                        
                               </tr>
                               <tr>
                                   <td>Biaya Lainnya</td>
                                   <td>: &nbsp;&nbsp;Rp</td>
                                   <td style="text-align: right; padding-right: 10px"><?= number_format($model['otherCostAmount'], 2, ".", ","); ?></td>
                                   <td style="border-left: 1px solid black">Tgl Masuk Gudang</td>
                                   <td>: &nbsp;&nbsp;</td>
                                   <td style="text-align: right; padding-right: 10px"></td>                        
                               </tr>
                               <tr>
                                   <td>Total</td>
                                   <td>: &nbsp;&nbsp;Rp</td>
                                   <td style="text-align: right; padding-right: 10px"><?= number_format($model['total'], 2, ".", ","); ?></td>
                                   <td style="border-left: 1px solid black">Catatan</td>
                                   <td>: &nbsp;&nbsp;</td>
                                   <td style="text-align: right; padding-right: 10px"></td>                        
                               </tr>
                           </table>
                        <?php } ?>
                       <br/>
                       <div style="font-size: 14px;">
                           <div style="  text-align: right; margin-right: 30px;">Jakarta, <?= $model['PIBdate'] ?></div>
                           <br>
                    <?php } ?>
                           
                       <div style="float: left; width: 40%; margin-left: 5%;">
                           Apoteker Penangung Jawab :<br><br><br><br><br><br>
                            <?= app\components\AppHelper::getSetting('PharmacistName', 'Pharmacist Name'); ?><br>
                            <?= app\components\AppHelper::getSetting('PharmacistNumber', 'Pharmacist Number'); ?>
                       </div>
                       <div style="float: left; width: 30%; margin-left: 5%;">Import Dept.<br><br><br><br><br>
                            <?= Yii::$app->user->identity->fullName; ?></div>
                       <div style="float: right; width: 15%">Mengetahui,<br><br><br><br><br>
                            <?= app\components\AppHelper::getSetting('CompanyDirector', 'Company Director'); ?></div>

                   </div>
               </div>
           </div>        
    </body>
</html>





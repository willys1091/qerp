<?php

use app\components\AppHelper;
use app\models\MsUser;
use yii\helpers\Html;

$model2 = $model;
$model3 = $model;
foreach($model2 as $model2){
    $supplier= $model2['supplierName'];
    $street= $model2['street'];
    $cityName = $model2['city'];
    $phone = $model2['officeNumber'];
    $cp = $model2['contactPerson'];
    $date = date('d F Y', strtotime($model2['purchaseOrderNonInventoryDate']));
    $currency = $model2['currencyID'];
    $poNum = $model2['purchaseOrderNonInventoryNum'];
    $additional = $model2['additionalInfo'];
    $hasVAT = $model2['hasVAT'];
   
}
?>
<style>
.report-table td{
    padding-left: 5px;
    padding-right: 5px;
}
ol{
    margin-bottom: -25px;
}
ol li{
    margin-bottom: -15px;
}
p{
    margin-top: -10px;
}

.table_head{
   
    width: 100%;
}
.table-middle{
	margin-top : -5px;
    border-collapse: collapse;
    width: 100%;
}

.table-middle tr  {
    width: 100%;
}
.table-middles{
	
    border-collapse: collapse;
    width: 100%;
}
.table-middles tr th {
    border: 1px solid black;
    width: 100%;
    color : white;
}

.table-detail tr th {
    border: 1px solid black;
    width: 100%;
}

.table-detail {
    border-collapse: collapse;
    width: 100%;
}

.header{
    float: left;
    font-size: 12px;
    text-align: left;
}
   .covers{
       
        border-style: solid;
        border-color: #005730;
        border : 2px;
        height: 100%;
        margin-top: 20px;
    }
</style>
<body style="font-family: eurostar; font-size: 12px;">
    <div style="text-align: center"><?php echo Html::img('assets_b/images/logonew.png',['height' => '70px', 'width' => '70px']) ?> </div><br/>                        
    <div style="font-size: 26px; color: #4b6b21; text-align: center"><b><?= AppHelper::getSetting('CompanyName', 'Company Name'); ?></b></div>
    <div style="text-align: center; color: #4b6b21;">Importer & Supplier of Pharmaceutical Raw Materials</div>
    <br>
     <div style="font-size: 16px; text-align: center">
         <b><u><?= "Purchase Order Non Inventory" ?></u></b>
         <br><?=$poNum?>
     </div>
     
    <!--first row-->
    <table style="border: none; margin-top: 40px; "> 
        <thead>
            <tr>
                <th style="width: 23%; text-align: left;">Vendor</th>
                <th style="width: 10%; text-align: left;">Place Of Delivery</th>
                <th style="width: 20%;text-align: left;"></th>
            </tr>
        </thead>
    </table>
    <table class="table-middle">
        <tbody>                    
            <tr> 
                <td valign="top" style="width: 30%; font-size: 14px;  border: 1px solid black;">
                    <table style="border: 0; ">
                        <tr>
                            <td style="border: 0;"><b><?= $supplier ?></b><br>
                                <?php echo nl2br($street); ?><br>
                                <?php echo ' Phone  :   '. $phone;?><br>
                                <b><?php echo 'Up. '.  $cp;?></b>
                            </td>
                            
                        </tr>
                    </table>
                </td>
                <td  valign="top" style=" font-size: 14px; padding: 5px;  border: 1px solid black; ">
                    <table style="border: 0; ">
                        <tr>
                            <td valign="top" style="border: 0;">
                                <?= $company->value1; ?><br>
                                <?=$streets->value1; ?><br>
                                <?=$kel->value1; ?>, <?=$kec->value1; ?>, <?=$city->value1; ?>, <?=$province->value1; ?><br>
                                <?=$city->value1; ?>, <?=$postalCode->value1; ?> - <?=$countrys->value1; ?>, 
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 0; "><div style="text-align: top;"><?=$imagePhone;?>+62 21<?=$phone1->value1?></div></td>
                        </tr>
                        <tr>
                            <td style="border: 0; "><div style="text-align: top;"><?=$imageFax;?> +62 21<?=$fax->value1?></div></td>
                        </tr>
                    </table>
                </td>
               <td  valign="top" style="width: 30%; font-size: 14px; padding: 5px; ">
                    <table style="border: 0; ">
                        <tr>
                            <td style="border: 0;">Date</td>
                            <td style="border: 0;"> : </td>
                            <td style="border: 0;"><?= $date?></td>
                        </tr>
                        <tr>
                            <td style="border: 0;">Currency</td>
                            <td style="border: 0;"> : </td>
                            <td style="border: 0;"><?= $currency; ?></td>
                        </tr>
                        <tr>
                            <td style="border: 0;">Delivery Code</td>
                            <td style="border: 0;"> : </td>
                            <td style="border: 0;"><?= 'Prompt' ?></td>
                        </tr>
                        <tr>
                            <td style="border: 0;">Payment</td>
                            <td style="border: 0;"> : </td>
                            <td style="border: 0;"><?= 'To be Confrim'?></td>
                        </tr>
                        <tr>
                            <td style="border: 0;">Page</td>
                            <td style="border: 0;"> : </td>
                            <td style="border: 0;"> 
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>  
        </tbody>
    </table>
    <div>
        <div style="margin-top: 10px; ">Please supply the following items</div>
        <table class="table-detail" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 10%;text-align: center;">No</th>
                    <th style="width: 30%;text-align: center;">Description of Goods</th>
                    <th style="width: 10%;text-align: center;" colspan='2' class='col-2'>Qty</th>
                    <th style="width: 20%;text-align: center;">Unit Price</th>
                    <th style="width: 20%;text-align: center;" >Amount</th>
                </tr>
            </thead>
<!--                 <tr>
                    <th  style="width:15%;"></th>
                    <th style="width:20%;"></th>
                </tr>-->
            <tbody>     
                    <?php
                        $no = 1;
                        foreach ($model as $model2) {
						$subTotal =  $model2['qty'] * $model2['price'] ;
                    ?>
                    <tr> 
                        <td style=" padding: 5px; border: 1px solid black; text-align:center;"><?= $no;?></td>
                        <td style=" padding: 5px; border: 1px solid black"><?= $model2['productName'];?></td>
                        <td style=" text-align: right; border: 1px solid black"><?= $model2['qty'];?></td>
                        <td style=" padding: 5px; border: 1px solid black; text-align: center"> <?= $model2['uomName']; ?></td>
                        <td style=" padding: 5px; border: 1px solid black; text-align: right">Rp. <?= number_format($model2['price'],2,".",",")  ?></td>
                        <td style=" padding: 5px; border: 1px solid black; text-align: right">Rp. <?=  number_format($subTotal,2,".",",")  ?></td>
                    </tr>
                    
                    <?php 
                            $no++; 
                            $discount =$model2['discount']; 
                            $tempDiscTotal = $model2['qty']*$model2['price']*($discount/100); 
                            $discTotal += $tempDiscTotal;
                            $subTotalCount += $subTotal;
                        } 
                        if($hasVAT)
                            $pph = ($subTotalCount - $discTotal) * 0.1;
                        else 
                            $pph = 0;
                    ?>
                    <tr>
                        <td colspan="3" ></td>
                        <td colspan="2" style="border: 1px solid black; ">Sub Total</td>
                        <td style="text-align: right; border: 1px solid black;">Rp. <?= number_format(($subTotalCount),0,",",".") ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" ></td>
                        <td colspan="2" style="border: 1px solid black; ">Discounts</td>
                        <td style="text-align: right; border: 1px solid black;">Rp. <?= number_format(($discTotal),0,",",".") ?></td>
                    </tr>
					<tr>
                        <td colspan="3" ></td>
                        <td colspan="2" style="border: 1px solid black; ">Total</td>
                        <td style="text-align: right; border: 1px solid black;">Rp. <?= number_format(($subTotalCount - $discTotal),0,",",".") ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" ></td>
                        <td colspan="2" style="border: 1px solid black; ">PPn 10%</td>
                        <td style="text-align: right; border: 1px solid black;">Rp. <?= number_format(($pph),0,",",".") ?></td>
                    </tr>
					<tr>
                        <td colspan="3" ></td>
                        <td colspan="2" style="border: 1px solid black; ">Grand Total</td>
                        <td style="text-align: right; border: 1px solid black;">Rp. <?= number_format(($model2['grandTotal']),0,",",".") ?></td>
                    </tr>
            </tbody>
        </table>
        <div style="margin-top: -50px; width: 300px;">Remarks : <?=$additional ? $additional : '-'?></div>
        <br>
        <div class="row" style=" text-align:right; font-size: 12px; margin-top: 150px;">
            <table class="table-detail" style="width: 70%; margin-right: 0px; margin-left: auto;">
                <thead>
                    <tr>
                        <th style="width: 25%;text-align: center;">Ordered By</th>
                        <th style="width: 25%;text-align: center;">Prepared By</th>
                        <th style="width: 25%;text-align: center;">Approved By</th>
                        <th style="width: 25%;text-align: center;">Confirmend By</th>
                    </tr>
                </thead>
                <tbody>     
                    <tr> 
                        <td style=" padding: 5px; border: 1px solid black; text-align:center;">
                            <br><br><br><br>
                        </td>
                        <td style=" padding: 5px; border: 1px solid black"></td>
                        <td style=" text-align: right; border: 1px solid black"></td>
                        <td style=" padding: 5px; border: 1px solid black; text-align: center"></td>
                    </tr>  
                    <tr> 
                        <td style=" padding: 5px; border: 1px solid black; text-align:center;">General Affairs</td>
                        <td style=" text-align: center; padding: 5px; border: 1px solid black">Purchasing Staff</td>
                        <td style=" text-align: center; border: 1px solid black">Direktur</td>
                        <td style=" padding: 5px; border: 1px solid black; text-align: center">Vendor</td>
                    </tr>  
                </tbody>
            </table>
        </div>
    </div>
</body>


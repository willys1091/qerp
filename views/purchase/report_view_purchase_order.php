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
    border: 1px solid black;
    width: 100%;
    backgound-color : green;
    
}
.table-middle tr td{
    border: 1px solid black;
    
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
.table-middles tr td{
   font-size: 14px;
    
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

<?php

use app\components\AppHelper;
use app\components\MdlDb;
use app\models\MsSubcategory;
use app\models\MsSuppliercontactdetail;
use app\models\MsUser;
use yii\helpers\Html;

$model2 = $model;
$origin = '';
$count = 1;
foreach ($model as $model){
    $purchaseDate = $model['purchaseOrderDate'];
    $purchaseNum = $model['purchaseOrderNum'];
	$revitionNotes = $model['revitionNotes'];
    $contactPerson = $model['contactPerson'];
    $contactPersonCC = $model['contactPersonCC'];
    $created = $model['createdBy'];
    $supplierID = $model['supplierID'];
    $supplier = $model['supplierName'];
    $origin .= $count.'). '.$model['origin'] . '. &nbsp;';
    $provinceSupplier = $model['province'];
    $countrySupp = $model['country'];
    $cityName = $model['city'];
    $street = $model['street'];
    $hsCode = $model['hsCode'];
    $uom = $model['uomName'];
    $pack = $model['packingTypeName'];
    $payment = $model['paymentDue'];
    $notes = $model['additionalInfo'];
    $subcategoryID = $model['productSubcategoryID'];
    $prekursorText = "";
    if($subcategoryID != null){
        $subcategoryModel = MsSubcategory::findOne(['subcategoryID' => $subcategoryID]);
        if($subcategoryModel != null){
            if (strpos(strtolower($subcategoryModel->subcategoryName), 'prekursor') !== false){
                $prekursorText = "(Precursor)";
            } else if (strpos(strtolower($subcategoryModel->subcategoryName), 'psikotropika') !== false) {
                $prekursorText = "(Psychotropic)";
            }
        }
    }
    
    if($model['packingType'] == '') {
      $pack = '-';
    } else {
        $pack = $model['packingType'];
    }
    if($model['shipmentType'] == '') {
      $shipment = '-';
    } else {
      $shipment = $model['shipmentType'];
    }
    if($model['deliveryType'] == '') {
      $delivery = '-';
    } else {
      $delivery = $model['deliveryType'];
    }
    $count++;
}

$contactDetail = MsSuppliercontactdetail::findOne(['contactPerson' => $contactPerson, 'supplierID' => $supplierID]);
if($contactDetail != null){
    if(strlen($contactDetail->nickname) > 0){
        $nickname = $contactDetail->nickname;
    }
    else{
        $nickname = $contactPerson;
    }
}
else{
    $nickname = $contactPerson;
}
$cc = explode(",", $contactPersonCC);

$purchaseDate = date('d F Y', strtotime($purchaseDate));
 ?>
<!DOCTYPE html>
<html>
<head> 
</head>
<body style="font-family: Eurostar">
    <table style="width:100%;" class="table_head">
        <tr>
            <td style="height:50px; width: 30%; text-align: center; font-family: arial; font-size: 14px">
                <div style=""><?php echo Html::img('assets_b/images/logonew.png',['height' => '75px', 'width' => '70px']) ?> </div>                       
                <div style="font-size: 32px; color: #4b6b21; "><b><?= AppHelper::getSetting('CompanyName', 'Company Name'); ?></b></div>
                <div style=" font-size: 13px; ">Importer & Supplier of Pharmaceutical Raw Materials</div>
            </td>
            <td colspan="3" style="font-family: arial; font-size: 24px; width: 50%; text-align: left">
                 <!--<div style="margin-top: -100px; margin-left: 295px;"><?= $footer; ?></div>-->
                 <table style="border: 0; ">
                    <tr>
                        <td valign="top" style="border: 0;"><?=$location;?></td>
                       
                        <td style="border: 0;"><?=$address->value1 ?> </td>
                    </tr>
                    <tr>
                        <td valign="top" style="border: 0;"><?=$imagePhone;?></td>
                       
                        <td style="border: 0;">+62 21<?=$phone1->value1?>, <?=$phone2->value1?>, <?=$phone3->value1?></td>
                    </tr>
                     <tr>
                        <td valign="top" style="border: 0;"><?=$imagePhone;?></td>
                       
                        <td style="border: 0;">+62 21<?=$phone4->value1 ?> [Direct Marketing Dept]</td>
                    </tr>
                    <tr>
                        <td style="border: 0;"><?=$imageFax;?></td>
                       
                        <td style="border: 0;">+62 21<?=$fax->value1?></td>
                    </tr>
                  
                </table>
            </td>
            <td style="width: 40%; font-size: 14px; padding: 5px;">
                <table style="border: 0; ">
                    <tr>
                        <td style="border: 0;"><b>License</b></td>
                       
                    </tr>
                    <tr>
                        <td style="border: 0;">Certificate Distribution No</td>
                        <td style="border: 0;"> : </td>
                        <td style="border: 0;"><?= AppHelper::getSetting('SertifikatDistribusiFarmasi','Sertifikat Distribusi Farmasi No') ?> </td>
                    </tr>
                    <tr>
                        <td style="border: 0;">Good Distribution Practice No</td>
                        <td style="border: 0;"> : </td>
                        <td style="border: 0;"><?= AppHelper::getSetting('SertifikatCDOB','Sertifikat CDOB Bahan Obat') ?></td>
                    </tr>
                    <tr>
                        <td style="border: 0;">Permit Psychotropic Drugs No</td>
                        <td style="border: 0;"> : </td>
                        <td style="border: 0;"> <?= AppHelper::getSetting('IjinPsikotropika','Ijin Importir Terdaftar Psikotropika') ?></td>
                    </tr>
                    <tr>
                        <td style="border: 0;">Permit Precursor Drugs No</td>
                        <td style="border: 0;"> : </td>
                        <td style="border: 0;"> <?= AppHelper::getSetting('IjinITPrekursorFarmasi','Ijin IT Prekursor Farmasi No') ?></td>
                    </tr>
                    <tr>
                        <td style="border: 0;"><b>Tax ID [NPWP]</b></td>
                        <td style="border: 0;"> : </td>
                        <td style="border: 0;"><b> <?=$NPWP->value1?></b></td>
                    </tr>
                </table>
            </td>
        </tr>
        
    </table>
    <table class="table-middle">
        <thead>
            <tr bgcolor='#77a53b' style="">
                
                <th style="width: 20%; text-align: center; font-size: 15px;"></th>
                <th style="width: 10%; text-align: center; font-size: 18px; color: white;">Purchase Order <?=$prekursorText?></th>
                <th style="width: 20%; text-align: center; font-size: 15px;"></th>
             
            </tr>
        </thead>
        <tbody>                    
           
                <tr> 
                    <td  valign="top" style="width: 30%; font-size: 14px; ">
                        <table style="border: 0; ">
                            
                            <tr>
                                <td valign="top" style="border: 0; ">Supplier</td>
                                <td  valign="top" style="border: 0;">:</td>
                                <td style="border: 0;"><b><?= $supplier ?></b><br>
                                    <?php echo nl2br($street); ?><br>
                                    <?php
                                        if (!empty($cityName)) {
                                            echo $cityName . ",<br>";
                                        }
                                    ?>
                                    <?php if (!empty($provinceSupplier)) echo $provinceSupplier . ", "; ?><?= $countrySupp; ?>
                                </td>
                              
                            </tr>
                           
                            <tr>
                                <td style="border: 0;">Attn</td>
                                <td style="border: 0;"> : </td>
                                <td style="border: 0;"> <?= $contactPerson; ?></td>
                                
                            </tr>
                            <tr>
                                <td valign="top" style="border: 0;">CC</td>
                                <td valign="top" style="border: 0;"> : </td>
                                <td style="border: 0;">
                                <?php
                                    if ($contactPersonCC != '') {
                                        for ($j = 0; $j < count($cc); $j++) {
                                            echo  $cc[$j];
                                            echo '<br>';
                                        }
                                    } else {
                                        
                                    }

                                    ?>
                                </td>
                                
                            </tr>
                           
                        </table>
                    </td>
                    <td  valign="top" style=" font-size: 14px; padding: 5px;">
                        <table style="border: 0; ">
                            <tr>
                                <td valign="top" style="border: 0;">Consignee : </td>
                            </tr>
                            <tr>
                        
                                <td valign="top" style="border: 0;">
                                    <?= $company->value1; ?><br>
                                    <?=$streets->value1; ?><br>
                                    <?=$kel->value1; ?>, <?=$kec->value1; ?>, <?=$city->value1; ?>, <?=$province->value1; ?><br>
                                    <?=$city->value1; ?>, <?=$postalCode->value1; ?> - <?=$countrys->value1; ?>, 
                                </td>
                            </tr>
                            <tr >
                                <td style="border: 0; "><div style="text-align: top;"><?=$imagePhone;?>+62 21<?=$phone1->value1?>, <?=$phone2->value1?>, <?=$phone3->value1?>, <?=$phone4->value1?></div></td>
                            </tr>
                             <tr>
                                 <td style="border: 0; "><div style="text-align: top;"><?=$imageFax;?> +62 21<?=$fax->value1?> <br>
                                         Attn. Mr.<?= app\components\AppHelper::getSetting('CompanyDirector', 'Company Director') ?> [<?= app\components\AppHelper::getSetting('CompanyAttnEmail', 'Attendant Email') ?>]</div></td>

                            </tr>
                            
                        </table>
                    </td>
                   <td  valign="top" style="width: 30%; font-size: 14px; padding: 5px;">
                        <table style="border: 0; ">
                            <tr>
                                <td valign="top" style="border: 0;">PO No</td>
                                <td valign="top" style="border: 0;"> : </td>
                                <td style="border: 0;"><?= $purchaseNum ?> <?=$revitionNotes ? '('.$revitionNotes.')' : ''?></td>
                            </tr>
                            <tr>
                                <td style="border: 0;">Date</td>
                                <td style="border: 0;"> : </td>
                                <td style="border: 0;"><?= $purchaseDate?></td>
                            </tr>
                             <tr>
                                <td style="border: 0;">Packing Type</td>
                                <td style="border: 0;"> : </td>
                                <td style="border: 0;"><?= $pack; ?></td>
                            </tr>
                            <tr>
                                <td style="border: 0;">Shipment</td>
                                <td style="border: 0;"> : </td>
                                <td style="border: 0;"><?= $shipment; ?></td>
                            </tr>
                            <tr>
                                <td style="border: 0;">Delivery</td>
                                <td style="border: 0;"> : </td>
                                <td style="border: 0;"><?= $delivery; ?></td>
                            </tr>
                            <tr>
                                <td style="border: 0;">Payment</td>
                                <td style="border: 0;"> : </td>
                                <td style="border: 0;"><?= $payment?></td>
                            </tr>
                            <tr>
                                <td style="border: 0;">Prepared By</td>
                                <td style="border: 0;"> : </td>
                                <td style="border: 0;"> 
                                <?php 
                                $details = MsUser::findOne(['username' => $created]); 
                                echo $details->fullName;
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 0;">Division</td>
                                <td style="border: 0;"> : </td>
                                <td style="border: 0;"> 
                                <?php 
                                $details = MsUser::findOne(['username' => $created]); 
                                echo $details->userRole;
                                ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                   
                </tr>  
               
           
        </tbody>
    </table>
    <div class="covers" style="margin-top: -1px;"><br>
        <div style="margin-left: 15px; margin-right: 15px; margin-top: -10px;"> 
            <div style="text-align: left; ">We herewith confirmed our order with following condition : </div>

            <table class="table-middles">
                <thead>
                    <tr bgcolor='#77a53b'>
                        <th style="width: 5%; text-align: center; ">No</th>
                        <th style="width: 250px; text-align: center; ">Product</th>
                        <th style="width: 170px; text-align: center; ">Origin /Country Of Origin</th>
                        <th style="width: 10%; text-align: center; ">Hs Code</th>
                        <th style="width: 10%; text-align: center; ">Qty</th>
                        <th colspan="2" style="width: 10px; text-align: center;  border-bottom: 1px solid black; border-left: 1px solid black">Unit Price</th>
                        <th colspan="2" style="width: 100px; text-align: center; ">Amount</th>
                        <th style="width: 5%; text-align: center; ">V</th>
                    </tr>
                </thead>
                <tbody>     
                        <?php
                            $no = 1;
                            foreach ($model2 as $model2) {
                        ?>
                        <tr> 
                            
                            <td style=" padding: 5px; border: 1px solid black; text-align:center;"><?= $no;?></td>
                            <td style=" padding: 5px; border: 1px solid black"><?= $model2['productName'];?></td>
                            <td style=" padding: 5px; border: 1px solid black"><?= $model2['origin'];?></td>
                            <td style=" padding: 5px; border: 1px solid black; text-align: center"> <?= $model2['hsCode']; ?></td>
                            <td style=" padding: 5px; text-align: center; border-bottom: 1px solid black;"><?= number_format($model2['qty'],2,".",","); ?> <?= $model2['uomName']; ?></td>
                            <td style="padding: 5px; text-align: left;  border-left: 1px solid black; border-bottom: 1px solid black;">
                                <?= $model2['currencyID']; ?>
                            </td>
                            <td style=" padding: 5px; text-align: right;  border-right: 1px solid black; border-bottom: 1px solid black;"> <?= number_format($model2['price'],2,".",","); ?> </td>
                            <td style="padding: 5px; text-align: left;  border-left: 1px solid black; border-bottom: 1px solid black;">
                                <?= $model2['currencyID']; ?>
                            </td>
                            <td style=" padding: 5px; text-align: right;  border-right: 1px solid black; border-bottom: 1px solid black;"> <?= number_format($model2['amount'],2,".",","); ?></td>
                            <td style=" padding: 5px; border: 1px solid black"></td>
                            
                        </tr>  
                        <?php 
                            $no = $no + 1;} 
                        ?>
                </tbody>
            </table>
            
            <div style="margin-top: 5px; font-size: 14px;" >
                <div style=" float: left; width: 100%;  ">
                    <div style="float: left; "><u><b>Note :</b></u> </div>
                    <div style="float: left; width: 100%; font-size: 14px; margin-left: -20px; margin-top: -10px;"><?= nl2br($notes); ?></div>
                </div>
            </div>
            <div style=" float: left; margin-top: 7px;">
                Please Confirm,<br>
                Thank you for your kind cooperation and support.
                <div style="float: left; width: 35%; margin-top: 5px;"><b>Yours Faithfully.</b><br></div>
                <div style="float: left; width: 40%; height: 50px; font-size: 14px; margin-top: 5px;"><b>Approval By.</b></div>
                <div style="float: left; width: 25%; height: 50px; font-size: 14px; margin-top: 5px;"><b>Confirmed By.</b></div>
                <div style="float: left; width: 50%; font-size: 14px;">
                    <u><b><?= app\components\AppHelper::getSetting('CompanyDirector', 'Company Director') ?></b></u><br><div style="font-size: 14px;">Director</div> <div style="color: red; font-size: 12px;"> #This is Computer Generated Quotation and Signature is not Required</div>
                </div>
                <div style="float: left; width: 40%; font-size: 14px; margin-left: -150px;">
                    <u><b><?= app\components\AppHelper::getSetting('PharmacistName', 'Pharmacist Name') ?></b></u><br>
                    <div style="font-size: 14px;">Pharmacist/
                        <?= app\components\AppHelper::getSetting('PharmacistNumber', 'Pharmacist Number') ?></div>
                </div>
                <div style="float: left; width: 25%; font-size: 14px; margin-left: -5px;">name, position, & stamp</div> 
                
            </div>

        </div>    
    </div>
</body>
</html>


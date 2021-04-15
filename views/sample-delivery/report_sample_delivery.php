<?php
use yii\helpers\Html;
use app\components\MdlDb;
use app\models\MsCustomerdetail;
use app\models\TrSampledeliverydetail;

$model2 = $model;
$subject = '';
foreach ($model as $model){
    $sampleDeliveryDate = $model['sampleDeliveryDate'];
    $sampleDeliveryNum = $model['sampleDeliveryNum'];
    $customerID = $model['customerID'];
    $customerName = $model['customerName'];
    $npwpAddress = $model['npwpAddress'];
    $uom = $model['uomName'];
    $notes = $model['notes'];
    
    $subject .= ($subject == '' ? '' : ', ') . $model['productName'];
}

if ($headModel->customerDetailID)
{
    $customerDetail = MsCustomerdetail::findOne(['customerDetailID' => $headModel->customerDetailID]);
} else 
{
    $customerDetail = MsCustomerdetail::find()->where(['customerID' => $customerID])->one();
}

if ($customerDetail)
{
    $attn = $customerDetail->contactPerson;
}

$sampleDeliveryDate = date('d F Y', strtotime($sampleDeliveryDate));

?>
<html>
<head> 
</head>
<body style="font-family: Eurostar">
    <div style="text-align: center"><?php echo Html::img('assets_b/images/logonew.png',['height' => '85px', 'width' => '80px']) ?> </div>
    <br/> 
    <div style="font-size: 25px; color: green; text-align: center; margin-top: -20px;"><?= app\components\AppHelper::getSetting('CompanyName','Company Name') ?></div>
    <div style="font-size: 14px; text-align: center; ">Importer & Supplier of Pharmaceutical Raw Materials and Finished Products</div>
    <div style="float: right; font-size: 16px; text-align: right; margin-top: 17px;"><b>Jakarta, <?= $sampleDeliveryDate; ?></b></div>
    <div style="float: right; font-size: 16px; text-align: right; "><b>Ref No. <?= $sampleDeliveryNum; ?></b></div>
    <br>
    <div style="float: left; width: 50%; font-size: 16px;">
        <b><?= $customerName; ?></b>
        <br>
        <b><?= $npwpAddress; ?></b>
        <div style="width: 100%; height: 25px;"></div>
        <b><?php if ($attn) { echo 'Attn. '.$attn; } ?></b>
        <div style="width: 100%; height: 25px;"></div>
        Subject : <?= $subject ?>
        <div style="width: 100%; height: 25px;"></div>
        Dear <?= $attn ?>
    </div>
    <div style="float: left; width: 100%; font-size: 15px; margin-top: 20px;">
        With reference to above subject and as requested by you, we are sending herewith the below sample.
    </div>
    <table style="width: 100%; border: 1px solid black; border-collapse: collapse; margin-top: 10px; margin-bottom: 15px;">
        <thead>
            <tr>
                <th style="text-align: center; font-size: 15px; padding: 5px; border-bottom: 1px solid black; border-left: 1px solid black;">Product Name</th>
                <th style="text-align: center; font-size: 15px; padding: 5px; border-bottom: 1px solid black; border-left: 1px solid black;">Origin</th>
                <th style="text-align: center; font-size: 15px; padding: 5px; border-bottom: 1px solid black; border-left: 1px solid black;">Batch No</th>
                <th style="text-align: center; font-size: 15px; padding: 5px; border-bottom: 1px solid black; border-left: 1px solid black;">Qty</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($model2 as $model) { ?>
            <tr>
                <td style="padding-top: 10px; padding-bottom: 10px; text-align: center; font-size: 15px; border-left: 1px solid black;"><i><?= $model['productName'];?></i></td>
                <td style="padding-top: 10px; padding-bottom: 10px; text-align: center; font-size: 15px; border-left: 1px solid black;"><i><?= $model['origin']; ?></i></td>
                <td style="padding-top: 10px; padding-bottom: 10px; text-align: center; font-size: 15px; border-left: 1px solid black;"><i><?= $model['batchNumber']; ?></i></td>
                <td style="padding-top: 10px; padding-bottom: 10px; text-align: center; font-size: 15px; border-left: 1px solid black;"><i><?= number_format($model['qty'],4,".",","); ?> <?= $model['uomName']; ?></i></td>
            </tr>
            <?php 
            $i++; } ?>
        </tbody>
    </table>
    
    <div style="float: left; width: 10%; font-size: 15px; ">Note : </div>
    <div style="float: left; width: 90%; font-size: 15px;"><?= nl2br($notes); ?></div><br>   
    
	<?=($i>3 ? '<div style="page-break-before: always;"></div>' : '' )?>
        <div style="float: left; font-size: 15px; width: 100%; margin-top: 8px;">
            Please acknowledge receipt of above sample and keep us updated on the status of approval at the earliest. With company stamped.
        </div>
        <br><br>
        <div style="margin-top: -30px;"> 
        <div style="float: left; font-size: 15px;">Thanking you</div>
        <br>
        <div style="float: left; width: 30%; font-size: 15px;">
            Yours sincerely,
            <div style="float: left; margin-top: 70px;">
                <u><?= app\components\AppHelper::getSetting('SamplingPIC','Sampling PIC') ?></u>
                <br>
                General Affair
                <div style="width: 100%; height: 10px;"></div>
                Cc. Nurdin Wijaya
            </div>
        </div>
        <div style="float: left; width: 45%; font-size: 15px;">
            Acknowledge,
            <div style="float: left; margin-top: 70px;">
                <u><?= app\components\AppHelper::getSetting('PharmacistName','Pharmacist Name') ?></u>
                <br>
                Apoteker Penanggung Jawab
            </div>
        </div>

        <div style="float: left; width: 25%; font-size: 15px; text-align: center;">
            Received by
            <div style="margin-top: 70px; font-size: 1.3em;">
                <div style="width: 100%; float:left; text-align: left; font-size: 14px;">[ &nbsp; Name, Date & Stamp &nbsp; ]</div>
                
            </div>
        </div> 
        <div style="float: left; font-size: 15px; width: 100%; text-align: center; margin-top: 20px;">
            <b>Please kindly send by Fax to <?= $fax['value1'] ?> after received the sample and duly signed.</b>
        </div>
       </div>
</body>
</html>


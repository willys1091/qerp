<?php
use yii\helpers\Html;

$model2 = $model;
$model3 = $model;
foreach($model2 as $model2){
    $customer = $model2['customerName'];
    $date = $model2['salesOrderDate'];   
    $emailCustomer = $model2['email'];
    $packName = $model2['packingTypeName'];
    $note = $model2['additionalInfo'];
    $contact = $model2['contactPerson'];
}
?>
<style type="text/css">
    a{
        color: blue;
    }
    table{
            border-collapse: collapse;
    }
    th,td{
        border: 1px solid black;
    }
    .color1{
        background-color: #c0c6b8;
    }
    .color2{
        background-color: white;
    }
    .image{
        padding-left: -8px;
    }
</style>
<body style="font-family: eurostar">
    <div style="text-align: center"><?php echo Html::img('assets_b/images/logonew.png',['height' => '75px', 'width' => '70px']) ?> </div><br/>                        
    <div style="font-size: 26px; color: #4b6b21; text-align: center"><b><?= app\components\AppHelper::getSetting('CompanyName', 'Company Name'); ?></b></div>
    <div style="text-align: center; color: #4b6b21;">Importer & Supplier of Pharmaceutical Raw Materials</div>
    <br>
    <!--first row-->
    <div style="margin-left: 5%">
        <div style="float: left; width: 10%; text-align: left; font-weight: bold; letter-spacing: 1px">Company</div>
        <div style="float: left; width: 40%; text-align: left;">: &nbsp;&nbsp;<?= $customer; ?></div>
        <div style="float: left; width: 12%; text-align: left; font-weight: bold; letter-spacing: 1px">Date</div>
        <div style="float: left; width: 5%; text-align: left;">:</div>
        <div style="float: left; text-align: left;"><?= $date; ?></div>
    </div>
    <!--second row-->
    <div style="margin-left: 5%">
        <div style="float: left; width: 10%; text-align: left; font-weight: bold; letter-spacing: 1px">Attn</div>
        <div style="float: left; width: 40%; text-align: left;">: &nbsp;&nbsp;<?= $contact; ?></div>
        <div style="float: left; width: 12%; text-align: left; font-weight: bold; letter-spacing: 1px">From</div>
        <div style="float: left; width: 5%; text-align: left;">:</div>
        <div style="float: left; text-align: left;"><?= app\components\AppHelper::getSetting('CompanyDirector', 'CompanyDirector'); ?></div>
    </div>
    <!--third row-->
    <div style="margin-left: 5%">
        <div style="float: left; width: 10%; text-align: left; font-weight: bold; letter-spacing: 1px">E-mail</div>
        <div style="float: left; width: 40%; text-align: left; color: blue">: &nbsp;&nbsp;<u><?= $emailCustomer; ?></u></div>
        <div style="float: left; width: 12%; text-align: left; font-weight: bold; letter-spacing: 1px">E-mail</div>
        <div style="float: left; width: 5%; text-align: left;">:</div>
        <div style="float: left; text-align: left; color: blue"><u><?= app\components\AppHelper::getSetting('CompanyAttnEmail', 'Attendant Email'); ?></u></div>
    </div>
    <!--fourth row-->
    <div style="margin-left: 5%">
        <div style="float: left; width: 10%; text-align: left; font-weight: bold; letter-spacing: 1px">Fax</div>
        <div style="float: left; width: 40%; text-align: left;">: &nbsp;&nbsp;<?= app\components\AppHelper::getSetting('Fax', 'Fax'); ?></div>
        <div style="float: left; width: 12%; text-align: left; font-weight: bold; letter-spacing: 1px">Cell Phone</div>
        <div style="float: left; width: 5%; text-align: left;">:</div>
        <div style="float: left; text-align: left;"><?= app\components\AppHelper::getSetting('Phone1', 'Phone 1'); ?></div>
    </div>
    <!--fifth row-->
    <div style="margin-left: 5%">
        <div style="float: left; width: 10%; text-align: left; font-weight: bold; letter-spacing: 1px">Pages</div>
        <div style="float: left; width: 40%; text-align: left;">: &nbsp;&nbsp;-</div>
        <div style="float: left; width: 12%; text-align: left; font-weight: bold; letter-spacing: 1px">Subject</div>
        <div style="float: left; width: 5%; text-align: left;">:</div>
        <div style="float: left; text-align: left;">Sales Order</div>
    </div>
    <div style="border-bottom: 3px solid #4b6b21; width: 100%; margin-top: 5px;"></div><br>
    <div style="margin-left: 5%">
        <div style="margin-top: 10px">Dear <?= $contact; ?>,</div>
        <div style="margin-top: 10px">Below is your sales order detail:</div>
        <br>
        <table style="width: 100%">
            <thead>
                <tr bgcolor='#77a53b'>
                    <th style="width: 10%;text-align: center; color: white">No</th>
                    <th style="width: 40%;text-align: center; color: white">Product</th>
                    <th style="width: 10%;text-align: center; color: white">Qty</th>
                    <th style="width: 10%;text-align: center; color: white">Pack</th>
                    <th style="width: 30%;text-align: center; color: white">Unit Price</th>
                </tr>
                <?php
                $i = 1;
                foreach ($model as $model){ 
                    if ($i % 2 == 0) { 
                        $color = 'color1';
                    } else {
                        $color = 'color2';
                    }
                ?>
                <tr class="<?= $color; ?>">
                    <td style="width: 15%; text-align: center; font-size: 12px"><?= $i; ?></td>
                    <td style="width: 30%; font-size: 12px"><?= $model['productName']; ?></td>
                    <td style="width: 15%; text-align: right; font-size: 12px"><?= $model['qty']; ?></td>
                    <td style="width: 15%; text-align: right; font-size: 12px"><?= $model['uomName']; ?></td>
                    <td style="width: 25%; text-align: right; font-size: 12px"><?= $model['price']; ?></td>
                </tr>
                <?php 
                $i = $i+1;
                } ?>
            </thead>
        </table>
        <div style="margin-top: 10px">
            <div style="float: left; width: 25%">Origin/Country of origin</div>
            <div style="float: left; width: 5%">:</div>
            <div style="float: left; width: 70%">
                <?php 
                $j = 1;
                foreach ($model3 as $model3){
                    echo $j.').&nbsp;'.$model3['origin'].'&nbsp;&nbsp;&nbsp;';
                    $j++;
                } ?>
            </div>
            <div><u>Note</u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</div>
            <div style="padding-left: 8%"><?= nl2br($note); ?></div>
            <br>
        </div>
        <br>
        <div style="float: left; width: 50%;"><b>Sincerely yours,</b><br><?php echo Html::img('assets_b/images/qbarcodekanji.png',['width' => '150px', 'class' => 'image']) ?></div><div style="float: left; width: 50%; height: 80px;"><b>Confirmed By,</b></div>
        <div style="float: left; width: 50%; font-size: 16px"><b><?= app\components\AppHelper::getSetting('CompanyDirector', 'Company Director'); ?>.</b></div><div style="float: left; width: 50%;"><b>___________________</b></div>
        <div style="color: red; font-size: 8px"><i>The sales order was processed automatically and therefore has no signature</i></div>
    </div>
</body>


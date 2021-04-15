<?php
use yii\helpers\Html;
use app\models\MsCustomerdetail;
use yii\helpers\Json;

$model2 = $model;
$model3 = $model;
$packName = "";
$i = 1;
foreach($model2 as $model2){
    $customerID = $model2['customerID'];
    $customer = $model2['customerName'];
    $date = $model2['salesQuotationDate'];   
    $emailCustomer = $model2['email'];
    $packName .= "$i). ".$model2['packingTypeName']." &nbsp; ";
    $note = $model2['additionalInfo'];
    $contact = $model2['contactPerson'];
    $cc= $model2['cc'];
    $attachment= $model2['attachment'];
    $delivery = $model2['delivery'] == null? "-" : $model2['delivery'];
    $payment = $model2['payment'] == null? "-" : $model2['payment'];
    
    $i++;
}
if($cc != '' || $cc !=null)
{
    $cc = explode(",", $cc);
}

$PIC = MsCustomerdetail::findOne(['customerID' => $customerID, 'contactPerson' => $contact]);
if (!$PIC) $PIC =  MsCustomerdetail::findOne(['customerID' => $customerID]);
if($PIC != null){
    $faxNumber = $PIC->fax;
    
    if(strlen($PIC->nickname) > 0){
        $nickname = $PIC->nickname;
    }
    else{
        $nickname = $contact;
    }
    
    if (strlen($PIC->email) > 0)
    {
        $emailCustomer = $PIC->email;
    }
}
else{
    $faxNumber = "";
}

$loggedUser = Yii::$app->user->identity;

?>
<style type="text/css">
    a{
        color: blue;
    }
    table{
            border-collapse: collapse;
    }
    th{
        border: 1px solid black;
    }
    td{
        padding-left: 5px;
        padding-right: 5px;
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
    .covers{
        top: 10px;
        border-style: solid;
        border-color: #005730;
        border : 3px;
        height: 100%;
        margin-top: 20px;
    }
</style>
<body style="font-family: eurostar; ">
  
    <div >
        <div style="margin-left: 108px;"><?php echo Html::img('assets_b/images/logonew.png',['height' => '75px', 'width' => '70px']) ?> </div><br/>                        
        <div style="margin-top: -25px; font-size: 32px; color: #4b6b21; "><b><?= app\components\AppHelper::getSetting('CompanyName', 'Company Name'); ?></b></div>
        <div style=" margin-top: -5px; font-size: 13px;">Importer & Supplier of Pharmaceutical Raw Materials</div>
    </div> 
    <div style="margin-top: -80px; margin-left: 320px;">
        <table style="border: 0; ">
                    <tr>
                        <td valign="top" style="border: 0;"><?=$location;?></td>
                       
                        <td style="border: 0;"><?=$address->value1 ?> </td>
                    </tr>
                    <tr>
                        <td valign="top" style="border: 0;"><?=$imagePhone;?></td>
                       
                        <td style="border: 0;">+62 21<?=$phone1->value1?>, <?=$phone2->value1?>, <?=$phone3->value1?>, <?=$phone4->value1 ?> </td>
                    </tr>
                    <tr>
                        <td style="border: 0;"><?=$imageFax;?></td>
                       
                        <td style="border: 0;">+62 21<?=$fax->value1?></td>
                    </tr>
                  
                </table>
    </div>
      
    <br>
    <!--first row-->
    <div class="covers">
     <table style="width: 100%; ">
        <tr bgcolor='#77a53b'>
            <td style="text-align: center;  font-size: 18px;"><b style="color: white;"><?=$id; ?></b></td>
       </tr>
     </table>
    <br>    
    <div style="margin-left: 5%">
        <div style="float: left; width: 10%; text-align: left; font-weight: bold; letter-spacing: 1px">Company</div>
        <div style="float: left; width: 40%; text-align: left;">: &nbsp;&nbsp;<?= $customer; ?></div>
        <div style="float: left; width: 12%; text-align: left; font-weight: bold; letter-spacing: 1px">Date</div>
        
        <div style="float: left; text-align: left;">: &nbsp;&nbsp;<?= $date; ?></div>
    </div>
    <!--second row-->
    <div style="margin-left: 5%">
        <div style="float: left; width: 10%; text-align: left; font-weight: bold; letter-spacing: 1px">Attn</div>
        <div style="float: left; width: 40%; text-align: left;">: &nbsp;&nbsp;<?= $contact ?></div>
        <div style="float: left; width: 12%; text-align: left; font-weight: bold; letter-spacing: 1px">From</div>
        <div style="float: left; text-align: left;">: &nbsp;&nbsp;<?= $created ?></div>
    </div>
    <!--third row-->
    <div style="margin-left: 5%">
        <div style="float: left; width: 10%; text-align: left; font-weight: bold; letter-spacing: 1px">Cc. </div>
        <?php if($cc != '' || $cc !=null) {
           
        ?>
        <div style="float: left; width: 5%; text-align: left; ">:</div>
        <div style="float: left; width: 38%; margin-left: -21px; text-align: left; ">
        <?php for($j = 0; $j < count($cc); $j++) 
                {
                     echo $cc[$j].', ';
                }
               
         ?>
        </div>
        <?php  } else { ?>
            <div style="float: left; width: 40%; text-align: left; ">:</div>
            
        <?php } ?>     
       
        
        <div style="float: left; width: 12%; text-align: left; font-weight: bold; letter-spacing: 1px">E-mail</div>
        <div style="float: left; text-align: left; color: blue">: &nbsp;&nbsp;<u> <?=$details->email;?></u></div>
    </div>
    <!--fourth row-->
    <div style="margin-left: 5%">
        <div style="float: left; width: 10%; text-align: left; font-weight: bold; letter-spacing: 1px">E-mail</div>
        <div style="float: left; width: 40%; text-align: left;">: &nbsp;&nbsp;<?= $emailCustomer; ?></div>
        <div style="float: left; width: 12%; text-align: left; font-weight: bold; letter-spacing: 1px">Cell Phone</div>
        <div style="float: left; text-align: left;">: &nbsp;&nbsp;<?= $details->phoneNumber; ?></div>
    </div>
    <!--fifth row-->
    <div style="margin-left: 5%">
        <div style="float: left; width: 10%; text-align: left; font-weight: bold; letter-spacing: 1px">Fax</div>
        <div style="float: left; width: 40%; text-align: left;">: &nbsp;&nbsp;<?= $faxNumber; ?></div>
        <div style="float: left; width: 12%; text-align: left; font-weight: bold; letter-spacing: 1px">Subject</div>
        <div style="float: left; text-align: left;">: &nbsp;&nbsp; Quotation</div>
    </div>
    <!--sixth row-->
    <div style="margin-left: 5%">
        <div style="float: left; width: 10%; text-align: left; font-weight: bold; letter-spacing: 1px">Pages</div>
        <div style="float: left; width: 40%; text-align: left;">: &nbsp;&nbsp;-</div>
        <div style="float: left; width: 12%; text-align: left; font-weight: bold; letter-spacing: 1px">Attachment</div>
        <div style="float: left; width: 5%; text-align: left;">:</div>
        <div style="float: left; text-align: left; margin-left: -20px;"><?=$attachment;?></div>
    </div>
    <div style="border-bottom: 3px solid #4b6b21; width: 100%; margin-top: 5px;"></div><br>
    <div style="margin-left: 5%; width: 90%;" >
        <div style="float: left; width: 15%;">Urgent</div>
        <div style="float: left; width: 20%;"><b>√ Please Reply</b></div>
        <div style="float: left; width: 25%;"><b>√ Our Telecom / Visit</b></div>
        <div style="float: left; width: 20%;"><b>√ At your request</b></div>
        <div style="float: left; width: 20%;">As Agree</div>
        <br>
        <div><u><b>Message,</b></u></div>
        <div style="margin-top: 10px">Dear <?= $nickname; ?>,</div>
        <div style="margin-top: 10px">We would like to offer with following conditions:</div>
        <br>
        <table style="width: 100%">
            <thead>
                <tr bgcolor='#77a53b'>
                    <th style="width: 7%;text-align: center; color: white">No</th>
                    <th style="width: 25%;text-align: center; color: white">Product</th>
                    <th style="width: 15%;text-align: center; color: white">Quantity</th>
                    <th style="width: 100px;text-align: center; color: white">Packing</th>
                    <th colspan="2" style="width: 220px;text-align: center; color: white">Unit Price</th>
                    <th colspan="2" style="width: 220px;text-align: center; color: white">Total Amount</th>
                </tr>
                <?php
                $i = 1;
                foreach ($model as $model){ 
                    if ($i % 2 == 0) { 
                        $color = 'color1';
                    } else {
                        $color = 'color2';
                    }
                    
                    $qty = floatVal($model['qty']);
                    $uomQty = floatVal($model['uomQty']);
                    $Qty = number_format($qty, strlen(explode('.', $qty)[1]), ',', '.');
                    $Uomqty = number_format($uomQty, strlen(explode('.', $uomQty)[1]), ',', '.');
                    
                ?>
                <tr class="<?= $color; ?>">
                    <td style="text-align: center; font-size: 14px; border-left: 1px solid black; border-bottom: 1px solid black;"><?= $i; ?></td>
                    <td style="font-size: 14px; border-left: 1px solid black; border-bottom: 1px solid black;"><?= $model['productName']; ?></td>
                    <td style="text-align: right; font-size: 14px; border-left: 1px solid black; border-bottom: 1px solid black;"><?= $Qty ?> <?= $model['uomName']; ?></td>
                    <td style="text-align: right; font-size: 14px; border-left: 1px solid black; border-bottom: 1px solid black;"><?= $Uomqty ?> <?= $model['uomName']; ?></td>
                    <td style="text-align: left; font-size: 14px; border-left: 1px solid black; border-bottom: 1px solid black;">
                        <?= $model['currencyID'] == NULL ? 'IDR' : $model['currencyID'] ?>
                    </td>
                    <td style="text-align: right; font-size: 14px; border-bottom: 1px solid black; border-right: 1px solid black;">
                        <?= number_format($model['priceOffer'],2,".",","); ?>
                    </td>
                    <td style="text-align: left; font-size: 14px; border-left: 1px solid black; border-bottom: 1px solid black;">
                        <?= $model['currencyID'] == NULL ? 'IDR' : $model['currencyID'] ?>
                    </td>
                    <td style="text-align: right; font-size: 14px; border-bottom: 1px solid black; border-right: 1px solid black;">
                        <?= number_format($model['subTotal'],2,".",","); ?>
                    </td>
                </tr>
                <?php 
                $i = $i+1;
                } ?>
            </thead>
        </table>
        <div style="margin-top: 10px; font-size: 14px;" >
            <div style="float: left; width: 25%"><b>Origin/Country of origin</b></div>
            <div style="float: left; width: 5%">:</div>
            <div style="float: left; width: 70%">
                <?php 
                $j = 1;
                foreach ($model3 as $model3){
                    echo $j.').&nbsp;'.$model3['origin'].'&nbsp;&nbsp;&nbsp;';
                    $j++;
                } ?>
            </div>
            <div style="float: left; width: 25%;"><b>Packing type</b></div>
            <div style="float: left; width: 5%;">:</div>
            <div style="float: left; width: 70%;"><?= $packName; ?></div>
            <div style="float: left; width: 25%;"><b>Delivery</b></div>
            <div style="float: left; width: 5%;">:</div>
            <div style="float: left; width: 70%;"><?= $delivery; ?></div>
            <div style="float: left; width: 25%;"><b>Payment Term</b></div>
            <div style="float: left; width: 5%;">:</div>
            <div style="float: left; width: 70%;"><?= $payment; ?></div>
            <div style="float: left; width: 25%; "><u><b>Note</b></u></div>
            <div style="float: left; width: 5%;">:</div>
            <div style="float: left; width: 70%; font-size: 14px; "><?= $note; ?></div>
            <br>
            We hope our quotation could meet your requirement and if you need any futher information, Please do not hestitate to contact us.
        </div>
        <br>
        <div style="float: left; width: 75%;"><b>Sincerely yours,</b><br>&nbsp;<?php echo Html::img('assets_b/images/qrcodekanji.jpg',['width' => '100px', 'class' => 'image']) ?></div>
        <div style="float: left; width: 25%; text-align: center;height: 80px;"><b>Approved By.</b></div>
        <div style="float: left; width: 75%; font-size: 14px"><u><b><?= $created ?>.</b></u><br><br><b>Cc : <?=$director->fullName?></b></div>
        <div style="float: left;  width: 25%; margin-top: -10px; " ><pre><b>[                 ]</b></pre>
        <div style="margin-left: 2px; margin-right: 5px; color: blue; font-size: 10px;"> *Name, Position and Company stamp</div></div><br>
        <div style="color: red; font-size: 12px"><i>#This is Computer Generated Quotation and Signature is not Required</i></div>
    </div>
    </div>
</body>


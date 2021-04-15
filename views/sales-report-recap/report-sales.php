<?php
use yii\helpers\Html;

$model2 = $model;

 
foreach ($model2 as $model2) {
    $date= $model2['goodsDeliveryDate'];
    $refNum = $model2['refNum'];
    $year = $model2['year'];
    $month = $model2['month'];
    $day = $model2['day'];
    $customerName = $model2['customerName'];
    $streetC = $model2['street'];
    $cityC = $model2['city'];
    $countryC = $model2['country'];
    $phoneC = $model2['phone'];
    $postC = $model2['postalCode'];
    $shipmentBy = $model2['shipmentBy'];
    $npwpAddress = $model2['npwpAddress'];
}

?>
<style type="text/css">
	@page {
		/*margin-top: 2.54cm;
		margin-bottom: 2.54cm;*/
		margin-left: 1cm;
		margin-right: 1cm;
	}
    table{
        width: 100%;
        font-size: 14px;
       
        border-collapse: collapse;
        border-left: none;
        border-right: none;
    }
    th{
        font-family: 'Eurostar';
    }
    td{
        font-family: 'Eurostar';
    }
</style>
<div class="row" style="height: 100px;"></div>
<div style="border: 1px solid black; margin-left: -20px; margin-right: -20px;  font-family: 'Eurostar'; ">

    <table style="">
        
        <thead>
            
            <tr>
               
                <th style="width: 20%; border-bottom: 1px solid black; border-left: 1px solid black; text-align: center">Dalivery Date</th>
                <th style="width: 30%; border-left: 1px solid black; border-bottom: 1px solid black; text-align: center">Customer</th>
                <th style="width: 20%; border-left: 1px solid black; border-bottom: 1px solid black; padding-left: 10px">Qty</th>
                <th style="width: 30%; border-left: 1px solid black; border-bottom: 1px solid black; padding-left: 10px; border-right: 1px solid black">Price</th>
            </tr>
        </thead>
         
       
        <tbody style='page-break-inside: avoid'>
          
            <?php  $i = 0;
            foreach ($model as $model) { ?>
            <tr>
                <td style="font-size: 16px;  border-bottom: 1px solid black; border-left: 1px solid black; text-align: center"><?= $model['goodsDeliveryDate']; ?></td>
                <td style="font-size: 16px; border-left: 1px solid black; border-bottom: 1px solid black; text-align: center"><?= $model['uomName']; ?></td>
                <td style="font-size: 16px;  border-left: 1px solid black; border-bottom: 1px solid black; padding-left: 10px"><?= $model['productName']; ?></td>
                <td style="border-left: 1px solid black; border-bottom: 1px solid black; padding-left: 10px; border-right: 1px solid black; font-size: 13px">
                  
                </td>
                 
            </tr>
            <?php $i++; } ?>
          
        </tbody>
    </table>
   
  
   
    </div>
   
</div>



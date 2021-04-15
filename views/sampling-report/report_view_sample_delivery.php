<?php
use kartik\export\ExportMenu;
use yii\helpers\html;
?>

<html>
    <head>
        <style type="text/css">
            table{
                border-collapse: collapse;
                width: 100%;
            }
            td,th{
                border: 1px solid black;
            }
            .header{
                float: left;
                font-size: 12px;
                text-align: left;
            }
        </style>
    </head>
    <body>
        <div style="background-color: white"> 
            <?php $count = count($model);
                if($count == 0){
                $message = 'No data result';
            }else{
                $message = '';
            }
            ?> 
            <?php echo Html::img('@web/assets_b/images/logonew.png',['height' => '85px', 'width' => '80px']) ?>
            <?= $message; ?>            
            <br/>
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center;">No</th>
                        <th style="text-align: center;">Product</th>
                        <th style="text-align: center;">Date of Sent</th>
                        <th style="text-align: center;">Reff No</th>
                        <th style="text-align: center;">Customer</th>
                        <th style="text-align: center;">Batch</th> 
                        <th style="text-align: center;">Origin</th> 
                        <th style="text-align: center;">Qty</th> 
                        <th style="text-align: center;">Remarks</th> 
                        <th style="text-align: center;">Result</th> 
                    </tr>
                </thead>
                <tbody>                    
               <?php 
               $no = 1;
               foreach($model as $model){
               $deliveryDate = date('d-m-Y', strtotime($model['sampleDeliveryDate']));?>
                    <tr> 
                        <td style="text-align: center;"><?= $no; ?></td>
                        <td style="text-align: left;"><?= $model['productName']; ?></td>
                        <td style="text-align: center;"><?= $deliveryDate; ?></td>
                        <td style="text-align: center;"><?= $model['refNum']; ?></td>
                        <td style="text-align: left;"><?= $model['customerName']; ?></td>
                        <td style="text-align: left;"><?= $model['batchNumber']; ?></td>
                        <td style="text-align: left;"><?= $model['origin']; ?></td> 
                        <td style="text-align: center;"><?= $model['qty']; ?></td> 
                        <td style="text-align: left;"><?= $model['notes']; ?></td> 
                        <td style="text-align: left;"><?= $model['statusName']; ?></td> 
                    </tr>                    
               <?php $no++; } ?>
                </tbody>
            </table>            
            <br/>
            <label>Export Data:</label>
            <?= html::a('<i>Export</i>',['sampling-report/excel2', 
                'dateS'=> $dateS,
                'dateE'=> $dateE,
                'type' => $type,
                'productID' => $productID,
                'idC' => $idC,
                'idS' => $idS
                ],
                ['class'=>'btn btnExport']) ?>
            <?php 
            
            //Html::a('link text', Url::to('', true)); ?>
        </div>        
    </body>
</html>







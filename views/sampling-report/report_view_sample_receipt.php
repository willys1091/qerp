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
            td,th{
                border: 1px solid black;
                font-size: 12px;
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
            
            <?php echo Html::img('@web/assets_b/images/logonew.png',['height' => '85px', 'width' => '80px']) ?><br>
            <?= $message; ?>
            <br/>
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center">No</th>
                        <th style="text-align: center;">Date Received</th>
                        <th style="text-align: center;">Product</th>
                        <th style="text-align: center;">Batch</th>
                        <th style="text-align: center;">Principal</th>
                        <th style="text-align: center;">Reff No</th> 
                        <th style="text-align: center">Qty</th>
                        <th style="text-align: center">Remarks</th>
                    </tr>
                </thead>
                <tbody>                    
                <?php 
                $no = 1;
                foreach($model as $model){
                $receiptDate =  date('d-m-Y', strtotime($model['sampleReceiptDate']));?>
                    <tr> 
                        <td style="text-align: center"><?= $no; ?></td>
                        <td style="width: 20%; text-align: center;"><?= $receiptDate; ?></td>
                        <td style="width: 25%; text-align: left;"><?= $model['productName']; ?></td>
                        <td style="width: 15%; text-align: center;"><?= $model['batchNumber']; ?></td>
                        <td style="width: 25%; text-align: center;"><?= $model['origin']; ?></td>
                        <td style="width: 15%; text-align: left;"><?= $model['refNum']; ?></td>
                        <td style="text-align: center"><?= $model['qty']; ?></td>
                        <td style="text-align: center"><?= $model['notes']; ?></td>
                    </tr>                    
                <?php $no++; } ?>
                </tbody>
            </table>
            <br>
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





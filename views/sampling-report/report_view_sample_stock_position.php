<?php
use yii\helpers\Html;
use yii\helpers\Url;
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
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center">No</th>
                        <th style="text-align: center;">Product</th>                        
                        <th style="text-align: center">Batch Number</th>
                        <th style="text-align: center">Origin</th>                        
                        <th style="text-align: center;">Stock</th>
                        <th style="text-align: center;">Out Qty</th>
                        <th style="text-align: center;">Reff</th>
                        <th style="text-align: center">Remarks</th>
                        <th style="text-align: center">Expired Date</th>                               
                    </tr>
                </thead>
                <tbody>               
                    <?php 
                    $no = 1;
                    foreach ($model as $model) { 
                        $Date = date('d-m-Y', strtotime($model['expiredDate'])); ?>
                    <tr> 
                        <td style="text-align: center"><?= $no; ?></td>
                        <td style="text-align: center;"><?= $model['productName']; ?></td>
                        <td><?= $model['batchNumber']; ?></td>
                        <td><?= $model['origin']; ?></td>                        
                        <td style="text-align: center;"><?= $model['jumlah']; ?></td>
                        <td style="text-align: center;"><?= $model['outQty'] ?></td>
                        <td style="text-align: center;"><?= $model['refNum'] ?></td>
                        <td><?= $model['notes']; ?></td>
                        <td style="text-align: center"><?= $Date; ?></td>
                    </tr>                     
                    <?php
                    $no = $no+1;
                    } ?>
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




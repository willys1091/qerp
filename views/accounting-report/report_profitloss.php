<?php
use yii\helpers\Html;
use app\models\MsCoa;
use app\models\TrJournaldetail;
use yii\helpers\Json;

date_default_timezone_set('Asia/Jakarta');
?>

<head>
    <style>
        .root{
            width: 58%;
            float: left;
        }
        .amount {
            width: 21%;
            float: left;
            text-align: right;
        }
        
        .tree{
            width: 100%;
        }
        .tree-header{
            width: 100%;
            font-size: 17px;
            font-weight: bold;
        }
        .tree-content{
            padding-left:5%;
            width:95%;
        }
        
        .leaves{
            font-size: 14px;
        }
        .leaves-title{
            width: 57.5%;
            float: left;
        }
        .leaves .amount {
            width: 21%;
        }
        .leaves .total {
            width: 20%;
            margin-left: 2px;
            padding-right: 3px;
            border: 1px solid black;
        }
    </style>
</head>

<body style="font-family: 'Eurostar'">
    <div class="row" style="text-align: center">
    <?= Html::img('assets_b/images/logonew.png',['height' => '80px', 'width' => '70px']) ?> 
    </div>                 
    <div class="row" style="font-size: 22px; color: green; text-align: center">PT Qwinjaya Aditama</div>
    <div class="row" style="text-align: center; font-size: 12px">Importir & Pedagang Besar Bahan Baku Farmasi</div>
    <div class="row" style="text-align: center; font-size: 20px; margin-top: 20px; font-weight: bold">Profit Loss Report</div>
    <div class="row" style="text-align: center; font-size: 15px;">Month : <?= $monthStart ?> / <?= $yearStart ?> - <?= $monthEnd ?> / <?= $yearEnd ?></div>
    <div style="font-size: 11px"><?= date('d M Y') ?></div>

    
    <div class="root">&nbsp;</div>
    <div class="amount"><strong>This Month</strong></div><div class="amount"><strong>Till This Month</strong></div>
    <hr>
    <?php 
    $groups = [];
    foreach($datas AS $data) {
        $groups[$data['rootCoaDescription']][] = $data;
    }
    
    $totalPLThisMonth = 0;
    $totalPLTillThisMonth = 0;
    foreach ($groups AS $coa => $contents) : 
        $totalAmount = 0;
        $totalLastAmount = 0;
        ?>
        <div class="tree">
            <div class="tree-header" style="font-size: 14px">
                <?= $coa ?>
            </div>
            <div class="tree-content">
            <?php foreach ($contents AS $content) : ?>
                <div class="leaves">
                    <div class="leaves-title">
                        <?= $content['description'] ?>
                    </div>
                    <div class="amount"><?= number_format($content['thisMonth'], 0, ',', '.') ?></div>
                    <div class="amount"><?= number_format($content['tillThisMonth'], 0, ',', '.') ?></div>
                </div>
            <?php 
            $totalAmount += $content['thisMonth'];
            $totalLastAmount += $content['tillThisMonth'];
            endforeach; ?>
                <div class="leaves">
                    <div class="leaves-title">
                        &nbsp;
                    </div>
                    <div class="amount total"><?= number_format($totalAmount, 0, ',', '.') ?></div>
                    <div class="amount total"><?= number_format($totalLastAmount, 0, ',', '.') ?></div>
                </div>
            </div>
            <?php $totalPLThisMonth += $totalAmount; $totalPLTillThisMonth += $totalLastAmount; ?>
        </div>
    <?php endforeach; ?>
    <hr>
    <div class="root" style="text-align: right;">LABA/(RUGI) SEBELUM PAJAK &nbsp; : &nbsp; &nbsp;</div>
    <div class="amount"><?= number_format($totalPLThisMonth, 0, ',', '.') ?></div>
    <div class="amount"><?= number_format($totalPLTillThisMonth, 0, ',', '.') ?></div>
    <hr>
</body>
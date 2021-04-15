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
            width: 55%;
            float: left;
        }
        .leaves .amount {
            width: 22%;
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
    $totalPLThisMonth = 0;
    $totalPLTillThisMonth = 0;
    foreach ($tree AS $coaRoot => $roots) : 
        $totalAmount = 0;
        $totalLastAmount = 0;
        ?>
        <div class="tree">
            <div class="tree-header" style="font-size: 14px">
                <?= $coaRoot ?>
            </div>
            <div class="tree-content">
            <?php foreach ($roots AS $coaParent => $parents) : ?>
                <div class="tree">
                    <div class="tree-header" style="font-size: 14px">
                        <?= $coaParent ?>
                    </div>
                    <div class="tree-content">
                        <?php foreach ($parents AS $content) : ?>
                            <div class="leaves">
                                <div class="leaves-title">
                                    <div style="float:left; width: 24%;">
                                        <?= $content['coaNo'] ?>
                                    </div>
                                    <div style="float:left; width: 76%;">
                                        <?= $content['description'] ?>
                                    </div>
                                    
                                </div>
                                <div class="amount"><?= number_format($content['thisMonth'], 0, ',', '.') ?></div>
                                <div class="amount"><?= number_format($content['tillThisMonth'], 0, ',', '.') ?></div>
                            </div>
                        <?php 
                        $totalAmount += $content['thisMonth'];
                        $totalLastAmount += $content['tillThisMonth'];
                        endforeach;?>
                    </div>
                </div>
            <?php endforeach; ?>
                <div class="leaves">
                    <div class="leaves-title" style="padding-left: 2.5%">
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
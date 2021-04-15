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
            width: 60%;
            float: left;
        }
        .amount {
            width: 20%;
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
            width: 55.5%;
            float: left;
        }
        .leaves .amount {
            width: 22%;
        }
        .leaves .total {
            width: 21%;
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
    <div class="row" style="text-align: center; font-size: 20px; margin-top: 20px; font-weight: bold">Balance Sheet Report</div>
    <div class="row" style="text-align: center; font-size: 15px;">Month :  <?= $monthStart ?> / <?= $yearStart ?> - <?= $monthEnd ?> / <?= $yearEnd ?></div>
    <div style="font-size: 11px"><?= date('d M Y') ?></div>

    
    <div class="root">&nbsp;</div>
    <div class="amount">This Month</div><div class="amount">Till This Month</div>
    <hr>
    <div class="tree">
        <div class="tree-header">
            AKTIVA
        </div>
        <div class="tree-content">
        <?php 
        $aktivasGroup = [];
        foreach($aktivas AS $aktiva) {
            $aktivasGroup[$aktiva['parentDescription']][] = $aktiva;
        } 
        $totalAmountAktiva = 0;
        $totalLastAmountAktiva = 0;
        foreach ($aktivasGroup AS $aktiva => $contents) : 
            $totalAmount = 0;
            $totalLastAmount = 0;
            ?>
            <div class="tree">
                <div class="tree-header" style="font-size: 14px">
                    <?= $aktiva ?>
                </div>
                <div class="tree-content">
                <?php foreach ($contents AS $content) : ?>
                    <div class="leaves">
                        <div class="leaves-title">
                            <?= $content['description'] ?>
                        </div>
                        <div class="amount"><?= number_format($content['amount'], 0, ',', '.') ?></div>
                        <div class="amount"><?= number_format($content['lastAmount'], 0, ',', '.') ?></div>
                    </div>
                <?php 
                $totalAmount += $content['amount'];
                $totalLastAmount += $content['lastAmount'];
                endforeach; ?>
                    <div class="leaves">
                        <div class="leaves-title">
                            &nbsp;
                        </div>
                        <div class="amount total"><?= number_format($totalAmount, 0, ',', '.') ?></div>
                        <div class="amount total"><?= number_format($totalLastAmount, 0, ',', '.') ?></div>
                    </div>
                </div>
            </div>
        <?php 
            $totalAmountAktiva += $totalAmount;
            $totalLastAmountAktiva += $totalLastAmount;
            endforeach; ?>
        </div>
    </div>
    <hr>
    <div class="root" style="text-align: right;">TOTAL AKTIVA : &nbsp; &nbsp;</div>
    <div class="amount"><?= number_format($totalAmountAktiva, 0, ',', '.') ?></div>
    <div class="amount"><?= number_format($totalLastAmountAktiva, 0, ',', '.') ?></div>
    <hr>
    
    
    <div class="tree">
        <div class="tree-header">
            PASIVA
        </div>
        <div class="tree-content">
        <?php 
        $pasivasGroup = [];
        foreach($pasivas AS $pasiva) {
            $pasivasGroup[$pasiva['parentDescription']][] = $pasiva;
        } 
        $totalAmountPasiva = 0;
        $totalLastAmountPasiva = 0;
        foreach ($pasivasGroup AS $pasiva => $contents) : 
            $totalAmount = 0;
            $totalLastAmount = 0;
            ?>
            <div class="tree">
                <div class="tree-header" style="font-size: 14px">
                    <?= $pasiva ?>
                </div>
                <div class="tree-content">
                <?php foreach ($contents AS $content) : ?>
                    <div class="leaves">
                        <div class="leaves-title">
                            <?= $content['description'] ?>
                        </div>
                        <div class="amount"><?= number_format($content['amount'], 0, ',', '.') ?></div>
                        <div class="amount"><?= number_format($content['lastAmount'], 0, ',', '.') ?></div>
                    </div>
                <?php 
                $totalAmount += $content['amount'];
                $totalLastAmount += $content['lastAmount'];
                endforeach; ?>
                    <div class="leaves">
                        <div class="leaves-title">
                            &nbsp;
                        </div>
                        <div class="amount total"><?= number_format($totalAmount, 0, ',', '.') ?></div>
                        <div class="amount total"><?= number_format($totalLastAmount, 0, ',', '.') ?></div>
                    </div>
                </div>
            </div>
        <?php 
            $totalAmountPasiva += $totalAmount;
            $totalLastAmountPasiva += $totalLastAmount;
            endforeach; ?>
        </div>
    </div>
    <hr>
    <div class="root" style="text-align: right;">TOTAL PASIVA : &nbsp; &nbsp;</div>
    <div class="amount"><?= number_format($totalAmountPasiva, 0, ',', '.') ?></div>
    <div class="amount"><?= number_format($totalLastAmountPasiva, 0, ',', '.') ?></div>
    <hr>
</body>
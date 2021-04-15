<?php
use yii\helpers\Html;
use app\models\MsCoa;
use app\models\TrJournaldetail;

date_default_timezone_set('Asia/Jakarta');
$balance = 0;
$totalBalance = 0;
$totalPenjualan = 0;
$totalHPP = 0;
$totalBiaya = 0;
$totalBiayaLain = 0;
$totalPendapatanLain = 0;
$totalAyatSilang = 0;
$totalLabaKotor = 0;
$totalPendapatanLain = 0;
$labaSebelumPajak = 0;
$dateYear = date('Y');
$dateMonth = date('m');
$dateDay = date('d');
switch ($dateMonth){
    case 01:
        $monthName = 'Januari';
        break;
    case 02:
        $monthName = 'Februari';
        break;
    case 03:
        $monthName = 'Maret';
        break;
    case 04;
        $monthName = 'April';
        break;
    case 05;
        $monthName = 'Mei';
        break;
    case 06;
        $monthName = 'Juni';
        break;
    case 07;
        $monthName = 'Juli';
        break;
    case 08;
        $monthName = 'Agustus';
        break;
    case 09;
        $monthName = 'September';
        break;
    case 10;
        $monthName = 'Oktober';
        break;
    case 11;
        $monthName = 'November';
        break;
    case 12; 
        $monthName = 'Desember';
        break;
}
?>
<body style="font-family: 'Eurostar'">
    <div class="row" style="text-align: center">
        <?php echo Html::img('assets_b/images/image.jpg',['height' => '80px', 'width' => '70px']) ?> 
    </div>                 
    <div class="row" style="font-size: 22px; color: green; text-align: center">PT Qwinjaya Aditama</div>
    <div class="row" style="text-align: center; font-size: 12px">Importir & Pedagang Besar Bahan Baku Farmasi</div>
    <div class="row" style="text-align: center; font-size: 20px; margin-top: 20px; font-weight: bold">Profit Loss Report</div>

    <?php
    	foreach($modelLevelZero as $modelLevelZero){
    		$modelLevelTwo = MsCoa::find()
                            ->rightJoin('tr_journaldetail', 'SUBSTR(tr_journaldetail.coaNo,1,3) = ms_coa.coaNo')
                            ->where(['=','ms_coa.coaLevel',2])
                            ->andWhere(['=','SUBSTR(ms_coa.coaNo,1,1)',$modelLevelZero->coaNo])
                            ->orderBy('ms_coa.coaNo')
                            ->all();
            $totalBalance = 0;
    ?>
    		<div class="row" style="font-size: 14pt;"><strong><?= $modelLevelZero->description ?></strong></div>
    <?php 
            foreach ($modelLevelTwo as $modelLevelTwo) {
                echo "<div style='float: left; width: 2%;'>&nbsp;</div>";
                echo "<div style='float: left;'>". $modelLevelTwo->description ."</div>";

                $modelLevelThree = MsCoa::find()
                            ->rightJoin('tr_journaldetail', 'SUBSTR(tr_journaldetail.coaNo,1,4) = ms_coa.coaNo')
                            ->where(['=','ms_coa.coaLevel',3])
                            ->andWhere(['=','SUBSTR(ms_coa.coaNo,1,3)',$modelLevelTwo->coaNo])
                            ->orderBy('ms_coa.coaNo')
                            ->all();

                foreach ($modelLevelThree as $modelLevelThree) {
                    echo "<div style='float: left; width: 4%;'>&nbsp;</div>";
                    echo "<div style='float: left;'>". $modelLevelThree->description ."</div>";

		    		$modelDetail = TrJournaldetail::find()
		    						->select(['ms_coa.description','tr_journaldetail.coaNo','drAmount','crAmount'])
		    						->joinWith('coaNos')
		    						->where(['=','SUBSTR(tr_journaldetail.coaNo,1,1)',$modelLevelZero->coaNo])
		    						->all();

					
					foreach($modelDetail as $modelDetail){
						if($modelLevelZero->coaNo == 4 || $modelLevelZero->coaNo == 7){
							$balance = $modelDetail->crAmount - $modelDetail->drAmount;
							if($modelLevelZero->coaNo == 4) $totalPenjualan = $totalPenjualan + $balance;
							if($modelLevelZero->coaNo == 7) $totalPendapatanLain = $totalPendapatanLain + $balance;
						}
						if($modelLevelZero->coaNo == 5 || $modelLevelZero->coaNo == 6 || $modelLevelZero->coaNo == 8){
							$balance = $modelDetail->drAmount - $modelDetail->crAmount;
							if($modelLevelZero->coaNo == 5) $totalHPP = $totalHPP + $balance;
							if($modelLevelZero->coaNo == 6) $totalBiaya = $totalBiaya + $balance;
							if($modelLevelZero->coaNo == 8) $totalBiayaLain = $totalBiayaLain + $balance;
							if($modelLevelZero->coaNo == 9) $totalAyatSilang = $totalAyatSilang + $balance;
						}

						$totalBalance = $totalBalance + $balance;
	?>
						<div class="row">
							<div style="float: left; width: 6%;">&nbsp;</div>
							<div style="float: left; width: 50%;"><?= $modelDetail->coaNos->description ?></div>
							<div style="float: right; width: 20%; text-align: right;" class="text-right"><?= number_format($balance,2,",",".") ?></div>
						</div>
	<?php
					}
				}
			}
    ?>
    		<div class="row">
    			<div style="float: left; width: 50%;"><strong>Total <?= $modelLevelZero->description ?></strong></div>
    			<div style="float: right; width: 20%; text-align: right;"><strong><?= number_format($totalBalance,2,",",".") ?></strong></div>
    		</div>
    <?php
    		

    		if($modelLevelZero->coaNo == 5){
                $totalLabaKotor = $totalPenjualan-$totalHPP
    ?>
    			<div style='margin-top: 10px;'></div>
    			<div class='row'>
    			<div style='float: left; width: 50%;'><strong>Laba Kotor </strong></div>
    			<div style='float: right; width: 20%; text-align: right;'><strong> <?= number_format($totalLabaKotor,2,",",".") ?></strong></div>
    			</div>
    <?php
    		}
    		echo "<div style='margin-top: 10px;'></div>";

    	} // end level zero
        $totalPendapatanLain = $totalBiaya-$totalPendapatanLain+$totalBiayaLain+$totalAyatSilang;
        $labaSebelumPajak = $totalLabaKotor - $totalPendapatanLain;
    ?>
    	<div style='margin-top: 10px;'></div>
		<div class='row'>
		<div style='float: left; width: 50%;'><strong>Total Pendapatan & Biaya Lain</strong></div>
		<div style='float: right; width: 20%; text-align: right;'><strong><?= number_format($totalPendapatanLain,2,",",".") ?></strong></div>
		</div>

        <div style='margin-top: 10px;'></div>
        <div class='row'>
        <div style='float: left; width: 50%;'><strong>Laba Bersih Sebelum Pajak</strong></div>
        <div style='float: right; width: 20%; text-align: right;'><strong><?= number_format($labaSebelumPajak,2,",",".") ?></strong></div>
        </div>
</body>
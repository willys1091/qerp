<?php
use yii\helpers\Html;
use endrikexe\ClientScript;

$this->title = 'Inventory Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-samplereceipthead-create">

    <?= $this->render('_form', [
        'model' => $model,
//        'periode' => $periode,
    ]) ?>

</div>
<style id="hide-yearpicker">
    .datepicker thead tr:first-child th
    {
        visibility: hidden !important;
    }
</style>
<?php ClientScript::singleton()->beginScript('js'); ?>
<script>
$(document).ready(function(){
    var $monthPicker = $("#hide-yearpicker");
    $monthPicker.remove();
    
    $("#inventoryreport-month").on('focus', function(){
        $("head").append($monthPicker);
    });

    $("#inventoryreport-month").on('focusout', function(){
        $monthPicker.remove();
    });

    
    
    var $date = $('#date');
    var $periode = $('#periode');
    var $monthPeriod = $('#monthPeriod');
    var $goodsReceiptNum = $('#goodsReceiptNum');
    var $product = $('#product');
    var $productIDStock = $('#productIDStock');
    var $poNum = $('#poNum');
    var $monthPicker = $('#monthPicker');
    var $productOOT = $('#productOOT');
    
    $date.hide();
    $periode.hide();
    $monthPeriod.hide();
    $goodsReceiptNum.hide();
    $product.hide();
    $poNum.hide();
    $monthPicker.hide();
    $productOOT.hide();
    $productIDStock.hide();
    
    $('#inventoryreport-typereport').change(function(){
        $date.hide();
        $periode.hide();
        $monthPeriod.hide();
        $goodsReceiptNum.hide();
        $product.hide();
        $productIDStock.hide();
        $poNum.hide();
        $monthPicker.hide();
        $productOOT.hide();
        
        var selectedValue = $(this).val();
        
        if (selectedValue == "Kartu Persediaan Barang") {
            $periode.show();
            $productIDStock.show();
        } else if (selectedValue == "Laporan OOT"){      
            $productOOT.show();
            $monthPicker.show();
        } else if (selectedValue == "Kartu Import") {
            $periode.show();
            //$product.show();
            $goodsReceiptNum.show();
            $poNum.show();
        } else if (selectedValue == "Import Realization Report (BPOM)"){
            $monthPeriod.show();
        } else if (selectedValue == "Import Realization Report (MENPERINDAG)"){
            $monthPeriod.show();
        }
    });
});
</script>
<?php ClientScript::singleton()->endScript(); ?>


<?php

use app\components\MdlDb;
use app\models\MsCoa;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widget\Pjax;
use yii\widgets\ActiveForm;

$this->title = 'Master COA';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="form">
    <div class="panel panel-default" id="myForm">
        <div class="panel-heading qwinjaya-header">
        <h3>Master Chart of Account</h3>
        </div>
                
        <div class="tr-samplereceipthead-form">
           
                <div class="box-footer">
                    <div class="form-group text-right">                
                        <?= Html::a( '<i class="glyphicon glyphicon-print"> Print  </i>', ['coa/print'], ['class' => 'btn btn-primary btnPrint']);
                        ?>

                    </div>
                </div>
            
        </div>
        
        <div class="panel-body">
            <div class="panel-group" id="accordion">
                <?php 
                    $connection = MdlDb::getDbConnection();
                    $sql = "SELECT a.coaNo, a.coaLevel, a.description
                            FROM ms_coa a
                            WHERE a.coaLevel = 0
                            ORDER BY a.coaNo ";
                    $model = $connection->createCommand($sql);
                    $result0 = $model->queryAll();
                    $counter0 = 0;
                    foreach ($result0 as $loopResult0) {
                    echo "  <div class='panel panel-default panel-accordion'>
                                <div class='panel-heading qwinjaya-subheader'>
                                    <h4 class='panel-title'>
                                        <a class='pull-right' data-toggle='collapse' href='#". substr($loopResult0['coaNo'],0,1) ."'> 
                                            <i class='more-less glyphicon glyphicon-plus'></i> 
                                        </a>
                                        <a class='subheader-title' data-toggle='collapse' data-parent='accordion' href='#". substr($loopResult0['coaNo'],0,1) ."'>
                                            ". $loopResult0['description'] ."
                                        </a>
                                    </h4>
                                </div>
                                <div id='". substr($loopResult0['coaNo'],0,1) ."' class='panel-collapse collapse'>
                                    <div class='panel-body'>";
                    
                    $connection = MdlDb::getDbConnection();
                    $sql = "SELECT a.coaNo, a.coaLevel, a.description
                            FROM ms_coa a
                            WHERE a.coaLevel = 1 AND a.coaNO like '".substr($loopResult0['coaNo'],0,1)."%'
                            ORDER BY a.coaNo ";
                    $model = $connection->createCommand($sql);
                    $result = $model->queryAll();
                    $counter1 = 0;
                    foreach ($result as $loopResult) {
                        echo "<div class='panel panel-default panel-accordion'>
                                    <div class='panel-heading qwinjaya-subheader'>
                                        <h4 class='panel-title'>
                                            <a class='pull-right' data-toggle='collapse' href='#". substr($loopResult['coaNo'],0,2) ."'> 
                                                <i class='more-less glyphicon glyphicon-plus'></i> 
                                            </a>
                                            <a class='subheader-title' data-toggle='collapse' data-parent='accordion' href='#". substr($loopResult['coaNo'],0,2) ."'>
                                                ". $loopResult['description'] ."
                                            </a>
                                            
                                        </h4>
                                    </div>
                                  <div id='". substr($loopResult['coaNo'],0,2) ."' class='panel-collapse collapse'>
                                        <div class='panel-body'>";
                                            $counter1 = $counter1+1;
                                            $sql = "SELECT a.coaNo, a.coaLevel, a.description
                                            FROM ms_coa a
                                            WHERE a.coaLevel = 2 AND a.coaNo LIKE '". substr($loopResult['coaNo'],0,2) ."%'
                                            ORDER BY a.coaNo ";
                                            $model = $connection->createCommand($sql);
                                            $result2 = $model->queryAll();

                                            $counter2 = 0;
                                            foreach ($result2 as $loopResult2) {
                                                echo "<div class='panel panel-default panel-accordion'>
                                                        <div class='panel-heading qwinjaya-subheader'>
                                                            <h4 class='panel-title'>
                                                                <a class='pull-right' data-toggle='collapse' href='#". substr($loopResult2['coaNo'],0,3) ."'> 
                                                                    <i class='more-less glyphicon glyphicon-plus'></i> 
                                                                </a>
                                                                <a data-toggle='collapse' data-parent='accordion' href='#". substr($loopResult2['coaNo'],0,3) ."'>
                                                                    ". $loopResult2['description'] ."
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id='". str_replace(" ","",substr($loopResult2['coaNo'],0,3)) ."' class='panel-collapse collapse'>
                                                            <div class='panel-body'>";
                                                                $sql = "SELECT a.coaNo, a.coaLevel, a.description
                                                                FROM ms_coa a
                                                                WHERE a.coaLevel = 3 AND a.coaNo LIKE '". substr($loopResult2['coaNo'],0,3) ."%'
                                                                ORDER BY a.coaNo ";

                                                                $model = $connection->createCommand($sql);
                                                                $result3 = $model->queryAll();
                                                                foreach ($result3 as $loopResult3) {
                                                                echo "<div class='panel panel-default'>
                                                                            <div class='panel-heading qwinjaya-subheader'>
                                                                                <h4 class='panel-title'>    
                                                                                    <a class='pull-right' data-toggle='collapse' href='#". str_replace(" ","",substr($loopResult3['coaNo'],0,5)) ."'> 
                                                                                        <i class='more-less glyphicon glyphicon-plus'></i> 
                                                                                    </a>
                                                                                    <a data-toggle='collapse' data-parent='accordion' href='#". str_replace(" ","",substr($loopResult3['coaNo'],0,5)) ."'>
                                                                                        ". $loopResult3['description'] ."
                                                                                    </a>
                                                                                
                                                                                </h4>
                                                                            </div>
                                                                            <div id='". str_replace(" ","",substr($loopResult3['coaNo'],0,4)) ."' class='panel-collapse collapse'>
                                                                                <div class='panel-body'>";
                                                                                
                                                                                
                                                                                $sql = "SELECT max(coaNo) AS no, max(ordinal) AS ordinal, a.coaNo, a.coaLevel, a.description
                                                                                FROM ms_coa a
                                                                                WHERE a.coaLevel = 4 AND a.coaNo LIKE '". substr($loopResult3['coaNo'],0,4) ."%'
                                                                                ORDER BY a.coaNo";

                                                                                $model = $connection->createCommand($sql);
                                                                                $resultMax = $model->queryAll(); 

                                                                                foreach ($resultMax as $loopResultMax) {
                                                                                    $headMax = substr($loopResult3['coaNo'],0,4);
                                                                                    $noMax = $loopResultMax['no'];
                                                                                    $ordinal = $loopResultMax['ordinal'];

                                                                                    if(strlen($noMax) <= 4){
                                                                                        $no = $headMax.".0001";
                                                                                    }
                                                                                    else{
                                                                                        $level4 = substr($noMax,-4);
                                                                                        $level4 = $level4 + 1;
                                                                                        $no = str_pad($level4,4,"0",STR_PAD_LEFT);
                                                                                        $no = $headMax.".".$no;
                                                                                    }

                                                                                    $ordinal = $ordinal + 1;
                                                                                }
                                                                                echo"".Html::button('<span style="font-size: 16px;" class="glyphicon glyphicon-plus" aria-hidden="true" >&nbspAdd</span>', ['value'=>Url::to(['create', 'id' => $no, 'ordinal' => $ordinal ]), 'class'=>'btn btn-md modalButton toolbar-icon', 'title' => 'Add COA Level 4' ])."";
                                                                                echo" </br>";
                                                                                echo" </br>";
                                                                    
                                                                                echo "<table class='tblv4 table-hover ui-sortable'>";
                                                                            
                                                                                $sql = "SELECT a.coaNo, a.coaLevel, a.description
                                                                                FROM ms_coa a                                                      
                                                                                WHERE a.coaLevel = 4 AND a.coaNo LIKE '". substr($loopResult3['coaNo'],0,4) ."%'
                                                                                AND a.flagActive = 1
                                                                                ORDER BY a.ordinal";

                                                                                $model = $connection->createCommand($sql);
                                                                                $result4 = $model->queryAll();
                                                                                foreach ($result4 as $loopResult4) {
                                                                                    $confirm = "";
                                                                                        /*
                                                                                        if ($loopResult4['counter'] <> NULL) {
                                                                                              $confirm = 'data cannot be deleted due to its connection to other application or transaction?';
                                                                                        }else{
                                                                                              $confirm = 'Are you sure you want to delete this Account ?';
                                                                                        }*/
                                                                                        echo 
                                                                                                "<tr class='level4'>
                                                                                                        <td style='padding-left:30px; padding-right:5px;width:95.7%' value= '". $loopResult4['coaNo'] ."'>". $loopResult4['description'].'&nbsp;&nbsp;'.$loopResult4['coaNo']."</td>
                                                                                                        <td>".Html::button('<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>', ['value' => Url::to(['update', 'id' => $loopResult4['coaNo']]), 'class'=>'modalButton','title' => 'Edit', 'style' => 'background-color:white; border:none;' ])."
                                                                                                            ".Html::a('<span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>', ['delete', 'id' => "".$loopResult4['coaNo'].""], ['title' => 'Delete','data' => [
                                                                                                            'confirm' => 'Are you sure you want to delete this Account?',
                                                                                                            'method' => 'post',
                                                                                                        ]])."
                                                                                                        </td>
                                                                                                </tr>";
                                                                                    
                                                                                }

                                                                            echo"</table>
                                                                            </div>
                                                                        </div>
                                                                    </div>";
                                                                }
                                                            
                                                            
                                                        echo"</div>
                                                    </div>
                                                </div>";
                                            }
                                echo"</div>
                              </div>
                        </div>";    
                    }
                    
                    
                    echo "          </div>
                                </div>
                            </div>";
                    }
                ?>
            </div>
        </div>
        <div class="panel-footer">
            <div class="pull-right">
            
            </div>
            <div class="clearfix"></div>           
        </div>
    </div>
</div>


</div>

<?php
    Modal::begin([
        'header' => '',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);

    echo "<div id='modalContent'><div>";
    Modal::end()
?>


<?php
$coaAjaxURL = Yii::$app->request->baseUrl. '/coa/order';

$js = <<< SCRIPT
        
$(document).ready(function () {
    
    function toggleIcon(e) {
        $(e.target)
            .prev('.panel-heading')
            .find(".more-less")
            .toggleClass('glyphicon-plus glyphicon-minus');
    }
    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);
    
    $(".modalButton").click(function(){
        $("#modal").modal('show')
             .find("#modalContent")
             .load($(this).attr('value'));
        });
        $('.main-footer').hide();
        
    $('.tblv4').sortable({
    items: "tr",
        revert: true,
        placeholder: "ui-state-highlight",
        //start: function(event, ui) { $('#loading-div').show(); },
        //stop: function(event, ui) { $('#loading-div').hide(); },
    beforeStop: function(event, ui) {
        
        newIndex = $(ui.helper).index('.level4');
            var counter = 0;
            $(ui.helper).parent().find('tr').each(function() {
                rowVal = $(this).find('td').attr('value');
                if (rowVal != undefined)
                {
                    counter = counter + 1;
                                        //$('#loading-div').show(0).delay(1000).hide(0);
                    setCOAOrder(rowVal,counter); 
                }
            });
        }
    }).disableSelection();
        
        
        
        
    $('.leveld').hide();
    
    $('.level').click(function() {
        console.log(1);
        if ($(this).next().is(":visible"))
        {
                    $(this).next().hide();
        }
        else
        {
                    $(this).next().show();
        }
    }); 
    
        function setCOAOrder(coaNo, ordinal){
        $.ajax({
            url: '$coaAjaxURL',
            async: false,
            type: 'POST',
            data: { coaNo: coaNo, ordinal: ordinal },
                   success: function(data) {
                   console.log(data);
        }
         });
        }
        
        $(document).ajaxStart(function(){
            $('#loading-div').show();
        }).ajaxStop(function(){
            $('#loading-div').hide();
        });
});
SCRIPT;
$this->registerJs($js);
?>

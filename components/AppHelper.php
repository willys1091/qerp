<?php
namespace app\components;

use app\models\MailQueue;
use app\models\MsSetting;
use DateTime;
use kartik\grid\GridView;
use kartik\widgets\DatePicker;
use Yii;
use yii\helpers\Html;
use yii\validators\DateValidator;
use yii\helpers\Url;


class AppHelper
{
    public static $activeStatus = ['1' => 'Active', '0' => 'Not Active'];
    public static $monthRomans = [
        "",
        "I",
        "II",
        "III",
        "IV",
        "V",
        "VI",
        "VII",
        "VIII",
        "IX",
        "X",
        "XI",
        "XII"
    ];
    
    public static $monthsNameId = [
        'None',
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];
    
    public static function getDbConnection ()
    {
        return Yii::$app->db;
    }
    
    public static function getDecimalClientOptionConfig(){
        return [
                'alias' => 'decimal',
                'digits' => 2,
                'digitsOptional' => false,
                'radixPoint' => ',',
                'groupSeparator' => '.',
                'autoGroup' => true,
                'removeMaskOnSubmit' => false
            ];
    }

    public static function getDatePickerConfig($additional = [])
    {
        $config = [
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'pickerButton' => false,
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'autoWidget' => true,
                'autoclose' => true,
                'todayBtn' => true,
                'startDate' => '-150y',
                'todayHighlight' => true,
            ]
        ];

        $config = array_merge($config, $additional);
        return $config;
    }
    
    public static function getMonthYearsPickerConfig($additional = [])
    {
        $config = [
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'pickerButton' => false,
            'pluginOptions' => [
                'startView'=>'year',
                'minViewMode'=>'months',
                'format' => 'mm-yyyy',
                'autoWidget' => true,
                'autoclose' => true,
                'todayBtn' => true,
                'todayHighlight' => true,
            ]
        ];

        $config = array_merge($config, $additional);
        return $config;
    }
    
    public static function getMonthYearPickerConfig($additional = [])
    {
        $config = [
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'pickerButton' => false,
            'pluginOptions' => [
                'startView'=>'year',
                'minViewMode'=>'years',
                'format' => 'yyyy',
                'autoWidget' => true,
                'autoclose' => true,
                'todayBtn' => true,
                'todayHighlight' => true,
            ]
        ];

        $config = array_merge($config, $additional);
        return $config;
    }
    
    public static function getYearPickerConfig($additional = [])
    {
        $config = [
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'pickerButton' => false,
            'pluginOptions' => [
                'startView'=>'year',
                'minViewMode'=>'years',
                'format' => 'yyyy',
                'autoWidget' => true,
                'autoclose' => true,
                'todayBtn' => true,
                'todayHighlight' => true,
            ],
           
            
        ];

        $config = array_merge($config, $additional);
        return $config;
    }
    public static function getMonthPickerConfig($additional = [])
    {
        $config = [
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'pickerButton' => false,
            'pluginOptions' => [
                'format' => 'mm',
                'minViewMode'=> 'months',
                'maxViewMode'=> 'months',
                'startView'=>'months',
                'autoclose' => true,
                'todayBtn' => true,
                'todayHighlight' => true,
            ]
        ];

        $config = array_merge($config, $additional);
        return $config;
    }
    public static function getDateRangePickerConfig($model,$additional = [])
    {
        $config = [
            'model' => $model,
            'attribute' => 'filterDate',
            'convertFormat' => true,
            'pluginOptions' => [
                'locale' => [
                    'format' => 'd-m-Y'
                ],
            ],
        ];

        $config = array_merge($config, $additional);
        return $config;
    }
    
     public static function getDatePickerRangeConfigs($startAttr = 'startDate', $endAttr = 'endDate', $additional = []) {
        $config = [
            'convertFormat' => true,
            'startAttribute' => $startAttr,
            'endAttribute' => $endAttr,
            'pluginOptions' => [
                'autoUpdateInput' => true,
                'locale' => [
                    'format' => 'd-m-Y',
                    'cancelLabel' => 'Clear'
                ],
            ],
             'pluginEvents' => [
                "cancel.daterangepicker" => "function() { $(this).val('').trigger('change'); }",
                "apply.daterangepicker" => "function(ev, picker) { $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY')); }",
            ]
           
        ];

        $config = array_merge($config, $additional);

        return $config;
    }
    

    
    public static function getTwoDecimalConfig($additional = [])
    {
        $config = [
            'alias' => 'decimal',
            'digits' => 2,
            'digitsOptional' => false,
            'radixPoint' => ',',
            'groupSeparator' => '.',
            'autoGroup' => true,
            'removeMaskOnSubmit' => false
        ];

        return $config;
    }
    public static function getFourDecimalConfig($additional = [])
    {
        $config = [
            'alias' => 'decimal',
            'digits' => 4,
            'digitsOptional' => false,
            'radixPoint' => ',',
            'groupSeparator' => '.',
            'autoGroup' => true,
            'removeMaskOnSubmit' => false
        ];

        return $config;
    }

    public static function formatNumberTwoDecimalConfig($data)
    {
        return number_format($data,2,",",".");
    }

    public static function formatNumberFourDecimalConfig($data)
    {
        return number_format($data,4,",",".");
    }

    public static function formatReceiptNumberConfig($data)
    {
        return number_format($data,4,",",".");
    }

    public static function getBrowseConfig($additionalClass, $targetValue, $targetText, $additional = [])
    {
        $class = 'btn btn-primary WindowDialogBrowse ';
        $class .= $additionalClass;

        $config = [
            'data-target-value' => $targetValue,
            'data-target-text' => $targetText,
            'data-target-width' => '1000',
            'data-target-height' => '600',
            'class' => $class,
        ];

        $config = array_merge($config, $additional);
        return $config;
    }

    public static function isValidDate($date, $format)
    {
        $validator = new DateValidator();
        $validator->format = "php:" . $format;
        return $validator->validate($date);
    }

    public static function convertDateTimeFormat($date, $formatFrom = "d-m-Y", $formatTo = "Y-m-d")
    {
        if (!empty($date)) {
            if (self::isValidDate($date, $formatFrom)) {
                $myDateTime = DateTime::createFromFormat($formatFrom, $date);
                return $myDateTime->format($formatTo);
            } else {
                return "";
            }
        } else {
            return "";
        }

    }
    public static function convertDateAndTimeFormat($date, $formatFrom = "d-m-Y H:i", $formatTo = "Y-m-d H:i")
    {
        if (!empty($date)) {
            if (self::isValidDate($date, $formatFrom)) {
                $myDateTime = DateTime::createFromFormat($formatFrom, $date);
                return $myDateTime->format($formatTo);
            } else {
                return "";
            }
        } else {
            return "";
        }

    }

    public static function sendMail($to, $reply_to, $subject, $message){
        $mail = new MailQueue();
        $mail->to = $to;
        $mail->subject = $subject;
        $mail->reply_to = $reply_to;
        $mail->message = $message;
        $mail->save();
    }
    public static function getIsActiveColumn()
    {
        return [
            'attribute' => 'flagActive',
            'value' => function ($data) {
                if ($data->flagActive == 1)
                    return Yii::t('app', 'Active');
                else if ($data->flagActive == 0)
                    return Yii::t('app', 'Inactive');
                else 
                    return Yii::t('app', 'All');
            },
            'filter' => ['' => Yii::t('app', 'All'), '1' => Yii::t('app', 'Active'), '0' => Yii::t('app', 'Inactive')],
            'filterType' => GridView::FILTER_SELECT2,
            'width' => '130px'
        ];
    }
    
    public static function getPaymentActionColumn()
    {
        return [
            
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{delete}{update}{print}',
                'width' => '50',
                'hAlign' => 'center',
                'vAlign' => 'middle',
                'header' => '',
                'buttons' => [
                    'update' => function ($url, $model) {
                        $url = ['update', 'id' => $model->primaryKey];
                        $icon = 'pencil';
                        $label = 'Edit';
                        return Html::a("<span class='glyphicon glyphicon-$icon action-icon'></span>&nbsp;&nbsp;", $url, [
                                'title' => $label,
                                'aria-label' => $label,
                                'data-method' => 'post',
                                'data-pajax' => '0'
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        $url = ['delete', 'id' => $model->primaryKey];
                        $icon = 'trash';
                        $label = 'Delete';
                        $confirm = 'Are you sure you want to delete this data ?';
                        return Html::a("<span class='glyphicon glyphicon-$icon action-icon'></span>&nbsp;&nbsp;", $url, [
                                'title' => $label,
                                'aria-label' => $label,
                                'data-confirm' => $confirm,
                                'data-method' => 'post',
                                'data-pajax' => '0'
                        ]);
                    },
                    'print' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-print action-icon'></span>&nbsp;&nbsp;", ['prints', 'id' => $model->primaryKey], [
                                'title' => 'Print',
                                'class' => 'btnPrint'
                        ]);
                    },
                ]
            
        ];
    }
    public static function getMasterActionColumn()
    {
        return [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{update}'.' '.'{delete}',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'header' => '',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a("<span class='glyphicon glyphicon-eye-open action-icon'></span>&nbsp;&nbsp;",
                        ['view', 'id' => $model->primaryKey],
                        [
                                        'title' => 'View',
                                        'class' => 'open-modal-btn'
                        ]);
                 },
                'delete' => function ($url, $model) {
                    if ($model->flagActive == 0) {
                        $url = ['restore', 'id' => $model->primaryKey];
                        $icon = 'repeat';
                        $label = 'Cancel Delete';
                        $confirm = 'Are you sure you want to activate this data ?';
                    } else {
                        $url = ['delete', 'id' => $model->primaryKey];
                        $icon = 'trash';
                        $label = 'Delete';
                        $confirm = 'Are you sure you want to delete this data ?';
                    }
                    return Html::a("<span class='glyphicon glyphicon-$icon action-icon'></span>&nbsp;&nbsp;", $url, [
                        'title' => $label,
                        'aria-label' => $label,
                        'data-confirm' => $confirm,
                        'data-method' => 'post',
                        'data-pajax' => '0'
                    ]);
                },
                'update' => function ($url, $model) {
                    return Html::a("<span class='glyphicon glyphicon-pencil action-icon'></span>&nbsp;&nbsp;",
                        ['update', 'id' => $model->primaryKey],
                        [
                            'title' => 'Edit',
                            'class' => 'open-modal-btn'
                        ]);
                }
            ]
        ];
    }
    public static function getMasterActionColumnNoActive()
    {
        return [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{update}'.' '.'{delete}',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'header' => '',
            'buttons' => [
                'delete' => function ($url, $model) {
                    $url = ['delete', 'id' => $model->primaryKey];
                    $icon = 'trash';
                    $label = 'Delete';
                    $confirm = 'Are you sure you want to delete this data ?';
                    return Html::a("<span class='glyphicon glyphicon-$icon action-icon'></span>&nbsp;&nbsp;", $url, [
                        'title' => $label,
                        'aria-label' => $label,
                        'data-confirm' => $confirm,
                        'data-method' => 'post',
                        'data-pajax' => '0'
                    ]);
                },
                'update' => function ($url, $model) {
                    return Html::a("<span class='glyphicon glyphicon-pencil action-icon'></span>&nbsp;&nbsp;",
                        ['update', 'id' => $model->primaryKey],
                        [
                            'title' => 'Edit',
                            'class' => 'open-modal-btn'
                        ]);
                }
            ]
        ];
    }
    public static function getActionColumnWithPrint()
    {
        return [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{print}'.' '.'{update}'.' '.'{delete}',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'header' => '',
            'buttons' => [
                'delete' => function ($url, $model) {
                    $url = ['delete', 'id' => $model->primaryKey];
                    $icon = 'trash';
                    $label = 'Delete';
                    $confirm = 'Are you sure you want to delete this data ?';
                    return Html::a("<span class='glyphicon glyphicon-$icon action-icon'></span>&nbsp;&nbsp;", $url, [
                        'title' => $label,
                        'aria-label' => $label,
                        'data-confirm' => $confirm,
                        'data-method' => 'post',
                        'data-pajax' => '0'
                    ]);
                },
                'update' => function ($url, $model) {
                    return Html::a("<span class='glyphicon glyphicon-pencil action-icon'></span>&nbsp;&nbsp;",
                        ['update', 'id' => $model->primaryKey],
                        [
                            'title' => 'Edit',
                            'class' => 'open-modal-btn'
                        ]);
                },
                'print' => function ($url, $model) {
                        return Html::a("<span class='glyphicon glyphicon-print action-icon'></span>&nbsp;&nbsp;",
                        ['print', 'id' => $model->primaryKey],
                        [
                            'title' => 'Print',
                            'class' => 'btnPrint'
                        ]);
                     },
            ]
        ];
    }
    public static function getApproveButton()
    {
        return [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{update}',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'header' => '',
            'buttons' => [
                'update' => function ($url, $model) {
                return Html::a("<span class='glyphicon glyphicon-save action-icon'></span>&nbsp;&nbsp;",
                    ['update', 'id' => $model->primaryKey],
                    [
                        'title' => 'Approve',
                        'class' => 'open-modal-btn'
                    ]);
                }
            ]
        ];
    }
    public static function getActionSales()
    {
        return [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{update}'.' '.'{delete}',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'header' => '',
            'buttons' => [
                'delete' => function ($url, $model) {
                        $url = ['delete', 'id' => $model->primaryKey];
                        $icon = 'trash';
                        $label = 'Delete';
                        $confirm = 'Are you sure you want to delete this data ?';
                    return Html::a("<span class='glyphicon glyphicon-$icon action-icon'></span>&nbsp;&nbsp;", $url, [
                        'title' => $label,
                        'aria-label' => $label,
                        'data-confirm' => $confirm,
                        'data-method' => 'post',
                        'data-pajax' => '0'
                    ]);
                },
                'update' => function ($url, $model) {
                    return Html::a("<span class='glyphicon glyphicon-pencil action-icon'></span>&nbsp;&nbsp;",
                        ['update', 'id' => $model->primaryKey],
                        [
                            'title' => 'Edit',
                            'class' => 'open-modal-btn'
                        ]);
                }
            ]
        ];
    }
    public static function getActionSalesWithoutDelete()
    {
        return [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{update}',
            'hAlign' => 'center',
            'vAlign' => 'middle',
            'header' => '',
            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a("<span class='glyphicon glyphicon-pencil action-icon'></span>&nbsp;&nbsp;",
                        ['update', 'id' => $model->primaryKey],
                        [
                            'title' => 'Edit',
                            'class' => 'open-modal-btn'
                        ]);
                }
            ]
        ];
    }
    public static function getCancelButtonOld(){
        $url = ['cancel'];
        $label = 'Cancel';
        $confirm = 'Unsaved data will be discarded. Are you sure ?';
        return Html::a("<span class='glyphicon glyphicon-remove'> Cancel </span>", $url, [
                'class'=>'btn btn-danger',
                'title' => $label,
                'aria-label' => $label,
                'data-confirm' => $confirm
        ]);
    } 
    public static function getCancelButton(){
        $url = ['index'];
        $label = 'Cancel';
        $confirm = 'Unsaved data will be discarded. Are you sure ?';
        return Html::a("<span class='glyphicon glyphicon-remove'> Cancel </span>", $url, [
                'class'=>'btn btn-danger cancel-button'
        ]);
    } 
    public static function getSetting($key1, $key2 = null) {
        $setting = MsSetting::find()->where(['key1'=>$key1]);
        if ($key2) { $setting->andWhere(['key2'=>$key2]); }
        $setting = $setting->one();
        
        if($setting){
            return $setting->value1;
        }
        else {
            return '';
        }
    }
    
    public static function findArrayByKey($array, $key, $match, &$index)
    {
        $i = 0;
        foreach($array as $object)
        {
            if($object[$key] == $match)
            {
                $index = $i;
                return $object;
            }
            $i++;
        }
        return null;
    }
    public static function dateConvert($date)
    {
        $date1 = str_replace('-', '/', $date);

        return $date1;
    }
   
    public static function generateInvoiceDueNumber()
    {
        $numb = MsSetting::findOne(['key1' => 'InvoiceDueAutoNumber']);
        $numbArr = explode('/', $numb->value1);
        $prefix = $numbArr[0];
        $code = $numbArr[1];
        $year = $numbArr[2];
        $no = $numbArr[3];
        
        $newYear = date('y');
        $newNo = str_pad($year == $newYear ? $no + 1 : 1, 4, '0', STR_PAD_LEFT);
        
        $newNumb = "$prefix/$code/$newYear/$newNo";
        
        $numb->value1 = $newNumb;
        $numb->save();
        
        return $newNumb;
    }
    
    public static function findArrayByProperty($array, $property, $match)
    {
        foreach($array as $object)
        {
            if($object->{$property} == $match)
            {
                return $object;
            }
        }
        return null;
    }
	 public static function getDatePickerRangeConfig($startAttr = 'dateSearchStart', $endAttr = 'dateSearchEnd', $additional = []) {
        $config = [
            'convertFormat' => true,
            'startAttribute' => $startAttr,
            'endAttribute' => $endAttr,
            'pluginOptions' => [
                'autoUpdateInput' => false,
                'locale' => ['format' => 'd-m-Y', 'cancelLabel' => 'Clear'],
            ],
            'pluginEvents' => [
                "cancel.daterangepicker" => "function() { $(this).val('').trigger('change'); }",
                "apply.daterangepicker" => "function(ev, picker) { $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY')); }",
            ]
        ];

        $config = array_merge($config, $additional);

        return $config;
    }
    
    public static function getDatePickersRangeConfig($startAttr = 'startDate', $endAttr = 'endDate', $additional = []) {
        $config = [
            'convertFormat' => true,
            'startAttribute' => $startAttr,
            'endAttribute' => $endAttr,
            'pluginOptions' => [
                'autoUpdateInput' => false,
                'locale' => ['format' => 'd-m-Y', 'cancelLabel' => 'Clear'],
            ],
            'pluginEvents' => [
                "cancel.daterangepicker" => "function() { $(this).val('').trigger('change'); }",
                "apply.daterangepicker" => "function(ev, picker) { $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY')); }",
            ]
        ];

        $config = array_merge($config, $additional);

        return $config;
    }
	
	 public static function getActionColumn($update = true, $delete = true, $withRestore = true) {
        $template = '';
        if($update) {
            $template .= '{update}';
        }
        if($delete) {
            $template .= '{delete}';
        }
        
        return [
            'class' => 'kartik\grid\ActionColumn',
            'width' => '60px',
            'template' => $template,
            'hAlign' => 'center',
            'header' => '',
            'buttons' => [
                'delete' => function ($url, $model) use ($withRestore) {
                    if ($withRestore) {
                        if ($model->flagActive == 0) {
                            $url = ['restore', 'id' => $model->primaryKey];
                            $icon = 'repeat';
                            $label = 'Cancel Delete';
                            $confirm = 'Are you sure you want to restore this data ?';
                        } else {
                            $url = ['delete', 'id' => $model->primaryKey];
                            $icon = 'trash';
                            $label = 'Delete';
                            $confirm = 'Are you sure you want to delete this data ?';
                        }
                    } else {
                        $url = ['delete', 'id' => $model->primaryKey];
                        $icon = 'trash';
                        $label = 'Delete';
                        $confirm = 'Are you sure you want to delete this data ?';
                    }
                    
                    
                    return Html::a("<span class='glyphicon glyphicon-$icon action-icon'></span>&nbsp;&nbsp;", $url, [
                            'title' => $label,
                            'aria-label' => $label,
                            'data-confirm' => $confirm,
                            'data-method' => 'post',
                            'data-pjax' => '0'
                    ]);
                },
                'update' => function ($url, $model) {
                    return Html::a("<span class='glyphicon glyphicon-pencil action-icon'></span>&nbsp;&nbsp;", ['update', 'id' => $model->primaryKey], [
                            'title' => 'Edit',
                            'class' => 'open-modal-btn'
                    ]);
                }
            ]
        ];
    }
    
     public static function getToolbarButtonPopUp($access, $url,$title, $btnColor, $icon, $id = null, $rawUrl = null) {
        if (AccessHelper::hasAccess($access)) {
            return Html::a("<i class='glyphicon glyphicon-$icon with-text'></i>".$title, $url, [
                        'id' => $id,
                        'type' => 'button',
                        'data-pjax' => '0',
                        'data-raw-url' => Url::to([$rawUrl]),
                        'class' => "btn $btnColor open-modal-btn"
                    ]) . ' ';
        } else {
            return "";
        }
    }
	
	public static function showVarDump($var) {
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
        Yii::$app->end();

        return true;
    }
    
    public static function getToolbarButtonPopUps($access, $url,$title, $btnColor, $icon, $id = null, $rawUrl = null) {
      
           return Html::a("<i class='glyphicon glyphicon-$icon with-text'></i>".$title, $url, [
                       'id' => $id,
                       'type' => 'button',
                       'data-pjax' => '0',
                       'data-raw-url' => Url::to([$rawUrl]),
                       'class' => "btn $btnColor open-modal-btn"
                   ]) . ' ';
      
   }
	
}
?>
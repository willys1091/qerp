<?php
namespace app\components;

use app\models\MailQueue;
use kartik\widgets\DatePicker;
use yii\validators\DateValidator;
use yii\helpers\Html;
use Yii;
use kartik\grid\GridView;

class XFormatter
{
    public static $alignCenter = [
        'alignment' => [
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ]
    ];
    
    public static $alignRight = [
        'alignment' => [
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ]
    ];
    
    public static $alignLeft = [
        'alignment' => [
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ]
    ];
    
    public static $companyTitle = [
        'alignment' => [
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ],
        'font' => [
            'size' => 24
        ]
    ];
    
    public static $title = [
        'alignment' => [
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ],
        'font' => [
            'bold' => true,
            'size' => 20
        ]
    ];
    
    public static $parameter = [
        'alignment' => [
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ],
        'font' => [
            'bold' => true,
            'size' => 14
        ]
    ];
    
    public static $tableHeader = [
        'alignment' => [
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ],
        'font' => [
            'bold' => true,
            'size' => 11
        ],
    ];
    
    public static $allBorder = [
        'borders' => [
            'allborders' => [
                'style' => 'thin',
                'color' => [
                    'rgb' => '000000'
                ]
            ]
        ]
    ];
    
    public  static $borderLeftDouble = [
        'borders' => [
            'left' => [
                'style' => 'double',
                'color' => [
                    'rgb' => '000000'
                ]
            ]
        ]
    ];
    
    public  static $borderBottomDouble = [
        'borders' => [
            'bottom' => [
                'style' => 'double',
                'color' => [
                    'rgb' => '000000'
                ]
            ]
        ]
    ];
    
    public static $borderLineDouble = [
        'borders' => [
            'allborders' => [
                'style' => 'double',
                'color' => [
                    'rgb' => '000000'
                ]
            ]
        ]
    ];
    
    public static $borderOutline = [
        'borders' => [
            'outline' => [
                'style' => 'medium',
                'color' => [
                    'rgb' => '000000'
                ]
            ]
        ]
    ];
    
    
}
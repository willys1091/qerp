<?php
namespace app\components;

use app\models\MailQueue;
use kartik\widgets\DatePicker;
use yii\validators\DateValidator;
use yii\helpers\Html;
use Yii;
use kartik\grid\GridView;

class ExcelFormatter
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
    
    public static $companyLogo = [
        'alignment' => [
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_BOTTOM,
        ]
    ];
    
    public static $companyTitle = [
        'alignment' => [
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ],
        'font' => [
            'size' => 28
        ]
    ];
    
    public static $title = [
        'alignment' => [
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ],
        'font' => [
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
            'size' => 12
        ],
        'fill' => [
            'type' => 'solid',
            'color' => [
                'rgb' => '9BBB59'
            ]
        ],
        'borders' => [
            'allborders' => [
                'style' => 'medium',
                'color' => [
                    'rgb' => '000000'
                ]
            ]
        ]
    ];
    
    public static $cell = [
        'borders' => [
            'outline' => [
                'style' => 'medium',
                'color' => [
                    'rgb' => '000000'
                ]
            ]
        ]
    ];
    
    public static $outerBorder = [
        'borders' => [
            'allborders' =>[
                'style' => 'thin',
                'color' => [
                    'rgb' => '000000'
                ]
            ],
            'outline' => [
                'style' => 'medium',
                'color' => [
                    'rgb' => '000000'
                ]
            ]
        ]
    ];
}
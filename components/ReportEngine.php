<?php

namespace app\components;

use app\models\MsProduct;
use app\models\MsUom;
use app\models\MsWarehouse;
use app\models\Report;
use app\models\SampleStockCard;
use kartik\grid\GridView;
use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use yii\db\ActiveQuery;

class ReportEngine {

    public static function getGridView(Model $report, $query, $headers, $title = null, $gridOpts = [], $pageSize = 50) {
        $paginationSetting = $pageSize == 0 ? false : ['pageSize' => $pageSize];

        if (!$title) {
            $title = $report->reportTitle;
        }

        if (!is_array($query)) {
            /* @var $query ActiveQuery */
            $totalCount = $query->count();
            $sql = $query->createCommand()->rawSql;

            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                'sort' => false,
                'totalCount' => $totalCount,
                'pagination' => $paginationSetting
            ]);
        } else {
            $dataProvider = new ArrayDataProvider([
                'allModels' => $query,
                'sort' => false,
                'pagination' => $paginationSetting
            ]);
        }

        $gridColumns = self::getGridColumns($headers);

        $gridConfig = [
            'pjax' => false,
            'dataProvider' => $dataProvider,
            'toolbar' => false,
            'panel' => [
                'heading' => $title
            ],
            'columns' => $gridColumns
        ];

        $mergedConfig = array_merge($gridConfig, $gridOpts);

        return GridView::widget($mergedConfig);
    }

    public static function downloadReport(Model $report, $query, $columnDefinitions, $title = null) {
        if (!$title) {
            $title = $report->reportTitle;
        }

        $fileName = $title . " - " . date("YmdHis");

        $writer = new XLSXWriter();
        
        $writer->setAuthor("Qwinjaya Reporting");
        $writer->setTitle($title);
        $writer->setCompany("Qwinjaya Aditama");
        $writer->setDescription("$title gerenerated from ESB FNB Application");

        $headersType = [];
        $headersLabel = [];
        $columnWidths = [];

        foreach ($columnDefinitions as $column) {
            $headersLabel[] = $column['label'];
            $headersType[] = $column['type'];
//            if (isset($column['width'])) {
//                $columnWidths[] = $column['width'];
//            } else {
//                $columnWidths[0] = '32';
//            }
            $columnWidths[] = '32';
            $columnWidths[] = '32';
            $columnWidths[] = '32';
            $columnWidths[] = '27';
            $columnWidths[] = '10';
            $columnWidths[] = '27';
            $columnWidths[] = '32';
            $columnWidths[] = '20';
            $columnWidths[] = '20';
        }
        
        // Set column type definitions
        $writer->writeSheetHeader('Report', $headersType, [
            'font-style' => 'bold',
            'widths' => $columnWidths,
            'suppress_row' => true
        ]);

        // Write report title
        $writer->writeSheetRowInString('Report', [$title], [
            'font-style' => 'bold',
            'font-size' => 16,
        ]);

        // Write company name
        $writer->writeSheetRowInString('Report', ["Qwinjaya Aditama"], [
            'font-style' => 'bold',
        ]);

        // Write blank space
        $writer->writeSheetRowInString('Report', [], [
            'font-style' => 'bold',
        ]);

        // Show Filtered Data
        foreach ($report->getAttributes(null, ["reportTitle"]) as $attribute => $value) {
            if ((!empty($value) || $value === "0") && $attribute != 'dateTo' && $attribute != 'expectedDate' && $attribute != 'expectedDateTo' && $attribute != 'reportDate') {
                $label = (new Report())->getAttributeLabel($attribute);
                $value = self::getAttributeValue($attribute, $value);
                
                if ($attribute == 'productID') {
                    $label = "Product Name";
                   
                }
                if ($attribute == 'warehouseID') {
                    $label = "Warehouse Name";
                   
                }
                
                $writer->writeSheetRowInString('Report', [$label, $value], [
                    'font-style' => 'bold',
                ]);
            }
        }

        // Write blank space
        $writer->writeSheetRowInString('Report', []);

        // Write header
        $writer->writeSheetRowInString('Report', $headersLabel, [
            'font-style' => 'bold',
            'border' => 'left,top,right,bottom',
            'border-style' => 'dashed',
            'halign' => 'center',
        ]);

        if (is_array($query)) {
            foreach ($query as $data) {
                //order query data based on column definitions
                $intersect = array_intersect_key($data, $columnDefinitions);
                $sortedData = array_replace($columnDefinitions, $intersect);
                $writer->writeSheetRow('Report', $sortedData, [
                    "border" => "left,top,right,bottom",
                    "border-style" => 'dashed',
                ]);
            }
        } else {
            foreach ($query->each() as $data) {
                //order query data based on column definitions
                $intersect = array_intersect_key($data, $columnDefinitions);
                $sortedData = array_replace($columnDefinitions, $intersect);
                $writer->writeSheetRow('Report', $sortedData, [
                    "border" => "left,top,right,bottom",
                    "border-style" => 'dashed',
                ]);
            }
        }
        
        //header("Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="' . $fileName . '.xlsx"');
        
        

        $writer->writeToStdOut();
        ob_end_clean();
        exit;
    }

    private static function getAttributeValue($attribute, $value) {
        switch ($attribute) {
            case "productID":
                $value = MsProduct::findOne($value)->productName;
                
                break;
            case "warehouseID":
                $value = MsWarehouse::findOne($value)->warehouseName;
                break;
            case "uomID":
                $value = MsUom::findOne($value)->uomName;
                break;
            case "productName":
              $value = MsProduct::findOne($value)->productName;
              break;
        }

        return $value;
    }

    private static function getGridColumns($columnDefinitions) {
        $columns = [];
        $columns[] = [
            'class' => 'kartik\grid\SerialColumn',
            'width' => Yii::$app->params['serialColumnWidth'],
        ];
        foreach ($columnDefinitions as $key => $header) {
            $type = $header['type'];
            $label = $header['label'];
            $format = "text";
            $hAlign = "left";
            $headerAlign = "center";
            $columnOptions = isset($header["columnOptions"]) ? $header["columnOptions"] : [];

            if ($type == "date") {
                $format = ['date', 'php:d/m/Y'];
                $hAlign = "center";
                $headerAlign = "center";
            }

            if ($type == "datetime") {
                $format = ['date', 'php:d/m/Y H:i:s'];
                $hAlign = "center";
                $headerAlign = "center";
            }

            if ($type == "price") {
                $format = ['decimal', 2];
                $hAlign = "right";
                $headerAlign = "right";
            }

            if ($type == "integer") {
                $format = ['decimal', 0];
                $hAlign = "right";
                $headerAlign = "right";
            }

            $config = [
                'attribute' => $key,
                'label' => $label,
                'format' => $format,
                'headerOptions' => [
                    'class' => "text-$headerAlign",
                ],
                'contentOptions' => [
                    'class' => "text-$hAlign",
                ],
            ];

            $mergedConfig = array_merge($config, $columnOptions);
            $columns[] = $mergedConfig;
        }
        return $columns;
    }

}

<?php

Yii::$container->set('kartik\grid\GridView', [
    'pjax' => true,
    'pjaxSettings' => [
        'options' => [
            'enablePushState' => false
        ]
    ]
]);

Yii::$container->set('dmstr\web\AdminLteAsset', [
    'js' => []
]);

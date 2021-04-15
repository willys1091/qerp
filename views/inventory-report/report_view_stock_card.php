<?php
use app\models\MsSupplier;
use app\models\MsProduct;
use yii\helpers\Url;
use yii\helpers\Html;

?>
<html>
    <head>
        <style type="text/css">
            table{
                border-collapse: collapse;
                width: 100%;
            }
            td,th{
                border: 1px solid black;
                font-size: 12px;
            }
            .header{
                float: left;
                font-size: 12px;
                text-align: left;
            }
        </style>
    </head>
    <body>
        <div style="padding: 10px; border: 1px solid black;">
            <table style="width:100%;">
                <tr>
                    <td style="height:50px; width: 25%; text-align: center; font-family: arial; font-size: 14px">
                        <?php echo Html::img('assets_b/images/logonew.png',['height' => '50px', 'width' => '50px']) ?>                         
                        <br/>PT.QWINJAYA ADITAMA</td>
                    <td style="font-family: arial; font-size: 24px; width: 50%; text-align: center"></td>
                    <td style="width: 25%; font-size: 10px; padding: 10px;">No : <br/>Date : <br/>Time Receipt : <br/></td>
                </tr>
            </table>
            <p style="text-align: center">Kartu Persediaan Barang</p>
            <div style="float:left"><label style="text-align: left">Nama Barang: $productName</label></div>
            <div style="float:right"><label style="text-align:right">Tahun: $year</label></div>
            <table>
                <thead>
                    <tr>
                        <th>Tgl/Bln</th>
                        <th>No.PO</th>
                        <th>Pemasok</th>
                        <th>NO.Batch</th>
                        <th style="border-right: 2px solid black">Masuk</th>
                        <th style="border-left: 2px solid black"></th>
                        <th>Tgl/Bln</th>
                        <th>No.DO</th>
                        <th>Pelanggan</th>
                        <th>No.Batch</th>
                        <th style="border-right: 2px solid black">Keluar</th>
                        <th style="border-left: 2px solid black"></th>
                        <th>Sisa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>11</td>
                        <td>12</td>
                        <td>13</td>
                        <td>14</td>
                        <td style="border-right: 2px solid black">15</td>
                        <td style="border-left: 2px solid black"></td>
                        <td>16</td>
                        <td>17</td>
                        <td>18</td>
                        <td>19</td>
                        <td style="border-right: 2px solid black">20</td>
                        <td style="border-left: 2px solid black"></td>
                        <td>21</td>
                    </tr>
                </tbody>
            </table>
            <br/>
            <br/>
            <br/>
            <label>Notes:</label>
            <p></p>
        </div>        
    </body>
</html>





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
            <p style="text-align: center">Import Realization Report PT. Qwinjaya Aditama  2016</p>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No.PO</th>
                        <th>No.AJU</th>
                        <th>No.PIB</th>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Origin</th>
                        <th>Supplier</th>
                        <th>Unit Price In</th>
                        <th>Total Invoice In</th>
                        <th>Import Duty</th>
                        <th>Import Tax</th>
                        <th>Clearance Tax</th>
                        <th>Faktur Pajak</th>
                        <th>Clearance Cost</th>
                        <th>Total Import Cost(Rp)</th>
                        <th>Tax Rate</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>11</td>
                        <td>12</td>
                        <td>13</td>
                        <td>14</td>
                        <td>15</td>
                        <td>16</td>
                        <td>17</td>
                        <td>18</td>
                        <td>19</td>
                        <td>20</td>
                        <td>21</td>
                        <td>22</td>
                        <td>23</td>
                        <td>24</td>
                        <td>25</td>
                        <td>26</td>
                        <td>27</td>
                        <td>28</td>
                        <td>29</td>
                    </tr>
                </tbody>
            </table>
            <br/>
            <br/>
        </div>        
    </body>
</html>





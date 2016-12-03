<?php
use backend\modules\org\GoJsAsset;

GoJsAsset::register($this);
\yii\web\JqueryAsset::register($this);
?>

    <div id="myDiagramDiv" style="background-color: #696969; border: solid 1px black; height: 500px"></div>


<div id="sample" style="display:none;">

    <div>
        <div id="myInspector"></div>
        <hr>
    </div>
    <div>
        <div>
            <button id="SaveButton" onclick="save()">Save</button>
            <button onclick="load()">Load</button>
            Diagram Model saved in JSON format:
        </div>
        <textarea id="mySavedModel" style="width:100%;height:250px"><?=$charts?></textarea>
    </div>
</div>
<?php
echo'<pre>';
print_r(json_decode($charts));
echo'<pre>';




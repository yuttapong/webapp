<?php
/* @var $this yii\web\View */

$this->title = 'Team';
\yii\web\JqueryAsset::register($this);
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use yii\bootstrap\Html;
use \yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'id' => 'form-assign',
    'enableAjaxValidation' => true,
]);
?>


<?php $this->beginBlock('sidebar') ?>
<?php $this->endBlock() ?>
<div class="row">
    <div class="col-md-6">
        <?php
        echo Typeahead::widget([
            'name' => 'searchUser',
            'options' => ['placeholder' => 'พิมชื่อพนักงาน ...', 'id' => 'search-user'],
            'pluginOptions' => ['highlight' => true],
            'pluginEvents' => [
                'typeahead:select' => 'function(index, item) { 
                $(this).typeahead(\'val\',\'\');
                var pushUser = function(item) {
                    var input = "<input type=\"hidden\" name=\"users[]\" value=\""+item.id+"\"> ";
                    var html = "<li class=\"text-info\"><p>"+input+"<button  type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"if(confirm(\'ต้องการลบ:: ใช่หรือไม่ ? \' )){$(this).parent().parent().remove()}\"><i class=\"fa fa-trash\"></i></button> "+item.name+"</p></li>";
                    return html;
                }
                $("#selected-user").append(pushUser(item));
               }',
            ],
            'dataset' => [
                [
                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                    'display' => 'name',
                    'remote' => [
                        'url' => Url::to(['setting/find-customer']) . '?q=%QUERY',
                        'wildcard' => '%QUERY'
                    ]
                ]
            ]
        ]);
        ?>
        <p>
        <ul id="selected-user" class="list-unstyled">
            <?php
            if ($userItems) {
                foreach ($userItems as $u) {
                    $userId = Html::hiddenInput('users[]', $u->user_id);
                    echo Html::tag('li', '<p>' . $userId . Html::button('<i class="fa fa-trash"></i> ', ['class' => 'btn btn-danger btn-xs btn-removeassign']) . ' ' . $u->name . '</p>', [
                        'class' => ''
                    ]);
                }
            }
            ?>
        </ul>
        <button type="button" id="btn-assignteam" class="btn btn-success">Save</button>
        </p>
    </div>
    <div class="col-md-6"></div>
</div>
<a data-pin-do="embedBoard" data-pin-board-width="400" data-pin-scale-height="240" data-pin-scale-width="80"
   href="https://www.pinterest.com/pinterest/official-news/"></a>


<?php
ActiveForm::end();


?>


<?php
$js = <<<JS
function notifyBrowser(title,desc,url) {
    if (Notification.permission !== "granted")
    {
        Notification.requestPermission();
    }
    else
    {
        var notification = new Notification(title, {
        icon:'http://localhost/webapp/backend/web/upload/personnel/1/thumbnail/NhmEtzuqFU1S-VJVB2QsvhJcTdR8IEZt.jpg',
        body: desc,
        });
        
        notification.onclick = function () {
             window.open(url); 
        };
        
        notification.onclose = function () {
            console.log('Notification closed');
        };
    
    }
   }
  $("#notificationButton").click(function(){
            var x = Math.floor((Math.random() * 10) + 1); /* Random number between 1 to 10 */
            var title = 'มีรายการอนุมัติใหม่รอคุณอยู่';
            var desc ='PO หมายเลขที่ PO584788';
            var url = 'http://app.siricenter.com';
            notifyBrowser(title,desc,url);
            return false;
  });
  
 $("#btn-assignteam").on('click',function(e) {
     var form = $("#form-assign");
     var data = form.serialize();
     $("#assign-result").remove();
      $(this).after('<span id="assign-result"><i class="fa fa-refresh fa-spin fa-2x"></i></span>');
     $.ajax({
       type:'POST',
       url: 'save-assign-team',
       data: data,
       dataType:'json',
       success:function(rs) {
          $("#assign-result").html(rs);
          if(rs.result===1) {
            $("#assign-result").html(rs.message).addClass('text-success').fadeOut(3000);
            loadUser(rs.rows);
          }else{
            $("#assign-result").html(rs.message).addClass('text-danger');
          }
       }
     });
 })
 
 $(".btn-removeassign").on('click', function(e) {
     if(confirm('ต้องการลบ:: ใช่หรือไม่ ? ' )){
     $(this).parent().parent().remove()
     }
 })

function loadUser(items) {
  var rs = '';
  $.each(items,function(index,item) {
     rs += '<li class="text-success"><p>';
     rs += '<button type="button" class="btn btn-danger btn-xs" onclick="$(this).parent().parent().remove();"><i class="fa fa-trash"></i></button> '
     rs +='<input type="hidden" name="users[]" value="'+item.user_id+'"> ' + item.name;
     rs +='</p></li>';
  })
   $("#selected-user").html(rs);
}

function refreshUser() {
   $.ajax({
      
   })
}

JS;
$this->registerJs($js);
?>
<input type="button" id="notificationButton" value="แจ้งเตือน"/>


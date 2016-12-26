<?php
/* @var $this yii\web\View */

$this->title = 'Promotion';
?>
	<div class="row">
		
        
        <div class="col-md-12">


        <div class="table-responsive">
            <table id="table-promotion" class="table table-bordred table-striped">
                <thead>
                <th>Banner</th>
                <th>Title</th>
                <th>Price</th>
                <th>Action</th>
                </thead>
                <tbody>

                <tr>
                    <td><img src="https://placeimg.com/350/100/any3" class="img img-thumbnail"></td>
                    <td>แอร์ Sumsung 22,000 BTU จำนวน 1 ตัว</td>
                    <td>22,900฿</td>
                    <td><p data-placement="top" data-toggle="tooltip" title="รายละเอียด"><button class="btn btn-default btn-xs" data-title="รายละเอียด" data-toggle="modal" data-target="#view" ><span class="glyphicon glyphicon-search"></span></button></p></td>
                </tr>

                <tr>
                    <td><img src="https://placeimg.com/350/100/any2" class="img img-thumbnail"></td>
                    <td>เงินคืน จอง+สัญญา</td>
                    <td>50,000฿</td>
                    <td><p data-placement="top" data-toggle="tooltip" title="รายละเอียด"><button class="btn btn-default btn-xs" data-title="รายละเอียด" data-toggle="modal" data-target="#view" ><span class="glyphicon glyphicon-search"></span></button></p></td>
                </tr>


                <tr>
                    <td><img src="https://placeimg.com/350/100/any1" class="img img-thumbnail"></td>
                    <td>ชุดครัว Built-In</td>
                    <td>300,000฿</td>
                    <td><p data-placement="top" data-toggle="tooltip" title="รายละเอียด"><button class="btn btn-default btn-xs" data-title="รายละเอียด" data-toggle="modal" data-target="#view" ><span class="glyphicon glyphicon-search"></span></button></p></td>
                </tr>
                </tbody>
            </table>



<div class="clearfix"></div>


            <ul class="pagination">
                <li class="disabled"><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
            </ul>

                
            </div>
            
        </div>
	</div>



<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Edit Your Detail</h4>
      </div>
          <div class="modal-body">
          <div class="form-group">
        <input class="form-control " type="text" placeholder="Mohsin">
        </div>
        <div class="form-group">
        
        <input class="form-control " type="text" placeholder="Irshad">
        </div>
        <div class="form-group">
        <textarea rows="2" class="form-control" placeholder="CB 106/107 Street # 11 Wah Cantt Islamabad Pakistan"></textarea>
    
        
        </div>
      </div>
          <div class="modal-footer ">
        <button type="button" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
      </div>
        </div>
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
    </div>
    
    
    
    <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">รายละเอียด:: โปรโมชั่น</h4>
      </div>
          <div class="modal-body">
              <img src="https://placeimg.com/500/250/any2" class="img img-thumbnail img-responsive">
              <p>แอร์ Sumsung 22,000 BTU จำนวน 1 ตัว</p>
       
      </div>
        <div class="modal-footer hidden ">
        <button type="button" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
      </div>
        </div>
    <!-- /.modal-content --> 
  </div>
      <!--

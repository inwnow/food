<div class="row">
    <div class="col s12 blue lighten-4">
	 <span class="flow-text" style="text-align:center"> กรุณาลงทะเบียนก่อนเข้าใช้งาน</span>
    </div>
</div>




	<div class="row">
    
    <form class="col s12"  method="post" action="chklogin.php">
	 <div class="col s8 offset-s4">
      <div class="row">
        <div class="input-field col s3">
          <input id="user" name="usr" type="text" required class="validate">
          <label for="user">ชื่อผู้ใช้</label>
        </div>
	    </div>
        
      <div class="row">
        <div class="input-field col s3">
          <input id="password" name="pwd" required type="password" class="validate">
          <label for="password">รหัสผ่าน</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s3">

          <select name="ward_id" required class="form-control" style="width:100%">
          <option value=""></option>
          <?php $obj->connMS(); 
          $sqlward=$obj->msFetch("select * from Ward order by ward_name asc");
          while($rowward=sqlsrv_fetch_object($sqlward)){?><option value="<?=$rowward->ward_id?>" <? if($rowward->ward_id==$show->ward_id){echo 'selected';}?>>
          <?php echo $rowward->ward_name;?>
          <?}?> 
          </select>

        </div>
      </div>
 </div>
      <div class="row">
			<div class="col s8 offset-s4">
            <div class="input-field col">
        <input type="submit" class="waves-effect blue darken-1 btn" value="เข้าระบบ">
        </div>
          </div>
		  </div>
        </form>
		
      </div>


	 
    <script>
    $(document).ready(function() {
    $('select').select2({placeholder:"กรุณาเลือกหอผู้ป่วย"});
    });
</script>
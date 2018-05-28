<div class="row">
    <div class="col s12 blue lighten-4">
	 <span class="flow-text"> กรุณาลงทะเบียนก่อนเข้าใช้งาน</span>
    </div>
</div>
	  

	<div class="row">
  
    <form class="col s12"  method="post" action="chkflogin.php">
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
      </div>
      <div class="row">
          <div class="col s8 offset-s4">
            <div class="input-field">
            <input type="submit" class="waves-effect blue darken-1 btn" value="เข้าระบบ"> <input type="button" class="waves-effect grey lighten-2 grey-text text-darken-3 btn" value="ยกเลิก" onclick="history.back()">
            </div>
          </div>
          </div>
          
        </form>
      


	  </div>
    </div>
    <script>
    $(document).ready(function() {
    $('select').select2({placeholder:"กรุณาเลือกหอผู้ป่วย"});
    });
</script>
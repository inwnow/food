<div class="container">
 <nav>
    <div class="nav-wrapper">
      <div class="col s12">
        <a href="#!" class="flow-text">&nbsp;รายงานสรุปยอดอาหาร</a>
      </div>
    </div>
  </nav>

<div class="section">

</div>


    <div class="row">
      <div class="col s6 offset-s3">
      <form method=post action="index.php?files=viewreport" name="frm1" target="_blank" class="form-inline">
        <div class="input-field col s6">
            <input placeholder="Placeholder" id="first_name" name="fdate" type="text" value="<? if(!empty($fdate)){echo $fdate;}else{echo date("Y-m-d");}?>" class="datepicker">
            <label for="first_name">กรุณาเลือกวันที่</label>
        </div>

        <div>
        <input type="submit" name="viewreport" value="ดูข้อมูล" class="btn btn-success">
        </div>
        </form>     
      </div>
    </div>

	
</div>
<script>
$('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15, // Creates a dropdown of 15 years to control year,
    today: 'Today',
    clear: 'Clear',
    close: 'Ok',
    closeOnSelect: false // Close upon selecting a date,
  });
</script>
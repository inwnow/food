<div class="container">
<nav>
   <div class="nav-wrapper">
     <div class="col s12">
       <a href="#!" class="flow-text">&nbsp;พิมพ์สติกเกอร์</a>
     </div>
   </div>
 </nav>
 </div>
<div class="row">
    <div class="col s8 offset-s4">
    <form method="post" action="viewcard.php">
        <div class="row">
            <div class="input-field col">

            <select name="wid" required class="form-control" style="width:300px">
            <option value=""></option>
            <?php $obj->connMS(); 
            $sqlward=$obj->msFetch("select * from Ward order by ward_name asc");
            while($rowward=sqlsrv_fetch_object($sqlward)){?><option value="<?=$rowward->ward_id?>" <? if($rowward->ward_id==$show->ward_id){echo 'selected';}?>>
            <?php echo $rowward->ward_name;?>
            <?}?> 
            </select>

            </div>
        </div>

        <div class="row">
            <div class="input-field col">
                <input type="submit" class="waves-effect blue darken-1 btn" value="ดูรายงาน">
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
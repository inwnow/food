<?php session_start();
require_once("function.php");
$obj=new ConnDB();
$obj->connMS();
$row = $obj->msAll("select i.hn,i.regist_flag,i.ladmit_n,CAST(RTRIM(t.titleName) + RTRIM(p.firstName) + '  ' + RTRIM(p.lastName) AS CHAR(50)) AS Name,w.ward_id,w.ward_name,dbo.ymd2cbe(i.admit_date) as date,dbo.nowage(p.birthDay,dbo.ce2ymd(getdate()))as age from Ipd_h i left join PATIENT p on (p.hn=i.hn) left join Ward w on(w.ward_id = i.ward_id) LEFT JOIN PTITLE t ON (p.titleCode = t.titleCode) where i.hn = '$hn' and i.regist_flag='$vn'  and i.discharge_status='0'");//เลือกข้อมูล
$obj->construct();
$show=$obj->getQuery("foods"," where hn='$hn' and vn='$vn' and ward_id='$wid' and dc='0'");
?>

<div class="row">
        <div class="col s12">
        <span id="savethis"></span>
          <div class="card">
          <div class="card-title blue-text text-darken-2"><br>&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?files=foodorder"><i class="material-icons">arrow_back</i></a> HN <?php echo $row->hn;?>-<?php echo $row->regist_flag;?> ชื่อ <?php echo $row->Name;?> อายุ <?php echo $row->age;?> <br/></div>
            <div class="card-content">
              <p>
                <div class="input-field col s2">
                <input  id="bed" name="bed" type="text" value="<?php echo $show->bed;?>" onchange="savebed('<?php echo $hn;?>','<?php echo $vn;?>','bed',this.value)" class="validate">
                <label for="bed" class="red-text text-accent-2">เตียง</label>
                </div>

                <div class="input-field col s2">
                <input  id="wght" name="wght" type="text" value="<?php echo $show->wght;?>" onchange="savefood('<?php echo $hn;?>','<?php echo $vn;?>','wght',this.value)" class="validate">
                <label for="wght" class="red-text text-accent-2">น้ำหนัก</label>
                </div>

                <div class="input-field col s8">
                <input  id="diag" name="diag" type="text" value="<?php echo $show->diag;?>" onchange="savebed('<?php echo $hn;?>','<?php echo $vn;?>','diag',this.value)" class="validate">
                <label for="diag" class="red-text text-accent-2">การวินิจฉัย</label>
                </div>

              <div class="row">
                <div class="col s12">
                    <div class="card-title blue-text text-darken-2">ชนิดอาหาร</div>
                    <div class="card-panel">
                    <span class="white-text">


                <div class="row">
                <? $obj->construct(); $sqlkind=$obj->getFetch("select * from kind where id between '1' and '9' order by name asc");
                while($rowkind=$sqlkind->fetch_object()){?>      
                <div class="col s4">  
                <input type="radio" name="kind_id" id="kind<?=$rowkind->id;?>" value="<?=$rowkind->id;?>" <? if($rowkind->id==$show->kind){echo 'checked';}?> onclick="savefood('<?php echo $hn;?>','<?php echo $vn;?>','kind',this.value);">
                <label for="kind<?=$rowkind->id;?>" class="red-text text-accent-2"><?=$rowkind->name;?></label>
                </div>
                <?}?>    
                </div>

                </span>
                    </div>
                </div>
                </div>


                <div class="row">
                <div class="col s12">
                    <div class="card-title blue-text text-darken-2">อาหาร BD</div>
                    <div class="card-panel">
                    <span class="white-text">

                    <div class="row">
                    <div class="col s2 blue-text text-darken-2">
                    อาหารเหลว
                    <div class="row">
                    <div class="col s6 blue-text text-darken-2 input-field">
                    <input id="first_name" type="text" value="<?php if($show->category=="1"){echo $show->foodsize1;}?>" placeholder="จำนวน" onchange="savebd('<?php echo $hn;?>','<?php echo $vn;?>','10','1','foodsize1',this.value)" class="validate">
                    <label for="first_name" class="red-text text-accent-2">เหลวใส</label>
                    </div>	
                    <div class="col s6 blue-text text-darken-2 input-field">
                    <input id="first_name" type="text" value="<?php if($show->category=="2"){echo $show->foodsize1;}?>" placeholder="จำนวน"onchange="savebd('<?php echo $hn;?>','<?php echo $vn;?>','10','2','foodsize1',this.value)" class="validate">
                    <label for="first_name" class="red-text text-accent-2">นมกล่อง</label>
                    </div>
                    </div>
                    </div>
					</div>

					<div class="row">
                    <div class="col s5 blue-text text-darken-2">
                    อาหารทางสายยาง 
                    <div class="row">
                    <div class="col s2 blue-text text-darken-2 input-field">
                    <input id="first_name" type="text" value="<?php if($show->category=="3"){echo $show->foodsize1;}?>" placeholder="ซีซี" onchange="savebd('<?php echo $hn;?>','<?php echo $vn;?>','11','3','foodsize1',this.value)" class="validate">
                    <label for="first_name" class="red-text text-accent-2">BD 1:1</label> 
                    </div>	
					<div class="col s2 blue-text text-darken-2 input-field">
                    <input id="first_name" type="text" value="<?php if($show->category=="7"){echo $show->foodsize1;}?>" placeholder="ซีซี" onchange="savebd('<?php echo $hn;?>','<?php echo $vn;?>','11','7','foodsize1',this.value)" class="validate">
                    <label for="first_name" class="red-text text-accent-2">BD 1.2:1</label>
                    </div>
                    <div class="col s2 blue-text text-darken-2 input-field">
                    <input id="first_name" type="text" value="<?php if($show->category=="4"){echo $show->foodsize1;}?>" placeholder="ซีซี" onchange="savebd('<?php echo $hn;?>','<?php echo $vn;?>','11','4','foodsize1',this.value)" class="validate">
                    <label for="first_name" class="red-text text-accent-2">BD 1.5:1</label>
                    </div>
                    <div class="col s2 blue-text text-darken-2 input-field">
                    <input id="first_name" type="text" value="<?php if($show->category=="5"){echo $show->foodsize1;}?>" placeholder="ซีซี" onchange="savebd('<?php echo $hn;?>','<?php echo $vn;?>','11','5','foodsize1',this.value)" class="validate">
                    <label for="first_name" class="red-text text-accent-2">BD 2:1</label>
                    </div>	
                    <!-- <div class="col s2 blue-text text-darken-2 input-field">
                    <input id="first_name" type="text" value="<?php if($show->category=="6"){echo $show->foodsize1;}?>" placeholder="ซีซี" onchange="savebd('<?php echo $hn;?>','<?php echo $vn;?>','11','6','foodsize1',this.value)" class="validate">
                    <label for="first_name" class="red-text text-accent-2">BD 1:1 DM</label>                    
                    </div> -->
                    </div>
                    </div>


					<div class="col s3 blue-text text-darken-2">จำนวน
                    <div class="row">
					<div class="col s4 blue-text text-darken-2 input-field">
                    <input id="first_name" type="text" value="<?php if($show->category){echo $show->foodsize2;}?>" placeholder="จำนวน" onchange="savefeed('<?php echo $hn;?>','<?php echo $vn;?>','foodsize2',this.value)" class="validate">
                    <label for="first_name" class="red-text text-accent-2">Feed </label>
                    </div>
					</div>
                    </div>


					<div class="col s4 blue-text text-darken-2">โรค<br /><br />
                    <div class="row">
					<p class="col s6 blue-text text-darken-2">
                   <input type="checkbox" id="dm" name="dm" value="1" <? if($show->dm=="1"){echo 'checked';}?>  onclick="savedisease('<?php echo $hn;?>','<?php echo $vn;?>','dm',this.value)" />
					<label for="dm" class="red-text text-accent-2">เบาหวาน</label>
                    </p>
					<p class="col s4 blue-text text-darken-2">
                   <input type="checkbox" id="ckd" name="ckd" value="1" <? if($show->ckd=="1"){echo 'checked';}?> onclick="savedisease('<?php echo $hn;?>','<?php echo $vn;?>','ckd',this.value)" />
					<label for="ckd" class="red-text text-accent-2">ไต</label>
                    </p>
					</div>
                    </div>


					</div>

					<div class="row">
					
					</div>


					<div class="row">
                    <div class="col s12 blue-text text-darken-2">นมผสมสำหรับเด็ก
                    <div class="row">

                    <div class="col s1 blue-text text-darken-2 input-field">
                    <input id="first_name" type="text" value="<?php if($show->category=="8"){echo $show->foodsize1;}?>" placeholder="ซีซี" onchange="savebd('<?php echo $hn;?>','<?php echo $vn;?>','11','8','foodsize1',this.value)" class="validate">
                    <label for="first_name" class="red-text text-accent-2">20 Kcal</label>
                    </div>
                    <div class="col s1 blue-text text-darken-2 input-field">
                    <input id="first_name" type="text" value="<?php if($show->category=="8"){echo $show->foodsize2;}?>" placeholder="ขวด" onchange="savebd('<?php echo $hn;?>','<?php echo $vn;?>','11','8','foodsize2',this.value)" class="validate">
                    <label for="first_name" class="red-text text-accent-2">จำนวน</label>
                    </div>	
					
                    <div class="col s1 blue-text text-darken-2 input-field">
                    <input id="first_name" type="text" value="<?php if($show->category=="9"){echo $show->foodsize1;}?>" placeholder="ซีซี" onchange="savebd('<?php echo $hn;?>','<?php echo $vn;?>','12','9','foodsize1',this.value)" class="validate">
                    <label for="first_name" class="red-text text-accent-2">24 Kcal</label>
                    </div>
                    <div class="col s1 blue-text text-darken-2 input-field">
                    <input id="first_name" type="text"value="<?php if($show->category=="9"){echo $show->foodsize2;}?>" placeholder="ขวด" onchange="savebd('<?php echo $hn;?>','<?php echo $vn;?>','12','9','foodsize2',this.value)" class="validate">
                    <label for="first_name" class="red-text text-accent-2">จำนวน</label>
                    </div>

					<div class="col s1 blue-text text-darken-2 input-field">
                    <input id="first_name" type="text" value="<?php if($show->category=="10"){echo $show->foodsize1;}?>" placeholder="ซีซี" onchange="savebd('<?php echo $hn;?>','<?php echo $vn;?>','12','10','foodsize1',this.value)" class="validate">
                    <label for="first_name" class="red-text text-accent-2">27 Kcal</label>
                    </div>
                    <div class="col s1 blue-text text-darken-2 input-field">
                    <input id="first_name" type="text"value="<?php if($show->category=="10"){echo $show->foodsize2;}?>" placeholder="ขวด" onchange="savebd('<?php echo $hn;?>','<?php echo $vn;?>','12','10','foodsize2',this.value)" class="validate">
                    <label for="first_name" class="red-text text-accent-2">จำนวน</label>
                    </div>

					<div class="col s1 blue-text text-darken-2 input-field">
                    <input id="first_name" type="text" value="<?php if($show->category=="11"){echo $show->foodsize1;}?>" placeholder="ซีซี" onchange="savebd('<?php echo $hn;?>','<?php echo $vn;?>','12','11','foodsize1',this.value)" class="validate">
                    <label for="first_name" class="red-text text-accent-2">30 Kcal</label>
                    </div>
                    <div class="col s1 blue-text text-darken-2 input-field">
                    <input id="first_name" type="text"value="<?php if($show->category=="11"){echo $show->foodsize2;}?>" placeholder="ขวด" onchange="savebd('<?php echo $hn;?>','<?php echo $vn;?>','12','11','foodsize2',this.value)" class="validate">
                    <label for="first_name" class="red-text text-accent-2">จำนวน</label>
                    </div>

					



                    </div>
                    </div>
                    </div>


                    </span>
                    </div>
                </div>
                </div>




                <div class="row">
                <div class="col s12">
                    <div class="card-title blue-text text-darken-2">อาหารเพิ่มเติม</div>
                    <div class="card-panel">
                    <span class="white-text">
                    
                    <div class="row">
                    <? $sqlspecial=$obj->getFetch("select * from special order by id asc");
                    while($rowspecial=$sqlspecial->fetch_object()){
                    $specials=$obj->getQuery("specialfoods"," where hn='$hn' and vn='$vn' and ward_id='$wid' and special='$rowspecial->id'");
                        ?>        
                    <div class="col s4"><input type="checkbox" onclick="savespecial('<?php echo $hn;?>','<?php echo $vn;?>','special',this.value)" name="special" id="special<?=$rowspecial->id;?>" value="<?=$rowspecial->id;?>" <? if($rowspecial->id==$specials->special){echo 'checked';}?>>
                    <label for="special<?=$rowspecial->id;?>" class="red-text text-accent-2"><?=$rowspecial->name;?></label></div>
                    <?}?>
                    </div>   
                    
                    </span>
                    </div>
                </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                    <textarea id="textarea1" onchange="savebed('<?php echo $hn;?>','<?php echo $vn;?>','note',this.value)" class="materialize-textarea"><?php echo $show->note;?></textarea>
                    <label for="textarea1" class="red-text text-accent-2">หมายเหตุ</label>
                    </div>
                </div>
                 

              </p>
            </div>
            <div class="card-action center-align">
              <a class="waves-effect waves-light btn" href="index.php?files=foodorder">บันทึก</a>
            </div>
          </div>
        </div>
</div>

<script>
    $(document).ready(function() {
    $('select').select2({placeholder:"กรุณาเลือกหอผู้ป่วย"});
    });
</script>

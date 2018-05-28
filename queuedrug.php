<?php if(empty($queueNo)){?>
			<form method="post" action="" name="search">
			<div class="ui equal width grid">
			<div class="column">
			<center>
			<div class="ui input">
				  <input type="number" placeholder="ป้อนคิวของท่าน" name="queueNo" style="font-size:25px;text-align:center" value="<?php echo $queueNo;?>">
				</div>
				<br /><br />
				<select id="" name="stationNo" class="ui fluid selection dropdown" onchange="document.search.submit()" style="text-align:center;width:340px">
				<option value="">กรุณาเลือกหน่วยงาน</option>
					<?php 
					$sqls=sqlsrv_query($conn,"select * from queueHotKDept  order by deptDesc asc");
					while($rows=sqlsrv_fetch_object($sqls)){
					?>
					<option value="<?php echo $rows->deptCode;?>" <?php if($stationNo==$rows->deptCode){echo "selected";}?>><?php echo $rows->deptCode?> : <?php echo $rows->deptDesc?></option>
					<?php } ?>
				</select>
			</div>
			</center>
			

				</div>
			</form>
			<?php }else{?>
            <div class="ui link cards">
										  <div class="ui card centered">
											<div class="image">
											  <img src="./images/matthew.png">
											</div>
											<div class="content">
											  <div class="header"><center><font size="5" color="red"><?php echo $queueNo;?></font></center></div>
											  <div class="meta">
												<a><center> <?php if(!empty($rowqcall->queueNo)){$total=$queueNo-$rowqcall->queueNo;}if($total>0){echo "เหลืออีก".$total." คิว";}if($total==0){echo "ถึงคิวท่านแล้ว";}?></center></a>
											  </div>
											  <div class="description">
												<center><?php echo $dept->deptDesc;?></center>
											  </div>
											</div>
											<div class="extra content">
											  <span class="right floated">
												<?php echo $obj->shortdatetime(date("Y-m-d H:i:s"));?>
											  </span>
											  <span>
												<i class="user icon"></i>
												คิวปัจจุบัน <?php echo $rowqcall->queueNo;?>
											  </span>
											</div>
										  </div>
										  
										</div>
          </div>
		  <?php }?>
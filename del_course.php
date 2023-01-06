<?php               
    require_once 'dbconfig_sugang.php';
?>

<p><h3> 수강꾸러미에서 제거</h3></p>
<table class="table table-striped">
    <?php
    	$Ccode = mysqli_real_escape_string($link, $_REQUEST['ccode']);
    	$Snumber = mysqli_real_escape_string($link, $_REQUEST['student_id']);

		if (empty($Ccode) || empty($Snumber)) {
			print "학번과 교과목 코드를 모두 입력해주세요";
			exit;
		}

		$sql = "SELECT COUNT(*) FROM REGISTER WHERE Snumber = '$Snumber' AND Ccode = '$Ccode'";
		$is_registered = mysqli_query($link, $sql);

		if(mysqli_num_rows($is_registered) > 0) {
			$sql = "DELETE FROM REGISTER WHERE Snumber = '$Snumber' AND Ccode = '$Ccode'";
			$result = mysqli_query($link, $sql);

			echo $Snumber."의 수강꾸러미에서 ".$Ccode."가 제거되었습니다.<br>";
		}
		else {
			echo $Ccode."가 수강꾸러미에 없습니다.<br>";
		}
		mysqli_close($link);	
    ?>
</table>
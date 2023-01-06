<!-- 
2학기에 개설되지 않은 교과목 신청 불가
한 학생에 대해 신청하는 과목이 이미 relation이 존재할 경우 insert 불가 -> O
한 학생에 대해 신청한 교과목들의 총 이수학점은 24점을 넘을 수 없음 -> O
한 학생에 대해 신청한 교과목 중 교양 과목은 최대 3개까지 허용됨 -> O
한 학생에 대해 신청한 교과목들은 서로 시간이 겹치면 안됨 -> 
모든 교과목의 수강정원은 2명으로 최대 2명까지 수강이 가능 -> 
-->

<?php               
    require_once 'dbconfig_sugang.php';
?>

<p><h3> 수강꾸러미에 담기</h3></p>
<table class="table table-striped">
    <?php
    	$Ccode = mysqli_real_escape_string($link, $_REQUEST['ccode']);
    	$Snumber = mysqli_real_escape_string($link, $_REQUEST['student_id']);

		if (empty($Ccode) || empty($Snumber)) {
			print "학번과 교과목 코드를 모두 입력해주세요";
			exit;
		}

		$sql = "SELECT CourseName FROM DIVISION WHERE CourseCode = '$Ccode'";
		$is_2022_2 = mysqli_query($link, $sql);
		$row = mysqli_fetch_array($is_2022_2);

		$Cname = $row['CourseName'];

		$sql = "SELECT CourseType, Credit FROM COURSE WHERE CourseName = '$Cname'";
		$result = mysqli_query($link, $sql);
		$row = mysqli_fetch_array($result);

		$Ctype = $row['CourseType'];
		$Ccredit = $row['Credit'];

		$sql = "SELECT StudQuota FROM DIVISION WHERE CourseCode = '$Ccode'";
		$result = mysqli_query($link, $sql);
		$row = mysqli_fetch_array($result);
		$CstudQuota = $row['StudQuota'];
		
		if(mysqli_num_rows($is_2022_2) > 0) { // 2022-2 과목 확인
			$sql = "SELECT SUM(Ccredit) AS CREDITSUM FROM REGISTER WHERE Snumber = '$Snumber'";
			$result = mysqli_query($link, $sql);
			$row = mysqli_fetch_array($result);
			
			$total_credits = $row['CREDITSUM'];

			if($total_credits + $Ccredit <= 24) { // 24학점 제한
				if(!strcmp($Ctype, "교양")) { // 교양 3개 제한
					$sql = "SELECT COUNT(*) AS CULTURALSUM FROM REGISTER WHERE Snumber = '$Snumber' AND CourseType = '교양'";
					$result = mysqli_query($link, $sql);
					$row = mysqli_fetch_array($result);
					$total_cultural = $row['CULTURALSUM'];
					
					if($total_cultural >= 3) {
						echo "교양 과목은 최대 3개까지 담을 수 있습니다.<br>";	
					}
					else {
						$sql = "INSERT INTO REGISTER VALUE('$Snumber', '$Ccode', '$Cname', '$Ctype', $Ccredit, $CstudQuota)";
						$result = mysqli_query($link, $sql);

						if(mysqli_errno($link) == 1062) { // 중복 확인
							echo "이미 수강꾸러미에 담은 교과목은 담을 수 없습니다.<br>";
						}
						else {
							echo $Ccode."를 수강꾸러미에 담았습니다.<br>";
						}
					}
				}
				else {
					$sql = "INSERT INTO REGISTER VALUE('$Snumber', '$Ccode', '$Cname', '$Ctype', $Ccredit, $CstudQuota)";
					$result = mysqli_query($link, $sql);

					if(mysqli_errno($link) == 1062) { // 중복 확인
						echo "이미 수강꾸러미에 담은 교과목은 담을 수 없습니다.<br>";
					}
					else {
						echo $Ccode."를 수강꾸러미에 담았습니다.<br>";
					}
				}
			}
			else {
				echo "24학점 이상 수강신청 할 수 없습니다.<br>";
			}
		}
		else {
			echo $Ccode."는 2022년 2학기 수강 신청 가능 과목이 아닙니다.<br>";
		}
		mysqli_close($link);	
    ?>
</table>
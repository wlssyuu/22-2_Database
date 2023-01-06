<!--
    각 학생이 수강신청한 교과목들에 대한 정보 조회가 가능해야 한다.
    또한, 각 교과목별 수강생의 총 인원수도 조회 가능해야 한다. 
-->

<?php               
    require_once 'dbconfig_sugang.php';
?>

<p><h3> 수강꾸러미 조회</h3></p>
<div class="container">
    <?php
        $Ccode = mysqli_real_escape_string($link, $_REQUEST['ccode']);

        if (empty($Ccode)) {
			print "조회할 교과목 코드를 입력해주세요";
			exit;
		}
        
        $sql = "SELECT Ccode, Cname, Ccredit, CstudQuota FROM REGISTER WHERE Ccode = '$Ccode'";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);

        if(mysqli_num_rows($result) > 0) {
            $sql = "SELECT COUNT(*) AS STUSUM FROM REGISTER WHERE Ccode = '$Ccode'";
            $result = mysqli_query($link, $sql);
            $STUSUM = mysqli_fetch_array($result);

            print   "<table class='table table-striped' border='1'>";
            print   "<tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Credit</th>
                        <th>StudQuota</th>
                    </tr>";
                print "<tr><td>".$row['Ccode']."</td><td>"
                .$row['Cname']."</td><td>".$row['Ccredit']."</td><td>".$STUSUM['STUSUM']." / ".$row['CstudQuota']."</td></tr>";
            print   "</table>";
        }
        else {
            $sql = "SELECT CourseName, StudQuota FROM DIVISION WHERE CourseCode = '$Ccode'";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_array($result);

            $Cname = $row['CourseName'];

            $sql = "SELECT Credit FROM COURSE WHERE CourseName = '$Cname'";
            $result = mysqli_query($link, $sql);
            $credit = mysqli_fetch_array($result);

            print   "<table class='table table-striped' border='1'>";
            print   "<tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Credit</th>
                        <th>StudQuota</th>
                    </tr>";
            print "<tr><td>".$Ccode."</td><td>"
                .$Cname."</td><td>".$credit['Credit']."</td><td> 0 / ".$row['StudQuota']."</td></tr>";

        }
        
        mysqli_close($link);
    ?>
    </div>
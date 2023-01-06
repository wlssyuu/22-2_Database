<?php               
    require_once 'dbconfig_sugang.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Project Website</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">[2022-2, COMP322-6] Database Project - 수강꾸러미 DBMS</a>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
        <br>
        <br>
        <div class="row">
            <div class="col-lg-10">
                <h1 class="page-header">수강신청을 위한 수강꾸러미 시스템</h1>
    			<div class="jumbotron">                  
    			  <h2>학번과 수강하고자 하는 교과목 코드를 입력하세요</h2>
    			</div>

                <form action="insert_data.php" method="post">
                  <div class="form-group">
                    <label for="student_id">학번</label>
                    <input class="form-control" name="student_id" placeholder="학번을 입력하세요 (e.g., 1234567890)">
                  </div>
                  <div class="form-group">
                    <label for="ccode">교과목 코드</label>
                    <input class="form-control" name="ccode" placeholder="교과목 코드를 입력하세요 (e.g., CLTR0003-005)">
                  </div>
                  <button type="submit" class="btn btn-default" formaction="add_course.php">수강꾸러미에 담기</button>
                  <button type="submit" class="btn btn-default" formaction="del_course.php">수강꾸러미에서 제거</button>
                  <button type="submit" class="btn btn-default" formaction="view_bag.php">수강꾸러미 조회</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
    <h2>수강꾸러미 현황</h2>
    <?php
        $sql = "SELECT Ccode, Cname, CstudQuota FROM REGISTER";
        $result = mysqli_query($link, $sql);

        if(mysqli_num_rows($result) > 0){
            print   "<table class='table table-striped' border='1'>";
            print   "<tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>StudQuota</th>
                    </tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                print "<tr><td>".$row['Ccode']."</td><td>"
                .$row['Cname']."</td><td>".$row['CstudQuota']."</td></tr>";
            }
            print   "</table>";

            $sql = "SELECT SUM(Ccredit) AS CREDITSUM FROM REGISTER";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_array($result);
            $total_credits = $row['CREDITSUM'];

            echo "Total credits: ".$total_credits;
        }

        mysqli_close($link);
    ?>
    </div>
</body>

</html>

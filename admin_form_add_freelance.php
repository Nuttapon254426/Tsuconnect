<!DOCTYPE html>
<html>

<head>
    <title>Add Student Information</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>
body {
	font-family: 'Varela Round', sans-serif;
}
.modal-confirm {		
	color: #636363;
	width: 325px;
	font-size: 14px;
}
.modal-confirm .modal-content {
	padding: 20px;
	border-radius: 5px;
	border: none;
}
.modal-confirm .modal-header {
	border-bottom: none;   
	position: relative;
}
.modal-confirm h4 {
	text-align: center;
	font-size: 26px;
	margin: 30px 0 -15px;
}
.modal-confirm .form-control, .modal-confirm .btn {
	min-height: 40px;
	border-radius: 3px; 
}
.modal-confirm .close {
	position: absolute;
	top: -5px;
	right: -5px;
}	
.modal-confirm .modal-footer {
	border: none;
	text-align: center;
	border-radius: 5px;
	font-size: 13px;
}	
.modal-confirm .icon-box {
	color: #fff;		
	position: absolute;
	margin: 0 auto;
	left: 0;
	right: 0;
	top: -70px;
	width: 95px;
	height: 95px;
	border-radius: 50%;
	z-index: 9;
	background: #82ce34;
	padding: 15px;
	text-align: center;
	box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
}
.modal-confirm .icon-box i {
	font-size: 58px;
	position: relative;
	top: 3px;
}
.modal-confirm.modal-dialog {
	margin-top: 80px;
}
.modal-confirm .btn {
	color: #fff;
	border-radius: 4px;
	background: #82ce34;
	text-decoration: none;
	transition: all 0.4s;
	line-height: normal;
	border: none;
}
.modal-confirm .btn:hover, .modal-confirm .btn:focus {
	background: #6fb32b;
	outline: none;
}
.trigger-btn {
	display: inline-block;
	margin: 100px auto;
}
</style>
</head>

<body>
    <div class="container mt-5">
        <h2>Add ข้อมูลนิสิต</h2>
        <form action="process_form.php" method="post">
            <div class="mb-3">
                <label for="std_id" class="form-label">รหัสนิสิต:</label>
                <input type="text" class="form-control" name="std_id" required>
            </div>

            <div class="mb-3">
                <label for="std_Fname" class="form-label">ชื่อของนิสิต :</label>
                <input type="text" class="form-control" name="std_Fname" required>
            </div>

            <div class="mb-3">
                <label for="std_Lname" class="form-label">สกุลของนิสิต:</label>
                <input type="text" class="form-control" name="std_Lname" required>
            </div>

            <div class="mb-3">
                <label for="std_faculty" class="form-label">คณะของนิสิต:</label>
                <input type="text" class="form-control" name="std_faculty" required>
            </div>

            <div class="mb-3">
                <label for="std_major" class="form-label">สาขาวิชาของนิสิต:</label>
                <input type="text" class="form-control" name="std_major" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">ที่อยู่ของนิสิต:</label>
                <input type="text" class="form-control" name="address" required>
            </div>

            <div class="mb-3">
                <label for="std_tel" class="form-label">เบอร์โทรของนิสิต:</label>
                <input type="tel" class="form-control" name="std_tel" required>
            </div>

            <button href="#myModal" type="submit" class="btn btn-primary " data-toggle="modal">Add ข้อมูลนิสิต</button>

            <!-- Modal HTML -->
            <div id="myModal" class="modal fade">
                <div class="modal-dialog modal-confirm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="icon-box">
                                <i class="material-icons">&#xE876;</i>
                            </div>
                            <h4 class="modal-title w-100">Awesome!</h4>
                        </div>
                        <div class="modal-body">
                            <p class="text-center">Your  has been confirmed. Check your  detials.</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success btn-block" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
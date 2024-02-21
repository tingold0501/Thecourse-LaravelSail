<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="background: #fff !important; margin: 0 auto; margin-top: 30px; width: 90%; font-family: 'Times New Roman', Times, serif; font-size: 14px; color: #333333; border: 1px solid #e1e1e1;">
	<div style="margin: 0 auto; width: 90%;font-family: 'Times New Roman', Times, serif;">
		<div style="margin-bottom: 25px;font-family: 'Times New Roman', Times, serif;">
            <h3 style="font-size: 20px;font-family: 'Times New Roman', Times, serif;">Đăng ký khóa học thành công</h3>
            <h4 style="font-size: 18px;font-family: 'Times New Roman', Times, serif;">
                Học viên : {{$mailData['name']}}
            </h4>
            <table style="border: 1px solid black;font-family: 'Times New Roman', Times, serif;">
                <tr style="height: 50px;font-family: 'Times New Roman', Times, serif;">
                    <td style="width:5%;padding: 20px 20px;border-right: 1px solid black;font-family: 'Times New Roman', Times, serif;border-bottom:1px solid black">#</td>
                    <td style="width:70%;padding: 20px 20px;border-right: 1px solid black;border-bottom:1px solid black;font-family: 'Times New Roman', Times, serif;">Tên Khóa Học</td>
                    <td style="width:25%;padding: 20px 20px;border-bottom:1px solid black;font-family: 'Times New Roman', Times, serif;">Giá  </td>
                </tr>
                <tr style="height: 50px;font-family: 'Times New Roman', Times, serif;">
                    <td style="width:5%;padding: 20px 20px;border-right: 1px solid black;border-bottom:1px solid black;font-family: 'Times New Roman', Times, serif;">1</td>
                    <td style="width:70%;padding: 20px 20px;border-right: 1px solid black;border-bottom:1px solid black;font-family: 'Times New Roman', Times, serif;">{{$mailData['course']->name}}</td>
                    <td style="width:25%;padding: 20px 20px;border-bottom:1px solid black;font-family: 'Times New Roman', Times, serif;">{{number_format($mailData['course']->price,)}}  </td>
                </tr>
                <tr>
                    <td colspan="2" style="width:80%;padding: 20px 20px;border-right: 1px solid black;font-family: 'Times New Roman', Times, serif;">
                        <b>Tổng cộng</b>
                    </td>
                    <td style="width:20%;padding: 20px 20px">
                        {{number_format($mailData['course']->price,)}}
                    </td>
                </tr>
            </table>
		</div>
		<p>Thân gửi,</p>
	</div>	
	<div style="width: 100%; margin-top: 50px; height: 100px;overflow: hidden;">
    	<img  src="https://img.freepik.com/free-vector/hand-painted-watercolor-pastel-sky-background_23-2148902771.jpg" alt="logo" class="img-responsive" style="width: 100%">
  	</div>
</body>
</html>
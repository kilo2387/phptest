<!DOCTYPE HTML>
<html>
<head>
    <meta chartype="utf-8">
</head>
<body>
<?php
$name = $email = $gender = $comment = $website = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $website = test_input($_POST["website"]);
    $comment = test_input($_POST["comment"]);
    $gender= test_input($_POST["gender"]);
}


function test_input($date){
    $date = trim($date);
    $date = stripslashes($date);
    $date = htmlspecialchars($date);
    return $date;
}



?>



<h2>用户信息</h2>
<form method="post" action="http://localhost:8007/hh.php">
    姓名：<input type="text" name="name">
    <br><br>
    电邮：<input type="text" name="email">
    <br><br>
    密码：<input type="password" name="pwd">
    <br><br>
    网址：<input type="text" name="website">
    <br><br>
    你最喜欢的水果是：
    <br>
    <input type="radio" name="candy" value="apple">Apple<br>
    <input type="radio" name="candy" value="banana">Banana<br>
    你喜欢的数字：
    <br>
    <input type="checkbox" name="data[]" value="1">1<br>
    <input type="checkbox" name="data[]" value="2">2<br>
    <input type="checkbox" name="data[]" value="3">3<br>
    <input type="checkbox" name="data[]" value="4">4<br>
    <input type="checkbox" name="data[]" value="5">5<br>

    评论：<textarea name="comment" rows="5" cols="40"></textarea>
    <br><br>
    性别：
    <input type="radio" name="gender" value="female">女性
    <input type="radio" name="gender" value="male">男性
    <br><br>
    你使用的手机是：<br>
    <select>
        <option value="huawei" name="phone">华为</option>
        <option value="xiaomi" name="phone">小米</option>
        <option value="oppo" name="phone">oppo</option>
    </select>
    <input type="submit" name="submit" value="提交">
</form>

<?php
echo "<h2>您的输入：</h2>";
echo $name;
echo "<br>";
echo $email;
echo "<br>";
echo $website;
echo "<br>";
echo $comment;
echo "<br>";
echo $gender;

echo "<br>";

echo $pwd;
echo "<br>";
echo $candy;
echo "<br>";
echo $data;
echo "<br>";
echo $phone;
echo "<br>";
echo "<br>";
?>




<br>
<br><br><br><br>


</body>

</html>


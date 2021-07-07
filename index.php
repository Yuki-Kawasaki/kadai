
<html>
<head><title>PHP TEST</title></head>
<style type="text/css">
  body {
    background: #eeeeee;
  }
	
	*{
		font-family: "Meiryo UI";
	}
	.example  {
		background:#FFCC99
	}
	h1{
		font-weight: bold; 
	}
	.one{
		background:#99CCCC
	}
	.two{
		font-weight: bold;
	}
</style>	

<body>
<div class ="example">
	<p><h1>掲示板</h1></p>

	<form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
	<input type="text" name="personal_name"><br><br>
	<textarea name="contents" rows="8" cols="40">
	</textarea><br><br>
	<input type="submit" name="btn1" value="投稿する">
	</form>
</div>
	
<div class ="one">	
<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    writeData();
}

readData();

function readData(){
    $keijban_file = 'keijiban.txt';

    $fp = fopen($keijban_file, 'rb');

    if ($fp){
        if (flock($fp, LOCK_SH)){
            while (!feof($fp)) {
                $buffer = fgets($fp);
                print($buffer);
            }

            flock($fp, LOCK_UN);
        }else{
            print('ファイルロックに失敗しました');
        }
    }

    fclose($fp);
}

function writeData(){
    $personal_name = $_POST['personal_name'];
    $contents = $_POST['contents'];
    $contents = nl2br($contents);
	
	$data = "<hr>\r\n";
    $data = $data."<p>投稿者:".$personal_name."</p>\r\n";
    $data = $data."<p>内容:</p>\r\n";
	$data = $data."<p>".$contents."</p>\r\n";

    $keijban_file = 'keijiban.txt';

    $fp = fopen($keijban_file, 'ab');

    if ($fp){
        if (flock($fp, LOCK_EX)){
            if (fwrite($fp,  $data) === FALSE){
                print('ファイル書き込みに失敗しました');
            }

            flock($fp, LOCK_UN);
        }else{
            print('ファイルロックに失敗しました');
        }
    }

    fclose($fp);
}

?>	
</div>
</body>
</html>

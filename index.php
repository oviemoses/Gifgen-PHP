<?php
if(isset($_POST['speed']))
{
    header('Content-type: image/gif');
    if(isset($_POST['download'])){
    header('Content-Disposition: attachment; filename="animated.gif"');
    }
    include('GIFEncoder.class.php');
    function frame($image){
        ob_start();
        imagegif($image);
        global $frames, $framed;
        $frames[]=ob_get_contents();
        $framed[]=$_POST['speed'];
        ob_end_clean();
    }
	$cnt = count($_FILES);
	
	for($key=1;$key<=$cnt;$key++)
    {
            $tmp_name = $_FILES["images".$key]["tmp_name"];
		     $im = imagecreatefromstring(file_get_contents($tmp_name));
            $resized = imagecreatetruecolor($_POST['width'],$_POST['height']);
            imagecopyresized($resized, $im, 0, 0, 0, 0, $_POST['width'], $_POST['height'], imagesx($im), imagesy($im));
            frame($resized);
    }
    $gif = new GIFEncoder($frames,$framed,0,2,0,0,0,'bin');
    echo $gif->GetAnimation();
}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name='robots' content='index,follow' />
	<title>Create GIF image using php</title>
	<script src="jquery-latest.js"></script>
	<script src="jquery.MultiFile.js"></script>
	<script src="jquery.placeholder.js"></script>
	<style>
	input{
	margin:10px;
	padding:10px;
	}
	
	.center{
	width:205px;
	border:1px solid #000;
	border-radius:5px;
	padding:10px;
	clear:both;
	}
	</style>

</head>
<center>
		<div id="forms" class="menu">
			<h1>GIF Generator</h1>
				<form action="" method="post" enctype="multipart/form-data">
					<input type="file" name="images1" class="multi">
					<input type="file" name="images2" class="multi">
					<input type="file" name="images3" class="multi">
				<div id="idiv">
					<input type="hidden" id="bno" value="1"  />
				</div> 
				<div id="jdiv">
					<input type="button" onclick="addfile();" value="Add Input File" style="padding:8px; font-weight:bold; background:#15A915; border-radius:5px; color:#fff;">
				</div>
								
						<script type="text/javascript">
						function addfile()
						{
							var cnt = parseInt($('#bno').val());
							
							cnt = ++cnt;
							var n = cnt + 2;
							var content = "<div id='bdiv_"+cnt+"'><span id='spimg["+n+"]'> </span><input type='file' name='images"+n+"' id='img["+n+"]' onclick='load_image(this.id)'/><span id='spimg["+n+"]'></span><div style='display:inline;' id='cdiv'><a href='javascript:removefile(this,"+cnt+");' id='file_"+cnt+"'><input type='button' id='delete' name='delete' value='Delete' style='padding:5px; background:red; color:#fff;' /></a></div></div>";
							if(cnt==2)
							{
							}
							$('#idiv').append(content);
							$('#bno').val(cnt);
						}
						function removefile(fromObj)
						{
							var cnt2 = parseInt($('#bno').val());
							
							if(cnt2>1)
							{
							$('#bdiv_'+cnt2).remove();
								
								if(cnt2==2)
								{
									$('#cdiv').remove();
								}
								cnt2--;
								$('#bno').val(cnt2);
							}
						} 
						
							$(function(){
								$('input[placeholder], textarea[placeholder]').placeholder();
						});
						</script>
						<script language=Javascript>
						function isNumberKey(evt)
						{
							var charCode = (evt.which) ? evt.which : event.keyCode
							if (charCode > 31 && (charCode < 48 || charCode > 57))
								return false;
						
						return true;
						}
						</script>
					<div class="center">
						<label>SPEED:</label><br>
							<input name="speed" maxlength="10" type="text" placeholder="Speed in MS" onKeyPress="return isNumberKey(event)" style="padding:5px;"><br><br>
						<label>WIDTH: </label><br>
							<input name="width" maxlength="4" type="text" placeholder="Width" onKeyPress="return isNumberKey(event)" style="padding:5px;"><br><br>
						<label>HEIGHT: </label><br>
							<input name="height" maxlength="4" type="text" placeholder="Height" onKeyPress="return isNumberKey(event)" style="padding:5px;"><br><br>
							<input type="submit" style="padding:10px; background:#00A2E4; border-radius:5px; font-weight:bold; color:#fff;" name="preview" value="Preview">
							<input type="submit" style="padding:10px; background:#15A915; border-radius:5px; font-weight:bold; color:#fff;" name="download" value="Download">
					</div>
				</form>
		</div>
		</center>
		
</html>
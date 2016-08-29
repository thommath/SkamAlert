<?php 
	
	if(!isset($_COOKIE['skam']) && !(isset($_POST['pass']) && $_POST['pass'] == 'skam')){
		$pass = "false";
	}else{
		$pass = "true";
	}
	
	$mysqli = new mysqli("fdb12.awardspace.net", "username", "password", "database");
	
	if ($mysqli->query("INSERT INTO `Skam` (`Episode`, `tid`, `passord`) VALUES ('" . getUserIp() . "', '" . date("d-m-y") . "', '" . $pass . "');") === TRUE) {
		
	}else{
		echo "Fikk ikke koblet til databasen, siden er kanskje treg eller overbelastet.";
	}
	
	if(isset($_POST['pass'])){
		if($_POST['pass'] == "skam"){
			setcookie('skam', 'true');
		}
	}else if(isset($_POST['remove'])){
		setcookie("skam", "", time() - 3600);
	}
	
	function getUserIP()
	{
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP))
		{
			$ip = $client;
		}
		elseif(filter_var($forward, FILTER_VALIDATE_IP))
		{
			$ip = $forward;
		}
		else
		{
			$ip = $remote;
		}

		return $ip;
	}
?>


<HTML>

<head>
	
	<meta charset="UTF-8">
	
	<title>S*** Alert</title>
	
    <link href="bootstrap.css" rel="stylesheet">
	
	<script>
	
	var last = "";
		
	function start(){
		var req ;

		// Browser compatibility check  		
		if (window.XMLHttpRequest) {
		   req = new XMLHttpRequest();
			} else if (window.ActiveXObject) {

		 try {
		   req = new ActiveXObject("Msxml2.XMLHTTP");
		 } catch (e) {

		   try {
			 req = new ActiveXObject("Microsoft.XMLHTTP");
		   } catch (e) {}
		 }

		}
		
		
		var req = new XMLHttpRequest();
		req.open("GET", "sjekk.html",true);
		req.onreadystatechange = function () {
			last = req.responseText;
		}
		req.send(null);
		
		setInterval(function(){ sjekk(); }, <?php if(isset($_GET["interval"])){echo $_GET["interval"];}else{echo 60000;}?>);
	}
	
	function sjekk(){
		var req = new XMLHttpRequest();
		req.open("GET", "sjekk.html",true);
		req.onreadystatechange = function () {
		
			if(last != req.responseText && req.responseText != ""){
				last = req.responseText;
				document.title = "<?php if(isset($_COOKIE['skam']) || isset($_POST['pass'])){echo "Ny SKAM!";}else{echo "Ny S***!";}?>";
				alert("Ny S***!");
				document.title = "<?php if(isset($_COOKIE['skam']) || isset($_POST['pass'])){echo "Skam Alert";}else{echo "S*** Alert";}?>";
				document.getElementById('frame').contentWindow.location.reload();
			}
	//		document.getElementById('hello').innerHTML = "Contents : " + req.responseText;
		}

		req.send(null);
	}

	
	function remove_overlay(){
		document.getElementById('overlay').style.display = 'none';
	}
	
	
	</script>
	
	<style>
	*{
		margin: 0;
		padding: 0;
	}
	
	iframe{
		border-width: 0;
	}
	
	a{
		color: inherit;
	}
	
	.container {
		padding: 0;
		width: 100%;
		height: 100%;
		<?php if(!isset($_COOKIE['skam']) && !(isset($_POST['pass']) && $_POST['pass'] == 'skam')){echo "display: none;";}?>
	}
	
	.container2{
		padding: 0;
		width: 100%;
		height: 100%;
		<?php if(isset($_COOKIE['skam']) || (isset($_POST['pass']) && $_POST['pass'] == 'skam')){echo "display: none;";}?>
	}
	
	
	#sidebar {
		display: inline-block;
		height: 100%;
		width: 15%;
		padding: 15px;
		
		background-color: #333;
		color: fafafa; 
	}
	
	#foter{
		float: bottom;
		height: 18px;
		
		text-align: center;
	}
	
	#top{
		height: auto;
	}
	
	#iframe {
		float: right;
		width: 85%;
		display: inline-block;
	}
	
	.overlay{
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 10;
		background-color: rgba(0,0,0,0.5); /*dim the background*/
		<?php if(!isset($_COOKIE['skam']) && !(isset($_POST['pass']) && $_POST['pass'] == 'skam')){echo "display: none;";}?>
	}
	.overlay_stuff{
		margin: 10% auto;
		padding: 1%;
		width: 50%;
		height: 50%;
		background-color: #333;
		color: #fafafa;
	}
	
	@media (max-width: 2000px) {
		#sidebar{width: 10%;}
		#iframe {width: 90%;}
	}@media (max-width: 1800px) {
		#sidebar{width: 12%;}
		#iframe {width: 88%;}
	}@media (max-width: 1600px) {
		#sidebar{width: 14%;}
		#iframe {width: 86%;}
	}@media (max-width: 1400px) {
		#sidebar{width: 16%;}
		#iframe {width: 84%;}
	}@media (max-width: 1200px) {
		#sidebar{width: 18%;}
		#iframe {width: 82%;}
	}@media (max-width: 1100px) {
		#sidebar{width: 21%;}
		#iframe {width: 79%;}
	}@media (max-width: 1000px) {
		#sidebar{width: 24%;}
		#iframe {width: 76%;}
	}@media (max-width: 900px) {
		#sidebar{width: 27%;}
		#iframe {width: 73%;}
	}@media (max-width: 800px) {
		#sidebar{width: 30%;}
		#iframe {width: 70%;}
	}@media (max-width: 700px) {
		#sidebar{width: 33%;}
		#iframe {width: 67%;}
	}@media (max-width: 600px) {
		#sidebar{width: 35%;}
		#iframe {width: 65%;}
	}
	
	@media (max-width: 400px) {
		#sidebar{
			width: 100%;
			height: auto;
			display: block;
		}
		#top{
			height: auto;
		}
	
		#iframe {
			width: 100%;
			height: 95%;
			display: block;
		}
	}
	
	
	</style>
</head>


<body onload="start()">

<?php

if(isset($_POST["epost"])){
	if(filter_var($_POST["epost"], FILTER_VALIDATE_EMAIL)){
		$mysqli = new mysqli("fdb12.awardspace.net", "usernamne", "password", "database");
		
		if ($mysqli->query("INSERT INTO `SkamEpost` (`Epost`) VALUES ('" . $_POST["epost"] . "')") === TRUE) {
			echo "<div class=\"bg-success\">Du er lagt til i mailinglista</div>";
		}else{
			echo "<div class=\"bg-danger\">Beklager noe gikk galt, prøv igjen senere</div>";
		}
	}else{
		echo "<div class=\"bg-danger\">Ikke en gyldig epost, prøv igjen :)</div>";
	}
}

?>

<div class="overlay" id="overlay">
	<div class="overlay_stuff">
		<h1 style="text-align: center;">Dette er ikke en offisiell side!</h1>
		<p>Denne siden er laget av en privatperson med formål om å automatisere en handling for brukeren så brukeren kan bruke tiden sin på andre handlinger. Det er en ikke-kommersiell side av en privat aktør som ikke prøver å minske interessen eller ødelegge markedsføringen til NRK, men skape større interesse ved å tilby en ny funksjon som forhåpentligvis vil spre interessen for NRK sitt program, SKAM. Dette skal siden gjøre ved å vasle brukeren ikke bare når brukeren er alene foran pcen, men også mens brukeren er andre steder og dermed spre interessen for programmet SKAM. </p>
		
		<h2>Disclaimer</h2>
		<p>Alt av innhold som omhandler SKAM tilhører NRK, dette inkluderer alt fra programnavnet, varemerke, logo, foto og annet innhold i poster og selve programmene.</p>
		
		<p>Jeg garanterer ikke at denne siden eller epost-vaslingen vil virke til enhver tid. Serveren har begrenset kapasitet og jeg vil øke kapasiteten om nødvendig</p>
		
		<button onclick="remove_overlay()" class="btn btn-default">Jeg har lest og forstått informasjonen over</button>
		
	</div>
</div>


<div class="container">
	<div id="sidebar">
		<div class="" id="top">
			<a href="#"><h1 style="font-size: 1.8em;">Skam Alert!</h1></a>
			<br>
			<p>Denne siden vil gi deg muligheten til å bruke mer enn 5 minutter per oppgave siden denne siden gjør dette for deg. Lykke til på eksamen!</p>
			<br>
			<h1 style="font-size: 17px;">Få oppdatering på epost</h1>
			<br>
			<form action="#" method="post">
			
				<input type="text" style="color: black;" name="epost"><br><br>
				
				<p class="lead">
				<input class="btn btn-default" type="submit" value="Send" name="Submit">
				</p>
			</form>
			<br>
			
			<form action="#" method="post">
				<p> Fjern cookien her</p>
				<input type="hidden" name="remove" value="lol">
				<p class="lead">
				<input class="btn btn-default" type="submit" value="Send" name="Submit">
				</p>
			</form>
			
		</div>
		
		<div class="item" id="foter">
			<p class="font-size: 0.1em;">Dette er ikke en offisiell side! Inholdet som omhandler programmet SKAM tilhører NRK. Dette omfatter alt fra programnavnet, varemerke, logo, foto og annet innhold i poster og selve programmene.</p>
			
			<p>Ved spørsmål angående SKAM har jeg ingen ting med det å gjøre så send derfor mail til <a href="skam@nrk.no">skam@nrk.no</a></p>
			
			<p>Ved spørsmål om varslingstjenesten kontakt meg. </p>
			<a href="mailto:thomlmath@gmail.com"><p>thomlmath@gmail.com</p></a>
		</div>
	</div>

	<div class="item" id="iframe">
		<iframe id="frame" src="http://skam.p3.no" width="100%" height="100%"></iframe>
	</div>
</div>

<div class="container2">
	<div id="sidebar">
		<div class="" id="top">
			<a href="#"><h1 style="font-size: 1.8em;">S*** Alert!</h1></a>
			<br>
			<p>Denne siden vil automatisere en handling for deg ved å vasle deg når alliansen gjør sitt neste trekk. Lykke til på eksamen!</p>
			<br>
			<h1 style="font-size: 17px;">Få oppdatering på epost</h1>
			<br>
			<form action="#" method="post">
			
				<input type="text" style="color: black;" name="epost"><br><br>
				
				<p class="lead">
				<input class="btn btn-default" type="submit" value="Send" name="Submit">
				</p>
			</form>
			<br>
			
		</div>
		
		<div class="item" id="foter">
			<p>Ved spørsmål om varslingstjenesten kontakt meg. </p>
			<a href="mailto:thomlmath@gmail.com"><p>thomlmath@gmail.com</p></a>
		</div>
	</div>

	<div class="item" id="iframe">
		
			<form action="#" method="post">
				
				<p>Ved å trykke submit godtar du at vi lagrer en cookie på pcen din som lar deg slippe å skrive inn dette passordet igjen</p>
				
				<input type="password" style="color: black;" name="pass"><br><br>
				
				<p class="lead">
				<input class="btn btn-default" type="submit" value="Log in" name="Submit">
				</p>
			</form>
	</div>
</div>

</body>


</HTML>
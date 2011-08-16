<?php
$handle = @fopen("inits.csv", "r") or trigger_error('Unable to open tsv file', E_USER_ERROR);
$tsv = fread($handle, filesize("inits.csv"));
fclose($handle);
$rows = explode("\n", $tsv);
foreach ($rows as $i=>$a) {
  $cols = explode("\t", $a);
	foreach ($cols as $n=>$b) { //strip quotes from strings
		$output[$n] = substr($b, 1, strlen($b)-2);
	}
	$data[$i] = $output;
}

if ($_GET['modem'])
{
  switch ($_GET['protocol'])
  {
    case 'v34':
      $output = $data[$_GET['modem']][2];
    break;
    case 'v90':
      $output = $data[$_GET['modem']][1];
    break;
  }
	
	if ($_GET['speakeroff'])
	{	
		$output .= "M0";
	}	
	
	if ($_GET['lostcarrier'])
	{	
		$output .= $data[$_GET['modem']][3];
	}
	echo $output;
}
else
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US">
<head>
  <title>Modem Init Builder</title>
  <link rel='stylesheet' type='text/css' href='main.css' />
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
  <script type="text/javascript" src="prototype.js"></script>
  <script type="text/javascript" src="process.js"></script>
</head>

<body>
<h1>Modem Init Builder</h1>

<form id='data' name='data' action=''>

<div>
<label for='modem'>
Modem:
<select id='modem' name='modem' onChange='javascript:getInit()'>
	<option value='z'>(select modem)</option>
<?php
foreach ($data as $n=>$a) {
	if ($n <> 0)
		 echo "    <option value='".$n."'>".$a[0]."</option>\n";
}
?>
  </select>
	</label>

  <label for='protocol'>
	Protocol:
  <select id='protocol' name='protocol' onChange='javascript:getInit()'>
    <option value='v34'>v.34</option>
    <option value='v90'>v.90</option>
  </select>
	</label>
</div>
<div>	
	<label for='lostcarrier'>Increase Lost-carrier timeout:
	<input type='checkbox' id='lostcarrier' name='lostcarrier' onChange='javascript:getInit()' />
	</label>
	<label for='speakeroff'>Turn off modem speaker:
	<input type='checkbox' id='speakeroff' name='speakeroff' onChange='javascript:getInit()' />
	</label>
</div>
</form>
<div id="init"></div>
</body>
</html>
<?php
}
?>
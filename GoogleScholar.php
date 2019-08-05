
<!DOCTYPE html>
<html>
<head>
<title>Google Scholar</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" >
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
</head>

<body>


<?php

#ini_set(default_charset, "utf-8");
#header('Content-Type: application/json; charset=utf-8');
#header('Content-Type: application/json');

/*function iconv($a, $b, $c) {
	return $c;
}*/

$user="qubfVSkAAAAJ";
#if(!isset($_GET["user"]))
	#exit -1;

# create and load the HTML
include('simple_html_dom.php');
$html = new simple_html_dom();
#$html->load_file("http://scholar.google.se/citations?user=" . $_GET["user"]);
$html->load_file("https://scholar.google.com/citations?hl=en&user=qubfVSkAAAAJ");
#print "{\n \"total_citations\": " . $html->find("#gsc_rsb_st td.gsc_rsb_std", 0)->plaintext . ",\n";

    $Cit_A=$html->find("#gsc_rsb_st td.gsc_rsb_std", 0)->plaintext;

#print "{\n \"total_citations\": " . $html->find("#gsc_rsb_st td.gsc_rsb_std", 1)->plaintext . ",\n";
    $Cit_B=$html->find("#gsc_rsb_st td.gsc_rsb_std", 1)->plaintext;
    
#print "{\n \"total_citations\": " . $html->find("#gsc_rsb_st td.gsc_rsb_std", 2)->plaintext . ",\n";
    $hindex_A=$html->find("#gsc_rsb_st td.gsc_rsb_std", 2)->plaintext;
    
#print "{\n \"total_citations\": " . $html->find("#gsc_rsb_st td.gsc_rsb_std", 3)->plaintext . ",\n";
    $hindex_B=$html->find("#gsc_rsb_st td.gsc_rsb_std", 3)->plaintext;
    
#print "{\n \"total_citations\": " . $html->find("#gsc_rsb_st td.gsc_rsb_std", 4)->plaintext . ",\n";
    $i10_inex_A=$html->find("#gsc_rsb_st td.gsc_rsb_std", 4)->plaintext;
    
#print "{\n \"total_citations\": " . $html->find("#gsc_rsb_st td.gsc_rsb_std", 5)->plaintext . ",\n";
    $i10_inex_B=$html->find("#gsc_rsb_st td.gsc_rsb_std", 4)->plaintext;

#print "{\n \"Arun\": " . $html->find("#gsc_rsb_st th.gsc_rsb_sth", 1)->plaintext . ",\n";
    $header_A=$html->find("#gsc_rsb_st th.gsc_rsb_sth", 1)->plaintext;

#print "{\n \"total_citations\": " . $html->find("#gsc_rsb_st th.gsc_rsb_sth", 2)->plaintext . ",\n";
    $header_B=$html->find("#gsc_rsb_st th.gsc_rsb_sth", 2)->plaintext;


$s = " \"citations_per_year\": {";
$years = $html->find('.gsc_g_t');
$scores = $html->find('.gsc_g_al');

foreach($scores as $key => $score) {
	$s .= "\n  \"" . $years[$key]->plaintext ."\": ". $score->plaintext . ",";
	
	#echo $years[$key]->plaintext;
	
	$labels .= $years[$key]->plaintext.",";
	$data .= $score->plaintext.",";
	
}
#print substr($s, 0, -1) . "\n },\n";



/*
$str = " \"publications\": [";
foreach($html->find("#gsc_a_t .gsc_a_tr") as $pub) {
	$str .= "\n  {\n    \"title\": \"" . $pub->find(".gsc_a_at", 0)->plaintext;
	$str .= "\",\n    \"authors\": \"" . $pub->find(".gs_gray", 0)->plaintext;
	$str .= "\",\n    \"venue\": \"" .$pub->find(".gs_gray", 1)->plaintext;
	if($pub->find(".gsc_a_ac", 0)->plaintext == "&nbsp;")
		$str .= "\",\n    \"citations\": 0";
	else
		$str .= "\",\n    \"citations\": " . $pub->find(".gsc_a_ac", 0)->plaintext;
	if($pub->find(".gsc_a_h", 0)->plaintext == " ")
		$str .= ",\n    \"year\": 0";
	else
		$str .= ",\n    \"year\": " . $pub->find(".gsc_a_h", 0)->plaintext;
	$str .= "\n  },";
}
print substr($str, 0, -1) . "\n ]\n}";*/

?>

<div style="width:100%;margin:0 auto;">
    
    <table width="100%">
        <tr>
            <td align="center" width="60%">
               <div ><canvas id="line-chart"></canvas>
                </div>
           </td>
           <td align="center" width="40%">
                <table style="border-bottom:1px solid #e5e5e5;" cellspacing="15" width="100%" align="center">
                    <tr>
                        <td>Cited by:</td>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                    <tr >
                        <td style="border-bottom:1px solid #e5e5e5; border-top:1px solid #e5e5e5;">&nbsp;</td>
                        <td style="text-align: center; border-bottom:1px solid #e5e5e5; border-top:1px solid #e5e5e5;" >
                        <?php echo "$header_A"; ?>
                        </td>
                        <td style="text-align: center; border-bottom:1px solid #e5e5e5; border-top:1px solid #e5e5e5;">
                        <?php echo "$header_B"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Citations</td>
                        <td style="text-align: center;">
                        <?php echo "$Cit_A"; ?>
                        </td>
                        <td style="text-align: center;">
                        <?php echo "$Cit_B"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>h-index</td>
                        <td style="text-align: center;">
                        <?php echo "$hindex_A"; ?>
                        </td>
                        <td style="text-align: center;">
                        <?php echo "$hindex_B"; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>i10-index</td>
                        <td style="text-align: center;">
                        <?php echo "$i10_inex_A"; ?>
                        </td>
                        <td style="text-align: center;">
                        <?php echo "$i10_inex_B"; ?>
                        </td>
                    </tr>
                </table>
           </td> 
           
        </tr>
    </table>
</div>


<script>
    new Chart(document.getElementById("line-chart"), {
  type: 'line',
  data: {
    /*labels: [1500,1600,1700,1750,1800,1850,1900,1950,1999,2050],*/
    labels: [<?php echo $labels; ?>],
    datasets: [{ 
        /*data: [282,350,411,502,635,809,947,1402,3700,5267],*/
        data: [<?php echo "$data"; ?>],
        label: "Citations",
        borderColor: "#8e5ea2",
        fill: false
      }]
  },
  options: {
    title: {
      display: true,
      text: 'Google Scholar Citations per year'
    }
  }
});
</script>

<div>
    

    
</div>
</body>
</html>

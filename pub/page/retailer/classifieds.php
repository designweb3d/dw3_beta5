<?php 
$ret_id =$_GET['P1']??'';
if ($ret_id == ""){
    header("HTTP/1.0 404 Not Found");
    //require_once($_SERVER['DOCUMENT_ROOT'] ."/sbin/error.php?e=401");
    exit;
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/header_main.php';
require_once $_SERVER['DOCUMENT_ROOT'] . $INDEX_HEADER;
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/common_div.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/js/Multiavatar.php';

if ($INDEX_HEADER == '/pub/section/header0.php'){$INDEX_HEADER_HEIGHT = '0';}
else if ($INDEX_HEADER == '/pub/section/header1.php'){$INDEX_HEADER_HEIGHT = '50';}
else if ($INDEX_HEADER == '/pub/section/header2.php'){$INDEX_HEADER_HEIGHT = '20';}
else if ($INDEX_HEADER == '/pub/section/header3.php'){$INDEX_HEADER_HEIGHT = '30';}
else {$INDEX_HEADER_HEIGHT='50';}

if($USER_LANG == "FR"){
    echo ($SECTION_HTML_FR);
} else {
    echo ($SECTION_HTML_EN);
}

$sql = "SELECT * FROM customer WHERE id = '" . $ret_id . "';";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$CL_LAT = $data["latitude"];
$CL_LNG= $data["longitude"];
if ($data["company"] == ""){
    $retailer_name = dw3_decrypt($data["last_name"]);
} else {  
    $retailer_name = $date["company"];                     
}

echo "<div style='min-height:70vh;'>";
echo "<h1 style='text-align:center;padding:10px;color:vertical-align:middle;color:#".$CIE_COLOR7.";background-color:#".$CIE_COLOR6.";'>".$retailer_name."</h1>";
//map
echo "<div id='googleMap' style='height:300px;width:100%;'></div>";

    //INFORMNATIONS GÉNÉRALES
    echo "<div class='dw3_box' style='padding:0px;line-height:1.3em;background:rgba(255,255,255,0.95);color:#222;min-height:25px;font-weight:normal;'><table class='tblDATA'><tr style='border-left:0px;'><th>" . $retailer_name . "</th></tr><tr><td>".dw3_decrypt($data["adr1"]). "<br>".dw3_decrypt($data["adr2"]). "<br>".$data["city"]." ".$data["province"]. "<br>".$data["postal_code"]." ".$data["country"]. "</td></tr></table></div><br>";
    echo "<div class='dw3_box' style='line-height:1.3em;background:rgba(255,255,255,0.95);color:gold;min-height:25px;font-weight:normal;text-align:center;'><span class='material-icons'>star</span><span class='material-icons'>star</span><span class='material-icons'>star</span><span class='material-icons'>star</span><span class='material-icons'>star</span></div><br>";
    echo "<button onclick=\"dw3_set_loc('".$data['retailer_loc_id']."','".$retailer_name."');\">Choisir comme détaillant préféré</button>";

//classifieds
   $sql = "SELECT A.*, IFNULL(B.name_fr,'') AS category_name,IFNULL(B.name_en,'') AS category_name_en, IFNULL(C.id,-1) AS cat_parent_id, 
           IFNULL(C.name_fr,'') AS cat_parent_name, IFNULL(C.name_en,'') AS cat_parent_name_en
    FROM classified A
   LEFT JOIN (SELECT name_fr,name_en, id, parent_name FROM product_category) B ON B.id = A.category_id
   LEFT JOIN (SELECT name_fr,name_en, id FROM product_category) C ON C.name_fr = B.parent_name
   WHERE A.active = 1 ";
    $sql .= " AND A.customer_id = '".$ret_id."' ORDER BY category_name ASC, A.name_fr ASC LIMIT 500";

   $cat_name = "";
   //echo $sql;
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $RNDSEQ=rand(100,100000);
                    $filename= $row["img_link"];
                    if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $row["customer_id"] . "/" . $filename)){
                        $filename = "/pub/img/dw3/nd.png";
                    } else {
                        if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $row["customer_id"] . "/" . $filename)){
                            $filename = "/pub/img/dw3/nd.png";
                        }else{
                            $filename = "/fs/customer/" . $row["customer_id"] . "/" . $filename;
                        }
                    }
                    if($USER_LANG == "FR"){  
                        $trad_parent = $row["cat_parent_name"]; 
                        $trad_child = $row["category_name"]; 
                    } else {
                        $trad_parent = $row["cat_parent_name_en"];
                        $trad_child = $row["category_name_en"];
                    }
                    //navigate in categories must be sorted by categories
                    if ($row["category_name"] != "" && $cat_name != $row["category_name"]){
                        if ($row["cat_parent_id"] == "-1"){
                            echo "<h3 style='text-align:left;padding:10px;color:vertical-align:middle;color:#".$CIE_COLOR7.";background-color:#".$CIE_COLOR6.";'> <- <span style='cursor:pointer;' onclick='history.back()'><u>".$trad_parent."</u></span> > <strong style='color:#".$CIE_COLOR7.";vertical-align:middle;'>".$trad_child ."</strong></h3>";
                        } else {
                            echo "<h3 style='text-align:left;padding:10px;color:vertical-align:middle;color:#".$CIE_COLOR7.";background-color:#".$CIE_COLOR6.";'> <a href='/pub/page/classifieds/index.php?KEY=".$KEY."&PID=".$PAGE_ID."&P1=".$row["cat_parent_id"]."'><u style='vertical-align:middle;color:#".$CIE_COLOR7.";'>".$trad_parent."</u> </a> <strong style='color:#".$CIE_COLOR7.";vertical-align:middle;'> > ".$trad_child ."</strong></h3>";
                        }
                    }
                    //echo "before row cn:".$row["category_name"]."var cn:".$cat_name."<hr>";
                    $cat_name = $row["category_name"];
                    //echo "after row cn:".$row["category_name"]."var cn:".$cat_name."<hr>";
                    
                    echo "<div style='margin:25px 15px 25px 15px;border:0px solid #444; box-shadow: 5px 5px 5px 5px rgba(0,0,0,0.5);max-width:350px;display:inline-block;border-radius:10px;'>
                            <table style='border-collapse: collapse;border:0px;width:100%;margin-right:auto;margin-left:auto;display:inline-block;color:#".$CIE_COLOR4.";background-color:#".$CIE_COLOR3.";border-radius:10px;'>
                            <tr onclick='getAD(". $row["id"] . ");'  style='cursor:pointer;padding:0px;border:0px;border-top-right-radius:10px;border-top-left-radius:10px;' >";
                            if($USER_LANG == "FR"){
                                echo "<td  style='text-align:center;padding:4px 0px 4px 0px;border-top-right-radius:10px;border-top-left-radius:10px;'><strong>". $row["name_fr"] ."</strong></td></tr>";
                            } else {
                                echo "<td style='text-align:center;padding:4px 0px 4px 0px;border-top-right-radius:10px;border-top-left-radius:10px;'><strong>". $row["name_en"] ."</strong></td></tr>";
                            }
                        //image                           
                             echo "<tr style='padding:0px;border:0px;' onclick='getAD(". $row["id"] . ");'>"
                                   . "<td style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;'><img class='dw3_product_photo' src='" . $filename . "?t=" . $RNDSEQ . "' onerror='this.onerror=null; this.src=\"./img/dw3/nd.png\";' alt='Image du produit: ". $row["name_fr"] . "'></td></tr>";
                        //prix
                            $plitted = explode(".",$row["price"]);
                            $whole = $plitted[0]??$row["price"];
                            $fraction = $plitted[1]??0; 
                            if ($fraction == 0){
                                $fraction = "00";
                            }else{
                                $fraction = str_pad(rtrim($fraction, "0"), 2 , "0");
                            }
                            echo "<tr style='height:35px;'><td style='font-family:Sunflower;border:0px;text-align:center;padding-right:5px;padding-top:13px;padding-bottom:13px;'><strong>". number_format($whole) . ".<sup>" . $fraction . "</sup></strong></td></tr>";
                        //actions
                            echo "<tr style='border-bottom-right-radius:10px;border-bottom-left-radius:10px;'><td  style='border:0px;border-bottom-left-radius:10px;border-bottom-right-radius:10px;'>";
                                if($USER_LANG == "FR"){
                                    echo "<button onclick=\"getAD('" . $row["id"]  . "');\" style='min-height:50px;margin-right:0px;float:left;border-bottom-left-radius:10px;padding:7px;max-width:130px;'><span class='material-icons' style='font-size:24px;vertical-align:middle;'>help_center</span> <span style='width:92px;'>Plus d'infos</span></button>";
                                } else {
                                    echo "<button onclick=\"getAD('" . $row["id"]  . "');\" style='min-height:50px;margin-right:0px;float:left;border-bottom-left-radius:10px;padding:7px;max-width:130px;'><span class='material-icons' style='font-size:24px;vertical-align:middle;'>help_center</span> <span style='width:92px;'>More Infos</span></button>";
                                }

                                if($USER_LANG == "FR"){
                                    echo "<button onclick=\"buyAD('" . $row["id"]  . "');\" style='min-height:50px;margin-left:0px;float:right;border-bottom-right-radius:10px;padding:7px;max-width:130px;'><span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span> <span style='width:92px;'>Ajouter</span></button>";
                                } else {
                                    echo "<button onclick=\"buyAD('" . $row["id"]  . "');\" style='min-height:50px;margin-left:0px;float:right;border-bottom-right-radius:10px;padding:7px;max-width:130px;'><span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span> <span style='width:92px;'>Add</span></button>";
                                }                       
                        echo "</td></tr></table></div>";
            }
        } else {
/*                     echo "<h3 style='text-align:left;padding:10px;color:vertical-align:middle;color:#".$CIE_COLOR7.";background-color:#".$CIE_COLOR6.";cursor:pointer;' onclick='history.back()'> <- <u>"; if ($USER_LANG == "FR"){echo "Retour";} else {echo "Return";} echo "</u></h3>";
                    if ($USER_LANG == "FR"){
                        echo "<span style='text-shadow:0px 0px 1px #333;'>Aucune annonce classée dans cette catégorie pour le moment.</span>";
                    } else {
                        echo "<span style='text-shadow:0px 0px 1px #333;'>No classified ads in this category at the moment.</span>";
                    } */
        }
    echo "</div>";
    ?>
<?php 
    //require_once $_SERVER['DOCUMENT_ROOT'] . "/pub/page/page.js.php"; 
?>
<script>
//$(document).ready(function (){
    document.getElementById("dw3_body").innerHTML = "";
    bREADY = true;
//});

function initMap() {
	//navigator.geolocation.getCurrentPosition(function(position) {
		var pos = {
			lat: <?php echo $CL_LAT??'0'; ?>,
			lng: <?php echo $CL_LNG??'0'; ?>
		};
		window.pos = pos;
		//directionsService = new google.maps.DirectionsService;
		//directionsDisplay = new google.maps.DirectionsRenderer;
		//directionsRenderer = new google.maps.DirectionsRenderer();
		map = new google.maps.Map(document.getElementById("googleMap"), {
			zoom: 18,
			  panControl: true,
			  zoomControl: true,
			  mapTypeControl: true,
			  scaleControl: true,
			  streetViewControl: true,
			  overviewMapControl: true,
			  rotateControl: true,
			center: {lat: pos.lat, lng: pos.lng},
		});
		//directionsDisplay.setMap(map);
		//directionsRenderer.setMap(map);
		var me = new google.maps.LatLng(pos.lat, pos.lng);
		myloc = new google.maps.Marker({
			clickable: false,
			icon: new google.maps.MarkerImage('//maps.gstatic.com/mapfiles/mobile/mobileimgs2.png',
															new google.maps.Size(22,22),
															new google.maps.Point(0,18),
															new google.maps.Point(11,11)),
			shadow: null,
			zIndex: 999,
			map: map
		});	
		myloc.setPosition(me);
		
	//});
}
function setMapPos(clLAT,clLNG) {
    if (bREADY == false || clLAT == "" || clLAT == "0"){return;}
	var pos = {
				lat: clLAT,
				lng: clLNG
		};
		
	window.pos = pos;
		map = new google.maps.Map(document.getElementById("googleMap"), {
			zoom: 18,
			center: {lat: pos.lat, lng: pos.lng},
			mapId: '<?php echo $CIE_GMAP_MAP; ?>',
			mapTypeId: 'hybrid',
			heading:0,
			tilt:45	
		});
		var me = new google.maps.LatLng(pos.lat, pos.lng);
		var marker = new google.maps.Marker({
			position: me,
			map: map,
            icon: {
				path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
				fillColor: 'red',
				fillOpacity: 1,
				strokeColor: '#FFF',
				strokeWeight: 1,
				scale: 1.2,
				shadow: true,
				labelOrigin: new google.maps.Point(0, -31),				
			},
			label: {
			  text: '↔',
			  fontSize: '17px',
			  color: 'white',
			  fontWeight: 'bold',

			},
			draggable: true
			});
}
function dw3_set_loc(loc_id,loc_name) {
    //var xmlhttp = new XMLHttpRequest();
    //xmlhttp.open('GET', '/pub/page/set_loc.php?ID=' + loc_id , true);
	//xmlhttp.send();
    var myDate = new Date();
    myDate.setMonth(myDate.getMonth() + 12);
    document.cookie = "STORE="+loc_id+";expires=" + myDate +";path=/;domain=.<?php echo $_SERVER['SERVER_NAME']; ?>;";
    //dw3_msg_close();
/*     if (document.getElementById('dw3_loc_span')) {
        document.getElementById('dw3_loc_span').innerHTML = "<a href='/pub/page/location/index.php'><div style='border-radius:5px;color:#<?php echo $CIE_COLOR9; ?>'>Magasin préféré: " + loc_name + "</div></a>";
    } */
/*     setTimeout(() => {
        location.reload();
        return false;
    }, "1500"); */
    if (document.getElementById('retailer_loc_span')){
        document.getElementById('retailer_loc_span').innerHTML = "<u>"+loc_name+"</u>";
    }
    dw3_notif_add("Votre magasin préféré a été modifié.");
}
</script>
<?php 
    if ($CIE_GMAP_KEY!=""){ 
        echo "<script src='https://maps.googleapis.com/maps/api/js?key=" . $CIE_GMAP_KEY . "&callback=initMap'></script>";
    } 
    require_once $_SERVER['DOCUMENT_ROOT'] . $INDEX_FOOTER;
    exit; 
?>
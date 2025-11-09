<?php
	$sql = "SELECT *
			FROM app_user
			LEFT JOIN app on app_user.app_id = app.id
			WHERE user_id = '" . $USER . "'
			ORDER BY sort_number";

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {
		$MENU = "<table id='tblMENU' class='noselect' style='-webkit-touch-callout: none;' >";
		while($row = $result->fetch_assoc()) {
			if($USER_LANG == "FR"){$APNOM = $row["name_fr"];} else {$APNOM = $row["name_en"];}
			if($row["filename"]=="config"){$icon_class="config-icon";}else{$icon_class="";}
			if ($row["filename"] . ".php" == $PAGE1 || $row["filename"] . ".php" == $PAGE2){
				$PAGE_ICON = $row["icon"];
				$MENU .= "
					<tr class='noselect' style='margin:0px;padding:0px;box-shadow:inset 0px 0px 3px 1px #" . $CIE_COLOR4 . ";cursor:default;'><td onclick='closeMENU();' class='noselect'><span class='material-icons noselect " . $icon_class . "' style='color:". $row["color"] . ";'>". $row["icon"] . "</span>  ". $APNOM . "</td><td class='noselect' style='width:20px;' onclick='closeMENU();window.open(\"../". $row["filename"] . "/" . $row["filename"] . ".php?KEY=" . $KEY . "\",\"_blank\");'><span class='material-icons' style='color:grey;'>arrow_outward</span></td></tr>";
			} else {
                if($row["filename"]=="toolbox"){
                    $MENU .= "
                        <tr class='noselect' style='margin:0px;padding:0px;' ><td onclick='closeMENU();dw3_tool_menu();' class='noselect' unselectable='on' onselectstart='return false;'><span class='material-icons noselect " . $icon_class . "' style='color:". $row["color"] . ";'>". $row["icon"] . "</span>  ". $APNOM . "</td><td style='width:20px;'></td></tr>";
                } else {
                    $MENU .= "
                        <tr class='noselect' style='margin:0px;padding:0px;' ><td onclick='closeMENU();window.open(\"../". $row["filename"] . "/" . $row["filename"] . ".php?KEY=" . $KEY . "\",\"_self\");window.getSelection().empty();' class='noselect' unselectable='on' onselectstart='return false;'><span class='material-icons noselect " . $icon_class . "' style='color:". $row["color"] . ";'>". $row["icon"] . "</span>  ". $APNOM . "</td><td style='width:20px;' onclick='closeMENU();window.open(\"../". $row["filename"] . "/" . $row["filename"] . ".php?KEY=" . $KEY . "\",\"_blank\");'><span class='material-icons' style='color:grey;'>arrow_outward</span></td></tr>";
                }
			}
		}
        $MENU .= "<tr class='noselect' style='margin:0px;padding:0px;' onclick='openOPT();'><td colspan=2 class='noselect'><span  class='material-icons noselect' style='color:black;'>manage_accounts</span> <b class='noselect'>Options</b> (" . $USER_NAME . ")</td></tr>";
		$MENU .= "</table>";
	}

?>
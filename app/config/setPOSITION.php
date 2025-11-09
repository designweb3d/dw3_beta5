<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$POSTE_ID= $_GET['ID'];
        $sql = "SELECT * FROM position WHERE id = '".$POSTE_ID."' LIMIT 1;";
            $result = $dw3_conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div id='divEDIT_HEADER' class='dw3_form_head'>
                        <h3>". $row["name"] ."</h3>
                        <button class='dw3_form_close' onclick='closeEDITOR();'><span class='material-icons'>cancel</span></button>
                    </div>
                    <div class='dw3_form_data'>";
                    echo "<table class='tblDATA'>";
                    echo "<tr><th style='min-width:100px;'>Ouverture</th><td><select  id='carACTIVE'>";
                        echo "<option value='0'"; if ($row["active"] == "0"){echo " selected ";} echo ">Inactif</option>";
                        echo "<option value='1'"; if ($row["active"] == "1"){echo " selected ";} echo ">Actif</option>";
                    echo "</select></td></tr>";
                    echo "<tr><th style='min-width:100px;'>Valide jusqu'à</th><td><input style='width:auto' type='date' id='carEND' value='".$row["date_end_post"]."'></td></tr>";
                    echo "<tr><th style='min-width:100px;'>Salaire de base</th><td><input type='text' id='carSALARY_MIN' value='".$row["salary_min"]."' style='width:40%'>
                            <select id='carSALARY_TYPE' style='width:59%;float:right;'>";
                    echo "<option value='HOUR'"; if ($row["salary_type"] == "HOUR"){echo " selected ";} echo ">Heure</option>";
                    echo "<option value='DAY'"; if ($row["salary_type"] == "DAY"){echo " selected ";} echo ">Jour</option>";
                    echo "<option value='WEEK'"; if ($row["salary_type"] == "WEEK"){echo " selected ";} echo ">Semaine</option>";
                    echo "<option value='MONTH'"; if ($row["salary_type"] == "MONTH"){echo " selected ";} echo ">Mois</option>";
                    echo "<option value='YEAR'"; if ($row["salary_type"] == "YEAR"){echo " selected ";} echo ">Année</option>";
                    echo "</select></td></tr>";
                        $sqld = "SELECT * FROM prototype_head WHERE parent_table='user' ;";
                            $resultd = $dw3_conn->query($sqld);
                            echo "<tr><th style='min-width:100px;'>Document à compléter</th><td><select id='carDOC'>";
                            if ($resultd->num_rows > 0) {
                                    echo "<option value='0' disabled selected>Non-définit</option>";
                                while($rowd = $resultd->fetch_assoc()) {
                                    echo "<option value='".$rowd["id"]."'"; if ($row["document_id"] == $rowd["id"]){echo "selected";} echo ">".$rowd["name_fr"]."</option>";
                                }
                            } else {
                                echo "<option value='0' disabled>Aucun document utilisateur trouvé</option>";
                            }
                            echo "</select></td></tr>";

                    echo "<tr><th style='min-width:100px;'>Lieu</th><td><select id='carTELECOMMUTE'>";
                        echo "<option value='0'"; if ($row["telecommute"] == "0"){echo " selected ";} echo ">Sur Place</option>";
                        echo "<option value='1'"; if ($row["telecommute"] == "1"){echo " selected ";} echo ">Télétravail</option>";
                        echo "<option value='2'"; if ($row["telecommute"] == "2"){echo " selected ";} echo ">Télétravail & Sur Place</option>";
                    echo "</select></td></tr>";
                    echo "<tr><th style='min-width:100px;'>Type de travail</th><td>";
                                echo "<input style='margin:5px 0px;' type='checkbox' id='carFULL_TIME'"; if ($row["full_time"] == "1"){ echo " checked ";} echo "><label for='carFULL_TIME'> Temps plein</label><br>";
                                echo "<input style='margin:5px 0px;' type='checkbox' id='carPART_TIME'"; if ($row["part_time"] == "1"){ echo " checked ";}echo "><label for='carPART_TIME'> Temps partiel</label><br>";
                                echo "<input style='margin:5px 0px;' type='checkbox' id='carCONTRACTOR'"; if ($row["contractor"] == "1"){ echo " checked ";}echo "><label for='carCONTRACTOR'> Contractuel</label><br>";
                                echo "<input style='margin:5px 0px;' type='checkbox' id='carTEMPORARY'"; if ($row["temporary"] == "1"){ echo " checked ";}echo "><label for='carTEMPORARY'> Temporaire</label><br>";
                                echo "<input style='margin:5px 0px;' type='checkbox' id='carINTERN'"; if ($row["intern"] == "1"){ echo " checked ";}echo "><label for='carINTERN'> Stage</label><br>";
                                echo "<input style='margin:5px 0px;' type='checkbox' id='carVOLUNTEER'"; if ($row["volunteer"] == "1"){ echo " checked ";}echo "><label for='carVOLUNTEER'> Bénévole</label><br>";
                                echo "<input style='margin:5px 0px;' type='checkbox' id='carPER_DIEM'"; if ($row["per_diem"] == "1"){ echo " checked ";}echo "><label for='carPER_DIEM'> Payé à la journée</label><br>";
                                echo "<input style='margin:5px 0px;' type='checkbox' id='carOTHER'"; if ($row["other"] == "1"){ echo " checked ";}echo "><label for='carOTHER'> Autre</label><br>";
                    echo "</td></tr>";
                    echo "<tr><th style='min-width:100px;'>Responsabilités</th><td><textarea id='carRESP' rows='4'>".$row["responsibilities"]."</textarea></td></tr>";
                    echo "<tr><th style='min-width:100px;'>Habiletés</th><td><textarea id='carHABI' rows='4'>".$row["skills"]."</textarea></td></tr>";
                    echo "<tr><th style='min-width:100px;'>Qualifications</th><td><textarea id='carQUAL' rows='4'>".$row["qualifications"]."</textarea></td></tr>";
                    echo "<tr><th style='min-width:100px;'>Éducation</th><td><textarea id='carEDUC' rows='4'>".$row["education"]."</textarea></td></tr>";
                    echo "<tr><th style='min-width:100px;'>Expérience</th><td><textarea id='carEXPE' rows='4'>".$row["experience"]."</textarea></td></tr>";
                    echo "</table></div>
                    <div class='dw3_form_foot'>
                        <button class='grey' onclick=\"closeEDITOR();\"><span class='material-icons'>cancel</span></button>
                        <button class='green' onclick=\"updCAREER('".$POSTE_ID."');\"><span class='material-icons'>save</span> Enregistrer</button>
                    </div
                    ";
                }
            }
        $dw3_conn->close();
    ?>
<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/header_main.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . $PAGE_HEADER;
 require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/common_div.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/js/Multiavatar.php';
 $multiavatar = new Multiavatar();
 if ($PAGE_HEADER== '/pub/section/header0.php'){$INDEX_HEADER_HEIGHT = '0';}
 else if ($PAGE_HEADER== '/pub/section/header1.php'){$INDEX_HEADER_HEIGHT = '50';}
 else if ($PAGE_HEADER== '/pub/section/header2.php'){$INDEX_HEADER_HEIGHT = '20';}
 else if ($PAGE_HEADER== '/pub/section/header3.php'){$INDEX_HEADER_HEIGHT = '30';}
 else {$INDEX_HEADER_HEIGHT='50';}
?>
	<div class='dw3_quiz_data' style='top:<?php echo $INDEX_HEADER_HEIGHT; ?>px;'>
        <div id='quiz_page0' style='position:absolute;top:70px;left:0px;bottom:0px;width:100%;transition: left 1.2s ease-in-out;overflow-x:hidden;overflow-y:hidden;'>
            <div class='dw3_quiz_foot'>
                <button onclick="dw3_go_home();" style='float:left;color:#eee;border:1px solid #eee;background-color:#444;padding:8px 12px 6px 12px;'>
                    <span class='material-icons'>close</span> Annuler
                </button>
                <div style='display:inline-block;vertical-align:center;box-shadow:inset 0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:24px;padding:6px;'>1/4</div>	
                <button onmouseup="goto_page('1','0');" style='color:#000;float:right;padding:8px 12px 6px 12px;background-color:#1D9521;'>
                    <span class='material-icons'>skip_next</span> Continuer
                </button>
            </div>	
            <div class='dw3_page' style='min-height:90vh;max-height:90vh;background:#f0f0f0;color:#333;overflow-x:hidden;overflow-y:auto;'>
                <h3>Type d'entreprise</h3>
                <div class="dw3_box" style='max-width:600px;'><br>Forme juridique de l'entreprise:
                    <select name='cfgTYPE' id='reponse1'>
                            <option value="1">Entreprise individuelle</option>
                            <option value="2">Société en nom collectif</option>
                            <option value="3">Société en commandite</option>
                            <option value="4">Société par actions</option>
                            <option value="5">Coopérative</option>
                            <option value="6">Organisme à but non lucratif</option>
                        </select>
                </div>
                <div class="dw3_box" style='max-width:600px;'><br>Secteurs d'activité:
                    <select name='cfgCAT' id='reponse2'>
                        <!-- n/a <option value="1">Administrations publiques</option> -->
                        <option value="2">Agriculture, foresterie, pêche et chasse</option>
                        <option value="3">Arts, spectacles et loisirs</option>
                        <option value="4">Autres services</option>
                        <option value="5">Commerce de détail</option>
                        <option value="6">Commerce de gros</option>
                        <option value="7">Construction</option>
                        <option value="8">Extraction minière, exploitation en carrière, et extraction de pétrole et de gaz</option>
                        <option value="9">Fabrication</option>
                        <option value="10">Finance et assurances</option>
                        <option value="11">Gestion de sociétés et d'entreprises</option>
                        <option value="12">Hébergement et services de restauration</option>
                        <option value="13">Industrie de l'information et industrie culturelle</option>
                        <option value="14">Services administratifs, services de soutien</option>
                        <option value="15">Services d'enseignement</option>
                        <option value="16">Services de restauration et débit de boisson</option>
                        <option value="17">Services immobiliers et services de location et de location à bail</option>
                        <option value="18">Services professionnels, scientifiques et techniques</option>
                        <!-- n/a <option value="19">Services publics</option> -->
                        <option value="20">Soins de santé et assistance sociale</option>
                        <option value="21">Transport et entreposage</option>
                        <option value="22">Transport par camion</option>
                    </select><br>
                    Autre secteur d'activité et/ou spécialisation:
                    <input id='reponse3' type='text' value=''>               
                </div><br>
                <div class="dw3_box"><br>Chiffre d'affaire:
                    <select name='cfgTYPE' id='reponse2a' style='width:40%;float:right;'>
                            <option value="1">0-30,000$</option>
                            <option value="2">30-100,000$</option>
                            <option value="3">100-500,000$</option>
                            <option value="4">+500,000$</option>
                            <option value="5">+1,000,000$</option>
                            <option value="6">+10,000,000$</option>
                        </select>
                </div>
                <div class="dw3_box"><br>Nombre d'employés:
                    <select name='cfgTYPE' id='reponse2b' style='width:40%;float:right;'>
                            <option value="1">0-1</option>
                            <option value="2">2-10</option>
                            <option value="3">10-50</option>
                            <option value="4">50-100</option>
                            <option value="5">+100</option>
                            <option value="6">+500</option>
                        </select>
                </div>
                <hr>* Toutes vos réponses vous seront également envoyés, si vous le désirez, à la fin du questionnaire.
            </div>
        </div>
        <div id='quiz_page1' style='position:absolute;top:70px;left:100%;bottom:0px;width:100%;transition: left 1.2s ease-in-out;overflow-x:hidden;overflow-y:hidden;'>
            <div class='dw3_quiz_foot'>
                <button onmouseup="goto_page('0','1');" style='float:left;padding:8px 12px 6px 12px;'>
                    <span class='material-icons'>skip_previous</span> Retour
                </button>
                <div style='display:inline-block;vertical-align:center;box-shadow:inset 0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:24px;padding:6px;'>2/4</div>	
                <button onmouseup="goto_page('2','1');" style='float:right;padding:8px 12px 6px 12px;background-color:#1D9521;'>
                    <span class='material-icons'>skip_next</span> Continuer
                </button>
            </div>	
            <div id='dw3_submit_q2' class='dw3_page' style='min-height:90vh;max-height:90vh;background:#f0f0f0;color:#333;overflow-x:hidden;overflow-y:auto;'>
                <h3>Quels sont vos objectifs pour votre plan marketing?</h3>
                <div class='dw3_box'>
                    <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                    <input type='checkbox' id='reponse9' style='cursor:pointer;'><label for='reponse9' style='cursor:pointer;margin-top:-2px;'> Fidélisation</label>
                    </div>
                    <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                        <input type='checkbox' id='reponse4' style='cursor:pointer;'><label for='reponse4' style='cursor:pointer;margin-top:-2px;'> Publications régulières</label>
                    </div>
                    <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                        <input type='checkbox' id='reponse5' style='cursor:pointer;'><label for='reponse5' style='cursor:pointer;margin-top:-2px;'> Campagne de publicité ciblé</label>
                    </div>
                    <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                        <input type='checkbox' id='reponse5a' style='cursor:pointer;'><label for='reponse5a' style='cursor:pointer;margin-top:-2px;'> Modernisation</label>
                    </div>
                    <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                        <input type='checkbox' id='reponse6' style='cursor:pointer;'><label for='reponse6' style='cursor:pointer;margin-top:-2px;'> Lancement</label>
                    </div>
                    <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                        <input type='checkbox' id='reponse7' style='cursor:pointer;'><label for='reponse7' style='cursor:pointer;margin-top:-2px;'> Nouvelle région</label>
                    </div>
                    <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                        <input type='checkbox' id='reponse8' style='cursor:pointer;'><label for='reponse8' style='cursor:pointer;margin-top:-2px;'> Nouveau projet</label>
                    </div>
                    <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                        <input type='checkbox' id='reponse9a' style='cursor:pointer;'><label for='reponse9a' style='cursor:pointer;margin-top:-2px;'> Bulletins d'information (Newsletters)</label>
                    </div>
                </div>
                <h3>Clientèle cible:</h3>
                    <div class='dw3_box'>                
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse10' style='cursor:pointer;'><label for='reponse10' style='cursor:pointer;margin-top:-2px;'> 0-12 ans</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse11' style='cursor:pointer;'><label for='reponse11' style='cursor:pointer;margin-top:-2px;'> 12-18</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse12' style='cursor:pointer;'><label for='reponse12' style='cursor:pointer;margin-top:-2px;'> 18-30</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse12a' style='cursor:pointer;'><label for='reponse12a' style='cursor:pointer;margin-top:-2px;'> 30-40</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse13' style='cursor:pointer;'><label for='reponse13' style='cursor:pointer;margin-top:-2px;'> 40-60</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse14' style='cursor:pointer;'><label for='reponse14' style='cursor:pointer;margin-top:-2px;'> 60+</label>
                        </div>
                        <br>               
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' checked id='reponse14a' style='cursor:pointer;'><label for='reponse14a' style='cursor:pointer;margin-top:-2px;'> Homme</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' checked id='reponse14b' style='cursor:pointer;'><label for='reponse14b' style='cursor:pointer;margin-top:-2px;'> Femme</label>
                        </div>
                        <br>               
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' checked id='reponse14c' style='cursor:pointer;'><label for='reponse14c' style='cursor:pointer;margin-top:-2px;'> Particulier</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' checked id='reponse14d' style='cursor:pointer;'><label for='reponse14d' style='cursor:pointer;margin-top:-2px;'> Entreprise</label>
                        </div>
                    </div>              
                <h3>Territoire visé:</h3>
                    <div class='dw3_box'>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse15' style='cursor:pointer;'><label for='reponse15' style='cursor:pointer;margin-top:-2px;'> International</label>
                        </div><br>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse16' style='cursor:pointer;'><label for='reponse16' style='cursor:pointer;margin-top:-2px;'> Canada-USA</label>
                        </div><br>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse17' style='cursor:pointer;'><label for='reponse17' style='cursor:pointer;margin-top:-2px;'> National</label>
                        </div><br>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse18' style='cursor:pointer;'><label for='reponse18' style='cursor:pointer;margin-top:-2px;'> Provincial</label>
                        </div><br>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse19' style='cursor:pointer;'><label for='reponse19' style='cursor:pointer;margin-top:-2px;'> Région de l'Abitibi-Témiscamingue</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse20' style='cursor:pointer;'><label for='reponse20' style='cursor:pointer;margin-top:-2px;'> Région du Bas-Saint-Laurent</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse21' style='cursor:pointer;'><label for='reponse21' style='cursor:pointer;margin-top:-2px;'> Région de la Capitale-Nationale</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse22' style='cursor:pointer;'><label for='reponse22' style='cursor:pointer;margin-top:-2px;'> Région du Centre-du-Québec</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse23' style='cursor:pointer;'><label for='reponse23' style='cursor:pointer;margin-top:-2px;'> Région de Chaudière-Appalaches</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse24' style='cursor:pointer;'><label for='reponse24' style='cursor:pointer;margin-top:-2px;'> Région de la Côte-Nord</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse25' style='cursor:pointer;'><label for='reponse25' style='cursor:pointer;margin-top:-2px;'> Région de l'Estrie</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse26' style='cursor:pointer;'><label for='reponse26' style='cursor:pointer;margin-top:-2px;'> Région de la Gaspésie et des Îles-de-la-Madeleine</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse27' style='cursor:pointer;'><label for='reponse27' style='cursor:pointer;margin-top:-2px;'> Région de Lanaudière</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse28' style='cursor:pointer;'><label for='reponse28' style='cursor:pointer;margin-top:-2px;'> Région des Laurentides</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse29' style='cursor:pointer;'><label for='reponse29' style='cursor:pointer;margin-top:-2px;'> Région de Laval</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse29a' style='cursor:pointer;'><label for='reponse29a' style='cursor:pointer;margin-top:-2px;'> Région de la Mauricie</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse30' style='cursor:pointer;'><label for='reponse30' style='cursor:pointer;margin-top:-2px;'> Région de la Montérégie</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse31' style='cursor:pointer;'><label for='reponse31' style='cursor:pointer;margin-top:-2px;'> Région de Montréal</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse32' style='cursor:pointer;'><label for='reponse32' style='cursor:pointer;margin-top:-2px;'> Région de la Nord-du-Québec</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse33' style='cursor:pointer;'><label for='reponse33' style='cursor:pointer;margin-top:-2px;'> Région de l'Outaouais</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse34' style='cursor:pointer;'><label for='reponse34' style='cursor:pointer;margin-top:-2px;'> Région du Saguenay–Lac-Saint-Jean</label>
                        </div>
                        <div style='margin:2px;display:inline-block;vertical-align:center;background-color:rgba(0,0,0,0.7);color:#f0f0f0;box-shadow:0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:14px;padding:8px;'>
                            <input type='checkbox' id='reponse35' style='cursor:pointer;'><label for='reponse35' style='cursor:pointer;margin-top:-2px;'> Ma localité</label>
                        </div>
                    </div><br>
                    <div class='dw3_box' style='margin-bottom:150px;'>
                        Ma localité:
                        <input type='text' id='reponse36'>
                    </div>
            </div>
        </div>
        <div id='quiz_page2' style='position:absolute;top:70px;left:100%;bottom:0px;width:100%;transition: left 1.2s ease-in-out;overflow-x:hidden;overflow-y:hidden;'>
            <div class='dw3_quiz_foot'>
                <button onmouseup="goto_page('1','2');" style='float:left;padding:8px 12px 6px 12px;'>
                    <span class='material-icons'>skip_previous</span> Retour
                </button>	
                <div style='display:inline-block;vertical-align:center;box-shadow:inset 0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:24px;padding:6px;'>3/4</div>	
                <button onmouseup="goto_page('3','2');" style='float:right;padding:8px 12px 6px 12px;background-color:#1D9521;'>
                    <span class='material-icons'>skip_next</span> Continuer
                </button>
            </div>	
            <div id='dw3_submit_q3' class='dw3_page' style='min-height:90vh;max-height:90vh;background:#f0f0f0;color:#333;overflow-x:hidden;overflow-y:auto;'>
                <h3>Vos disponibilités pour vous contacter</h3>
                <div class='dw3_box' style='padding:10px;width:240px'>
                    <input id='reponsey' type='checkbox' disabled checked><label for='reponsey'> Par courriel</label><br>
                    <input id='reponsex' type='checkbox' checked><label for='reponsex'> Par téléphone</label><br>
                    <input id='reponsez' type='checkbox' checked><label for='reponsez'> Par message texte</label><br>
                </div>
                <hr>Pour les appels téléphoniques, veuillez nous indiquer les meilleures heures pour vous appeler.<br>
                <div class="dw3_box" style='width:150px;'><h3>Lundi</h3>
                    De:
                    <input id='reponse37' type="time" value="<?php echo $CIE_OPEN_J1_H1; ?>" style='width:auto;float:right;'>
                    <br>À:
                    <input id='reponse38' type="time" value="<?php echo $CIE_OPEN_J1_H2; ?>" style='width:auto;float:right;'>
                </div>
                <div class="dw3_box" style='width:150px;'><h3>Mardi</h3>
                    De:
                    <input id='reponse39' type="time" value="<?php echo $CIE_OPEN_J2_H1; ?>" style='width:auto;float:right;'>
                    <br>À:
                    <input id='reponse40' type="time" value="<?php echo $CIE_OPEN_J2_H2; ?>" style='width:auto;float:right;'>
                </div>
                <div class="dw3_box" style='width:150px;'><h3>Mercredi</h3>
                    De:
                    <input id='reponse41' type="time" value="<?php echo $CIE_OPEN_J3_H1; ?>" style='width:auto;float:right;'>
                    <br>À:
                    <input id='reponse42' type="time" value="<?php echo $CIE_OPEN_J3_H2; ?>" style='width:auto;float:right;'>
                </div>
                <div class="dw3_box" style='width:150px;'><h3>Jeudi</h3>
                    De:
                    <input id='reponse43' type="time" value="<?php echo $CIE_OPEN_J4_H1; ?>" style='width:auto;float:right;'>
                    <br>À:
                    <input id='reponse44' type="time" value="<?php echo $CIE_OPEN_J4_H2; ?>" style='width:auto;float:right;'>
                </div>
                <div class="dw3_box" style='width:150px;'><h3>Vendredi</h3>
                    De:
                    <input id='reponse45' type="time" value="<?php echo $CIE_OPEN_J5_H1; ?>" style='width:auto;float:right;'>
                    <br>À:
                    <input id='reponse46' type="time" value="<?php echo $CIE_OPEN_J5_H2; ?>" style='width:auto;float:right;'>
                </div>
                <div class="dw3_box" style='width:150px;'><h3>Samedi</h3>
                    De:
                    <input id='reponse47' type="time" value="<?php echo $CIE_OPEN_J6_H1; ?>" style='width:auto;float:right;'>
                    <br>À:
                    <input id='reponse48' type="time" value="<?php echo $CIE_OPEN_J6_H2; ?>" style='width:auto;float:right;'>
                </div>
                <div class="dw3_box" style='width:150px;margin-bottom:50px;'><h3>Dimanche</h3>
                    De:
                    <input id='reponse49' type="time" value="<?php echo $CIE_OPEN_J0_H1; ?>" style='width:auto;float:right;'>
                    <br>À:
                    <input id='reponse50' type="time" value="<?php echo $CIE_OPEN_J0_H2; ?>" style='width:auto;float:right;'>
                </div>  
                <br>       
                <br>       
                <br>
                <div style='width:100%;height:40px;'> </div>       
            </div>
        </div>
        <div id='quiz_page3' style='text-align:center;position:absolute;top:70px;left:100%;width:100%;bottom:0px;transition: left 1.2s ease-in-out;overflow:hidden;'>
            <div class='dw3_quiz_foot'>
                <button onmouseup="goto_page('2','3');" style='float:left;padding:8px 12px 6px 12px;'>
                    <span class='material-icons'>skip_previous</span> Retour
                </button>
                <div style='display:inline-block;vertical-align:center;box-shadow:inset 0px 0px 3px 3px rgba(255,255,255,0.3);border-radius:15px;font-size:24px;padding:6px;'>4/4</div>	
                <button id='btnaddRDV' onclick='sendQuotation();' style='float:right;padding:8px 12px 6px 12px;border:1px solid #eee;background-color:#2573DE;color:white;'>
                    <span class='material-icons'>event_available</span> Envoyer
                </button>
            </div>	
            <div class='dw3_page' style='padding:20px 0px;text-align:middle;background-color:rgba(255,255,255,0.7);min-height:90vh;max-height:90vh;overflow-x:hidden;overflow-y:auto;'>
                <div class='dw3_paragraf'><h3>Veuillez entrer les informations pour vous contacter</h3><br>
                    <table style='width:100%;border-spacing: 0px;'>
                        <tr><td width='35' style='padding:5px;border-bottom:1px solid #ddd;'><span class='material-icons' style='font-size:25px;color:#444;'>person_outline</span></td>
                                <td width='*' style='padding:5px;border-bottom:1px solid #ddd;'><input style='width:100%;border:0px;padding:10px;' type='text' id='txtSUBMIT_NOM' placeHolder='Prénom*' onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></td></tr>
                        <tr><td width='35' style='padding:5px;border-bottom:1px solid #ddd;'></td>
                                <td width='*' style='padding:5px;border-bottom:1px solid #ddd;'><input style='width:100%;border:0px;padding:10px;' type='text' id='txtSUBMIT_NOM' placeHolder='Nom*' onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></td></tr>
                        <tr><td width='35' style='padding:5px;border-bottom:1px solid #ddd;'><span class='material-icons' style='font-size:25px;color:#444;'>store</span></td>
                                <td width='*' style='padding:5px;border-bottom:1px solid #ddd;'><input style='width:100%;border:0px;padding:10px;' type='text' id='txtSUBMIT_NOM' placeHolder='Nom de la compagnie' onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></td></tr>
                        <tr><td width='35' style='padding:5px;border-bottom:1px solid #ddd;'></td>
                                <td width='*' style='padding:5px;border-bottom:1px solid #ddd;'><input style='width:100%;border:0px;padding:10px;' type='text' id='txtSUBMIT_NOM' placeHolder='Poste / Occupation' onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></td></tr>
                        <tr><td width='35' style='padding:5px;border-bottom:1px solid #ddd;'><span class='material-icons' style='font-size:25px;color:#444;'>mail</span></td>
                                <td width='*' style='padding:5px;border-bottom:1px solid #ddd;'><input style='width:100%;border:0px;padding:10px;' type='text' id='txtSUBMIT_EMAIL' placeHolder='Courriel*' onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></td></tr>
                        <tr><td width='35' style='padding:5px;border-bottom:1px solid #ddd;'><span class='material-icons' style='font-size:25px;color:#444;'>phone</span></td>
                                <td width='*' style='padding:5px;border-bottom:1px solid #ddd;'><input style='width:100%;border:0px;padding:10px;' type='text' id='txtSUBMIT_TEL' placeHolder='Téléphone' onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></td></tr>
                    </table><br>
                    <div style='width:30px;vertical-align:middle;display:inline-block;'>
                        <input id='reponsezz' checked type='checkbox' style='margin:5px;'>
                    </div>
                    <label for='reponsezz'>M'envoyer une copie du formulaire à mon adresse courriel.</label>
                    <br>
                    <div style='width:30px;vertical-align:middle;display:inline-block;'>
                        <input id='chkROBOT' checked name='chkROBOT' type='checkbox' style='margin:5px;'>
                    </div>
                    <label for='chkROBOT'>Je ne suis pas un robot et j'accepte la </label><a href='/legal/PRIVACY' target='_blank'>politique de confidentialité</a> et les <a href='/legal/CONDITION' target='_blank'>conditions d'utilisations</a>.<br>                    
                </div>
            </div>
        </div>
    </div>

<script>
let today = new Date();

$(document).ready(function (){
    document.getElementById("dw3_body").innerHTML = "";
    dw3_msg_open("<br>En développement!");

});

function goto_page(page,from){
    //let xw = document.getElementById("divSUBMIT").offsetWidth;parent.innerWidth
    //let xw= window.innerWidth;
    let xw = document.getElementById("quiz_page1").offsetWidth;
	if (page=="0"){
		document.getElementById("quiz_page0").style.left = "0px";
		document.getElementById("quiz_page1").style.left = xw + "px";
		document.getElementById("quiz_page2").style.left = xw + "px";
		document.getElementById("quiz_page3").style.left = xw + "px";
    }else if(page=="1") {
		document.getElementById("quiz_page0").style.left = "-" + xw + "px";
		document.getElementById("quiz_page1").style.left = "0px";
		document.getElementById("quiz_page2").style.left = xw + "px";  
		document.getElementById("quiz_page3").style.left = xw + "px";  
    }else if(page=="2") {
		document.getElementById("quiz_page0").style.left = "-" + xw + "px";
		document.getElementById("quiz_page1").style.left = "-" + xw + "px";
		document.getElementById("quiz_page2").style.left = "0px";
		document.getElementById("quiz_page3").style.left = xw + "px";  
    }else if(page=="3") {
		document.getElementById("quiz_page0").style.left = "-" + xw + "px";
        document.getElementById("quiz_page1").style.left = "-"+xw + "px";
		document.getElementById("quiz_page2").style.left = "-"+xw + "px";
		document.getElementById("quiz_page3").style.left = "0px";
    }
}


function sendQuotation(){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        //
	};
    }   
		xmlhttp.open('GET', 'email_info.php'
                                        + '?S=' + encodeURIComponent(summary)  
										+ '&U=' + encodeURIComponent(user_id)
										+ '&D=' + encodeURIComponent(description)
										+ '&F=' + encodeURIComponent(date_from)    
										+ '&L=' + encodeURIComponent(location)    
										+ '&T=' + encodeURIComponent(date_to),    
										true);
		xmlhttp.send();
  
}

</script>
</body>
</html>
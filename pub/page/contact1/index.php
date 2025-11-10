  <?php 
 require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/loader.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . $INDEX_HEADER;
 require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/common_div.php';
 ?>

 <div class='dw3_paragraf'>
    <h2>Contactez-nous</h2>
    <br><span style='color:#888;'>Nous sommes là pour vous aider et répondre à toutes vos questions.</span>
    <br><br>
    <span class='material-icons' style='font-size:20px;color:#f17144;vertical-align:middle;'>phone</span> Téléphone<br>
    &#160;&#160;&#160;&#160;&#160;&#160;<span style='color:#888;'><?php echo $CIE_TEL1; ?></span><br><br>
    <span class='material-icons' style='font-size:20px;color:#f17144;vertical-align:middle;'>fax</span> Sans frais<br>
    &#160;&#160;&#160;&#160;&#160;&#160;<span style='color:#888;'><?php echo $CIE_TEL2; ?></span><br><br>
    <span class='material-icons' style='font-size:20px;color:#f17144;vertical-align:middle;'>mail</span> Courriel<br>
    &#160;&#160;&#160;&#160;&#160;&#160;<span style='color:#888;'><?php echo $CIE_EML1; ?></span><br><br>
    <span class='material-icons' style='font-size:20px;color:#f17144;vertical-align:middle;'>place</span> Adresse<br>
    &#160;&#160;&#160;&#160;&#160;&#160;<span style='color:#888;'><?php echo $CIE_ADR; ?></span><br><br>
    <span class='material-icons' style='font-size:20px;color:#f17144;vertical-align:middle;'>schedule</span> Heures d'ouvertures<br>
    &#160;&#160;&#160;&#160;&#160;&#160;<span style='color:#888;'>Du Lundi au Dimanche: 09:00H – 17:00H</span><br><br>
</div>
    
<script>
<?php 
     require_once $_SERVER['DOCUMENT_ROOT'] . "/pub/page/page.js.php";
?>
</script>
</body>
</html>

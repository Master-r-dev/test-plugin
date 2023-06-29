<?php
/* Template Name: Archive Page Stocks */

get_header(); ?>
 
<div class="clear"></div>
</header> 
 
<div id="content" class="site-content">
 
<div class="container">
 
  <div class="content-left-wrap col-md-9">
    <div id="primary" class="content-area">
      <main id="main" class="site-main" role="main">
	  <form>
		<input type="text" size="30" onkeyup="showResult(this.value)">
		<div id="livesearch"></div>
	  </form>
	    <?php 
		  	if ( file_exists(dirname(__FILE__) . '/content-tmpl_archives.php')  ) {        		      
				include_once( dirname(__FILE__) . '/content-tmpl_archives.php' );				
			} else {
				echo '<div >Missing archive template file!</div>';
			} 
		?>
 
      </main>
    </div>
  </div>
  
  <script>
function showResult(str) {
  if (str.length==0) {
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
	  text=JSON.parse(this.responseText); 
	  for (let x in text){
		document.getElementById("livesearch").innerHTML+=text[x]['post_name']+'   |   ';
	  }      
      document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("POST",ajaxurl+"?action=get_stock&search="+str,true);
  xmlhttp.send();
}
</script>
</div>

<?php get_footer(); ?>
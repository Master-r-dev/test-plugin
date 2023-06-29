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
	    <?php  			 
			$args = array(
				'post_type' => 'al_stocks',
				'name' => get_query_var( 'al_stocks', '' ),
				'post_status' => 'publish',
    			'posts_per_page' => 1
			);
			$my_query = new WP_Query($args);  
		  	if ( $my_query->have_posts()) : $my_query->the_post();   ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
				<header class="entry-header">
					<h1 class="entry-title"><?php echo get_the_title($my_query->post->ID); ?></h1>
				</header> 
				
				<div class="entry-content">
					<?php the_content(); echo '<br/>';?> 
					<?php  if (get_post_meta(get_the_ID(), 'price', true)=='' )  echo 'price: none'; else echo 'price: '.get_post_meta(get_the_ID(), 'price', true) ; ?>
					|
					<a class="stock_option" data-t="<?php echo get_the_title($my_query->post->ID); ?>"></a>
					<span id="loading" style="display:none">Loading...</span>
					<ul id="result"></ul>
					<div style="clear: both; margin-bottom: 30px;"></div>
				
				</div> 
				
				</article> 

			<?php else :?>
			<div >Stock doesnt exist</div>
			<?php endif;?> 	

      </main> 
    </div> 
  </div>
  
<script>
function add_data(text,t){ 
		let li, ul = document.getElementById("result") ;  
		text=JSON.parse(text);
		if (t==1) {
			for ( let x of text['data']){
				li = document.createElement("li");
				li.appendChild(document.createTextNode(x['breed'] +' | '+ x['country']));
				ul.appendChild(li); 
			}
			
		}
		else if (t==2) {
			li = document.createElement("li");
			li.appendChild(document.createTextNode(text['fact']));
			ul.appendChild(li); 
		}
		else {
			for ( let x in text['data']){
				li = document.createElement("li");
				li.appendChild(document.createTextNode(text['data'][x]['fact']));
				ul.appendChild(li);
			}
		}	
		document.getElementById("loading").style.display='none'	
}

function data_fetch(t=1) {
	document.getElementById("loading").style.display='block'
	let req = new XMLHttpRequest();
	req.addEventListener("load",
		function(){
			add_data(this.responseText,t)
		} 
	);
	if (t==1){
		//get breeds
		req.open("GET", "https://catfact.ninja/breeds"); 
	} else if (t==2){
		//get fact
		req.open("GET", "https://catfact.ninja/fact"); 
	} else {
		//get facts
		req.open("GET", "https://catfact.ninja/facts"); 
	}
	req.setRequestHeader('X-CSRF-TOKEN',  'DmJKUBSx1sw9sT7XduqiQHszZEOIRpdNsLAbGwjT'); 
	req.send();
}

let links = document.getElementsByClassName('stock_option')
for (i = 0; i < links.length; i++) {
    if (links[i].getAttribute('data-t').length < 12) {
		links[i].innerHTML='get breeds'
		links[i].addEventListener("click", ()=>data_fetch(1), false);
	}
	else if (links[i].getAttribute('data-t').length < 15) {
		links[i].innerHTML='get fact'
		links[i].addEventListener("click", ()=>data_fetch(2), false);
	}
	else {
		links[i].innerHTML='get facts'
		links[i].addEventListener("click", ()=>data_fetch(3), false);
	}
}
</script>
</div> 

<?php get_footer(); ?>

/**
 * Copyright (c) 2016 Gian MR
 * Gian MR Theme Custom Javascript
 *
 * @package Muvipro
 */

function muvipro_loadTabContent( tab_name, post_id ) {
	var container   = document.getElementById( 'muvipro_player_content_id' );
	if ( container ) {
		var tabc = container.querySelector( '#' + tab_name );

		if( tabc ) {
			/* only load content if it wasn't already loaded. */
			var isLoaded = tabc.getAttribute( 'data-loaded' );
			if ( ! isLoaded ) {
				if ( ! container.classList.contains( 'muvipro-player-loading' ) ) {
					container.classList.add( 'muvipro-player-loading' );
					var xhttp = new XMLHttpRequest();

					xhttp.onreadystatechange = function() {
						if ( this.readyState == 4 && this.status == 200 ) {
							tabc.innerHTML = this.responseText;
							container.classList.remove( 'muvipro-player-loading' );
							tabc.setAttribute( 'data-loaded', '1' );
						}
					};
					
					xhttp.open( 'POST', mvpp.ajax_url, true );
					xhttp.setRequestHeader( "Content-type", "application/x-www-form-urlencoded; charset=UTF-8" );
					xhttp.send( 'action=muvipro_player_content&tab=' + tab_name + '&post_id=' + post_id );
				}
			}
		}
	}
}

document.addEventListener('DOMContentLoaded', function() {
	var elemt = document.getElementById( 'muvipro_player_content_id' );
	if ( elemt ) {
		var post_id = elemt.getAttribute( 'data-id' );

		/* load tab content on click */
		var btn = elemt.querySelectorAll( 'ul.muvipro-player-tabs > li' );
		function clicktab( e ) {
			if( btn ) {
				for( var i = 0; i<btn.length; i++ ){
					btn[i].classList.remove("selected");
				}
			}
			var clickedTab = e.currentTarget;
			clickedTab.classList.add("selected");
			e.preventDefault();
			var tabContent = document.querySelectorAll( ".tab-content-ajax" );
			for (i = 0; i < tabContent.length; i++) {
				tabContent[i].classList.remove( "selected" );
			}
			var anchorReference = e.target;
			/* console.log (anchorReference); */
			var activePaneId = anchorReference.getAttribute( "href" );
			var activePane = document.querySelector( activePaneId );
			activePane.classList.add("selected");
			var tab_name = activePaneId.replace('#','');
			muvipro_loadTabContent( tab_name, post_id );
		}
		for (i = 0; i < btn.length; i++) {
			btn[i].addEventListener("click", clicktab);
		}
		var firstbtn = document.querySelector( 'ul.muvipro-player-tabs > li > a' );	
		firstbtn.click();
	};
});

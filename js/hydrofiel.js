/**
 * Function to hide all additional registrations.
 */
function hideAll(){
	document.querySelectorAll('.inschrijving').forEach( registration => registration.classList.add('d-none'));
	document.getElementById('showAll').classList.remove('d-none');
	document.getElementById('hideAll').classList.add('d-none');
}

/**
 * Function to show all registrations.
 */
function showAll(){
	document.querySelectorAll('.inschrijving').forEach( registration => registration.classList.remove('d-none'));
	document.getElementById('showAll').classList.add('d-none');
	document.getElementById('hideAll').classList.remove('d-none');
}

function toggleInschrijf(val){
	if (val==="1") {
		$('#registrationDeadline').toggleClass('d-none', false);
		$('#cancellationDeadline').toggleClass('d-none', false);
	}
	else {
		$('#cancellationDeadline').toggleClass('d-none', true);
		$('#registrationDeadline').toggleClass('d-none', true);
	}
}

jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });

    $("img").each(function(){
        $(this).addClass("img-fluid");
	});
	
	$("#info").click( () => window.location = "/" );
});

$(document).on('click',function(){
	$('.navbar-collapse').collapse('hide');
});

const pressed = [];
const secret = [ "ArrowUp", "ArrowUp", "ArrowDown", "ArrowDown", "ArrowLeft", "ArrowRight", "ArrowLeft", "ArrowRight" ];
let cornifyLoaded = false;

function magic(){
	document.documentElement.style.setProperty('--background-color', 'magenta' );
	document.documentElement.style.setProperty('--primary-color', '#982cd5');
	document.documentElement.style.setProperty('--footer-color', 'pink' );
	if ( cornifyLoaded ) cornify_add();
}

window.addEventListener('keyup', e => {
	pressed.push( e.key );
	pressed.splice( -secret.length - 1, pressed.length - secret.length );
	if ( pressed.join("").includes( secret.join("") ) ){
		if ( ! cornifyLoaded ){
			const script = document.createElement('script');
			script.onload = () => {
				cornifyLoaded = true;
				magic();
			}
			script.src = "https://www.cornify.com/js/cornify.js";
			document.head.appendChild(script);
		}
		magic();
	}
} );

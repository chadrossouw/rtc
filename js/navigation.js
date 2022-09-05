/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
	/*setDocHeight();
	if(window.innerWidth>=1200){
		window.addEventListener('resize', setDocHeight);
	}
	window.addEventListener('orientationchange', setDocHeight);
	*/
	
	const siteNavigation = document.getElementById( 'site-navigation' );
	const buttonHamburger = document.getElementById( 'hamburger' );
	const navLinks = siteNavigation.querySelectorAll('li a');
	// Toggle the .toggled class and the aria-expanded value each time the button is clicked.
	buttonHamburger.addEventListener( 'click', toggleMenu );

	// Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
	document.addEventListener( 'click', function( event ) {
		const isClickInside = siteNavigation.contains( event.target );
		if ( ! isClickInside ) {
			closeMenu();
		}
	} );

	navLinks.forEach(link=>link.addEventListener('click',()=>{
		closeMenu();
	}))
	const headerwrap = document.querySelector('.site-header');
	var lastScrollTop = 0;

	document.addEventListener("scroll", headerslide);

	function headerslide(){
		let st = window.pageYOffset || document.documentElement.scrollTop;
		if ( st >= 100 && st <= 300) {
			headerwrap.classList.add("addFixed");
			headerwrap.classList.remove("slideInDown", "slideOut");
		} 
		else if( st > 300 && st <= 600){
			headerwrap.classList.add("slideOut");
			if( st<lastScrollTop){
				headerwrap.classList.remove("slideInDown");
			}
		}
		else if (st > 600 && st<lastScrollTop){
			headerwrap.classList.add("slideOut","slideInDown");
		}
		else if (st > 600 && st>lastScrollTop){
			headerwrap.classList.remove("slideInDown");
		}
		else {
			headerwrap.classList.remove("slideInDown","slideOut","addFixed");
		}
		lastScrollTop = st;
	}
	


	function toggleMenu(){
		siteNavigation.classList.toggle( 'toggled' );
		buttonHamburger.classList.toggle('is-active');
		document.documentElement.classList.toggle('scroll_lock');
		if ( buttonHamburger.getAttribute( 'aria-expanded' ) === 'true' ) {
			buttonHamburger.setAttribute( 'aria-expanded', 'false' );
		} else {
			buttonHamburger.setAttribute( 'aria-expanded', 'true' );
		}
	}

	function closeMenu(){
		siteNavigation.classList.remove( 'toggled' );
		buttonHamburger.classList.remove('is-active');
		buttonHamburger.setAttribute( 'aria-expanded', 'false' );
		document.documentElement.classList.remove('scroll_lock');
	}

	

	/*Details*/
	class Accordion {
		constructor(el) {
		  // Store the <details> element
		  this.el = el;
		  // Store the <summary> element
		  this.summary = el.querySelector('summary');
		  // Store the <div class="content"> element
		  this.content = el.querySelector('.details-text');
	  
		  // Store the animation object (so we can cancel it if needed)
		  this.animation = null;
		  // Store if the element is closing
		  this.isClosing = false;
		  // Store if the element is expanding
		  this.isExpanding = false;
		  // Detect user clicks on the summary element
		  this.summary.addEventListener('click', (e) => this.onClick(e));
		}
	  
		onClick(e) {
		  // Stop default behaviour from the browser
		  e.preventDefault();
		  // Add an overflow on the <details> to avoid content overflowing
		  this.el.style.overflow = 'hidden';
		  // Check if the element is being closed or is already closed
		  if (this.isClosing || !this.el.open) {
			this.open();
		  // Check if the element is being openned or is already open
		  } else if (this.isExpanding || this.el.open) {
			this.shrink();
		  }
		}
	  
		shrink() {
		  // Set the element as "being closed"
		  this.isClosing = true;
		  
		  // Store the current height of the element
		  const startHeight = `${this.el.offsetHeight}px`;
		  // Calculate the height of the summary
		  const endHeight = `${this.summary.offsetHeight}px`;
		  
		  // If there is already an animation running
		  if (this.animation) {
			// Cancel the current animation
			this.animation.cancel();
		  }
		  
		  // Start a WAAPI animation
		  this.animation = this.el.animate({
			// Set the keyframes from the startHeight to endHeight
			height: [startHeight, endHeight]
		  }, {
			duration: 400,
			easing: 'ease-out'
		  });
		  
		  // When the animation is complete, call onAnimationFinish()
		  this.animation.onfinish = () => this.onAnimationFinish(false);
		  // If the animation is cancelled, isClosing variable is set to false
		  this.animation.oncancel = () => this.isClosing = false;
		}
	  
		open() {
		  // Apply a fixed height on the element
		  this.el.style.height = `${this.el.offsetHeight}px`;
		  // Force the [open] attribute on the details element
		  this.el.open = true;
		  // Wait for the next frame to call the expand function
		  window.requestAnimationFrame(() => this.expand());
		}
	  
		expand() {
		  // Set the element as "being expanding"
		  this.isExpanding = true;
		  // Get the current fixed height of the element
		  const startHeight = `${this.el.offsetHeight}px`;
		  // Calculate the open height of the element (summary height + content height)
		  const endHeight = `${this.summary.offsetHeight + this.content.offsetHeight}px`;
		  
		  // If there is already an animation running
		  if (this.animation) {
			// Cancel the current animation
			this.animation.cancel();
		  }
		  
		  // Start a WAAPI animation
		  this.animation = this.el.animate({
			// Set the keyframes from the startHeight to endHeight
			height: [startHeight, endHeight]
		  }, {
			duration: 400,
			easing: 'ease-out'
		  });
		  // When the animation is complete, call onAnimationFinish()
		  this.animation.onfinish = () => this.onAnimationFinish(true);
		  // If the animation is cancelled, isExpanding variable is set to false
		  this.animation.oncancel = () => this.isExpanding = false;
		}
	  
		onAnimationFinish(open) {
		  // Set the open attribute based on the parameter
		  this.el.open = open;
		  // Clear the stored animation
		  this.animation = null;
		  // Reset isClosing & isExpanding
		  this.isClosing = false;
		  this.isExpanding = false;
		  // Remove the overflow hidden and the fixed height
		  this.el.style.height = this.el.style.overflow = '';
		}
	  }
	  
	  document.querySelectorAll('details').forEach((el) => {
		new Accordion(el);
	  });


	  let couponToggle = document.querySelector('.woocommerce-form-coupon-toggle');
	  if(couponToggle){
		couponToggle.setAttribute('tabindex',0);
		couponToggle.addEventListener('click',e=>{
			if(e.currentTarget.nextElementSibling.style.display=='none'){
				e.currentTarget.nextElementSibling.style.display='block';
			}
			else{
				e.currentTarget.nextElementSibling.style.display='none';
			}
		})
	  }
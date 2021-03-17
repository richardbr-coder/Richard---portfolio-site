
(function($) {

	var	$window = $(window),
		$body = $('body'),
		$wrapper = $('#wrapper'),
		$header = $('#header'),
		$footer = $('#footer'),
		$main = $('#main'),
		$main_articles = $main.children('article');

	// Breakpoints.
		breakpoints({
			xlarge:   [ '1281px',  '1680px' ],
			large:    [ '981px',   '1280px' ],
			medium:   [ '737px',   '980px'  ],
			small:    [ '481px',   '736px'  ],
			xsmall:   [ '361px',   '480px'  ],
			xxsmall:  [ null,      '360px'  ]
		});

	// Play initial animations on page load.
		$window.on('load', function() {
			window.setTimeout(function() {
				$body.removeClass('is-preload');
			}, 100);
		});

	// Fix: Flexbox min-height bug on IE.
		if (browser.name == 'ie') {

			var flexboxFixTimeoutId;

			$window.on('resize.flexbox-fix', function() {

				clearTimeout(flexboxFixTimeoutId);

				flexboxFixTimeoutId = setTimeout(function() {

					if ($wrapper.prop('scrollHeight') > $window.height())
						$wrapper.css('height', 'auto');
					else
						$wrapper.css('height', '100vh');

				}, 250);

			}).triggerHandler('resize.flexbox-fix');

		}

	// Nav.
		var $nav = $header.children('nav'),
			$nav_li = $nav.find('li');

		// Add "middle" alignment classes if we're dealing with an even number of items.
			if ($nav_li.length % 2 == 0) {

				$nav.addClass('use-middle');
				$nav_li.eq( ($nav_li.length / 2) ).addClass('is-middle');

			}

	// Main.
		var	delay = 325,
			locked = false;

		// Methods.
			$main._show = function(id, initial) {

				var $article = $main_articles.filter('#' + id);

				// No such article? Bail.
					if ($article.length == 0)
						return;

				// Handle lock.

					// Already locked? Speed through "show" steps w/o delays.
						if (locked || (typeof initial != 'undefined' && initial === true)) {

							// Mark as switching.
								$body.addClass('is-switching');

							// Mark as visible.
								$body.addClass('is-article-visible');

							// Deactivate all articles (just in case one's already active).
								$main_articles.removeClass('active');

							// Hide header, footer.
								$header.hide();
								$footer.hide();

							// Show main, article.
								$main.show();
								$article.show();

							// Activate article.
								$article.addClass('active');

							// Unlock.
								locked = false;

							// Unmark as switching.
								setTimeout(function() {
									$body.removeClass('is-switching');
								}, (initial ? 1000 : 0));

							return;

						}

					// Lock.
						locked = true;

				// Article already visible? Just swap articles.
					if ($body.hasClass('is-article-visible')) {

						// Deactivate current article.
							var $currentArticle = $main_articles.filter('.active');

							$currentArticle.removeClass('active');

						// Show article.
							setTimeout(function() {

								// Hide current article.
									$currentArticle.hide();

								// Show article.
									$article.show();

								// Activate article.
									setTimeout(function() {

										$article.addClass('active');

										// Window stuff.
											$window
												.scrollTop(0)
												.triggerHandler('resize.flexbox-fix');

										// Unlock.
											setTimeout(function() {
												locked = false;
											}, delay);

									}, 25);

							}, delay);

					}

				// Otherwise, handle as normal.
					else {

						// Mark as visible.
							$body
								.addClass('is-article-visible');

						// Show article.
							setTimeout(function() {

								// Hide header, footer.
									$header.hide();
									$footer.hide();

								// Show main, article.
									$main.show();
									$article.show();

								// Activate article.
									setTimeout(function() {

										$article.addClass('active');

										// Window stuff.
											$window
												.scrollTop(0)
												.triggerHandler('resize.flexbox-fix');

										// Unlock.
											setTimeout(function() {
												locked = false;
											}, delay);

									}, 25);

							}, delay);

					}

			};

			$main._hide = function(addState) {

				var $article = $main_articles.filter('.active');

				// Article not visible? Bail.
					if (!$body.hasClass('is-article-visible'))
						return;

				// Add state?
					if (typeof addState != 'undefined'
					&&	addState === true)
						history.pushState(null, null, '#');

				// Handle lock.

					// Already locked? Speed through "hide" steps w/o delays.
						if (locked) {

							// Mark as switching.
								$body.addClass('is-switching');

							// Deactivate article.
								$article.removeClass('active');

							// Hide article, main.
								$article.hide();
								$main.hide();

							// Show footer, header.
								$footer.show();
								$header.show();

							// Unmark as visible.
								$body.removeClass('is-article-visible');

							// Unlock.
								locked = false;

							// Unmark as switching.
								$body.removeClass('is-switching');

							// Window stuff.
								$window
									.scrollTop(0)
									.triggerHandler('resize.flexbox-fix');

							return;

						}

					// Lock.
						locked = true;

				// Deactivate article.
					$article.removeClass('active');

				// Hide article.
					setTimeout(function() {

						// Hide article, main.
							$article.hide();
							$main.hide();

						// Show footer, header.
							$footer.show();
							$header.show();

						// Unmark as visible.
							setTimeout(function() {

								$body.removeClass('is-article-visible');

								// Window stuff.
									$window
										.scrollTop(0)
										.triggerHandler('resize.flexbox-fix');

								// Unlock.
									setTimeout(function() {
										locked = false;
									}, delay);

							}, 25);

					}, delay);


			};

		// Articles.
			$main_articles.each(function() {

				var $this = $(this);

				// Close.
					$('<div class="close">Close</div>')
						.appendTo($this)
						.on('click', function() {
							location.hash = '';
						});

				// Prevent clicks from inside article from bubbling.
					$this.on('click', function(event) {
						event.stopPropagation();
					});

			});

		// Events.
			$body.on('click', function(event) {

				// Article visible? Hide.
					if ($body.hasClass('is-article-visible'))
						$main._hide(true);

			});

			$window.on('keyup', function(event) {

				switch (event.keyCode) {

					case 27:

						// Article visible? Hide.
							if ($body.hasClass('is-article-visible'))
								$main._hide(true);

						break;

					default:
						break;

				}

			});

			$window.on('hashchange', function(event) {

				// Empty hash?
					if (location.hash == ''
					||	location.hash == '#') {

						// Prevent default.
							event.preventDefault();
							event.stopPropagation();

						// Hide.
							$main._hide();

					}

				// Otherwise, check for a matching article.
					else if ($main_articles.filter(location.hash).length > 0) {

						// Prevent default.
							event.preventDefault();
							event.stopPropagation();

						// Show article.
							$main._show(location.hash.substr(1));

					}

			});

		// Scroll restoration.
		// This prevents the page from scrolling back to the top on a hashchange.
			if ('scrollRestoration' in history)
				history.scrollRestoration = 'manual';
			else {

				var	oldScrollPos = 0,
					scrollPos = 0,
					$htmlbody = $('html,body');

				$window
					.on('scroll', function() {

						oldScrollPos = scrollPos;
						scrollPos = $htmlbody.scrollTop();

					})
					.on('hashchange', function() {
						$window.scrollTop(oldScrollPos);
					});

			}

		// Initialize.

			// Hide main, articles.
				$main.hide();
				$main_articles.hide();

			// Initial article.
				if (location.hash != ''
				&&	location.hash != '#')
					$window.on('load', function() {
						$main._show(location.hash.substr(1), true);
					});

})(jQuery);









//I am a developer typing
const typedTextSpan = document.querySelector(".typed-text");
const cursorSpan = document.querySelector(".cursor");

const textArray = [
  "Developer",
  "Designer",
  "Programmer",
  "Musician",
  "Astronomer",
  "Photographer",
  "Drone Pilot",
  "Husband",
  "Dad",
];
const typingDelay = 150;
const erasingDelay = 100;
const newTextDelay = 1000; // Delay between current and next text
let textArrayIndex = 0;
let charIndex = 0;

function type() {
  if (charIndex < textArray[textArrayIndex].length) {
    if (!cursorSpan.classList.contains("typing"))
      cursorSpan.classList.add("typing");
    typedTextSpan.textContent += textArray[textArrayIndex].charAt(charIndex);
    charIndex++;
    setTimeout(type, typingDelay);
  } else {
    cursorSpan.classList.remove("typing");
    setTimeout(erase, newTextDelay);
  }
}

function erase() {
  if (charIndex > 0) {
    if (!cursorSpan.classList.contains("typing"))
      cursorSpan.classList.add("typing");
    typedTextSpan.textContent = textArray[textArrayIndex].substring(
      0,
      charIndex - 1
    );
    charIndex--;
    setTimeout(erase, erasingDelay);
  } else {
    cursorSpan.classList.remove("typing");
    textArrayIndex++;
    if (textArrayIndex >= textArray.length) textArrayIndex = 0;
    setTimeout(type, typingDelay + 1100);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  // On DOM Load initiate the effect
  if (textArray.length) setTimeout(type, newTextDelay + 250);
});

$(document).ready(documentReady);

function documentReady() {
  var characterCollection = [
    "A",
    "B",
    "C",
    "D",
    "E",
    "F",
    "G",
    "H",
    "I",
    "J",
    "K",
    "L",
    "M",
    "N",
    "O",
    "P",
    "R",
    "S",
    "T",
    "U",
    "V",
    "Y",
    "Z",
  ];

  var currentText = $(".effect-text-container h1").text();

  var currentTextCollection = new Array();

  var characterCount = 0;

  var characterSpeed = 500;

  pushCurrentTextChrachters();

  function pushCurrentTextChrachters() {
    for (var i = 0; i < currentText.length; i++) {
      var currentCharacter = currentText.slice(i, i + 1);

      currentTextCollection.push(currentCharacter);
    }
  }

  var characterCountIncreaseInterval = setInterval(
    characterCountIncrease,
    characterSpeed
  );

  function characterCountIncrease() {
    if (characterCount == currentTextCollection.length) {
      clearInterval(characterCountIncreaseInterval);

      clearInterval(setRandomTextInterval);
    }

    characterCount++;
  }

  function getRandomText() {
    var result = "";

    if (characterCount == 0) {
      for (var i = 0; i < currentTextCollection.length; i++) {
        var randomCharacter =
          characterCollection[
            Math.floor(Math.random() * characterCollection.length)
          ];

        result += randomCharacter;
      }
    } else {
      result = currentText.slice(0, characterCount);

      for (var i = 0; i < currentTextCollection.length - characterCount; i++) {
        var randomCharacter =
          characterCollection[
            Math.floor(Math.random() * characterCollection.length)
          ];

        result += randomCharacter;
      }
    }

    return result;
  }

  var setRandomTextInterval = setInterval(setRandomText, 50);

  function setRandomText() {
    console.log(getRandomText());

    $(".effect-text-container h1").text(getRandomText());
  }
}
























//The bars in the skills section
var skills = {
	ht: 75,
	jq: 55,
	sk: 95,
	ph: 75,
	il: 90,
	in: 85,
	fl: 80,
	ex: 65,
	da: 40,
	ma: 100
  };
  
  $.each(skills, function (key, value) {
	var skillbar = $("." + key);
  
	skillbar.animate(
	  {
		width: value + "%"
	  },
	  3000,
	  function () {
		$(".speech-bubble").fadeIn();
	  }
	);
  });
  
  


  /* Demo purposes only */
$(".hover").mouseleave(
	function() {
	  $(this).removeClass("hover");
	}
  );









//interest circles in meet me
  let rid = null;
  const spring = 0.09;
  const friction = 0.8;
  let divs = Array.from(document.querySelectorAll(".innerdiv"));
  
  class Chart {
	constructor(path, text, target) {
	  this.path = path;
	  this.text = text;
	  this.text.textContent = target + "%";
	  this.R = 10;
	  this.start = .01;
	  this.divisions = 100;
	  this.vel = 0;
	  this.stylePath(target);
	}
  
	stylePath(target) {
	  let d = `M${this.R},0  A${this.R},${this.R} 0 1,1 ${this.R},-.01z`;
	  this.path.setAttributeNS(null, "d", d);
	  this.pathLength = this.path.getTotalLength();
	  this.unit = this.pathLength / this.divisions;
	  this.strokeLength = this.start * this.unit;
	  this.target = target * this.unit;
	  this.path.style.strokeDasharray = `${this.strokeLength},${this.pathLength -
	  this.strokeLength}`;
	}
  
	updateStrokeLength() {
	  this.dist = this.target - this.strokeLength;
	  this.acc = this.dist * spring;
	  this.vel += this.acc;
	  this.vel *= friction;
	  this.strokeLength += this.vel;
	  this.path.style.strokeDasharray = `${this.strokeLength},${this.pathLength -
	  this.strokeLength}`;
	}}
  
  
  let charts = [];
  
  //Adjust the percentages in the circles in the interest section
  charts.push(new Chart(aPath, aText, 100));
  charts.push(new Chart(bPath, bText,85));
  charts.push(new Chart(gPath, gText, 95));
  
  function Frame() {
	rid = window.requestAnimationFrame(Frame);
	charts.map(c => c.updateStrokeLength());
  }
  Frame();
  
  divs.map(div => {
	div.addEventListener("input", function () {
	  charts.map(c => {
		if (isNaN(parseInt(c.text.textContent))) {c.text.textContent = 0 + "%";}
		if (parseInt(c.text.textContent) > 100) {c.text.textContent = 100 + "%";}
		if (rid) {window.cancelAnimationFrame(rid);}
		c.target = (parseInt(c.text.textContent) || 0) * c.unit;
		if (!c.text.textContent.match("%"))
		{c.text.textContent += "%";}
		Frame();
	  });
	});
  });
  
  






  






//   //script to set display property
         
//             img = document.getElementById("pic2"); 
//             // Function to increase image size 
//       function enlargeImg() { 
//         // Set image size to 1.5 times original 
//         img.style.transform = "scale(1.5)"; 
//         // Animation effect  
//         img.style.transition = "transform 0.25s ease"; 
//       } 
//       // Function to reset image size 
//       function resetImg() { 
//         // Set image size to original 
//         img.style.transform = "scale(1)"; 
//         img.style.transition = "transform 0.25s ease"; 
//       } 
    





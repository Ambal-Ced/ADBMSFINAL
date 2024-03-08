// Function to navigate back to home.html and scroll to a specific section
function navigateBack(sectionId) {
		window.location.href = 'Home.html#' + sectionId;
}

// Functions to handle navigation from account.html
function back1() {
		navigateBack('Home-section');
}

function back2() {
		navigateBack('products-section');
}

function back3() {
		navigateBack('downloadsect');
}

function back4() {
		navigateBack('aboutus');
}

// Existing code for handling menu button clicks and smooth scrolling
const header = document.querySelector("header");
const menuBtn = document.querySelector("#menu-btn");
const closeMenuBtn = document.querySelector("#close-menu-btn");

menuBtn.addEventListener("click", () => {
		header.classList.toggle("show-mobile-menu");
});

closeMenuBtn.addEventListener("click", () => {
		menuBtn.click();
});

document.querySelectorAll('.menulinks a').forEach(link => {
		link.addEventListener('click', function(event) {
				event.preventDefault();
				const targetId = this.getAttribute('href');
				const targetElement = document.querySelector(targetId);
				if (targetElement) {
						targetElement.scrollIntoView({ behavior: 'smooth' });
				}
				header.classList.remove("show-mobile-menu");
		});
});

// Functions for clicking buttons on home.html
function Productsect() {
		document.getElementById("products-section").scrollIntoView({ behavior: 'smooth' });
}

function DownloadPage() {
		document.getElementById("downloadsect").scrollIntoView({ behavior: 'smooth' });
}

// Automatically scroll to the section specified in the URL hash when the page loads
document.addEventListener('DOMContentLoaded', function() {
		if (window.location.hash) {
				const sectionId = window.location.hash.substring(1);
				const targetElement = document.getElementById(sectionId);
				if (targetElement) {
						targetElement.scrollIntoView({ behavior: 'smooth' });
				}
		}
});

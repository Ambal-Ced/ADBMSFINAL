
const header = document.querySelector("header");
const menuBtn = document.querySelector("#menu-btn");
const closeMenuBtn = document.querySelector("#close-menu-btn");

menuBtn.addEventListener("click", () => {
	header.classList.toggle("show-mobile-menu");
});
closeMenuBtn.addEventListener("click", () => {
	menuBtn.click();
});
/*for header scroll*/
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
/*for header scroll*/

/*for clicking buttons*/
function Productsect() {
	document.getElementById("products-section").scrollIntoView({ behavior: 'smooth' });
}
function DownloadPage() {
	document.getElementById("downloadsect").scrollIntoView({ behavior: 'smooth' });
}

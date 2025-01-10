 /*~~~~~~~~~~~~~~~ TOGGLE BUTTON ~~~~~~~~~~~~~~~*/
 const navMenu = document.getElementById("nav-menu");
 const navLink = document.querySelectorAll(".nav-link");
 const hamburger = document.getElementById("hamburger");

 hamburger.addEventListener("click", () => {
   navMenu.classList.toggle("hidden");
   hamburger.classList.toggle('ri-close-large-line');
 });

 navLink.forEach(link => {
   link.addEventListener("click", () => {
     navMenu.classList.add("hidden");
     hamburger.classList.remove('ri-close-large-line');
   });
 });

 /*~~~~~~~~~~~~~~~ SHOW SCROLL UP ~~~~~~~~~~~~~~~*/
 const scrollUp = () => {
   const scrollUpBtn = document.getElementById("scroll-up");

   if (window.scrollY >= 250) {
     scrollUpBtn.classList.remove("hidden");
   } else {
     scrollUpBtn.classList.add("hidden");
   }
 };

 window.addEventListener("scroll", scrollUp);

 /*~~~~~~~~~~~~~~~ CHANGE BACKGROUND HEADER ~~~~~~~~~~~~~~~*/
 const scrollHeader = () => {
   const header = document.getElementById("navbar");

   if (window.scrollY >= 50) {
     header.classList.add("border-b", "border-yellow-500");
   } else {
     header.classList.remove("border-b", "border-yellow-500");
   }
 };
 window.addEventListener("scroll", scrollHeader);
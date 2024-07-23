// Карусель с участниками
const slidesContainer = document.querySelector('.participants__slides');
const slides = document.querySelectorAll('.participants__slide');
const prev = document.querySelector('.participants__btns-prev');
const next = document.querySelector('.participants__btns-next');
const counter = document.querySelector('.participants__btns-counter');
const totalSlides = slides.length;
let slidesToShow;

function setSlidesToShow() {
  if (window.innerWidth <= 768) {
    slidesToShow = 1;
  } else if (window.innerWidth <= 1024) {
    slidesToShow = 2;
  } else {
    slidesToShow = 3;
  }
}

setSlidesToShow();
let currentIndex = slidesToShow;

for (let i = 0; i < slidesToShow; i++) {
  slidesContainer.appendChild(slides[i].cloneNode(true));
  slidesContainer.insertBefore(slides[totalSlides - 1 - i].cloneNode(true), slidesContainer.firstChild);
}

slidesContainer.style.transform = `translateX(${-currentIndex * 100 / slidesToShow}%)`;

function updateCounter() {
  let currentSlide = ((currentIndex - slidesToShow) % totalSlides + totalSlides) % totalSlides + 1;
  counter.textContent = `${currentSlide}/${totalSlides}`;
}

function showSlide(index) {
  slidesContainer.style.transition = 'transform 0.5s ease-in-out';
  currentIndex = index;

  slidesContainer.style.transform = `translateX(${-currentIndex * 100 / slidesToShow}%)`;
  updateCounter();

  setTimeout(() => {
    if (currentIndex >= totalSlides + slidesToShow) {
      slidesContainer.style.transition = 'none';
      currentIndex = slidesToShow;
      slidesContainer.style.transform = `translateX(${-currentIndex * 100 / slidesToShow}%)`;
    } else if (currentIndex < slidesToShow) {
      slidesContainer.style.transition = 'none';
      currentIndex = totalSlides + slidesToShow - 1;
      slidesContainer.style.transform = `translateX(${-currentIndex * 100 / slidesToShow}%)`;
    }
  }, 500);
}

prev.addEventListener('click', () => {
  showSlide(currentIndex - 1);
});

next.addEventListener('click', () => {
  showSlide(currentIndex + 1);
});

function autoSlide() {
  showSlide(currentIndex + 1);
}

let slideInterval = setInterval(autoSlide, 4000);

document.querySelector('.participants__slider').addEventListener('mouseover', () => {
  clearInterval(slideInterval);
});

document.querySelector('.participants__slider').addEventListener('mouseout', () => {
  slideInterval = setInterval(autoSlide, 4000);
});

updateCounter();


// Карусель с шагами

document.addEventListener('DOMContentLoaded', function () {
  const sliderContainer = document.querySelector('.stages__list');
  const slides = document.querySelectorAll('.stages__item');
  const prevButton = document.querySelector('.stages__nav--prev');
  const nextButton = document.querySelector('.stages__nav--next');
  const dotsContainer = document.querySelector('.stages__dots');
  const slidesPerGroup = 5;
  let currentSlide = 0;
  const gap = 20;

  function createDots() {
    for (let i = 0; i < slidesPerGroup; i++) {
      const dot = document.createElement('div');
      dot.classList.add('stages__dot');
      dot.dataset.index = i;
      dotsContainer.appendChild(dot);
    }
  }

  function updateDots() {
    const dots = document.querySelectorAll('.stages__dot');
    dots.forEach(dot => dot.classList.remove('active'));
    dots[currentSlide].classList.add('active');
  }

  function updateButtons() {
    prevButton.classList.toggle('disabled', currentSlide === 0);
    nextButton.classList.toggle('disabled', currentSlide === slidesPerGroup - 1);
  }

  function showSlides(index) {
    const slideWidth = slides[0].offsetWidth + gap;
    sliderContainer.style.transform = `translateX(${-index * slideWidth}px)`;
    updateDots();
    updateButtons();
  }

  dotsContainer.addEventListener('click', function (e) {
    if (e.target.classList.contains('stages__dot')) {
      currentSlide = parseInt(e.target.dataset.index);
      showSlides(currentSlide);
    }
  });

  prevButton.addEventListener('click', function () {
    if (currentSlide > 0) {
      currentSlide--;
      showSlides(currentSlide);
    }
  });

  nextButton.addEventListener('click', function () {
    if (currentSlide < slidesPerGroup - 1) {
      currentSlide++;
      showSlides(currentSlide);
    }
  });

  window.addEventListener('resize', function () {
    showSlides(currentSlide);
  });

  createDots();
  showSlides(currentSlide);
});

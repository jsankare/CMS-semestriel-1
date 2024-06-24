document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.querySelector('.carousel--inner');
    const items = document.querySelectorAll('.carousel--item');
    const prevButton = document.querySelector('.carousel--control.prev');
    const nextButton = document.querySelector('.carousel--control.next');
    let currentIndex = 0;

    function updateCarousel() {
        const width = items[0].clientWidth;
        carousel.style.transform = `translateX(-${currentIndex * width}px)`;
    }

    prevButton.addEventListener('click', function() {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = items.length - 1;
        }
        updateCarousel();
    });

    nextButton.addEventListener('click', function() {
        if (currentIndex < items.length - 1) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        updateCarousel();
    });

    window.addEventListener('resize', updateCarousel);
});

document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('.gallery--classic__item__picture');
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    const captionText = document.getElementById('caption');
    const span = document.getElementsByClassName('close')[0];

    images.forEach(image => {
        image.addEventListener('click', function() {
            modal.style.display = 'block';
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        });
    });

    span.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});

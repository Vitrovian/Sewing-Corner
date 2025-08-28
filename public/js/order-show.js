// Показати модальне вікно зображення
function showImageModal(imageUrl) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imageUrl;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
// Сховати модальне вікно зображення
function hideImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.getElementById('modalImage').src = '';
}
// Для скасування
function openCancelModal(event) {
    event.preventDefault();
    document.getElementById('cancelModal').style.display = 'flex';
}
function closeCancelModal() {
    document.getElementById('cancelModal').style.display = 'none';
}
// Закриття модального вікна по кліку на фон
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) hideImageModal();
    });
});

// Функції для модального вікна встановлення ціни
function openSetPriceModal(event) {
    event.preventDefault();
    const modal = document.getElementById('setPriceModal');
    const modalContent = modal.querySelector('div:first-child');
    modal.style.display = 'flex';
    setTimeout(() => {
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modalContent.classList.remove('scale-90');
        modalContent.classList.add('scale-100');
        document.getElementById('price-modal').focus();
    }, 10);
}

function closeSetPriceModal() {
    const modal = document.getElementById('setPriceModal');
    const modalContent = modal.querySelector('div:first-child');
    modal.classList.add('opacity-0', 'pointer-events-none');
    modalContent.classList.remove('scale-100');
    modalContent.classList.add('scale-90');
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);
}

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('setPriceModal');
    modal.addEventListener('click', function(e) {
        // Нічого не робимо
    });
});

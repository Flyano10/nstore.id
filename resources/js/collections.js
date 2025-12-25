document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('collection-track');
    const prevButton = document.getElementById('collection-prev');
    const nextButton = document.getElementById('collection-next');
    const items = document.querySelector('[data-collection-items]');
    
    if (!track || !prevButton || !nextButton) return;

    // Ukuran item + gap (sesuaikan dengan CSS Anda)
    const itemWidth = 300; // lebar item
    const gap = 24; // jarak antar item (sesuai dengan gap-6 = 1.5rem = 24px)
    const scrollAmount = itemWidth + gap;

    // Fungsi untuk mengecek apakah bisa scroll ke kiri
    function canScrollLeft() {
        return track.scrollLeft > 0;
    }

    // Fungsi untuk mengecek apakah bisa scroll ke kanan
    function canScrollRight() {
        return track.scrollLeft < (track.scrollWidth - track.clientWidth - 1);
    }

    // Update status tombol berdasarkan posisi scroll
    function updateButtonStates() {
        prevButton.disabled = !canScrollLeft();
        nextButton.disabled = !canScrollRight();
    }

    // Event listener untuk tombol prev
    prevButton.addEventListener('click', () => {
        track.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
        
        // Update status tombol setelah animasi selesai
        setTimeout(updateButtonStates, 300);
    });

    // Event listener untuk tombol next
    nextButton.addEventListener('click', () => {
        track.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
        
        // Update status tombol setelah animasi selesai
        setTimeout(updateButtonStates, 300);
    });

    // Update status tombol saat halaman dimuat
    updateButtonStates();
    
    // Update status tombol saat ukuran jendela berubah
    window.addEventListener('resize', updateButtonStates);
    
    // Update status tombol saat scroll
    track.addEventListener('scroll', updateButtonStates);
});

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('create-chapter-modal');
    const btn = document.getElementById('create-chapter-btn');
    const close = document.querySelector('.close-modal');

    btn.addEventListener('click', () => {
        modal.style.display = 'block';
    });

    close.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});

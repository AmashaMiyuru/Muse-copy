document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('create-group-modal');
    const btn = document.getElementById('create-group-btn');
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
document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.querySelector(".sidebar");
        const headerHeight = document.querySelector(".hero").offsetHeight;

        window.addEventListener("scroll", function () {
            if (window.scrollY >= headerHeight) {
                sidebar.classList.add("fixed");
                document.body.classList.add("sidebar-active");
            } else {
                sidebar.classList.remove("fixed");
                document.body.classList.remove("sidebar-active");
            }
        });
    });


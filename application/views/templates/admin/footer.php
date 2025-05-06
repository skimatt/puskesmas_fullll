</main>

<!-- JavaScript untuk toggle sidebar -->
<script>
    const toggleSidebar = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    toggleSidebar.addEventListener('click', () => {
        sidebar.classList.toggle('open');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
    });
</script>
</body>
</html>
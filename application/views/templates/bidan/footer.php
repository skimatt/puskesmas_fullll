</main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toggleSidebar = document.getElementById('toggleSidebar');
            var sidebar = document.getElementById('sidebar');
            var overlay = document.getElementById('overlay');

            toggleSidebar.addEventListener('click', function() {
                sidebar.classList.toggle('sidebar-hidden');
                overlay.classList.toggle('hidden');
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.add('sidebar-hidden');
                overlay.classList.add('hidden');
            });
        });
    </script>
</body>
</html>
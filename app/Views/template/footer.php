
    <!-- JavaScript for mobile sidebar -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileSidebar = document.getElementById('mobileSidebar');
            const openSidebarBtn = document.getElementById('openSidebar');
            const closeSidebarBtn = document.getElementById('closeSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            // Initially hide the mobile sidebar
            mobileSidebar.style.display = 'none';
            
            // Open sidebar
            openSidebarBtn.addEventListener('click', function() {
                mobileSidebar.style.display = 'block';
                setTimeout(() => {
                    mobileSidebar.querySelector('.mobile-sidebar').classList.add('active');
                }, 10);
            });
            
            // Close sidebar function
            function closeSidebar() {
                mobileSidebar.querySelector('.mobile-sidebar').classList.remove('active');
                setTimeout(() => {
                    mobileSidebar.style.display = 'none';
                }, 300);
            }
            
            // Close sidebar events
            closeSidebarBtn.addEventListener('click', closeSidebar);
            sidebarOverlay.addEventListener('click', closeSidebar);
        });
    </script>
</body>
</html>